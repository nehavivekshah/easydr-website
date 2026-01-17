<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\SendMail;
use App\Models\Branches;
use App\Models\User;
use App\Models\Doctors;
use App\Models\Doctor_reviews;
use App\Models\Roles;
use App\Models\Specialists;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctors::leftJoin('users', 'users.id', '=', 'doctors.uid')
            ->leftJoin('doctor_reviews', 'doctor_reviews.doctor_id', '=', 'doctors.id')
            ->select(
                'doctors.id',
                'doctors.uid',
                'doctors.specialist',
                'doctors.fees',
                'doctors.license',
                'doctors.education',
                'doctors.about',
                'doctors.extra',
                'doctors.created_at',
                'doctors.updated_at',

                'users.first_name',
                'users.last_name',
                'users.email',
                'users.photo',

                DB::raw('COALESCE(AVG(doctor_reviews.rating), 0) AS avg_rating')
            )
            ->where('users.status', 1)
            ->groupBy(
                'doctors.id',
                'doctors.uid',
                'doctors.specialist',
                'doctors.fees',
                'doctors.license',
                'doctors.education',
                'doctors.about',
                'doctors.extra',
                'doctors.created_at',
                'doctors.updated_at',

                'users.first_name',
                'users.last_name',
                'users.email',
                'users.photo'
            )
            ->orderBy('doctors.id', 'desc')
            ->limit(8)
            ->get();

        $specialists = Specialists::where('status', 1)->limit(12)->get();

        return view('frontend/home', ['specialists' => $specialists, 'doctors' => $doctors]);
    }
    public function doctors(Request $request, $specialty = null)
    {
        $doctors = Doctors::leftJoin('users', 'users.id', '=', 'doctors.uid')
            ->leftJoin('doctor_reviews', 'doctor_reviews.doctor_id', '=', 'doctors.id')
            ->select(
                'doctors.id',
                'doctors.uid',
                'doctors.specialist',
                'doctors.fees',
                'doctors.license',
                'doctors.education',
                'doctors.about',
                'doctors.extra',
                'doctors.created_at',
                'doctors.updated_at',

                'users.first_name',
                'users.last_name',
                'users.email',
                'users.photo',

                DB::raw('COALESCE(AVG(doctor_reviews.rating), 0) AS avg_rating')
            )
            ->where('users.status', 1)
            ->where(function ($query) use ($request, $specialty) {
                if ($specialty) {
                    $query->where('doctors.specialist', 'LIKE', '%' . $specialty . '%');
                }
                if ($request->input('specialty')) {
                    $query->where('doctors.specialist', 'LIKE', '%' . $request->input('specialty') . '%');
                }
                if ($request->input('search')) {
                    $query->where(function ($q) use ($request) {
                        $q->where('users.first_name', 'LIKE', '%' . $request->input('search') . '%')
                            ->orWhere('users.last_name', 'LIKE', '%' . $request->input('search') . '%')
                            ->orWhere('doctors.specialist', 'LIKE', '%' . $request->input('search') . '%');
                    });
                }
            })
            ->groupBy(
                'doctors.id',
                'doctors.uid',
                'doctors.specialist',
                'doctors.fees',
                'doctors.license',
                'doctors.education',
                'doctors.about',
                'doctors.extra',
                'doctors.created_at',
                'doctors.updated_at',

                'users.first_name',
                'users.last_name',
                'users.email',
                'users.photo'
            )
            ->orderBy('doctors.id', 'desc')
            ->get();

        $specialists = Specialists::where('status', 1)->limit(12)->get();

        return view('frontend/doctors', ['specialists' => $specialists, 'doctors' => $doctors]);
    }
    public function specialists(Request $request)
    {
        $specialists = Specialists::where('status', 1)->get();

        return view('frontend/specialists', ['specialists' => $specialists]);
    }
    public function doctorDetails($id, $token)
    {
        $doctor = Doctors::leftJoin('users', 'users.id', '=', 'doctors.uid')
            ->leftJoin('doctor_reviews', 'doctor_reviews.doctor_id', '=', 'doctors.id')
            ->select(
                'doctors.id',
                'doctors.uid',
                'doctors.specialist',
                'doctors.fees',
                'doctors.license',
                'doctors.education',
                'doctors.about',
                'doctors.extra',
                'doctors.created_at',
                'doctors.updated_at',

                'users.first_name',
                'users.last_name',
                'users.email',
                'users.photo',

                DB::raw('COALESCE(AVG(doctor_reviews.rating), 0) AS avg_rating')
            )
            ->where('users.id', '=', $id)
            ->groupBy(
                'doctors.id',
                'doctors.uid',
                'doctors.specialist',
                'doctors.fees',
                'doctors.license',
                'doctors.education',
                'doctors.about',
                'doctors.extra',
                'doctors.created_at',
                'doctors.updated_at',

                'users.first_name',
                'users.last_name',
                'users.email',
                'users.photo'
            )
            ->first();

        if (!$doctor) {
            return abort(404, 'Doctor not found');
        }

        // Get reviews separately
        $reviews = Doctor_reviews::where('doctor_id', $doctor->id)->limit(12)->get();

        return view('frontend/doctorDetails', [
            'doctor' => $doctor,
            'reviews' => $reviews
        ]);
    }

    public function login()
    {
        return view('frontend/login');
    }
    public function loginPost(Request $request)
    {
        $credetials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credetials)) {

            // Get the authenticated user
            $user = Auth::user();

            $company = Branches::where('id', '=', ($user->branch ?? ''))->first();

            $roles = Roles::where('id', '=', ($user->role ?? ''))->first();

            // Store companies in session
            session(['companies' => $company]);
            session(['roles' => $roles]);

            return redirect('/')->with('success', 'Successfully Login.');
        }

        return back()->with('error', 'Login Credetials Invalid.');
    }
    public function signup()
    {
        return view('frontend/signup');
    }
    public function signupPost(Request $request)
    {

        $emailPrefix = explode('@', $request->email)[0];
        $mobilePrefix = substr($request->mobile, 0, 3);

        try {
            $user = new User();

            $user->branch = $request->input('branch', 1);
            $user->username = $emailPrefix . $mobilePrefix;
            $user->first_name = $request->first_name;
            $user->last_name = $request->input('last_name', '');
            $user->photo = $request->input('photo', '');
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->dob = $request->input('dob', '');
            $user->gender = $request->input('gender', '');
            $user->role = $request->input('role', 5);
            $user->notify = $request->input('notify', 1);
            $user->status = $request->input('status', 0);

            $user->save();

            // OTP generation (use 6-digit secure OTP instead)
            $otp = rand(100000, 999999); // or keep date('is') if required

            $to = $user->email;
            $subject = "$otp Account Verification Code";
            $message = "We have received an account verification request. The verification code to verify your account is below.<br><strong>$otp</strong> is the account verification code.<br><br><b>Regards</b><br>Easy Doctor";

            $viewName = 'inc.sendmail';
            $viewData = ["name" => "Sir/Ma'am", "messages" => $message];

            try {
                Mail::to($to)->send(new SendMail($subject, $viewName, $viewData));
            } catch (\Exception $e) {
                $user->delete(); // rollback user
                //dd($e->getMessage()); // Log the error message for debugging
                return back()->with('error', 'Failed to send verification email. Please try again.');
            }

            // 5. Store OTP and user ID in session
            session([
                'otpSession' => [
                    'uid' => $user->id,
                    'otp' => $otp
                ]
            ]);

            // Optionally store OTP in session or database if needed for later verification

            return redirect('/otp')->with('success', 'Successfully registered! Please check your email for verification.');

        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;
            if ($errorCode == 1062) {
                return back()->with('error', 'Duplicate Entry.');
            }
            return back()->with('error', 'Oops, something went wrong.');
        }
    }
    public function otp()
    {
        return view('frontend/otp');
    }
    public function verifyOtp(Request $request)
    {
        // 1. Validate incoming OTP code
        $request->validate([
            'otp_code' => 'required|digits:6',  // or 'string' if you allow non-numeric
        ]);

        // 2. Retrieve OTP session data
        $otpSession = session('otpSession');

        // If no session data exists, prompt user to re-register or request a new OTP
        if (!$otpSession) {
            return back()->with('error', 'No OTP session found. Please request a new code or register again.');
        }

        $uid = $otpSession['uid'];
        $storedOtp = $otpSession['otp'];
        $redir = $otpSession['redir'] ?? '';

        // 3. Compare submitted OTP with the stored OTP
        if ($request->otp_code == $storedOtp) {
            // 4. If matched, mark the user as verified in the database
            $user = User::find($uid);

            if (!$user) {
                return back()->with('error', 'User not found. Please register again.');
            }

            // Example: set 'status' to 1 for verified, or use another field if needed
            $user->status = 1;
            $user->save();

            // 5. Clear OTP session to prevent reuse
            session()->forget('otpSession');

            if (($redir ?? '') == 'redirPassword') {

                session([
                    'userSession' => [
                        'uid' => $user->id
                    ]
                ]);

                return redirect('/create-new-password')
                    ->with('success', 'OTP verified successfully! You can create a new password.');
            } else {
                return redirect('/login')
                    ->with('success', 'OTP verified successfully! You can now access the dashboard.');
            }

        }

        // If the OTP doesn't match, return an error
        return back()->with('error', 'Invalid or incorrect OTP code. Please try again.');
    }
    public function forgotPassword()
    {
        return view('frontend/forgotPassword');
    }
    public function forgotPasswordPost(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        $otp = rand(100000, 999999);
        $to = $user->email ?? '';
        $subject = $otp . " Account Verification Code";

        $message = "
        <p>Dear User,</p>
        <p>We have received a request to reset the password for your account. Please use the verification code below to complete the process:</p>
        <h2>$otp</h2>
        <p>If you did not request a password reset, please ignore this email or contact support.</p>
        <p><b>Regards,</b><br>Easy Doctor Team</p>
        ";

        $viewName = 'inc.sendmail';
        $viewData = ["name" => "Sir/Ma'am", "messages" => $message];

        try {
            Mail::to($to)->send(new SendMail($subject, $viewName, $viewData));
        } catch (\Exception $e) {
            // If email sending fails, delete the created user
            //$user->delete();
            return back()->with('error', 'Failed to send verification email');
        }

        // 5. Store OTP and user ID in session
        session([
            'otpSession' => [
                'uid' => $user->id,
                'otp' => $otp,
                'redir' => 'redirPassword'
            ]
        ]);

        return redirect('/otp')->with('success', 'Reset password sent your registed email id.');
    }
    public function createNewPassword()
    {
        return view('frontend/createNewPassword');
    }
    public function createNewPasswordPost(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        // Retrieve the user ID from the session
        $userSession = session('userSession');

        // Find the user by ID
        $user = User::find($userSession['uid']);

        if (!$user) {
            return back()->with('error', 'User not found. Please try again.');
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear the session data
        session()->forget('userSession');

        return redirect('/login')->with('success', 'Password updated successfully! You can now log in.');
    }
    public function logout()
    {
        Auth::logout();

        return back()->with('success', 'Successfully Logout.');
    }

    /*Website My Account Controllers*/
    public function myAccount()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        // Fetch some basic stats for the dashboard
        $appointmentsCount = DB::table('appointments')->where('pid', $user->id)->count();
        // Assuming reports and favorites tables exist or logic is known, otherwise placeholders
        $reportsCount = 0; // DB::table('reports')->where('patient_id', $user->id)->count();
        $favoritesCount = 0; // DB::table('favorites')->where('user_id', $user->id)->count();

        // Calculate total billing if applicable
        $billingAmount = 0; // Logic to sum billing

        return view('frontend/myAccount', compact('appointmentsCount', 'reportsCount', 'favoritesCount', 'billingAmount'));
    }

    public function myProfile()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }
        return view('frontend/myProfile', compact('user'));
    }

    public function appointments()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $appointments = DB::table('appointments')
            ->leftJoin('users as doc', 'appointments.did', '=', 'doc.id')
            ->leftJoin('doctors', 'doc.id', '=', 'doctors.uid')
            ->select(
                'appointments.*',
                'doc.first_name as doctor_first_name',
                'doc.last_name as doctor_last_name',
                'doctors.specialist'
            )
            ->where('appointments.pid', $user->id)
            ->orderBy('appointments.date', 'desc')
            ->orderBy('appointments.time', 'desc')
            ->get();

        return view('frontend/appointments', compact('appointments'));
    }

    public function cancelAppointment($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        // Find the appointment and ensure it belongs to the logged-in user
        $appointment = DB::table('appointments')
            ->where('id', $id)
            ->where('pid', $user->id)
            ->first();

        if (!$appointment) {
            return back()->with('error', 'Appointment not found or unauthorized.');
        }

        if ($appointment->status != '0') {
            return back()->with('error', 'Only pending appointments can be cancelled.');
        }

        // status '2' = Cancelled
        DB::table('appointments')->where('id', $id)->update(['status' => '2']);

        return back()->with('success', 'Appointment cancelled successfully.');
    }

    public function manageAppointment(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $doctors = Doctors::leftJoin('users', 'doctors.uid', '=', 'users.id')
            ->select('doctors.*', 'users.first_name', 'users.last_name')
            ->where('users.status', 1) // Active doctors
            ->get();

        return view('frontend/manageAppointment', compact('doctors'));
    }
    // Website pharmacy controllers
    public function pharmacy()
    {
        $prescribedMedicines = [];
        return view('frontend/pharmacy', ['prescribedMedicines' => $prescribedMedicines]);
    }
    /*Website Infomative pages*/
    public function about()
    {
        return view('frontend/about');
    }
    public function dataSecurity()
    {
        return view('frontend/dataSecurity');
    }
    public function service()
    {
        return view('frontend/services');
    }
    public function department()
    {
        return view('frontend/departments');
    }
    public function blog()
    {
        return view('frontend/blog');
    }
    public function contact()
    {
        return view('frontend/contact');
    }
}
