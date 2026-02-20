<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Appointments;
use App\Models\Doctors;
use App\Models\PaymentGatewayConfig;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class WebPaymentController extends Controller
{
    public function payment(Request $request)
    {
        $appointmentId = session('appointment_id');

        if (!$appointmentId) {
            return redirect('/my-account')->with('error', 'No appointment found to pay for.');
        }

        $appointment = Appointments::find($appointmentId);

        if (!$appointment) {
            return redirect('/my-account')->with('error', 'Appointment not found.');
        }

        // Get Doctor Fees
        $doctor = Doctors::where('uid', $appointment->did)->first();
        $amount = 10; // Default
        if ($doctor && $doctor->fees) {
            $amount = $doctor->fees;
        }

        // Get all active gateways
        $gateways = PaymentGatewayConfig::where('is_active', true)->get();

        if ($gateways->isEmpty()) {
            return redirect('/my-account')->with('error', 'No active payment gateway configured.');
        }

        // If a specific gateway is requested, or if only one exists
        $selectedGatewayName = $request->query('gateway');

        if ($selectedGatewayName) {
            $config = $gateways->firstWhere('gateway_name', $selectedGatewayName);

            if (!$config) {
                return redirect('/my-account')->with('error', 'Selected payment gateway is not available.');
            }
        } elseif ($gateways->count() === 1) {
            $config = $gateways->first();
        } else {
            // Multiple gateways available, show selection screen
            return view('frontend.payment_selection', [
                'gateways' => $gateways,
                'appointment' => $appointment,
                'amount' => $amount,
                'doctor_name' => $doctor ? $doctor->first_name . ' ' . $doctor->last_name : 'Doctor'
            ]);
        }

        // Proceed with the selected config
        $gatewayName = strtolower($config->gateway_name);

        if ($gatewayName === 'paypal') {
            return $this->payPalPayment($config, $amount);
        } elseif ($gatewayName === 'stripe') {
            return $this->stripePayment($config, $appointment, $amount);
        }

        return redirect('/my-account')->with('error', 'Unsupported payment gateway: ' . $config->gateway_name);
    }

    private function payPalPayment($config, $amount)
    {
        $provider = new PayPalClient;

        $payPalConfig = [
            'mode' => $config->environment, // 'sandbox' or 'live'
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

        $provider->setApiCredentials($payPalConfig);
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('payment.success'),
                "cancel_url" => route('payment.cancel'),
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
            return redirect('/my-account')->with('error', 'Something went wrong with PayPal.');
        } else {
            return redirect('/my-account')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    private function stripePayment($config, $appointment, $amount)
    {
        Stripe::setApiKey($config->api_secret);

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Doctor Appointment Fees',
                            'description' => 'Appointment for ' . $appointment->date . ' at ' . $appointment->time,
                        ],
                        'unit_amount' => $amount * 100, // Stripe in cents
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect()->away($session->url);
    }

    public function paymentCancel()
    {
        return redirect('/my-account')->with('error', 'You have canceled the transaction.');
    }

    public function paymentSuccess(Request $request)
    {
        $config = PaymentGatewayConfig::where('gateway_name', 'paypal')->where('is_active', true)->first();

        if (!$config) {
            return redirect('/my-account')->with('error', 'PayPal configuration not found.');
        }

        $payPalConfig = [
            'mode' => $config->environment,
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

        $provider = new PayPalClient;
        $provider->setApiCredentials($payPalConfig);
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return $this->finalizePayment('PayPal');
        } else {
            return redirect('/my-account')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function stripeSuccess(Request $request)
    {
        $config = PaymentGatewayConfig::where('gateway_name', 'stripe')->where('is_active', true)->first();

        if (!$config) {
            return redirect('/my-account')->with('error', 'Stripe configuration not found.');
        }

        Stripe::setApiKey($config->api_secret);
        $session = StripeSession::retrieve($request->get('session_id'));

        if ($session->payment_status === 'paid') {
            return $this->finalizePayment('Stripe');
        }

        return redirect('/my-account')->with('error', 'Stripe payment failed.');
    }

    public function stripeCancel()
    {
        return redirect('/my-account')->with('error', 'You have canceled the Stripe transaction.');
    }

    private function finalizePayment($gateway)
    {
        $appointmentId = session('appointment_id');
        if ($appointmentId) {
            $appointment = Appointments::find($appointmentId);
            if ($appointment) {
                $appointment->payment_status = 'paid';
                $appointment->save();

                // Send Email Notification
                $user = Auth::user();
                $doctor = Doctors::where('uid', $appointment->did)->first();
                $this->sendAppointmentEmail($appointment, $user, $doctor, $gateway);

                // Clear session
                session()->forget('appointment_id');

                return redirect('/my-account')->with('success', 'Transaction complete. Appointment booked successfully.');
            }
        }
        return redirect('/my-account')->with('error', 'Transaction complete but appointment not found.');
    }

    private function sendAppointmentEmail($appointment, $user, $doctor, $gateway = 'PayPal')
    {
        // Send SMS
        try {
            $smsService = new \App\Services\SmsService();
            $docName = $doctor ? $doctor->first_name . ' ' . $doctor->last_name : 'Doctor';
            $date = date('d M Y', strtotime($appointment->date));
            $time = $appointment->time;

            $message = "Payment Successful/nHello " . $user->first_name . ", Appointment confirmed with Dr. " . $docName . " on " . $date . " at " . $time . ". - EasyDoctor";

            $smsService->send($user->mobile, $message);
        } catch (\Exception $e) {
        }

        try {
            $to = $user->email;
            $subject = "Appointment Confirmation - EasyDoctor";

            $docName = $doctor ? $doctor->first_name . ' ' . $doctor->last_name : 'Doctor';
            $date = date('d M Y', strtotime($appointment->date));
            $time = $appointment->time;

            $message = "Dear " . $user->first_name . ",<br><br>";
            $message .= "Your appointment has been successfully booked and paid for.<br><br>";
            $message .= "<strong>Details:</strong><br>";
            $message .= "Doctor: Dr. " . $docName . "<br>";
            $message .= "Date: " . $date . "<br>";
            $message .= "Time: " . $time . "<br>";
            $message .= "Status: Paid (" . $gateway . ")<br><br>";
            $message .= "Please reach 15 minutes prior to your appointment time.<br><br>";
            $message .= "Regards,<br>Easy Doctor Team";

            $viewName = 'inc.sendmail';
            $viewData = ['name' => $user->first_name, 'messages' => $message];

            Mail::to($to)->send(new SendMail($subject, $viewName, $viewData));
        } catch (\Exception $e) {
            // Log error
        }
    }
}
