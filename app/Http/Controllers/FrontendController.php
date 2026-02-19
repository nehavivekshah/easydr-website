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
use App\Models\Usermetas;
use App\Models\Patients;
use App\Models\Specialists;
use App\Models\Wallets;
use App\Models\Chats;

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
                'doctors.experience',
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
                'doctors.experience',
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
                'doctors.experience',
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
                'doctors.experience',
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
                'doctors.experience',
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
                'doctors.experience',
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

        return redirect('/login')->with('success', 'Successfully Logout.');
    }

    /*Website My Account Controllers*/
    public function myAccount()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $today = Carbon::now()->toDateString();
        $userAddress = \App\Models\Usermetas::where('uid', $user->id)->first();

        if ($user->role == 4) {
            // DOCTOR DASHBOARD
            $doctorId = $user->id;

            // Appointments Stats
            $appointmentsCount = \App\Models\Appointments::where('did', $doctorId)->count();
            $todayAppointmentsCount = \App\Models\Appointments::where('did', $doctorId)
                ->where('date', $today)
                ->count();

            // My Patients (Unique PIDs linked to this doctor)
            $patientsCount = \App\Models\Appointments::where('did', $doctorId)
                ->distinct('pid')
                ->count('pid');

            // Wallet & Revenue
            $doctorInfo = \App\Models\Doctors::where('uid', $user->id)->first();
            $walletAmount = $doctorInfo ? $doctorInfo->wallet : 0;

            // Total Revenue (Sum of fees from completed or confirmed/paid appointments)
            $totalRevenue = \App\Models\Appointments::where('did', $doctorId)
                ->whereIn('status', [1, 3]) // 1 = Confirmed, 3 = Completed
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

            // Doctor Availability
            $doctorAvailability = \App\Models\Doctor_availables::where('doctor_id', $user->id)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->first();

            // Calendar Data: Upcoming unique appointment dates
            $appointmentDates = \App\Models\Appointments::where('did', $doctorId)
                ->where('date', '>=', $today)
                ->distinct()
                ->pluck('date')
                ->toArray();

            // Revenue Data: Monthly revenue for current year
            $revenueRaw = \App\Models\Appointments::where('did', $doctorId)
                ->whereIn('status', [1, 3]) // Confirmed or Completed
                ->whereYear('date', Carbon::now()->year)
                ->selectRaw('MONTH(date) as month, SUM(fees) as total')
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            // Format revenue for Chart.js (12 months)
            $monthlyRevenue = [];
            for ($m = 1; $m <= 12; $m++) {
                $monthlyRevenue[] = $revenueRaw[$m] ?? 0;
            }

            return view('frontend/myAccount', compact(
                'appointmentsCount',
                'todayAppointmentsCount',
                'patientsCount',
                'walletAmount',
                'totalRevenue',
                'recentAppointments',
                'doctorInfo',
                'doctorAvailability',
                'userAddress',
                'appointmentDates',
                'monthlyRevenue'
            ));

        } elseif ($user->role == 5) {
            // PATIENT DASHBOARD
            $patient = \App\Models\Patients::where('uid', $user->id)->first();
            $pid = $patient ? $patient->id : 0;

            // Appointment Stats - Handling PID ambiguity (User ID vs Patient ID)
            $appointmentsCount = \App\Models\Appointments::where(function ($q) use ($user, $pid) {
                $q->where('pid', $user->id);
                if ($pid > 0)
                    $q->orWhere('pid', $pid);
            })->count();

            $todayAppointmentsCount = \App\Models\Appointments::where(function ($q) use ($user, $pid) {
                $q->where('pid', $user->id);
                if ($pid > 0)
                    $q->orWhere('pid', $pid);
            })->where('date', $today)->count();

            $completedAppointmentsCount = \App\Models\Appointments::where(function ($q) use ($user, $pid) {
                $q->where('pid', $user->id);
                if ($pid > 0)
                    $q->orWhere('pid', $pid);
            })->where('status', 3)->count();

            $todayCompletedCount = \App\Models\Appointments::where(function ($q) use ($user, $pid) {
                $q->where('pid', $user->id);
                if ($pid > 0)
                    $q->orWhere('pid', $pid);
            })->where('date', $today)->where('status', 3)->count();

            $pendingAppointmentsCount = \App\Models\Appointments::where(function ($q) use ($user, $pid) {
                $q->where('pid', $user->id);
                if ($pid > 0)
                    $q->orWhere('pid', $pid);
            })->where('status', 0)->count();

            $todayPendingCount = \App\Models\Appointments::where(function ($q) use ($user, $pid) {
                $q->where('pid', $user->id);
                if ($pid > 0)
                    $q->orWhere('pid', $pid);
            })->where('date', $today)->where('status', 0)->count();

            // Billing & Payments
            $billingAmount = \App\Models\Appointments::where(function ($q) use ($user, $pid) {
                $q->where('pid', $user->id);
                if ($pid > 0)
                    $q->orWhere('pid', $pid);
            })->where('payment_status', 'paid')->sum('fees');

            $todayPaymentCount = \App\Models\Appointments::where(function ($q) use ($user, $pid) {
                $q->where('pid', $user->id);
                if ($pid > 0)
                    $q->orWhere('pid', $pid);
            })->where('date', $today)->where('payment_status', 'paid')->count();

            // Favorites/Reviews placeholders (could be expanded later)
            $favoritesCount = 0;

            // Recent Appointments
            $recentAppointments = \App\Models\Appointments::leftJoin('doctors', 'appointments.did', '=', 'doctors.uid')
                ->leftJoin('users as doctor', 'doctors.uid', '=', 'doctor.id')
                ->select(
                    'appointments.*',
                    'doctor.first_name as doctor_first_name',
                    'doctor.last_name as doctor_last_name'
                )
                ->where(function ($q) use ($user, $pid) {
                    $q->where('appointments.pid', $user->id);
                    if ($pid > 0)
                        $q->orWhere('appointments.pid', $pid);
                })
                ->orderBy('appointments.date', 'desc')
                ->orderBy('appointments.time', 'desc')
                ->limit(5)
                ->get();

            // Calendar Data: Upcoming unique appointment dates
            $appointmentDates = \App\Models\Appointments::where(function ($q) use ($user, $pid) {
                $q->where('appointments.pid', $user->id);
                if ($pid > 0)
                    $q->orWhere('appointments.pid', $pid);
            })->where('date', '>=', $today)
                ->distinct()
                ->pluck('date')
                ->toArray();

            return view('frontend/myAccount', compact(
                'appointmentsCount',
                'todayAppointmentsCount',
                'completedAppointmentsCount',
                'todayCompletedCount',
                'pendingAppointmentsCount',
                'todayPendingCount',
                'billingAmount',
                'todayPaymentCount',
                'favoritesCount',
                'patient',
                'userAddress',
                'recentAppointments',
                'appointmentDates'
            ));
        }
    }

    public function myPatients()
    {
        $user = Auth::user();
        if (!$user || $user->role != 4)
            return redirect('/login');

        // Robust query using DB table directly to match other frontend methods
        // We select both users.id (for profile) and patients.id (for history lookups)
        $patients = DB::table('appointments')
            ->where('appointments.did', $user->id)
            ->leftJoin('patients', 'appointments.pid', '=', 'patients.id')
            ->leftJoin('users', 'patients.uid', '=', 'users.id')
            ->leftJoin('usermetas', 'users.id', '=', 'usermetas.uid')
            ->select(
                'users.id',
                'patients.id as patient_table_id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.mobile',
                'users.photo',
                'users.dob',
                'users.gender',
                'patients.blood_group',
                'usermetas.address',
                'usermetas.city',
                'usermetas.state',
                DB::raw('COUNT(appointments.id) as total_appointments'),
                DB::raw('MAX(appointments.date) as last_visit')
            )
            ->groupBy(
                'users.id',
                'patients.id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.mobile',
                'users.photo',
                'users.dob',
                'users.gender',
                'patients.blood_group',
                'usermetas.address',
                'usermetas.city',
                'usermetas.state'
            )
            ->get();

        $specialists = Specialists::where('status', 1)->get();
        $doctors = User::where('role', 4)->where('status', 1)->get();

        return view('frontend.account.my_patients', compact('patients', 'specialists', 'doctors'));
    }

    public function getPatientDetails($id)
    {
        $doctor_id = Auth::id();

        // Appointment History for this patient/doctor
        $appointments = \App\Models\Appointments::where('pid', $id)
            ->where('did', $doctor_id)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        // Prescriptions for this patient/doctor
        $prescriptions = \App\Models\Prescriptions::where('patient_id', $id)
            ->where('doctor_id', $doctor_id)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($prescriptions as $prescription) {
            $prescription->medicines = \App\Models\Prescription_medinices::where('prescribe_id', $prescription->id)->get();
        }

        return response()->json([
            'appointments' => $appointments,
            'prescriptions' => $prescriptions
        ]);
    }

    public function getPrescriptionMeta()
    {
        return response()->json([
            'dosages' => DB::table('dosages')->where('status', 1)->get(),
            'frequencies' => DB::table('frequencies')->where('status', 1)->get(),
            'durations' => DB::table('durations')->where('status', 1)->get(),
            'routes' => DB::table('routes')->where('status', 1)->get(),
            'meals' => DB::table('meals')->where('status', 1)->get(),
        ]);
    }

    public function manageSlots()
    {
        $user = Auth::user();
        if ($user->role != 4)
            return redirect('/my-account');

        $today = Carbon::today();

        // Active (Today)
        $activeSlots = $this->generateDateSlots($user->id, $today, $today);

        // Upcoming (Tomorrow to +14 days)
        $upcomingSlots = $this->generateDateSlots($user->id, $today->copy()->addDay(), $today->copy()->addDays(14));

        // Past (Yesterday to -7 days) - displayed in reverse chronological order usually, but helper generates date-wise. 
        // Let's generate and then reverse if needed, or just let view handle it.
        $pastSlots = $this->generateDateSlots($user->id, $today->copy()->subDays(7), $today->copy()->subDay());

        // Reverse past slots to show most recent past first
        $pastSlots = array_reverse($pastSlots);

        return view('frontend.account.manage_slots', compact('activeSlots', 'upcomingSlots', 'pastSlots'));
    }

    private function generateDateSlots($doctorId, $startDate, $endDate)
    {
        $dates = [];
        $current = $startDate->copy();
        $now = Carbon::now();

        // Fetch all availability rules that might overlap with the requested range
        // Rule: from_date <= end_range AND to_date >= start_range
        $rules = \App\Models\Doctor_availables::where('doctor_id', $doctorId)
            ->where('from_date', '<=', $endDate->toDateString())
            ->where('to_date', '>=', $startDate->toDateString())
            ->get();

        while ($current->lte($endDate)) {
            $daySlots = [];
            $dateString = $current->toDateString();
            $dayName = $current->format('l'); // Monday, Tuesday...

            foreach ($rules as $rule) {
                // Check if rule covers this date
                if ($rule->from_date <= $dateString && $rule->to_date >= $dateString) {
                    // Check if day matches
                    $availableDays = explode(',', $rule->available_days);
                    if (in_array($dayName, $availableDays)) {
                        // Generate slots for this rule
                        $start = Carbon::parse($dateString . ' ' . $rule->start_time);
                        $end = Carbon::parse($dateString . ' ' . $rule->end_time);
                        $duration = $rule->duration;

                        while ($start->copy()->addMinutes($duration)->lte($end)) {
                            // Check if slot falls within rule bounds
                            // Note: $start is slot start. Slot end is $start + duration.

                            $isPast = $start->lt($now); // Slot start time is in the past

                            $daySlots[] = [
                                'time' => $start->format('h:i A'),
                                'is_past' => $isPast
                            ];

                            $start->addMinutes($duration);
                        }
                    }
                }
            }

            // sort slots by time if multiple rules merged (optional but good practice)
            usort($daySlots, function ($a, $b) {
                return strtotime($a['time']) - strtotime($b['time']);
            });

            // Store even if empty? User design shows containers for dates. 
            // If empty, maybe show "No slots available".
            if (!empty($daySlots) || $current->isToday()) {
                $dates[] = [
                    'date' => $current->format('l, F j, Y'), // Today, February 5
                    'is_today' => $current->isToday(),
                    'slots' => $daySlots
                ];
            }

            $current->addDay();
        }

        return $dates;
    }

    public function saveSlot(Request $request)
    {
        $user = Auth::user();
        if ($user->role != 4)
            return redirect('/login');

        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'days' => 'required|array',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'duration' => 'required|integer|min:5'
        ]);

        $slot = new \App\Models\Doctor_availables();
        $slot->doctor_id = $user->id; // note: checking if doctor_id maps to user->id or doctor->uid in other code. FrontendController seems to use user->id usually.
        // Wait, Doctor_availables model usage in FrontendController::myAccount used `where('doctor_id', $user->id)`.
        // However, WebDoctorController uses:
        // $docAvailable->doctor_id = $validatedData['doctor']; (where doctor is uid from doctors table?)
        // Let's re-verify user->id vs doctors->uid mapping. 
        // In FrontendController::myAccount: $doctorId = $user->id; ... Appointments::where('did', $doctorId)
        // In Doctor_availables: doctor_id column.

        // Let's assume user->id is correct for now based on `myAccount`. 
        // Actually, let's check `WebDoctorController` again. 
        // ` Doctor_availables::leftJoin('users', 'doctor_availables.doctor_id', '=', 'users.id')` 
        // This suggests doctor_id IS users.id.

        $slot->doctor_id = $user->id;
        $slot->from_date = $request->from_date;
        $slot->to_date = $request->to_date;
        $slot->available_days = implode(',', $request->days);
        $slot->start_time = $request->start_time;
        $slot->end_time = $request->end_time;
        $slot->duration = $request->duration;
        $slot->save();

        return redirect()->back()->with('success', 'Availability slot added successfully!');
    }

    public function doctorPrescriptions(Request $request)
    {
        $query = DB::table('prescriptions')
            ->leftJoin('patients', 'prescriptions.patient_id', '=', 'patients.id')
            ->leftJoin('users as patient', 'patients.uid', '=', 'patient.id')
            ->select(
                'prescriptions.*',
                'patient.first_name as patient_first_name',
                'patient.last_name as patient_last_name',
                'patients.id as patient_id'
            )
            ->where('prescriptions.doctor_id', Auth::id())
            ->orderBy('prescriptions.created_at', 'desc');

        if ($request->filled('q')) {
            $q = $request->query('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('patient.first_name', 'LIKE', "%{$q}%")
                    ->orWhere('patient.last_name', 'LIKE', "%{$q}%")
                    ->orWhere('prescriptions.id', 'LIKE', "%{$q}%");
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('prescriptions.prescribed_date', $request->query('date'));
        }

        $prescriptions = $query->paginate(10)->withQueryString();

        foreach ($prescriptions as $p) {
            $p->medicines = DB::table('prescription_medinices')
                ->where('prescribe_id', $p->id)
                ->get();
            $p->medicine_count = count($p->medicines);
        }

        return view('frontend.account.doctor_prescriptions', compact('prescriptions'));
    }

    public function doctorBilling()
    {
        $user = Auth::user();
        $doctor = Doctors::where('uid', $user->id)->first();

        if (!$doctor) {
            return back()->with('error', 'Doctor profile not found.');
        }

        $transactions = Wallets::where('did', $doctor->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalEarnings = Wallets::where('did', $doctor->id)
            ->where('status', 'credit')
            ->sum('amount');

        $availableBalance = $doctor->wallet ?? 0;

        $pendingPayments = Wallets::where('did', $doctor->id)
            ->where('status', 'pending')
            ->sum('amount');

        $bankDetails = Usermetas::where('uid', $user->id)
            ->whereIn('key', ['bank_name', 'account_number', 'ifsc_code', 'account_name'])
            ->pluck('value', 'key');

        return view('frontend.account.doctor_billing', compact(
            'transactions',
            'totalEarnings',
            'availableBalance',
            'pendingPayments',
            'bankDetails'
        ));
    }

    public function postPaymentRequest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $doctor = Doctors::where('uid', $user->id)->first();

        if (!$doctor) {
            return back()->with('error', 'Doctor profile not found.');
        }

        if ($request->amount > ($doctor->wallet ?? 0)) {
            return back()->with('error', 'Insufficient balance for this withdrawal.');
        }

        // Save bank details to usermetas for future use
        $bankDetails = [
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
            'account_name' => $request->account_name,
        ];

        foreach ($bankDetails as $key => $value) {
            Usermetas::updateOrCreate(
                ['uid' => $user->id, 'key' => $key],
                ['value' => $value]
            );
        }

        // Create a withdrawal transaction in wallets
        Wallets::create([
            'did' => $doctor->id,
            'amount' => $request->amount,
            'details' => "Withdrawal request to {$request->bank_name} (Acc: {$request->account_number})",
            'status' => 'pending', // We'll use 'pending' for withdrawal requests as well.
            // In Wallets table, 'status' is credit / pending / health_card.
            // We can use 'pending' to indicate a withdrawal that hasn't been processed yet.
            // Or we can add a new status if we really want to, but 'pending' fits existing schema well enough.
        ]);

        // Note: We DON'T decrement the doctor's wallet yet. 
        // We only decrement it when the admin approves/pays it. 
        // Admin approval logic is out of scope for now, but we expect it to change status to 'paid' and decrement doctor->wallet.

        return back()->with('success', 'Payment request submitted successfully. Admin will review it shortly.');
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

        $userData = User::leftjoin('branches', 'users.branch', '=', 'branches.id')
            ->leftjoin('roles', 'users.role', '=', 'roles.id')
            ->leftjoin('usermetas', 'users.id', '=', 'usermetas.uid')
            ->leftjoin('patients', 'users.id', '=', 'patients.uid')
            ->leftjoin('doctors', 'users.id', '=', 'doctors.uid')
            ->select(
                'branches.name as company',
                'usermetas.designation',
                'usermetas.adhar',
                'usermetas.address',
                'usermetas.city',
                'usermetas.state',
                'usermetas.country',
                'usermetas.pincode',
                'patients.blood_group',
                'patients.medical_file',
                'patients.height',
                'patients.weight',
                'patients.health_card',
                'patients.health_card_file',
                'patients.marital_status',
                'patients.family_doctor_id',
                'doctors.specialist',
                'doctors.fees',
                'doctors.license',
                'doctors.education',
                'doctors.experience',
                'doctors.about',
                'roles.title',
                'roles.subtitle',
                'users.*'
            )
            ->where('users.id', '=', $user->id)
            ->first();

        $doctors = User::where('branch', ($user->branch ?? ''))
            ->where('role', 4)
            ->select('id', 'first_name', 'last_name')
            ->get();

        return view('frontend/myProfile', ['user' => $userData, 'doctors' => $doctors]);
    }

    public function profileInfo()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $userAddress = \App\Models\Usermetas::where('uid', $user->id)->first();
        $patient = null;
        $doctorInfo = null;
        $doctorAvailability = null;

        if ($user->role == 5) {
            // Patient
            $patient = \App\Models\Patients::where('uid', $user->id)->first();
        } elseif ($user->role == 4) {
            // Doctor
            $doctorInfo = \App\Models\Doctors::where('uid', $user->id)->first();
            $doctorAvailability = \App\Models\Doctor_availables::where('doctor_id', $user->id)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->first();
        }

        return view('frontend/profileInfo', compact('user', 'userAddress', 'patient', 'doctorInfo', 'doctorAvailability'));
    }

    public function messages()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        // Get contacts based on existing appointments (Patient/Doctor links)
        if ($user->role == 4) {
            // I am a Doctor, get Patients I've seen
            $contacts = DB::table('appointments')
                ->join('patients', 'appointments.pid', '=', 'patients.id')
                ->join('users', 'patients.uid', '=', 'users.id')
                ->where('appointments.did', $user->id)
                ->select('users.id', 'users.first_name', 'users.last_name', 'users.photo')
                ->distinct()
                ->get();
        } else {
            // I am a Patient, get Doctors I've visited
            $patient = DB::table('patients')->where('uid', $user->id)->first();
            $pid = $patient ? $patient->id : 0;

            $contacts = DB::table('appointments')
                ->join('users', 'appointments.did', '=', 'users.id')
                ->where(function ($q) use ($user, $pid) {
                    $q->where('appointments.pid', $user->id);
                    if ($pid > 0)
                        $q->orWhere('appointments.pid', $pid);
                })
                ->select('users.id', 'users.first_name', 'users.last_name', 'users.photo')
                ->distinct()
                ->get();
        }

        return view('frontend/messages', compact('contacts'));
    }

    public function getChatContacts()
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Unauthorized'], 401);

        if ($user->role == 4) {
            $contacts = DB::table('appointments')
                ->join('patients', 'appointments.pid', '=', 'patients.id')
                ->join('users', 'patients.uid', '=', 'users.id')
                ->where('appointments.did', $user->id)
                ->select('users.id', 'users.first_name', 'users.last_name', 'users.photo')
                ->distinct()
                ->get();
        } else {
            $patient = DB::table('patients')->where('uid', $user->id)->first();
            $pid = $patient ? $patient->id : 0;

            $contacts = DB::table('appointments')
                ->join('users', 'appointments.did', '=', 'users.id')
                ->where(function ($q) use ($user, $pid) {
                    $q->where('appointments.pid', $user->id);
                    if ($pid > 0)
                        $q->orWhere('appointments.pid', $pid);
                })
                ->select('users.id', 'users.first_name', 'users.last_name', 'users.photo')
                ->distinct()
                ->get();
        }

        return response()->json($contacts);
    }

    private function getActiveAppointment($user1_id, $user2_id)
    {
        // Identify who is doctor and who is patient
        $user1 = User::find($user1_id);
        $user2 = User::find($user2_id);

        if (!$user1 || !$user2)
            return null;

        $doctorId = null;
        $patientId = null;

        if ($user1->role == 4)
            $doctorId = $user1->id;
        if ($user1->role == 5) {
            $p = \App\Models\Patients::where('uid', $user1->id)->first();
            $patientId = $p ? $p->id : null;
        }

        if ($user2->role == 4)
            $doctorId = $user2->id;
        if ($user2->role == 5) {
            $p = \App\Models\Patients::where('uid', $user2->id)->first();
            $patientId = $p ? $p->id : null;
        }

        if (!$doctorId || !$patientId)
            return null;

        $now = Carbon::now();
        $date = $now->toDateString();

        // Get confirmed appointments for today
        $appointments = DB::table('appointments')
            ->where('did', $doctorId)
            ->where('pid', $patientId)
            ->where('date', $date)
            ->where('status', '1') // Confirmed
            ->get();

        foreach ($appointments as $appt) {
            $start = Carbon::parse($appt->date . ' ' . $appt->time);
            $duration = $appt->duration ?? 30;
            $end = $start->copy()->addMinutes($duration);

            if ($now->between($start, $end)) {
                return $appt;
            }
        }

        return null;
    }

    public function fetchMessages($recipient_id)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Unauthorized'], 401);

        // Check for active appointment to determine if chat is allowed
        $activeAppt = $this->getActiveAppointment($user->id, $recipient_id);
        $canChat = !is_null($activeAppt);

        // Fetch messages
        $messages = Chats::where(function ($query) use ($user, $recipient_id) {
            $query->where('pid', $user->id)->where('did', $recipient_id);
        })
            ->orWhere(function ($query) use ($user, $recipient_id) {
                $query->where('pid', $recipient_id)->where('did', $user->id);
            })
            ->orderBy('id', 'asc')
            ->get();

        // Collect Appointment IDs to fetch details for headers
        $apptIds = $messages->pluck('aid')->filter()->unique();
        $appointmentsMap = [];
        if ($apptIds->isNotEmpty()) {
            $appointmentsMap = DB::table('appointments')
                ->whereIn('id', $apptIds)
                ->get()
                ->keyBy('id');
        }

        return response()->json([
            'messages' => $messages,
            'active_appointment' => $activeAppt,
            'can_chat' => $canChat,
            'appointments_map' => $appointmentsMap
        ]);
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Unauthorized'], 401);

        $request->validate([
            'recipient_id' => 'required|integer',
            'message' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        ]);

        if (!$request->active_appointment && !$request->message && !$request->hasFile('file')) {
            return response()->json(['error' => 'Message or file is required.'], 422);
        }

        // Strict Check: active appointment required
        $activeAppt = $this->getActiveAppointment($user->id, $request->recipient_id);

        if (!$activeAppt) {
            return response()->json(['success' => false, 'error' => 'Chat is disabled. No active appointment slot found for now.'], 403);
        }

        $filename = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/chats'), $filename);
        }

        $chat = Chats::create([
            'pid' => $user->id, // Sender 
            'did' => $request->recipient_id, // Receiver
            'sender_id' => $user->id,
            'aid' => $activeAppt->id,
            'msg' => $request->message,
            'file' => $filename,
            'status' => 0
        ]);

        return response()->json(['success' => true, 'chat' => $chat]);
    }

    public function checkAppointmentStatus($recipient_id)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Unauthorized'], 401);

        $query = DB::table('appointments')->where('status', '1'); // Confirmed

        if ($user->role == 4) {
            // Patient matches
            $patient = DB::table('patients')->where('uid', $recipient_id)->first();
            if (!$patient)
                return response()->json(['appointment' => null]);

            $query->where('did', $user->id)->where('pid', $patient->id);
        } else {
            // Doctor matches
            $query->where('did', $recipient_id)->where('pid', $user->id);
        }

        $appointment = $query->orderBy('date', 'desc')->orderBy('time', 'desc')->first();

        if ($appointment) {
            $apptDateTime = Carbon::parse($appointment->date . ' ' . $appointment->time);
            $duration = $appointment->duration ?? 30;
            $endTime = $apptDateTime->copy()->addMinutes($duration);
            $now = Carbon::now();

            return response()->json([
                'appointment' => [
                    'id' => $appointment->id,
                    'is_overdue' => $now->gt($endTime),
                    'is_completed' => $appointment->is_completed ?? '0,0',
                    'end_time' => $endTime->toDateTimeString(),
                ]
            ]);
        }

        return response()->json(['appointment' => null]);
    }

    public function checkAnyOverdueAppointment()
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['appointment' => null]);

        $now = Carbon::now();

        // Find all confirmed appointments for this user
        $query = DB::table('appointments')
            ->where('status', '1'); // Confirmed

        if ($user->role == 4) {
            $query->where('did', $user->id);
        } else {
            // Patient might be linked by user->id (pid) or patients->id
            $patient = DB::table('patients')->where('uid', $user->id)->first();
            $pid = $patient ? $patient->id : 0;
            $query->where(function ($q) use ($user, $pid) {
                $q->where('pid', $user->id);
                if ($pid > 0)
                    $q->orWhere('pid', $pid);
            });
        }

        $appointments = $query->get();

        foreach ($appointments as $appointment) {
            $apptDateTime = Carbon::parse($appointment->date . ' ' . $appointment->time);
            $duration = $appointment->duration ?? 30;
            $endTime = $apptDateTime->copy()->addMinutes($duration);

            if ($now->gt($endTime)) {
                // Determine display name (if user is doctor, show patient name; if user is patient, show doctor name)
                $displayName = 'User';
                $displayId = null;

                if ($user->role == 4) {
                    $otherUser = DB::table('users')
                        ->join('patients', 'users.id', '=', 'patients.uid')
                        ->where('patients.id', $appointment->pid)
                        ->orWhere('users.id', $appointment->pid) // Fallback if pid is user id
                        ->select('users.id as uid', 'users.first_name', 'users.last_name')
                        ->first();
                    $displayName = $otherUser ? ($otherUser->first_name . ' ' . $otherUser->last_name) : 'Patient';
                    $displayId = $otherUser ? $otherUser->uid : null;
                } else {
                    $otherUser = DB::table('users')->where('id', $appointment->did)->first();
                    $displayName = $otherUser ? ($otherUser->first_name . ' ' . $otherUser->last_name) : 'Doctor';
                    $displayId = $otherUser ? $otherUser->id : null;
                }

                return response()->json([
                    'appointment' => [
                        'id' => $appointment->id,
                        'other_user_id' => $displayId,
                        'other_user_name' => $displayName,
                        'is_completed' => $appointment->is_completed ?? '0,0',
                        'end_time' => $endTime->toDateTimeString(),
                    ]
                ]);
            }
        }

        return response()->json(['appointment' => null]);
    }

    public function ajaxCompleteAppointment($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        $query = DB::table('appointments')->where('id', $id);

        if ($user->role == 4) {
            $query->where('did', $user->id);
        } else {
            $patient = DB::table('patients')->where('uid', $user->id)->first();
            $pid = $patient ? $patient->id : 0;
            $query->where(function ($q) use ($user, $pid) {
                $q->where('pid', $user->id);
                if ($pid > 0)
                    $q->orWhere('pid', $pid);
            });
        }

        $appointment = $query->first();

        if (!$appointment) {
            return response()->json(['success' => false, 'error' => 'Appointment not found.'], 404);
        }

        if ($appointment->status == '3') {
            return response()->json(['success' => true, 'message' => 'Already completed.']);
        }

        // Logic based on user request:
        // if doctor click -> update 1,0
        // if patient click -> update 1,1
        $updateData = [];
        if ($user->role == 4) {
            $updateData['is_completed'] = '1,0';
        } else {
            $updateData['is_completed'] = '1,1';
            $updateData['status'] = '3'; // Mark as fully completed if patient finishes it
        }

        $updated = DB::table('appointments')->where('id', $id)->update($updateData);

        if (!$updated && $appointment->is_completed !== $updateData['is_completed']) {
            return response()->json(['success' => false, 'error' => 'Database update failed.'], 500);
        }

        // Credit doctor if fully completed
        if ($user->role != 4) {
            try {
                $this->creditDoctorWallet($id);
            } catch (\Exception $e) {
                \Log::error('Wallet credit failed: ' . $e->getMessage());
            }
        }

        return response()->json(['success' => true]);
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
                    'users.mobile as patient_mobile',
                    'users.photo as patient_photo',
                    'users.dob as patient_dob',
                    'users.gender as patient_gender'
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

            $dateStr = $now->toDateString();
            $appointments = $query
                ->orderByRaw("CASE 
                    WHEN appointments.date = ? THEN 1 
                    WHEN appointments.date > ? THEN 2 
                    ELSE 3 
                END ASC", [$dateStr, $dateStr])
                ->orderByRaw("CASE WHEN appointments.date >= ? THEN appointments.date END ASC", [$dateStr])
                ->orderByRaw("CASE WHEN appointments.date < ? THEN appointments.date END DESC", [$dateStr])
                ->orderByRaw("CASE WHEN appointments.date >= ? THEN appointments.time END ASC", [$dateStr])
                ->orderByRaw("CASE WHEN appointments.date < ? THEN appointments.time END DESC", [$dateStr])
                ->paginate(6);

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
                    'doc.photo as doctor_photo',
                    'doc.mobile as doctor_phone',
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

            $dateStr = $now->toDateString();
            $appointments = $query
                ->orderByRaw("CASE 
                    WHEN appointments.date = ? THEN 1 
                    WHEN appointments.date > ? THEN 2 
                    ELSE 3 
                END ASC", [$dateStr, $dateStr])
                ->orderByRaw("CASE WHEN appointments.date >= ? THEN appointments.date END ASC", [$dateStr])
                ->orderByRaw("CASE WHEN appointments.date < ? THEN appointments.date END DESC", [$dateStr])
                ->orderByRaw("CASE WHEN appointments.date >= ? THEN appointments.time END ASC", [$dateStr])
                ->orderByRaw("CASE WHEN appointments.date < ? THEN appointments.time END DESC", [$dateStr])
                ->paginate(6);

            return view('frontend/appointments', compact('appointments'));

        } else {
            return redirect('/login');
        }
    }

    public function repay($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $appointment = \App\Models\Appointments::find($id);

        if (!$appointment) {
            return redirect('/my-account')->with('error', 'Appointment not found.');
        }

        // Validate ownership
        $patient = \App\Models\Patients::where('uid', $user->id)->first();
        $isOwner = ($appointment->pid == $user->id) || ($patient && $appointment->pid == $patient->id);

        if (!$isOwner) {
            return redirect('/my-account')->with('error', 'Unauthorized access.');
        }

        if ($appointment->payment_status == 'paid') {
            return redirect('/my-account')->with('info', 'This appointment is already paid.');
        }

        session(['appointment_id' => $id]);

        return redirect()->route('payment');
    }

    public function cancelAppointment($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        // Find the appointment and ensure it belongs to the logged-in user (as patient or doctor)
        $appointment = DB::table('appointments')
            ->where('id', $id)
            ->where(function ($q) use ($user) {
                $q->where('pid', $user->id)->orWhere('did', $user->id);
            })
            ->first();

        if (!$appointment) {
            return back()->with('error', 'Appointment not found or unauthorized.');
        }

        // Allow cancellation for status 0 (Pending) and status 1 (Confirmed)
        if (!in_array($appointment->status, ['0', '1'])) {
            return back()->with('error', 'This appointment cannot be cancelled in its current state.');
        }

        // 30-minute rule check
        $now = Carbon::now();
        $apptDateTime = Carbon::parse($appointment->date . ' ' . $appointment->time);
        $deadline = $apptDateTime->copy()->subMinutes(30);

        if ($now->gt($deadline)) {
            return back()->with('error', 'Cancellations are only allowed until 30 minutes before the scheduled time.');
        }

        // status '2' = Cancelled
        DB::table('appointments')->where('id', $id)->update(['status' => '2']);

        return back()->with('success', 'Appointment cancelled successfully.');
    }

    public function confirmAppointment($id)
    {
        $user = Auth::user();
        if (!$user || $user->role != 4) {
            return redirect('/login');
        }

        $appointment = DB::table('appointments')
            ->where('id', $id)
            ->where('did', $user->id)
            ->first();

        if (!$appointment) {
            return back()->with('error', 'Appointment not found or unauthorized.');
        }

        DB::table('appointments')->where('id', $id)->update(['status' => '1']);

        $this->creditDoctorWallet($id);

        return back()->with('success', 'Appointment confirmed successfully.');
    }

    public function completeAppointment($id)
    {
        $user = Auth::user();
        if (!$user || $user->role != 4) {
            return redirect('/login');
        }

        $appointment = DB::table('appointments')
            ->where('id', $id)
            ->where('did', $user->id)
            ->first();

        if (!$appointment) {
            return back()->with('error', 'Appointment not found or unauthorized.');
        }

        DB::table('appointments')->where('id', $id)->update(['status' => '3']);

        $this->creditDoctorWallet($id);

        return back()->with('success', 'Appointment marked as completed.');
    }

    public function markAppointmentPaid($id)
    {
        $user = Auth::user();
        if (!$user || $user->role != 4) {
            return redirect('/login');
        }

        $appointment = DB::table('appointments')
            ->where('id', $id)
            ->where('did', $user->id)
            ->first();

        if (!$appointment) {
            return back()->with('error', 'Appointment not found or unauthorized.');
        }

        DB::table('appointments')->where('id', $id)->update(['payment_status' => 'paid']);

        $this->creditDoctorWallet($id);

        return back()->with('success', 'Appointment marked as PAID.');
    }

    private function creditDoctorWallet($appointmentId)
    {
        $appointment = DB::table('appointments')->where('id', $appointmentId)->first();
        if (!$appointment)
            return;

        // Condition for credit: Status is 1 (Confirmed) or 3 (Completed) AND payment_status is 'paid'
        $isValidStatus = in_array($appointment->status, ['1', '3']);
        $isPaid = $appointment->payment_status == 'paid';

        if ($isValidStatus && $isPaid) {
            // Check if already credited
            $alreadyCredited = Wallets::where('aid', $appointmentId)->where('status', 'credit')->exists();

            if (!$alreadyCredited) {
                $doctor = Doctors::where('uid', $appointment->did)->first();
                if ($doctor) {
                    // Fallback to doctor's current fee if appointment fee is zero/empty
                    $fee = (!empty($appointment->fees) && $appointment->fees > 0)
                        ? $appointment->fees
                        : ($doctor->fees ?? 0);

                    if ($fee > 0) {
                        // Increment doctor wallet
                        $doctor->increment('wallet', $fee);

                        // Create wallet record
                        Wallets::create([
                            'did' => $doctor->id,
                            'aid' => $appointmentId,
                            'details' => 'Payment credited for Appointment ID: ' . $appointmentId,
                            'amount' => $fee,
                            'status' => 'credit',
                        ]);
                    }
                }
            }
        }
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
            'referral_file' => 'nullable|required_if:payment_mode,Health Card|file|mimes:jpg,jpeg,png,pdf|max:2048',
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

        // Handle Referral File Upload
        if ($request->hasFile('referral_file')) {
            $file = $request->file('referral_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Store in public/assets/images/referrals
            $file->move(public_path('assets/images/referrals'), $filename);
            $appointment->referral_file = $filename;
        }

        if ($request->payment_mode == 'Online Payment') {
            $appointment->payment_gateway = $request->payment_gateway;
        }

        $doc = Doctors::where('uid', $request->doctor_id)->first();
        if ($doc) {
            $appointment->did = $doc->uid;
            $appointment->fees = $doc->fees ?? 0; // Save fees at the time of booking
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

    public function searchMedicines(Request $request)
    {
        $query = $request->query('q');
        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $medicines = DB::table('medicines')
            ->leftJoin('medicine_types', 'medicines.type_id', '=', 'medicine_types.id')
            ->where('medicines.name', 'LIKE', "%{$query}%")
            ->where('medicines.status', 1)
            ->limit(10)
            ->get([
                'medicines.id',
                'medicines.name',
                'medicines.medicine_category',
                'medicines.description',
                'medicine_types.name as type_name'
            ]);

        return response()->json($medicines);
    }
}
