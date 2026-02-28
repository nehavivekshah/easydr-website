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

        // Fetch active payment gateways and store locations
        $paymentGateways = PaymentGatewayConfig::where('is_active', 1)->get();
        $storeLocations = Store_locations::all();

        return view('frontend.cart', compact('cartItems', 'subtotal', 'paymentGateways', 'storeLocations'));
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

    public function checkout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $request->validate([
            'payment_method' => 'required|in:cod,online',
            'payment_gateway_id' => 'required_if:payment_method,online|nullable|exists:payment_gateway_configs,id',
            'shipping_address' => 'required|string|max:500',
            'store_id' => 'required|integer',
        ]);

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
                'shipping_address' => $request->shipping_address,
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

            return view('frontend.checkout_success', compact('order'));

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect('/cart')->with('error', 'An error occurred during checkout: ' . $e->getMessage());
        }
    }
}
