<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Usermetas;
use App\Models\Doctors;
use App\Models\Wallets;
use App\Models\Appointments;
use App\Models\Patients;
use App\Models\Specialists;
use App\Models\Doctor_availables;
use App\Models\Chats;
use App\Models\Wishlists;
use App\Models\Medicines;
use App\Models\Payment_gateway_configs;
use App\Models\Carts;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Razorpay\Api\Api as RazorpayApi;
use Exception;

class DoctorController extends ApiController
{
    public function walletHistory(Request $request, $id)
    {

        $doctor = Doctors::where('uid', $id)->first();
        $id = $doctor->id;
        //dd($id);
        // Page size (default 10)
        $perPage = $request->input('page', 10);

        $walletHistory = Wallets::leftJoin('appointments', 'wallets.aid', '=', 'appointments.id')
            ->leftJoin('users', 'appointments.pid', '=', 'users.id')
            ->select(
                'wallets.id',
                'users.first_name',
                'users.last_name',
                'wallets.details',
                'wallets.amount',
                'wallets.status',
                'wallets.created_at'
            )
            ->where('wallets.did', $id)
            ->orderBy('wallets.id', 'desc')
            ->paginate($perPage);

        if ($walletHistory->isEmpty()) {
            return $this->successResponse([], 'No wallet history found.');
        }

        return $this->successResponse([
            'data' => $walletHistory->items(),
            'current_page' => $walletHistory->currentPage(),
            'last_page' => $walletHistory->lastPage(),
            'per_page' => $walletHistory->perPage(),
            'total' => $walletHistory->total()
        ], 'Wallet history retrieved successfully.');
    }


    public function paymentHistory(Request $request, $id)
    {
        // Page size (default 10)
        $perPage = $request->input('page', 10);

        $paymentHistory = Appointments::leftJoin('users', 'appointments.pid', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.last_name',
                'appointments.fees',
                'appointments.payment_mode',
                'appointments.trans_details',
                'appointments.payment_status',
                'appointments.payment_date',
                'appointments.date',
                'appointments.time'
            )
            ->where('appointments.did', $id)
            ->orderBy('appointments.id', 'desc')
            ->paginate($perPage);   // <-- Pagination added

        if ($paymentHistory->isEmpty()) {
            return $this->successResponse([], 'No payment found.');
        }

        return $this->successResponse([
            'data' => $paymentHistory->items(),
            'current_page' => $paymentHistory->currentPage(),
            'last_page' => $paymentHistory->lastPage(),
            'per_page' => $paymentHistory->perPage(),
            'total' => $paymentHistory->total()
        ], 'Payment history retrieved successfully.');
    }

    public function medicines(Request $request, $uid = null)
    {
        $query = Medicines::query();

        if ($uid) {
            $query->withExists([
                'cart_items as in_cart' => function ($q) use ($uid) {
                    $q->where('user_id', $uid);
                }
            ]);
        } else {
            $query->selectRaw('*, 0 as in_cart');
        }

        // Change .get() to .paginate(10)
        $medicines = $query->paginate(10);

        // Transform the collection inside the paginator
        $medicines->getCollection()->transform(function ($item) {
            $item->in_cart = $item->in_cart ? 1 : 0;
            return $item;
        });

        // Return the whole paginated object
        return $this->successResponse($medicines, 'Medicines retrieved successfully.');
    }

    public function medicine($id)
    {

        // Fetch Medicines details between the patient and doctor
        $medicines = Medicines::where(function ($query) use ($id) {
            $query->where('id', '=', $id);
        })
            ->get();

        // Check if there are any medicine records
        if ($medicines->isEmpty()) {
            return $this->successResponse([], 'No medicine found.');
        }

        // Return the medicine details
        return $this->successResponse($medicines, 'Medicine details retrieved successfully.');

    }

    public function chats($pid, $did, $aid = null)
    {
        $query = Chats::leftJoin('appointments', 'chats.aid', '=', 'appointments.id')
            ->select('appointments.date', 'chats.*')
            ->where(function ($query) use ($pid, $did) {
                $query->where(function ($q) use ($pid, $did) {
                    $q->where('chats.pid', '=', $pid)
                        ->where('chats.did', '=', $did);
                })
                    ->orWhere(function ($q) use ($pid, $did) {
                        $q->where('chats.pid', '=', $did)
                            ->where('chats.did', '=', $pid);
                    });
            });

        if (!is_null($aid)) {
            $query->where('chats.aid', '=', $aid);
        }

        $chats = $query->get();

        if ($chats->isEmpty()) {
            return $this->successResponse([], 'No chat history found.');
        }

        return $this->successResponse($chats, 'Chat history retrieved successfully.');
    }

    public function chatPost(Request $request, $id, $did, $aid)
    {
        // Validate the incoming request
        $request->validate([
            'message' => 'nullable|string|max:500',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt|max:2048', // Adjust MIME types as needed
        ]);

        // Create a new chat entry
        $chat = new Chats();
        $chat->pid = $id; // Patient ID
        $chat->did = $did; // Doctor ID
        $chat->aid = $aid; // Doctor ID
        $chat->msg = $request->input('message', null);

        // Handle file attachment
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->move(public_path('assets/images/uploads'), $filename); // Move to the public directory

            $chat->file = 'assets/images/uploads/' . $filename; // Save the relative file path in the database
        }

        $chat->status = $request->input('status', '0'); // Default status
        $chat->save();

        // Return the saved chat entry
        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data' => $chat,
        ], 200);
    }

    public function cancelAppointment($id)
    {
        // Find the appointment by ID
        $cancelAppointment = Appointments::find($id);

        // Check if the appointment exists
        if (!$cancelAppointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found.',
            ], 404);
        }

        // Update the status to '2' (Cancelled)
        $cancelAppointment->status = '2';
        $cancelAppointment->save();

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'The appointment was successfully cancelled.',
            'data' => $cancelAppointment,
        ], 200);
    }

    public function wishlists($uid)
    {
        try {
            // Fetch wishlist entries for the given user ID
            $wishlists = Wishlists::leftjoin('doctors', 'wishlists.did', '=', 'doctors.uid')
                ->leftjoin('users', 'doctors.uid', '=', 'users.id')
                ->where('wishlists.uid', '=', $uid)
                ->get();

            // Check if the wishlist is empty
            if ($wishlists->isEmpty()) {
                return $this->successResponse([], 'No wishlist doctors found.');
            }

            // Return the wishlist data
            return $this->successResponse($wishlists, 'List of wishlist doctors retrieved successfully.');
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the wishlist.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function wishlistPost($uid, $did)
    {
        // Check if the wishlist entry exists
        $existingWishlist = Wishlists::where('uid', '=', $uid)->where('did', '=', $did)->first();

        if ($existingWishlist) {
            // If the entry exists, delete it
            $existingWishlist->delete();

            return $this->successResponse(null, 'Wishlist entry removed successfully.');
        } else {
            // If no entry exists, create a new one
            $wishlist = new Wishlists();
            $wishlist->uid = $uid;
            $wishlist->did = $did;
            $wishlist->save();

            return $this->successResponse($wishlist, 'Wishlist entry added successfully.');
        }
    }

    public function specialists()
    {
        // Join specialists with doctors and ensure that only specialists with associated doctors are selected
        $specialists = Specialists::join('doctors', 'specialists.title', '=', 'doctors.specialist')
            ->select('doctors.specialist', 'specialists.*')
            ->distinct()
            ->get();

        return $this->successResponse($specialists, 'List of available registered specialists');
    }

    public function doctorAvailable($id)
    {
        $now = Carbon::now();
        $currentDay = $now->format('l'); // Current day of the week
        /*
            ->where('start_time', '<=', $now->toTimeString())
            ->where('end_time', '>=', $now->toTimeString())
            */
        $doctorAvailable = Doctor_availables::where('doctor_id', $id)
            ->where('from_date', '<=', $now->toDateString())
            ->where('to_date', '>=', $now->toDateString())
            ->orderBy('from_date')
            ->get(['from_date', 'to_date', 'available_days', 'start_time', 'end_time', 'duration']);

        return $this->successResponse($doctorAvailable, 'Doctor Available Slots');
    }

    public function doctors(Request $request)
    {
        $search = $request->search ?? '';

        // Assuming the logged-in user's ID is accessible via Auth::id()
        $userId = $request->uid ?? '';

        $doctors = Doctors::leftJoin('users', 'doctors.uid', '=', 'users.id')
            ->leftJoin('doctor_reviews', 'doctors.uid', '=', 'doctor_reviews.doctor_id')
            // Left join with the wishlists table to check if the doctor is in the user's wishlist
            ->leftJoin('wishlists', function ($join) use ($userId) {
                $join->on('wishlists.did', '=', 'doctors.uid')
                    ->where('wishlists.uid', '=', $userId);
            })
            ->select(
                'doctors.specialist',
                'doctors.education',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.photo',
                'users.mobile',
                'users.email',
                'users.email_verified_at',
                'users.branch',
                'users.created_at',
                'users.updated_at',
                DB::raw('IFNULL(AVG(doctor_reviews.rating), 0) as average_rating'),
                DB::raw('IF(MAX(wishlists.id) IS NULL, 0, 1) as wishlist') // Use MAX() to avoid GROUP BY error
            )
            ->where('users.role', '=', '4') // Doctor role
            ->where('users.status', '=', '1') // Active users
            ->groupBy(
                'users.id',
                'doctors.specialist',
                'doctors.education',
                'users.first_name',
                'users.last_name',
                'users.photo',
                'users.mobile',
                'users.email',
                'users.email_verified_at',
                'users.branch',
                'users.created_at',
                'users.updated_at'
            )
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('users.first_name', 'like', "%{$search}%")
                        ->orWhere('users.last_name', 'like', "%{$search}%")
                        ->orWhereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE ?", ["%{$search}%"])
                        ->orWhere('doctors.specialist', 'like', "%{$search}%")
                        ->orWhere('doctors.education', 'like', "%{$search}%")
                        ->orWhereRaw("CONCAT(users.first_name, ' ', users.last_name, ' - ', doctors.specialist, ' - ', doctors.education) LIKE ?", ["%{$search}%"]);
                });
            })->get();


        return $this->successResponse($doctors, 'List of available registered doctors');
    }

    public function doctor($doctorId)
    {
        $doctorId = intval($doctorId);
        $userId = Auth::id(); // Assuming the user is authenticated

        // Fetch doctor details
        $doctor = Doctors::leftJoin('users', 'doctors.uid', '=', 'users.id')
            ->leftJoin('usermetas', 'doctors.uid', '=', 'usermetas.uid')
            ->leftJoin('doctor_reviews', 'doctors.uid', '=', 'doctor_reviews.doctor_id')
            ->leftJoin('wishlists', function ($join) use ($doctorId, $userId) {
                $join->on('wishlists.did', '=', 'doctors.uid')
                    ->where('wishlists.uid', '=', $userId);
            })
            ->leftJoin('appointments', 'appointments.did', '=', 'doctors.uid') // Join appointments for total count
            ->select(
                'users.id',
                'users.branch',
                'users.first_name',
                'users.last_name',
                'users.photo',
                'users.mobile',
                'users.altr_mobile',
                'users.email',
                'usermetas.designation',
                'usermetas.adhar',
                'usermetas.address',
                'usermetas.city',
                'usermetas.state',
                'usermetas.country',
                'usermetas.pincode',
                'users.email_verified_at',
                'doctors.specialist',
                'doctors.experience',
                'doctors.fees',
                'doctors.education',
                'doctors.license',
                'doctors.about',
                'doctors.extra',
                'users.created_at',
                'users.updated_at',
                DB::raw('COALESCE(AVG(doctor_reviews.rating), 0) as average_rating'),
                DB::raw('CASE WHEN COUNT(wishlists.id) > 0 THEN 1 ELSE 0 END as wishlist'),
                DB::raw('COUNT(appointments.id) as appointment_count'), // Count total appointments
                DB::raw('CASE WHEN COUNT(appointments.id) > 0 THEN 1 ELSE 0 END as appointment') // Current appointment status
            )
            ->where([
                ['users.role', '=', '4'],
                ['users.status', '=', '1'],
                ['doctors.uid', '=', $doctorId],
            ])
            ->groupBy(
                'users.id',
                'users.branch',
                'users.first_name',
                'users.last_name',
                'users.photo',
                'users.mobile',
                'users.altr_mobile',
                'users.email',
                'usermetas.designation',
                'usermetas.adhar',
                'usermetas.address',
                'usermetas.city',
                'usermetas.state',
                'usermetas.country',
                'usermetas.pincode',
                'users.email_verified_at',
                'doctors.specialist',
                'doctors.experience',
                'doctors.fees',
                'doctors.education',
                'doctors.license',
                'doctors.about',
                'doctors.extra',
                'users.created_at',
                'users.updated_at'
            )
            ->first();

        if (!$doctor) {
            return $this->errorResponse('Doctor not found', 404);
        }

        $now = Carbon::now();
        $currentDay = $now->format('l');

        // Fetch doctor's available times
        $availableTimes = Doctor_availables::where('doctor_id', $doctorId)
            ->where('from_date', '<=', $now->toDateString())
            ->where('to_date', '>=', $now->toDateString())
            ->orderBy('from_date')
            ->get();

        /*->where('start_time', '<=', $now->toTimeString())
        ->where('end_time', '>=', $now->toTimeString())*/

        // Format the response
        $doctorData = [
            'id' => $doctor->id,
            'branch' => $doctor->branch,
            'first_name' => $doctor->first_name,
            'last_name' => $doctor->last_name,
            'photo' => $doctor->photo,
            'mobile' => $doctor->mobile,
            'altr_mobile' => $doctor->altr_mobile,
            'email' => $doctor->email,
            'designation' => $doctor->designation,
            'adhar' => $doctor->adhar,
            'address' => $doctor->address,
            'city' => $doctor->city,
            'state' => $doctor->state,
            'country' => $doctor->country,
            'pincode' => $doctor->pincode,
            'email_verified_at' => $doctor->email_verified_at,
            'specialist' => $doctor->specialist,
            'experience' => $doctor->experience,
            'fees' => $doctor->fees,
            'license' => $doctor->license,
            'education' => $doctor->education,
            'about' => $doctor->about,
            'extra' => $doctor->extra,
            'created_at' => $doctor->created_at,
            'updated_at' => $doctor->updated_at,
            'average_rating' => $doctor->average_rating ?? 0,
            'wishlist' => $doctor->wishlist > 0 ? 1 : 0,
            'appointment' => $doctor->appointment > 0 ? 1 : 0,
            'appointment_count' => $doctor->appointment_count ?? 0,
            'available_times' => $availableTimes,
        ];

        return $this->successResponse($doctorData, 'Doctor Details with Available Times');
    }

    public function wallet($doctorId)
    {
        $doctorId = intval($doctorId);
        $userId = Auth::id(); // Assuming the user is authenticated

        // Fetch doctor details
        $doctor = Doctors::where([
            ['doctors.uid', '=', $doctorId],
        ])
            ->first();

        if (!$doctor) {
            return $this->errorResponse('Doctor not found', 404);
        }

        // Format the response
        $doctorData = [
            'id' => $doctor->id,
            'wallet_amount' => $doctor->wallet,
        ];

        return $this->successResponse($doctorData, 'Doctor Details with Available Times');
    }

    public function doctorPost($doctorId, Request $request)
    {
        // Retrieve the user record
        $user = User::find($doctorId);

        $name = explode(' ', $request->name);

        $user->first_name = $name[0] ?? '';
        $user->last_name = $name[1] ?? '';
        $user->email = $request->email ?? '';
        $user->mobile = $request->mobile ?? '';
        $user->altr_mobile = $request->alternative_mobile ?? '';
        $user->dob = $request->dob ?? '';
        $user->gender = $request->gender ?? '';

        // Save (or update) the user. save() works on both new and existing models.
        $user->save();

        // Save additional user metadata if provided. `id`, `uid`, ``, ``, ``, ``, ``, ``, ``, ``
        if (!empty($request->country) || !empty($request->pincode)) {

            $um = Usermetas::where('uid', $doctorId)->first();

            $usermeta = $um ? $um : new Usermetas();

            $usermeta->uid = $user->id;
            $usermeta->designation = $request->designation ?? '';

            if (!empty($request->adhar)) {
                $usermeta->adhar = $request->adhar;
                $usermeta->adhar_verified_at = NOW();
            }

            $usermeta->address = $request->address ?? '';
            $usermeta->city = $request->city ?? '';
            $usermeta->state = $request->state ?? '';
            $usermeta->country = $request->country ?? '';
            $usermeta->pincode = $request->pincode ?? '';
            $usermeta->save();

        }

        // Here, we use $doctorId if available; otherwise, you might consider $request->id.
        $du = Doctors::where('uid', $doctorId)->first();
        $doctor = $du ? $du : new Doctors();
        $doctor->uid = $user->id;
        $doctor->specialist = $request->specialization ?? '';
        $doctor->license = $request->medical_license_number ?? '';
        $doctor->education = $request->education ?? '';
        $doctor->about = $request->about ?? '';
        $doctor->extra = $request->extra ?? '';
        $doctor->save();

        // Return a JSON response. Adjust the 'data' field as needed.
        return response()->json([
            'success' => true,
            'message' => 'Successfully updated.',
            'data' => $user  // returning the updated user record
        ], 200);
    }

    public function doctorBoard($id)
    {
        // Fetch doctor details along with average rating
        $doctor = Doctors::leftJoin('users', 'doctors.uid', '=', 'users.id')
            ->leftJoin('doctor_reviews', 'doctors.uid', '=', 'doctor_reviews.doctor_id')
            ->select(
                'doctors.specialist',
                'doctors.education',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.photo',
                'users.mobile',
                'users.email',
                'users.email_verified_at',
                'users.branch',
                'users.created_at',
                'users.updated_at',
                DB::raw('IFNULL(AVG(doctor_reviews.rating), 0) as average_rating')
            )
            ->where('users.role', '=', '4') // Role 4 represents doctors
            ->where('users.status', '=', '1') // Active users only
            ->where('doctors.id', '=', $id) // Specific doctor ID
            ->groupBy(
                'users.id',
                'doctors.specialist',
                'doctors.education',
                'users.first_name',
                'users.last_name',
                'users.photo',
                'users.mobile',
                'users.email',
                'users.email_verified_at',
                'users.branch',
                'users.created_at',
                'users.updated_at'
            )
            ->first(); // Fetch single record for the doctor

        // Fetch appointments for the doctor
        $appointments = Appointments::leftJoin('users', 'appointments.pid', '=', 'users.id')
            ->select(
                'users.first_name as patient_first_name',
                'users.last_name as patient_last_name',
                'users.mobile as patient_mobile',
                'appointments.*'
            )
            ->where('appointments.did', '=', $id) // Doctor ID in appointments
            ->get();

        // Get the count of unique patients
        $patientCount = Appointments::where('did', '=', $id)
            ->distinct('pid') // Count distinct patient IDs
            ->count('pid');

        // Get the count of total appointments
        $appointmentCount = Appointments::where('did', '=', $id)->count();

        // Return response with doctor details, appointments, patient count, and appointment count
        return $this->successResponse([
            'doctorDetails' => $doctor,
            'appointments' => $appointments,
            'earringAmt' => $patientCount,
            'patientCount' => $patientCount,
            'appointmentCount' => $appointmentCount,
        ], 'Doctor Details');
    }

    public function appointmentsOverview($id, Request $request)
    {
        // Get the filter from the query parameters. Default to 'all' if not provided.
        $filter = strtolower($request->query('filter', 'all'));

        // Get the current date/time.
        $currentDateTime = Carbon::now();
        $yesterdayDate = Carbon::yesterday();

        // Determine the date range based on the filter.
        switch ($filter) {
            case 'today':
                $startDate = $currentDateTime->copy()->startOfDay();
                $endDate = $currentDateTime->copy()->endOfDay();
                break;
            case 'yesterday':
                $startDate = $yesterdayDate->copy()->startOfDay();
                $endDate = $yesterdayDate->copy()->endOfDay();
                break;
            case 'weekly':
                $startDate = $currentDateTime->copy()->startOfWeek();
                $endDate = $currentDateTime->copy()->endOfWeek();
                break;
            case 'monthly':
                $startDate = $currentDateTime->copy()->startOfMonth();
                $endDate = $currentDateTime->copy()->endOfMonth();
                break;
            case 'yearly':
                $startDate = $currentDateTime->copy()->startOfYear();
                $endDate = $currentDateTime->copy()->endOfYear();
                break;
            default:
                // "all" or any unknown filter returns all appointments.
                $startDate = Carbon::parse('1900-01-01');
                $endDate = Carbon::parse('3000-12-31');
                break;
        }

        // Log the selected date range for debugging.
        \Log::info("Filter: {$filter}. Start Date: " . $startDate->toDateTimeString() . ", End Date: " . $endDate->toDateTimeString());

        // Fetch all appointments within the selected date range.
        // Adjust the where clause if $id should only match a specific column.
        $appointments = Appointments::where(function ($query) use ($id) {
            $query->where('appointments.pid', $id)
                ->orWhere('appointments.did', $id);
        })
            // Ensure that your "date" column is stored in a compatible format.
            ->whereBetween('appointments.date', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('appointments.date', 'desc')
            ->orderBy('appointments.time', 'desc')
            ->get();

        // Optional: Log the number of appointments returned.
        \Log::info("Total appointments fetched: " . $appointments->count());

        // Count different appointment statuses.
        $completedCount = $appointments->where('status', 1)->count(); // Status 1 = Completed
        $cancelledCount = $appointments->where('status', 2)->count(); // Status 2 = Cancelled

        // For appointments with status 0, differentiate based on the date.
        $upcomingCount = 0;
        $notAttendedCount = 0;
        foreach ($appointments as $appointment) {
            if ($appointment->status == 0) {
                // Convert the appointment date to a Carbon instance.
                $appointmentDate = Carbon::parse($appointment->date);
                // Compare the appointment date with the current date/time.
                if ($appointmentDate->greaterThan($currentDateTime)) {
                    $upcomingCount++;
                } else {
                    $notAttendedCount++;
                }
            }
        }

        // Debug: Log the status counts.
        \Log::info("Upcoming: {$upcomingCount}, Completed: {$completedCount}, Cancelled: {$cancelledCount}, Not Attended: {$notAttendedCount}");

        // Response data
        return $this->successResponse([
            'overview' => [
                'upcoming_count' => $upcomingCount,
                'completed_count' => $completedCount,
                'cancelled_count' => $cancelledCount,
                'not_attended_count' => $notAttendedCount,
            ],
        ], "Appointment overview for {$filter}");
    }

    public function appointments($id, $did = null)
    {
        $currentDateTime = Carbon::now();
        $todayDate = $currentDateTime->toDateString();
        $todayTime = $currentDateTime->toTimeString();

        // Build base query
        $query = Appointments::leftJoin('users as pet', 'appointments.pid', '=', 'pet.id')
            ->leftJoin('users as doc', 'appointments.did', '=', 'doc.id')
            ->leftJoin('doctors', 'doc.id', '=', 'doctors.uid')
            ->leftJoin('patients', 'pet.id', '=', 'patients.uid')
            ->leftJoin('users as famdoc', 'patients.familyDoctor', '=', 'famdoc.id')
            ->select(
                'pet.first_name as patient_first_name',
                'pet.last_name as patient_last_name',
                'pet.mobile as patient_mobile',
                'pet.email as patient_email',
                'famdoc.first_name as famdoctor_first_name',
                'famdoc.last_name as famdoctor_last_name',
                'famdoc.email as famdoctor_email',
                'doc.first_name as doctor_first_name',
                'doc.last_name as doctor_last_name',
                'doc.mobile as doctor_mobile',
                'doc.email as doctor_email',
                'doctors.specialist',
                'doctors.education',
                'patients.blood_group',
                'patients.medical_file',
                'patients.health_card_file',
                'appointments.*'
            )
            ->where(function ($query) use ($id) {
                $query->where('appointments.pid', $id)
                    ->orWhere('appointments.did', $id);
            });

        // Apply this condition only if $did is not null
        if (!is_null($did)) {
            $query->where(function ($query) use ($did) {
                $query->where('appointments.pid', $did)
                    ->orWhere('appointments.did', $did);
            });
        }

        // Get results sorted by date and time
        $appointments = $query->orderBy('appointments.date', 'desc')
            ->orderBy('appointments.time', 'desc')
            ->get();

        // Categorize
        $today = collect();
        $upcoming = collect();
        $past = collect();

        foreach ($appointments as $appointment) {
            if ($appointment->date === $todayDate) {
                if ($appointment->time >= $todayTime) {
                    $today->push($appointment);
                } else {
                    $past->push($appointment);
                }
            } elseif ($appointment->date > $todayDate) {
                $upcoming->push($appointment);
            } else {
                $past->push($appointment);
            }
        }

        return $this->successResponse([
            'upcoming' => $upcoming->values(),
            'today' => $today->values(),
            'past' => $past->values(),
        ], 'List of appointments categorized by time.');
    }

    public function myDoctors(Request $request)
    {
        // Retrieve the user ID from the request  
        $id = $request->user_id ?? '';

        // Fetch all appointments with joins  
        $doctors = Appointments::leftJoin('users as doc', 'appointments.did', '=', 'doc.id')
            ->leftJoin('doctors', 'doc.id', '=', 'doctors.uid')
            ->select(
                'appointments.id',
                'appointments.did',
                'doc.first_name as doctor_first_name',
                'doc.last_name as doctor_last_name',
                'doc.mobile as doctor_mobile',
                'doc.email as doctor_email',
                'doc.photo',
                'doctors.specialist',
                'doctors.education',
                'appointments.date',
                'appointments.time',
                'appointments.status'
            )
            ->where('appointments.pid', $id)
            ->orderBy('appointments.created_at', 'desc')
            ->get();

        // Get unique patients by ID  
        $uniqueDoctors = $doctors->unique('did')->values();

        // Return the success response with the list of unique doctors for the patient  
        return $this->successResponse([
            'Doctors' => $uniqueDoctors
        ], 'List of unique doctors for the patient.');
    }

    public function patients($id)
    {
        $currentDateTime = Carbon::now();

        // Fetch all patients with joins
        $patients = Appointments::leftJoin('users as pet', 'appointments.pid', '=', 'pet.id')
            ->leftJoin('users as doc', 'appointments.did', '=', 'doc.id')
            ->leftJoin('doctors', 'doc.id', '=', 'doctors.uid')
            ->leftJoin('patients', 'pet.id', '=', 'patients.uid')
            ->leftJoin('users as famdoc', 'patients.familyDoctor', '=', 'famdoc.id')
            ->select(
                'appointments.pid',
                'pet.first_name as patient_first_name',
                'pet.last_name as patient_last_name',
                'pet.mobile as patient_mobile',
                'pet.email as patient_email',
                'pet.photo as image_url',
                'famdoc.first_name as famdoctor_first_name',
                'famdoc.last_name as famdoctor_last_name',
                'famdoc.email as famdoctor_email',
                'doc.first_name as doctor_first_name',
                'doc.last_name as doctor_last_name',
                'doc.mobile as doctor_mobile',
                'doc.email as doctor_email',
                'doctors.specialist',
                'doctors.education',
                'patients.blood_group',
                'patients.medical_file',
                'patients.health_card_file',
                'appointments.date',
                'appointments.time',
                'appointments.status'
            )
            ->where('appointments.did', $id)
            ->orderBy('appointments.date', 'desc')
            ->orderBy('appointments.time', 'desc')
            ->get();

        // Get unique patients by ID
        $uniquePatients = $patients->unique('pid')->values();

        return $this->successResponse([
            'patients' => $uniquePatients
        ], 'List of unique patients for the doctor.');
    }

    public function patientDetails($patientId, $doctorId)
    {
        $currentDateTime = Carbon::now();
        $nextDateTime = $currentDateTime->copy()->addDay()->startOfDay();

        // Fetch all appointments with joins  `date`, `time`, `note`, `medical_file`, `health_card_file`, `fees`, `payment_mode`, `payment_status`, `is_completed`, `status`
        $appointments = Appointments::leftJoin('users as pet', 'appointments.pid', '=', 'pet.id')
            ->leftJoin('users as doc', 'appointments.did', '=', 'doc.id')
            ->leftJoin('patients', 'pet.id', '=', 'patients.uid')
            ->leftJoin('usermetas', 'appointments.pid', '=', 'usermetas.uid')
            ->leftJoin('users as famdoc', 'patients.familyDoctor', '=', 'famdoc.id')
            ->select(
                'doc.first_name as doctor_first_name',
                'doc.last_name as doctor_last_name',
                'doc.photo as doctor_image_url',
                'pet.first_name as patient_first_name',
                'pet.last_name as patient_last_name',
                'pet.photo as image_url',
                'pet.mobile as patient_mobile',
                'pet.altr_mobile as patient_altr_mobile',
                'pet.email as patient_email',
                'pet.dob as patient_dob',
                'pet.gender as patient_gender',
                'famdoc.first_name as famdoctor_first_name',
                'famdoc.last_name as famdoctor_last_name',
                'famdoc.email as famdoctor_email',
                'usermetas.designation',
                'usermetas.adhar',
                'usermetas.adhar_verified_at',
                'usermetas.address',
                'usermetas.city',
                'usermetas.state',
                'usermetas.country',
                'usermetas.pincode',
                'appointments.date',
                'appointments.time',
                'appointments.payment_mode',
                'appointments.payment_status',
                'appointments.is_completed',
                'patients.*'
            )
            ->where(function ($query) use ($patientId, $doctorId) {
                $query->where('appointments.pid', $patientId);
                $query->where('appointments.did', $doctorId);
            })
            ->orderBy('appointments.date', 'desc')
            ->orderBy('appointments.time', 'desc')
            ->get();  // Remove the groupBy here!  We'll group later.

        // Categorize appointments
        $todayDate = $currentDateTime->toDateString();
        $todayTime = $currentDateTime->toTimeString();

        $past = $appointments->filter(fn($appointment) => $appointment->date < $todayDate ||
            ($appointment->date === $todayDate && $appointment->time < $todayTime));

        $groupedPast = $past->groupBy('pid')->map(function ($appointmentsForPatient) {
            return $appointmentsForPatient->first();
        })->values();

        // Return response
        return $this->successResponse($groupedPast, 'List of appointments categorized by time and grouped by patient.');
    }

    /*public function appointmentPost(Request $request)
    {
        // Validate the incoming request `pid`, `did`, `date`, `time`, `note`, `medical_file`, `health_card_file`, `fees`, `payment`, `status`
        $request->validate([
            'pid' => 'required|integer',
            'doctor_id' => 'required|integer',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'problem_description' => 'nullable|string|max:255',
            'payment_option' => 'required|string',
        ]);

        // Check for upcoming appointments
        $upcomingAppointment = Appointments::where('pid', $request->pid)
            ->where('did', $request->doctor_id)
            ->whereDate('date', $request->date)
            ->where('time', $request->time)
            ->exists();

        $getFees = Doctors::where('uid','=',$request->doctor_id)->first();

        if (!$upcomingAppointment) {
            // Create a new appointment doctor_id: 2, pid: 24, date: 2025-01-20, time: 12:00, problem_description: cncj, payment_option: Cash Payment
            $bookAppointment = new Appointments();
            $bookAppointment->pid = $request->pid;
            $bookAppointment->did = $request->doctor_id;
            $bookAppointment->date = $request->date;
            $bookAppointment->time = $request->time;
            $bookAppointment->note = $request->problem_description;
            $bookAppointment->fees = $getFees->fees ?? 0;
            $bookAppointment->payment = $request->payment_option;

            if(!empty($request->health_card_number)){
                $bookAppointment->health_card_file = $request->health_card_number;
            }

            $bookAppointment->save();

            return $this->successResponse($bookAppointment, 'Appointment booked successfully!');
        } else {
            return $this->successResponse(null, 'Already appointment scheduled.');
        }
    }*/

    // A helper function for success responses
    protected function successResponse($data, $message = null, $code = 200)
    {
        return response()->json(['status' => true, 'message' => $message, 'data' => $data], $code);
    }

    // A helper function for error responses
    protected function errorResponse($message = null, $code = 400)
    {
        return response()->json(['status' => false, 'message' => $message, 'data' => null], $code);
    }

    /**
     * NEW: Returns a list of active payment gateways for the Flutter app.
     */
    public function getPaymentGateways()
    {
        $gateways = Payment_gateway_configs::where('is_active', true)
            ->get(['id', 'gateway_name']);

        return $this->successResponse($gateways, 'Payment gateways fetched successfully.');
    }

    /**
     * Handles the initial submission. Books directly for offline payments,
     * or initiates an online payment order using credentials from the database.
     */
    public function appointmentPost(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'pid' => 'required|integer',
            'doctor_id' => 'required|integer',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'problem_description' => 'nullable|string|max:1000',
            'payment_option' => 'required|string',
            'payment_gateway' => 'required_if:payment_option,Online Payment|string',
            'health_card_number' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        // Check for existing appointments
        $upcomingAppointment = Appointments::where('pid', $request->pid)
            ->where('did', $request->doctor_id)
            ->whereDate('date', $request->date)
            ->where('time', $request->time)
            ->where('status', '!=', 'Cancelled') // Allow booking if previous one was cancelled
            ->exists();

        if ($upcomingAppointment) {
            return $this->errorResponse('An appointment for this time slot is already scheduled.');
        }

        $doctor = Doctors::where('uid', $request->doctor_id)->first();
        if (!$doctor) {
            return $this->errorResponse('Doctor not found.', 404);
        }
        $fees = $doctor->fees ?? 0;

        // --- Logic Branch based on Payment Option ---
        if ($request->payment_option == 'Online Payment') {

            // MODIFIED: Fetch gateway config from the database
            $gatewayConfig = Payment_gateway_configs::where('gateway_name', $request->payment_gateway)
                ->where('is_active', true)
                ->first();

            if (!$gatewayConfig) {
                return $this->errorResponse('The selected payment gateway is not available.', 404);
            }

            if ($fees <= 0) {
                return $this->errorResponse('Online payment is not available as the fee is zero.');
            }

            if ($request->payment_gateway == 'Razorpay') {
                try {
                    // MODIFIED: Use keys from the database
                    $api = new RazorpayApi($gatewayConfig->api_key, $gatewayConfig->api_secret);
                    $orderData = [
                        'amount' => $fees * 100,
                        'currency' => 'INR',
                        'receipt' => 'appt_' . time(),
                    ];
                    $razorpayOrder = $api->order->create($orderData);

                    $dataToReturn = [
                        'gateway' => 'Razorpay',
                        'razorpay_order_id' => $razorpayOrder['id'],
                        'merchant_key' => $gatewayConfig->api_key, // Send public API key
                        'amount' => $fees * 100,
                    ];

                    return $this->successResponse($dataToReturn, 'Payment order created.');
                } catch (Exception $e) {
                    return $this->errorResponse('Razorpay Error: ' . $e->getMessage(), 500);
                }
            } elseif ($request->payment_gateway == 'Paypal') {
                try {
                    // Assume you're using a PayPal SDK or API wrapper
                    // These are placeholder variables for PayPal API calls

                    $paypalClientId = $gatewayConfig->api_key;
                    $paypalSecret = $gatewayConfig->api_secret;

                    // Normally you'd initialize your PayPal SDK here
                    // and create an order (use sandbox/live as per your config)

                    $orderId = 'PAYPAL_' . uniqid(); // Simulated order ID
                    $approvalUrl = 'https://www.sandbox.paypal.com/checkoutnow?token=' . $orderId;

                    $dataToReturn = [
                        'gateway' => 'Paypal',
                        'paypal_order_id' => $orderId,
                        'approval_url' => $approvalUrl,
                        'amount' => $fees,
                    ];

                    return $this->successResponse($dataToReturn, 'PayPal payment order created.');
                } catch (Exception $e) {
                    return $this->errorResponse('PayPal Error: ' . $e->getMessage(), 500);
                }
            } elseif ($request->payment_gateway == 'Stripe') {
                try {
                    $orderId = 'STRIPE_' . uniqid();
                    $checkoutUrl = 'https://checkout.stripe.com/pay/' . $orderId; // Replace with real API call

                    return $this->successResponse([
                        'gateway' => 'Stripe',
                        'stripe_order_id' => $orderId,
                        'checkout_url' => $checkoutUrl,
                        'amount' => $fees * 100,
                    ], 'Stripe payment session created.');
                } catch (Exception $e) {
                    return $this->errorResponse('Stripe Error: ' . $e->getMessage(), 500);
                }
            } elseif ($request->payment_gateway == 'CCAvenue') {
                try {
                    $orderId = 'CCA_' . uniqid();
                    $redirectUrl = route('ccavenue.redirect', ['order_id' => $orderId]); // Your route

                    return $this->successResponse([
                        'gateway' => 'CCAvenue',
                        'order_id' => $orderId,
                        'redirect_url' => $redirectUrl,
                        'amount' => $fees,
                    ], 'CCAvenue redirect URL generated.');
                } catch (Exception $e) {
                    return $this->errorResponse('CCAvenue Error: ' . $e->getMessage(), 500);
                }
            }

            return $this->errorResponse('Invalid online payment gateway specified.');

        } else {
            // This is your original, working logic for direct booking (Cash/Health Card)
            //`appointments`(`medical_file`, `payment_mode`, `payment_status`, `is_completed`, `order_id`, `status`)
            $bookAppointment = new Appointments();
            $bookAppointment->pid = $request->pid;
            $bookAppointment->did = $request->doctor_id;
            $bookAppointment->date = $request->date;
            $bookAppointment->time = $request->time;
            $bookAppointment->note = $request->problem_description;
            $bookAppointment->fees = $fees;
            $bookAppointment->payment_mode = $request->payment_option;
            $bookAppointment->status = '0';

            if (!empty($request->health_card_number)) {
                $bookAppointment->health_card_file = $request->health_card_number;
            }

            $bookAppointment->save();

            return $this->successResponse($bookAppointment, 'Appointment booked successfully!');
        }
    }

    /**
     * Verifies the payment and creates the appointment record using credentials from the database.
     */
    public function verifyPaymentAndBook(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'pid' => 'required|integer',
            'doctor_id' => 'required|integer',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'problem_description' => 'nullable|string',
            'gateway' => 'required|string',
            'razorpay_payment_id' => 'required_if:gateway,Razorpay|string',
            'razorpay_order_id' => 'required_if:gateway,Razorpay|string',
            'razorpay_signature' => 'required_if:gateway,Razorpay|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        // MODIFIED: Fetch gateway config from DB for verification
        $gatewayConfig = Payment_gateway_configs::where('gateway_name', $request->gateway)
            ->where('is_active', true)
            ->first();

        if (!$gatewayConfig) {
            return $this->errorResponse('The payment gateway is not available for verification.', 404);
        }

        if ($request->gateway == 'Razorpay') {
            try {
                // MODIFIED: Use keys from the database
                $api = new RazorpayApi($gatewayConfig->api_key, $gatewayConfig->api_secret);
                $api->utility->verifyPaymentSignature([
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature
                ]);
            } catch (Exception $e) {
                return $this->errorResponse('Payment verification failed: ' . $e->getMessage(), 400);
            }
        }

        $doctor = Doctors::where('uid', $request->doctor_id)->first();

        // Create the appointment now that payment is confirmed
        $bookAppointment = new Appointments();
        $bookAppointment->pid = $request->pid;
        $bookAppointment->did = $request->doctor_id;
        $bookAppointment->date = $request->date;
        $bookAppointment->time = $request->time;
        $bookAppointment->note = $request->problem_description;
        $bookAppointment->fees = $doctor->fees ?? 0;
        $bookAppointment->payment = 'Online Payment';
        $bookAppointment->payment_gateway = $request->gateway;
        $bookAppointment->payment_id = $request->razorpay_payment_id;
        $bookAppointment->order_id = $request->razorpay_order_id;
        $bookAppointment->status = 'Confirmed';
        $bookAppointment->save();

        return $this->successResponse($bookAppointment, 'Appointment booked successfully!');
    }

    public function appointmentCompletePost(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'appointment_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        // Find appointment
        $appointment = Appointments::find($validated['appointment_id']);

        if (!$appointment) {
            return $this->errorResponse('Appointment not found.', 404);
        }

        // Initialize is_completed as array with default values
        $isCompletedArray = explode(',', $appointment->is_completed ?? '0,0');

        // Ensure the array has exactly two elements
        $isCompletedArray = array_pad($isCompletedArray, 2, '0');

        // Update completion status based on user_id
        $updated = false;

        if ($appointment->did == $validated['user_id']) {
            $isCompletedArray[0] = '1';
            $updated = true;
        } elseif ($appointment->pid == $validated['user_id']) {
            $isCompletedArray[1] = '1';
            $updated = true;
        }

        if (!$updated) {
            return $this->errorResponse('User is not authorized to complete this appointment.', 403);
        }

        // Update fields
        $appointment->is_completed = implode(',', $isCompletedArray);

        // If both have marked complete, set status = 1
        if ($isCompletedArray[0] === '1' && $isCompletedArray[1] === '1') {
            $appointment->status = 1;
        }

        $appointment->save();

        return $this->successResponse($appointment, 'Appointment completion updated successfully!');
    }

    public function revenue($id, Request $request)
    {
        try {
            $now = Carbon::now();
            $filter = $request->query('filter', 'weekly'); // Default filter is weekly

            if ($filter === 'weekly') {
                // WEEKLY REVENUE
                $startOfWeek = $now->copy()->startOfWeek();
                $endOfWeek = $now->copy()->endOfWeek();

                $weeklyData = DB::table('appointments')
                    ->selectRaw('DATE(date) as day, SUM(fees) as amount')
                    ->where('did', $id)
                    ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
                    ->groupBy(DB::raw('DATE(date)'))
                    ->orderBy('day')
                    ->get();

                $weeklyRevenue = [];
                $currentDate = $startOfWeek->copy();
                while ($currentDate <= $endOfWeek) {
                    $day = $currentDate->toDateString();
                    $revenue = $weeklyData->firstWhere('day', $day)->amount ?? 0;
                    $weeklyRevenue[] = ['time' => $day, 'amount' => $revenue];
                    $currentDate->addDay();
                }

                return response()->json(['weekly' => $weeklyRevenue], 200);
            }

            if ($filter === 'monthly') {
                // MONTHLY REVENUE
                $startOfMonth = $now->copy()->startOfMonth();
                $endOfMonth = $now->copy()->endOfMonth();

                $monthlyData = DB::table('appointments')
                    ->selectRaw('DATE(date) as day, SUM(fees) as amount')
                    ->where('did', $id)
                    ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                    ->groupBy(DB::raw('DATE(date)'))
                    ->orderBy('day')
                    ->get();

                $monthlyRevenue = [];
                $currentDate = $startOfMonth->copy();
                while ($currentDate <= $endOfMonth) {
                    $day = $currentDate->toDateString();
                    $revenue = $monthlyData->firstWhere('day', $day)->amount ?? 0;
                    $monthlyRevenue[] = ['time' => $day, 'amount' => $revenue];
                    $currentDate->addDay();
                }

                return response()->json(['monthly' => $monthlyRevenue], 200);
            }

            if ($filter === 'yearly') {
                // YEARLY REVENUE
                $startOfYear = $now->copy()->startOfYear();
                $endOfYear = $now->copy()->endOfYear();

                $yearlyData = DB::table('appointments')
                    ->selectRaw('DATE_FORMAT(date, "%Y-%m") as month, SUM(fees) as amount')
                    ->where('did', $id)
                    ->whereBetween('date', [$startOfYear->toDateString(), $endOfYear->toDateString()])
                    ->groupBy(DB::raw('DATE_FORMAT(date, "%Y-%m")'))
                    ->orderBy('month')
                    ->get();

                $yearlyRevenue = [];
                for ($m = 1; $m <= 12; $m++) {
                    $month = $now->copy()->month($m)->format('Y-m');
                    $revenue = $yearlyData->firstWhere('month', $month)->amount ?? 0;
                    $yearlyRevenue[] = ['time' => $month, 'amount' => $revenue];
                }

                return response()->json(['yearly' => $yearlyRevenue], 200);
            }

            return response()->json(['error' => 'Invalid filter. Use weekly, monthly, or yearly'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function slots($id)
    {
        // Retrieve the slot by its ID.
        $slot = Doctor_availables::where('doctor_id', '=', $id)->orderBy('id', 'desc')->get();

        // If the slot is not found, return a 404 error response.
        if (!$slot) {
            return response()->json([
                'success' => false,
                'message' => 'Slot not found.'
            ], 404);
        }

        // Return a JSON response with the slot details.
        return response()->json([
            'success' => true,
            'data' => $slot
        ], 200);
    }

    public function manageSlot(Request $request)
    {

        // If a day is not provided, an empty string is used.
        $selectedDays = [];

        if ($request->monday == 1) {
            $selectedDays[] = "Monday";
        }
        if ($request->tuesday == 1) {
            $selectedDays[] = "Tuesday";
        }
        if ($request->wednesday == 1) {
            $selectedDays[] = "Wednesday";
        }
        if ($request->thursday == 1) {
            $selectedDays[] = "Thursday";
        }
        if ($request->friday == 1) {
            $selectedDays[] = "Friday";
        }
        if ($request->saturday == 1) {
            $selectedDays[] = "Saturday";
        }
        if ($request->sunday == 1) {
            $selectedDays[] = "Sunday";
        }

        $days = implode(',', $selectedDays);

        try {

            $startTime = date("H:i:s", strtotime($request->start_time));
            $endTime = date("H:i:s", strtotime($request->end_time));

            // Check if a slot with the same doctor and to_date already exists.
            $existingSlot = Doctor_availables::where('doctor_id', $request->doctor_id)
                ->where('to_date', '>', $request->from_date)
                ->first();

            if ($existingSlot) {
                return response()->json([
                    'success' => false,
                    'message' => 'A slot for the given to_date already exists.'
                ], 409); // 409 Conflict
            }

            // Create a new instance of the Doctor_availables model.
            $slot = new Doctor_availables();

            // Assign values to the model.
            $slot->doctor_id = $request->doctor_id;
            $slot->from_date = $request->from_date;
            $slot->to_date = $request->to_date;
            $slot->available_days = $days ?? '';
            $slot->start_time = $startTime;
            $slot->end_time = $endTime;
            $slot->duration = $request->appointment_duration;

            // Save the slot into the database.
            $slot->save();

            // Return a JSON response indicating success.
            return response()->json([
                'success' => true,
                'message' => 'New Slot Created.',
                'data' => $slot
            ], 200);

        } catch (\Exception $e) {

            // Log the exception for debugging.
            Log::error('Error in manageSlot: ' . $e->getMessage());

            // Return a JSON response with error details.
            return response()->json([
                'success' => false,
                'message' => 'There was an error creating the slot.',
                'error' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Get user's cart items.
     * Joins 'carts' with 'medicines' to get product details.
     */
    public function getCart($uid)
    {
        $cartItems = DB::table('carts')
            ->join('medicines', 'carts.medicine_id', '=', 'medicines.id')
            ->select(
                'carts.id',            // Cart ID (for removal/update)
                'carts.medicine_id',
                'carts.quantity',
                'medicines.name',
                'medicines.cost',
                'medicines.discount_cost',
                'medicines.img'
            )
            ->where('carts.user_id', $uid)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $cartItems
        ], 200);
    }

    /**
     * Add item to cart.
     * Checks if item exists -> updates quantity OR inserts new row.
     */
    public function addToCart(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'medicine_id' => 'required|integer|exists:medicines,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $userId = $request->user_id;
        $medicineId = $request->medicine_id;
        $qty = $request->quantity;

        // Optional: check stock availability
        $medicine = Medicines::find($medicineId);
        if ($medicine && $medicine->available < $qty) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock for this medicine'
            ], 400);
        }

        // Add or update cart
        $cart = Carts::updateOrCreate(
            ['user_id' => $userId, 'medicine_id' => $medicineId],
            ['quantity' => \DB::raw("quantity + $qty")]
        );

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'cart' => $cart
        ], 200);
    }
    /**
     * Update cart item quantity.
     */
    public function updateCartQuantity(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|integer|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        DB::table('carts')
            ->where('id', $request->cart_id)
            ->update(['quantity' => $request->quantity, 'updated_at' => now()]);

        return response()->json(['success' => true, 'message' => 'Cart updated'], 200);
    }

    /**
     * Remove item from cart.
     */
    public function removeFromCart($id)
    {
        $deleted = DB::table('carts')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Item removed'], 200);
        }

        return response()->json(['success' => false, 'message' => 'Item not found'], 404);
    }

    /**
     * Place Order.
     * Uses DB Transaction to ensure data integrity.
     */
    public function placeOrder(Request $request)
    {
        // 1. Validation - Match Flutter orderData keys
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'total_amount' => 'required|numeric',
            'shipping_address' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.qty' => 'required|integer',
            'items.*.price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $items = $request->items;

            // 2. Lookup Medicine and Verify Store exists
            $firstMedicine = DB::table('medicines')->where('id', $items[0]['id'])->first();

            if (!$firstMedicine) {
                throw new \Exception("Medicine with ID " . $items[0]['id'] . " not found.");
            }

            // CRITICAL FIX: Check if the store_id actually exists in the 'store_locations' table
            /*$storeExists = DB::table('store_locations')->where('LocationID', $firstMedicine->store_id)->exists();

            if (!$storeExists) {
                throw new \Exception("Order failed: The Store (ID: {$firstMedicine->store_id}) associated with this medicine does not exist in the database.");
            }*/

            // 3. Create the Order
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => $request->user_id,
                'store_id' => $firstMedicine->store_id,
                'supplier_id' => $firstMedicine->pharmacy_id ?? null, // Ensure this ID is valid too
                'shipping_address' => $request->shipping_address,
                'order_date' => now(),
                'status' => 'Pending',
                'total_amount' => $request->total_amount,
            ]);

            // 4. Process Order Items
            foreach ($items as $item) {
                // Check stock availability
                $dbMed = DB::table('medicines')->where('id', $item['id'])->first();

                if (!$dbMed) {
                    throw new \Exception("Item ID " . $item['id'] . " no longer exists.");
                }

                /*if ($dbMed->stock_quantity < $item['qty'] || $dbMed->available < 1) {
                    throw new \Exception("Insufficient stock for: " . $dbMed->name);
                }*/

                // Insert into order_items table
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'medicine_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                ]);

                // 5. Deduct Stock
                DB::table('medicines')
                    ->where('id', $item['id'])
                    ->decrement('stock_quantity', $item['qty']);
            }

            // 6. Clear user's cart
            DB::table('carts')->where('user_id', $request->user_id)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_id' => $orderId
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() // This will now show the specific reason
            ], 500);
        }
    }
    public function availableSlots(Request $request, $id)
    {
        $date = $request->query('date');
        if (!$date) {
            return response()->json(['success' => false, 'message' => 'Date is required'], 400);
        }

        $formattedDate = Carbon::parse($date);
        $dayOfWeek = $formattedDate->format('l');

        // Get Doctor's Availability for this date range
        $availability = Doctor_availables::where('doctor_id', $id)
            ->where('from_date', '<=', $date)
            ->where('to_date', '>=', $date)
            ->first();

        if (!$availability) {
            return response()->json([]);
        }

        // Check if the specific day is available
        $availableDays = explode('|', $availability->available_days);
        $availableDays = array_map('trim', $availableDays);
        if (!in_array($dayOfWeek, $availableDays)) {
            return response()->json([]);
        }

        // Generate Slots
        $startTime = Carbon::parse($availability->start_time);
        $endTime = Carbon::parse($availability->end_time);
        $duration = intval($availability->duration);

        $slots = [];
        while ($startTime->lt($endTime)) {
            $slotStart = $startTime->format('H:i');
            $slotEnd = $startTime->copy()->addMinutes($duration)->format('H:i');

            if ($startTime->copy()->addMinutes($duration)->gt($endTime)) {
                break;
            }

            // Check if booked
            $isBooked = Appointments::where('did', $id)
                ->where('date', $date)
                ->where('time', $slotStart)
                ->where('status', '!=', '2')
                ->exists();

            if (!$isBooked) {
                $slots[] = [
                    'value' => $slotStart,
                    'label' => Carbon::parse($slotStart)->format('h:i A') . ' - ' . Carbon::parse($slotEnd)->format('h:i A')
                ];
            }

            $startTime->addMinutes($duration);
        }

        return response()->json($slots);
    }
}
