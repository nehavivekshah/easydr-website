<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Appointments;
use App\Models\Doctors;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class WebPaymentController extends Controller
{
    public function payment(Request $request)
    {
        // This method is called when the user selects 'online' payment
        // It expects an appointment_id in the session or request

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

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

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
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect('/my-account')->with('error', 'Something went wrong.');
        } else {
            return redirect('/my-account')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function paymentCancel()
    {
        return redirect('/my-account')->with('error', 'You have canceled the transaction.');
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $appointmentId = session('appointment_id');
            if ($appointmentId) {
                $appointment = Appointments::find($appointmentId);
                if ($appointment) {
                    $appointment->payment_status = 'paid';
                    $appointment->save();

                    // Send Email Notification
                    $user = Auth::user();
                    $doctor = Doctors::where('uid', $appointment->did)->first();
                    $this->sendAppointmentEmail($appointment, $user, $doctor);

                    // Clear session
                    session()->forget('appointment_id');

                    return redirect('/my-account')->with('success', 'Transaction complete. Appointment booked successfully.');
                }
            }
            return redirect('/my-account')->with('error', 'Transaction complete but appointment not found.');

        } else {
            return redirect('/my-account')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    private function sendAppointmentEmail($appointment, $user, $doctor)
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
            $message .= "Status: Paid (PayPal)<br><br>";
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
