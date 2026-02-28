<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Carts;
use App\Models\Medicines;
use App\Models\Prescriptions;
use App\Models\Prescription_medinices;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\PaymentGatewayConfig;
use App\Models\Store_locations;
use App\Models\Patients;
use App\Models\Usermetas;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CartController extends Controller
{
    public function viewCart()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Please login to view your cart.');
        }

        $cartItems = Carts::with('medicine')->where('user_id', $user->id)->get();

        $subtotal = 0;
        foreach ($cartItems as $item) {
            if ($item->medicine) {
                // Use discount_cost if set, otherwise fall back to cost
                $price = $item->medicine->discount_cost ?? $item->medicine->cost ?? 0;
                $subtotal += $price * $item->quantity;
            }
        }

        return view('frontend.cart', compact('cartItems', 'subtotal'));
    }

    public function addPrescription(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Please login to add to cart.');
        }

        $request->validate([
            'prescription_id' => 'required|integer'
        ]);

        $prescriptionId = $request->prescription_id;

        // Resolve the patient record - same logic as FrontendController@patientPrescriptions
        $patient = \App\Models\Patients::where('uid', $user->id)->first();
        $pid = $patient ? $patient->id : 0;

        // Ensure prescription belongs to user - check both user_id and patients.id forms
        try {
            $prescription = Prescriptions::where('id', $prescriptionId)
                ->where(function ($q) use ($user, $pid) {
                    $q->where('patient_id', $user->id);
                    if ($pid > 0) {
                        $q->orWhere('patient_id', $pid);
                    }
                })
                ->first();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('CartController: prescription ownership check failed - ' . $e->getMessage());
            $prescription = Prescriptions::where('id', $prescriptionId)->first();
        }

        if (!$prescription) {
            return redirect()->back()->with('error', 'Prescription not found or unauthorized.');
        }

        $prescribedMedicines = Prescription_medinices::where('prescribe_id', $prescriptionId)->get();

        if ($prescribedMedicines->isEmpty()) {
            return redirect()->back()->with('warning', 'No medicines found in this prescription.');
        }

        $addedCount = 0;
        $notFoundItems = [];

        foreach ($prescribedMedicines as $pm) {
            // Attempt to find a matching medicine in catalog - NO status filter (column may not exist)
            try {
                $medicine = Medicines::where('name', 'LIKE', '%' . $pm->medicine_name . '%')->first();
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('CartController: medicine lookup failed - ' . $e->getMessage());
                $notFoundItems[] = $pm->medicine_name;
                continue;
            }

            if ($medicine) {
                // Check if already in cart
                $cartItem = Carts::where('user_id', $user->id)
                    ->where('medicine_id', $medicine->id)
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity += 1;
                    $cartItem->save();
                } else {
                    Carts::create([
                        'user_id' => $user->id,
                        'medicine_id' => $medicine->id,
                        'quantity' => 1
                    ]);
                }
                $addedCount++;
            } else {
                $notFoundItems[] = $pm->medicine_name;
            }
        }

        $msg = "$addedCount prescribed medicine(s) added to your cart.";
        if (count($notFoundItems) > 0) {
            $msg .= " The following items were not found in our active catalog: " . implode(', ', $notFoundItems) . ".";
            if ($addedCount === 0) {
                return redirect()->back()->with('warning', $msg);
            }
            return redirect('/cart')->with('warning', $msg);
        }

        return redirect('/cart')->with('success', $msg);
    }

    public function updateCart(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $request->validate([
            'cart_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Carts::where('id', $request->cart_id)->where('user_id', $user->id)->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            return redirect()->back()->with('success', 'Cart updated.');
        }

        return redirect()->back()->with('error', 'Item not found in your cart.');
    }

    public function removeCart($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $cartItem = Carts::where('id', $id)->where('user_id', $user->id)->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->back()->with('success', 'Item removed from cart.');
        }

        return redirect()->back()->with('error', 'Item not found.');
    }

    public function viewCheckout()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Please login to checkout.');
        }

        $cartItems = Carts::with('medicine')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('warning', 'Your cart is empty.');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            if ($item->medicine) {
                $price = $item->medicine->discount_cost ?? $item->medicine->cost ?? 0;
                $subtotal += $price * $item->quantity;
            }
        }

        // Auto-fetch Processing Store from the first medicine in the cart
        $cartStoreId = null;
        $firstMedicine = $cartItems->first()->medicine;
        if ($firstMedicine) {
            $cartStoreId = $firstMedicine->store_id;
        }

        // Fetch active payment gateways and store locations
        $paymentGateways = PaymentGatewayConfig::where('is_active', 1)->get();
        $storeLocations = Store_locations::all();

        // Fetch user meta for pre-filling the address
        $patient = Usermetas::where('uid', $user->id)->first();

        return view('frontend.checkout', compact('cartItems', 'subtotal', 'paymentGateways', 'storeLocations', 'cartStoreId', 'patient'));
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $request->validate([
            'payment_method' => 'required|in:cod,online',
            'payment_gateway_id' => 'required_if:payment_method,online|nullable|exists:payment_gateway_configs,id',
            'store_id' => 'required|integer',
            'fullName' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'street' => 'required|string|max:200',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
        ]);

        $shipping_address = $request->fullName . "\n" .
            $request->phone . "\n" .
            $request->street . "\n" .
            $request->city . ", " . $request->state . " " . $request->zip;

        $cartItems = Carts::with('medicine')->where('user_id', $user->id)->get();
        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Your cart is empty.');
        }

        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $price = $item->medicine->discount_cost ?? $item->medicine->cost ?? 0;
            $totalAmount += $price * $item->quantity;
        }

        DB::beginTransaction();

        try {
            // Create Order
            $order = Orders::create([
                'user_id' => $user->id,
                'status' => 0, // 0 = Pending
                'total_amount' => $totalAmount,
                'store_id' => $request->store_id,
                'shipping_address' => $shipping_address,
                'payment_method' => $request->payment_method,
                'payment_gateway_id' => $request->payment_method === 'online' ? $request->payment_gateway_id : null,
            ]);

            // Create OrderItems
            foreach ($cartItems as $item) {
                $price = $item->medicine->discount_cost ?? $item->medicine->cost ?? 0;
                OrderItems::create([
                    'order_id' => $order->id,
                    'medicine_id' => $item->medicine_id,
                    'quantity' => $item->quantity,
                    'price' => $price
                ]);
            }

            // Clear Cart
            Carts::where('user_id', $user->id)->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect('/cart')->with('error', 'An error occurred during checkout: ' . $e->getMessage());
        }

        if ($request->payment_method === 'online' && $request->payment_gateway_id) {
            return $this->processOnlinePayment($order);
        }

        return view('frontend.checkout_success', compact('order'));
    }

    private function processOnlinePayment($order)
    {
        $gateway = PaymentGatewayConfig::find($order->payment_gateway_id);
        if (!$gateway || !$gateway->is_active) {
            return redirect('/cart')->with('error', 'Selected payment gateway is not available.');
        }

        $gatewayName = strtolower($gateway->gateway_name);
        $amount = $order->total_amount;

        // Save order ID to session for success callback
        session(['checkout_order_id' => $order->id]);

        if ($gatewayName === 'paypal') {
            return $this->payPalPayment($gateway, $amount, $order);
        } elseif ($gatewayName === 'stripe') {
            return $this->stripePayment($gateway, $amount, $order);
        }

        return redirect('/cart')->with('error', 'Unsupported payment gateway: ' . $gateway->gateway_name);
    }

    private function payPalPayment($config, $amount, $order)
    {
        if (empty($config->api_key) || empty($config->api_secret)) {
            return redirect('/cart')->with('error', 'PayPal is not configured properly. Missing API credentials.');
        }

        $provider = new PayPalClient;
        $mode = strtolower($config->environment) === 'production' ? 'live' : 'sandbox';

        $payPalConfig = [
            'mode' => $mode,
            'sandbox' => [
                'client_id' => $config->api_key,
                'client_secret' => $config->api_secret,
                'app_id' => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id' => $config->api_key,
                'client_secret' => $config->api_secret,
                'app_id' => $config->additional_config['app_id'] ?? '',
            ],
            'payment_action' => 'Sale',
            'currency' => 'USD',
            'notify_url' => '',
            'locale' => 'en_US',
            'validate_ssl' => true,
        ];

        try {
            $provider->setApiCredentials($payPalConfig);
            $provider->getAccessToken();
        } catch (\Exception $e) {
            return redirect('/cart')->with('error', 'PayPal Configuration Error: ' . $e->getMessage());
        }

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('cart.payment.success', ['gateway' => 'paypal']),
                "cancel_url" => route('cart.payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
        }
        return redirect('/cart')->with('error', $response['message'] ?? 'Something went wrong with PayPal init.');
    }

    private function stripePayment($config, $amount, $order)
    {
        Stripe::setApiKey($config->api_secret);

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'inr',
                        'product_data' => [
                            'name' => 'Pharmacy Order #' . $order->id,
                        ],
                        'unit_amount' => $amount * 100, // Stripe expects cents/paise
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('cart.payment.success', ['gateway' => 'stripe']) . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cart.payment.cancel'),
        ]);

        return redirect()->away($session->url);
    }

    public function paymentCancel()
    {
        return redirect('/cart')->with('error', 'You have canceled the payment. Your order is pending.');
    }

    public function paymentSuccess(Request $request)
    {
        $orderId = session('checkout_order_id');
        $gatewayName = $request->query('gateway');

        if (!$orderId) {
            return redirect('/cart')->with('error', 'Order not found in session.');
        }

        $order = Orders::find($orderId);
        if (!$order) {
            return redirect('/cart')->with('error', 'Order not found.');
        }

        $config = PaymentGatewayConfig::where('gateway_name', $gatewayName)->where('is_active', true)->first();
        if (!$config) {
            return redirect('/cart')->with('error', 'Gateway configuration not found.');
        }

        if ($gatewayName === 'paypal') {
            $mode = strtolower($config->environment) === 'production' ? 'live' : 'sandbox';
            $payPalConfig = [
                'mode' => $mode,
                'sandbox' => [
                    'client_id' => $config->api_key,
                    'client_secret' => $config->api_secret,
                    'app_id' => 'APP-80W284485P519543T',
                ],
                'live' => [
                    'client_id' => $config->api_key,
                    'client_secret' => $config->api_secret,
                    'app_id' => $config->additional_config['app_id'] ?? '',
                ],
                'payment_action' => 'Sale',
                'currency' => 'USD',
                'notify_url' => '',
                'locale' => 'en_US',
                'validate_ssl' => true,
            ];

            try {
                $provider = new PayPalClient;
                $provider->setApiCredentials($payPalConfig);
                $provider->getAccessToken();
                $response = $provider->capturePaymentOrder($request['token']);

                if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                    $order->status = 1; // 1 = Paid/Processing
                    $order->save();
                    session()->forget('checkout_order_id');
                    return view('frontend.checkout_success', compact('order'));
                }
            } catch (\Exception $e) {
                return redirect('/cart')->with('error', 'PayPal Callback Error: ' . $e->getMessage());
            }

        } elseif ($gatewayName === 'stripe') {
            try {
                Stripe::setApiKey($config->api_secret);
                $session = StripeSession::retrieve($request->get('session_id'));

                if ($session->payment_status === 'paid') {
                    $order->status = 1;
                    $order->save();
                    session()->forget('checkout_order_id');
                    return view('frontend.checkout_success', compact('order'));
                }
            } catch (\Exception $e) {
                return redirect('/cart')->with('error', 'Stripe Callback Error: ' . $e->getMessage());
            }
        }

        return redirect('/cart')->with('error', 'Payment failed or was not verified. Contact support if you were charged.');
    }
}
