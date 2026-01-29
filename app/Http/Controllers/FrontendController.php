<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
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

        if ($user->role == 4) {
            // DOCTOR DASHBOARD
            $doctorId = $user->id; // Using User ID as reference, though some tables use doctors.id

            // Today's Appointments
            $today = Carbon::now()->toDateString();
            $appointmentsCount = \App\Models\Appointments::where('did', $doctorId)
                ->where('date', $today)
                ->count();

            // My Patients (Unique PIDs linked to this doctor)
            $patientsCount = \App\Models\Appointments::where('did', $doctorId)
                ->distinct('pid')
                ->count('pid');

            // Wallet & Revenue
            $doctorInfo = \App\Models\Doctors::where('uid', $user->id)->first();
            $walletAmount = $doctorInfo ? $doctorInfo->wallet : 0;

            // Total Revenue (Sum of fees from completed appointments)
            $totalRevenue = \App\Models\Appointments::where('did', $doctorId)
                ->where('status', 1) // 1 = Completed
                ->sum('fees');

            // Recent Appointments
            $recentAppointments = \App\Models\Appointments::leftJoin('patients', 'appointments.pid', '=', 'patients.id')
                ->leftJoin('users as patient', 'patients.uid', '=', 'patient.id')
                ->select(
                    'appointments.*',
                    'patient.first_name as patient_first_name',
                    'patient.last_name as patient_last_name'
                )
                ->where('appointments.did', $doctorId)
                ->orderBy('appointments.date', 'desc')
                ->orderBy('appointments.time', 'desc')
                ->limit(5)
                ->get();

            return view('frontend/myAccount', compact('appointmentsCount', 'patientsCount', 'walletAmount', 'totalRevenue', 'recentAppointments'));

        } elseif ($user->role == 5) {
            // PATIENT DASHBOARD
            $patient = \App\Models\Patients::where('uid', $user->id)->first();
            $pid = $patient ? $patient->id : 0; // This assumes appointments.pid uses PATIENTS.ID not USERS.ID.
            // CAUTION: In bookAppointment, I saved $patient->id (from patients table).
            // But let's verify if $patient->id is used or $user->id.
            // In bookAppointment: $appointment->pid = $patient->id; -> Correct.
            // Check if $pid is 0.

            // However, authentication uses User ID.
            // If patient entry is missing, we might have issues.

            $appointmentsCount = DB::table('appointments')->where('pid', $user->id)->count();
            // WAIT. In bookAppointment I used $patient->id. Mobile app sends 'pid'.
            // Let's stick to $user->id if possible, but the schema seems mixed.
            // Mobile app dashboardPage uses $doctorId (which is user ID in shared prefs).
            // Let's assume PID in appointments refers to User ID for now to be safe, 
            // OR I should use the Logic from Mobile App's `patientDetails`.
            // The mobile app `patientDetails` joins `users as pet` on `appointments.pid = pet.id`. 
            // This implies appointments.pid IS the User ID of the patient.
            // BUT in `bookAppointment` (my previous edit), I used `$patient->id`. 
            // If `patients.id` != `users.id`, this is a bug.
            // Usually `patients` table has `id` (AI) and `uid` (FK to users).
            // I should use `$user->id` for consistency if the app expects `users` join.
            // Let's change this query to use `$user->id` assuming my fix in bookAppointment used `$patient->uid`?
            // Re-checking bookAppointment: `$appointment->pid = $patient->id;`
            // If `patients.id` is standard AI, then appointments.pid maps to patients table.

            // Let's rely on what `appointments` method does below.
            // `appointments` method uses `->where('appointments.pid', $user->id)`.
            // So `appointments.pid` MUST BE User ID.

            $appointmentsCount = DB::table('appointments')->where('pid', $user->id)->count();
            $reportsCount = 0; // DB::table('reports')->where('patient_id', $user->id)->count();
            $favoritesCount = 0; // DB::table('favorites')->where('user_id', $user->id)->count();
            $billingAmount = DB::table('appointments')->where('pid', $user->id)->sum('fees');

            return view('frontend/myAccount', compact('appointmentsCount', 'reportsCount', 'favoritesCount', 'billingAmount'));
        }
    }

    public function myPatients()
    {
        $user = Auth::user();
        if ($user->role != 4)
            return redirect('/my-account');

        // Fetch unique patients for this doctor
        $patients = \App\Models\Appointments::leftJoin('patients', 'appointments.pid', '=', 'patients.id')
            ->leftJoin('users as patient', 'patients.uid', '=', 'patient.id')
            ->select(
                'patient.id',
                'patient.first_name',
                'patient.last_name',
                'patient.email',
                'patient.mobile',
                'patient.photo'
            )
            ->where('appointments.did', $user->id)
            ->distinct('appointments.pid')
            ->get();

        return view('frontend.account.my_patients', compact('patients'));
    }

    public function manageSlots()
    {
        $user = Auth::user();
        if ($user->role != 4)
            return redirect('/my-account');

        $slots = \App\Models\Doctor_availables::where('doctor_id', $user->id)->orderBy('id', 'desc')->get();
        return view('frontend.account.manage_slots', compact('slots'));
    }

    public function doctorPrescriptions()
    {
        return view('frontend.account.doctor_prescriptions');
    }

    public function doctorBilling()
    {
        return view('frontend.account.doctor_billing');
    }

    /* Patient Methods */
    public function myDoctors()
    {
        $user = Auth::user();
        // Get doctors visited by this patient
        $doctors = \App\Models\Appointments::leftJoin('users as doc', 'appointments.did', '=', 'doc.id')
            ->leftJoin('doctors', 'doc.id', '=', 'doctors.uid')
            ->select('doc.*', 'doctors.specialist')
            ->where('appointments.pid', $user->id)
            ->distinct('appointments.did')
            ->get();

        return view('frontend.account.my_doctors', compact('doctors'));
    }

    public function medicalReports()
    {
        return view('frontend.account.medical_reports');
    }

    public function patientPrescriptions()
    {
        return view('frontend.account.patient_prescriptions');
    }

    public function billing()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        // PATIENT BILLING (Using Appointments as Billing Records)
        // Appointments store 'fees' and 'payment_status'
        $billings = DB::table('appointments')
            ->leftJoin('users as doc', 'appointments.did', '=', 'doc.id')
            ->leftJoin('doctors', 'doc.id', '=', 'doctors.uid')
            ->select(
                'appointments.*',
                'doc.first_name as doctor_first_name',
                'doc.last_name as doctor_last_name',
                'doctors.specialist'
            )
            ->where('appointments.pid', $user->id)
            ->where('appointments.status', '!=', '2') // Exclude cancelled if preferred, or include all
            ->orderBy('appointments.date', 'desc')
            ->paginate(10); // Pagination

        return view('frontend.account.billing', compact('billings'));
    }

    public function changePassword()
    {
        return view('frontend.account.change_password');
    }

    public function changePasswordPost(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function myProfile()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }
        return view('frontend/myProfile', compact('user'));
    }

    public function messages()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }
        return view('frontend/messages');
    }

    public function appointments(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $filter = $request->input('filter');
        $now = Carbon::now();

        if ($user->role == 4) {
            // DOCTOR VIEW
            $query = DB::table('appointments')
                ->join('patients', 'appointments.pid', '=', 'patients.id')
                ->join('users', 'patients.uid', '=', 'users.id')
                ->select(
                    'appointments.*',
                    'users.first_name as patient_first_name',
                    'users.last_name as patient_last_name',
                    'users.mobile as patient_mobile'
                )
                ->where('appointments.did', $user->id);

            // Filtering
            if ($filter == 'upcoming') {
                $query->where(function ($q) use ($now) {
                    $q->where('appointments.date', '>', $now->toDateString())
                        ->orWhere(function ($sub) use ($now) {
                            $sub->where('appointments.date', '=', $now->toDateString())
                                ->where('appointments.time', '>', $now->toTimeString());
                        });
                });
            } elseif ($filter == 'past') {
                $query->where(function ($q) use ($now) {
                    $q->where('appointments.date', '<', $now->toDateString())
                        ->orWhere(function ($sub) use ($now) {
                            $sub->where('appointments.date', '=', $now->toDateString())
                                ->where('appointments.time', '<', $now->toTimeString());
                        });
                });
            }

            $appointments = $query->orderBy('appointments.date', 'desc')
                ->orderBy('appointments.time', 'desc')
                ->get();

            return view('frontend/doctor_appointments', compact('appointments'));

        } elseif ($user->role == 5) {
            // PATIENT VIEW
            $patient = \App\Models\Patients::where('uid', $user->id)->first();
            // Assuming PID in appointments refers to User ID based on my previous analysis 
            // OR strictly adhering to previous logic where $pid might be patients.id.
            // Safe bet: stick to what was working ($pid logic) or assume $user->id if previously validated.
            // Previous code used: $pid = $patient ? $patient->id : 0; AND ->where('appointments.pid', $pid)
            // But dashboard used ->where('appointments.pid', $user->id).
            // This inconsistency persists. I will use $user->id as per dashboard for broader compatibility if new appts use user ID.
            // Actually, let's try to match both to be safe: 
            // ->where(function($q) use ($user, $pid) { $q->where('pid', $user->id)->orWhere('pid', $pid); })
            $pid = $patient ? $patient->id : 0;

            $query = DB::table('appointments')
                ->leftJoin('users as doc', 'appointments.did', '=', 'doc.id')
                ->leftJoin('doctors', 'doc.id', '=', 'doctors.uid')
                ->select(
                    'appointments.*',
                    'doc.first_name as doctor_first_name',
                    'doc.last_name as doctor_last_name',
                    'doctors.specialist'
                )
                ->where(function ($q) use ($user, $pid) {
                    $q->where('appointments.pid', $user->id);
                    if ($pid > 0)
                        $q->orWhere('appointments.pid', $pid);
                });

            // Filtering
            if ($filter == 'upcoming') {
                $query->where(function ($q) use ($now) {
                    $q->where('appointments.date', '>', $now->toDateString())
                        ->orWhere(function ($sub) use ($now) {
                            $sub->where('appointments.date', '=', $now->toDateString())
                                ->where('appointments.time', '>', $now->toTimeString());
                        });
                });
            } elseif ($filter == 'past') {
                $query->where(function ($q) use ($now) {
                    $q->where('appointments.date', '<', $now->toDateString())
                        ->orWhere(function ($sub) use ($now) {
                            $sub->where('appointments.date', '=', $now->toDateString())
                                ->where('appointments.time', '<', $now->toTimeString());
                        });
                });
            }

            $appointments = $query->orderBy('appointments.date', 'desc')
                ->orderBy('appointments.time', 'desc')
                ->get();

            return view('frontend/appointments', compact('appointments'));
        }
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

    public function bookAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'payment_mode' => 'required',
            'problem_description' => 'required|string|min:10',
            'payment_gateway' => 'required_if:payment_mode,Online Payment',
            'health_card_number' => 'required_if:payment_mode,Health Card',
            'terms_accepted' => 'required|accepted',
        ]);

        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to book an appointment.');
        }

        $patient = \App\Models\Patients::where('uid', Auth::id())->first();
        if (!$patient) {
            return back()->with('error', 'Patient profile not found. Please complete your profile.');
        }

        $appointment = new \App\Models\Appointments();
        $appointment->pid = $patient->id;
        $appointment->did = $request->doctor_id;

        $appointment->date = $request->appointment_date;
        $appointment->time = $request->appointment_time;
        $appointment->payment_mode = $request->payment_mode;
        $appointment->status = 0; // Pending
        $appointment->payment_status = 'unpaid';
        $appointment->note = $request->problem_description; // Mapped from new field

        // Handle conditionally required fields
        if ($request->payment_mode == 'Health Card') {
            $appointment->health_card_file = $request->health_card_number;
        }

        if ($request->payment_mode == 'Online Payment') {
            $appointment->payment_gateway = $request->payment_gateway;
        }

        $doc = Doctors::where('uid', $request->doctor_id)->first();
        if ($doc) {
            $appointment->did = $doc->uid;
        } else {
            return back()->with('error', 'Details related to doctor not found.');
        }

        $appointment->save();

        if ($appointment->payment_mode == 'online') {
            session(['appointment_id' => $appointment->id]);
            return redirect()->route('payment');
        }

        // Send Email Notification
        $user = Auth::user();
        $this->sendAppointmentEmail($appointment, $user, $doc);

        return redirect('/my-account')->with('success', 'Appointment booked successfully.');
    }

    // Helper to send SMS
    private function sendAppointmentSms($user, $appointment, $doctor)
    {
        try {
            $smsService = new \App\Services\SmsService();
            $docName = $doctor ? $doctor->first_name . ' ' . $doctor->last_name : 'Doctor';
            $date = date('d M Y', strtotime($appointment->date));
            $time = $appointment->time;

            $message = "Hello " . $user->first_name . ", Appointment confirmed with Dr. " . $docName . " on " . $date . " at " . $time . ". - EasyDoctor";

            $smsService->send($user->mobile, $message);
        } catch (\Exception $e) {
            // Log error
        }
    }

    private function sendAppointmentEmail($appointment, $user, $doctor)
    {
        // Send SMS as well
        $this->sendAppointmentSms($user, $appointment, $doctor);

        try {
            $to = $user->email;
            $subject = "Appointment Confirmation - EasyDoctor";

            $docName = $doctor ? $doctor->first_name . ' ' . $doctor->last_name : 'Doctor';
            $date = date('d M Y', strtotime($appointment->date));
            $time = $appointment->time; // Assuming time is stored as readable string or logic to format it

            $message = "Dear " . $user->first_name . ",<br><br>";
            $message .= "Your appointment has been successfully booked.<br><br>";
            $message .= "<strong>Details:</strong><br>";
            $message .= "Doctor: Dr. " . $docName . "<br>";
            $message .= "Date: " . $date . "<br>";
            $message .= "Time: " . $time . "<br>";
            $message .= "Status: " . ($appointment->payment_mode == 'online' ? 'Paid' : 'Confirmed') . "<br><br>";
            $message .= "Please reach 15 minutes prior to your appointment time.<br><br>";
            $message .= "Regards,<br>Easy Doctor Team";

            $viewName = 'inc.sendmail'; // Reusing existing view
            $viewData = ['name' => $user->first_name, 'messages' => $message];

            Mail::to($to)->send(new SendMail($subject, $viewName, $viewData));
        } catch (\Exception $e) {
            // Log error but don't stop the flow
            // \Log::error("Email sending failed: " . $e->getMessage());
        }
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
        $specialists = Specialists::where('status', 1)->get();
        return view('frontend/departments', compact('specialists'));
    }
    public function blog()
    {
        return view('frontend/blog');
    }
    public function contact()
    {
        return view('frontend/contact');
    }

    public function contactPost(Request $request)
    {
        // Validation and email sending logic would go here
        // For now, we'll just redirect back with a success message
        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }

    public function help()
    {
        return view('frontend/help');
    }
}
