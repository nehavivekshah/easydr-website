<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

use App\Models\Branches;
use App\Models\Roles;
use App\Models\User;
use App\Models\Doctors;
use App\Models\Specialists;
use App\Models\Cities;
use App\Models\States;
use App\Models\Countries;
use App\Models\Patients;
use App\Models\Appointments;
use App\Models\Wallets;
use App\Models\Doctor_availables;

use Carbon\Carbon;

class WebAppointmentController extends Controller
{
    public function upcomingAppointments()
    {
        // Define the current date and time
        $currentDateTime = Carbon::now();

        $appointments = Appointments::leftJoin('users as pet', 'appointments.pid', '=', 'pet.id') // Join patient users
            ->leftJoin('users as doc', 'appointments.did', '=', 'doc.id') // Join doctor users
            ->leftJoin('doctors', 'doc.id', '=', 'doctors.uid') // Join doctors
            ->leftJoin('patients', 'pet.id', '=', 'patients.uid') // Corrected join with patients table
            ->leftJoin('users as famdoc', 'patients.family_doctor_id', '=', 'famdoc.id') // Join family doctor
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
                'appointments.*' // All appointment fields
            )
            ->where(function ($query) use ($currentDateTime) {
                $query->whereDate('appointments.date', '>', $currentDateTime->toDateString()) // Future dates
                    ->orWhere(function ($query) use ($currentDateTime) {
                        $query->whereDate('appointments.date', '=', $currentDateTime->toDateString()) // Same day
                            ->whereTime('appointments.time', '>', $currentDateTime->toTimeString()); // Future times
                    });
            })
            ->orderBy('appointments.date', 'DESC')
            ->orderBy('appointments.time', 'DESC')
            ->get();


        // Pass appointments and page name to the view
        return view('appointments', [
            'appointments' => $appointments,
            'pagename' => 'Upcoming Appointments',
        ]);
    }

    function appointmentHistory()
    {

        // Define the current date and time
        $currentDateTime = Carbon::now();

        $appointments = Appointments::leftJoin('users as pet', 'appointments.pid', '=', 'pet.id') // Join patient users
            ->leftJoin('users as doc', 'appointments.did', '=', 'doc.id') // Join doctor users
            ->leftJoin('doctors', 'doc.id', '=', 'doctors.uid') // Join doctors
            ->leftJoin('patients', 'pet.id', '=', 'patients.uid') // Corrected join with patients table
            ->leftJoin('users as famdoc', 'patients.family_doctor_id', '=', 'famdoc.id') // Join family doctor
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
                'appointments.*' // All appointment fields
            )
            ->where(function ($query) use ($currentDateTime) {
                $query->whereDate('appointments.date', '<', $currentDateTime->toDateString()) // Future dates
                    ->orWhere(function ($query) use ($currentDateTime) {
                        $query->whereDate('appointments.date', '=', $currentDateTime->toDateString()) // Same day
                            ->whereTime('appointments.time', '<', $currentDateTime->toTimeString()); // Future times
                    });
            })
            ->orderBy('appointments.date', 'DESC')
            ->orderBy('appointments.time', 'DESC')
            ->get();

        return view('appointments', ['appointments' => $appointments, 'pagename' => 'Appointment History']);
    }

    function appointmentCalendar()
    {

        // Define the current date and time
        $currentDateTime = Carbon::now();

        $appointments = Appointments::leftJoin('users as pet', 'appointments.pid', '=', 'pet.id') // Join patient users
            ->leftJoin('users as doc', 'appointments.did', '=', 'doc.id') // Join doctor users
            ->leftJoin('doctors', 'doc.id', '=', 'doctors.uid') // Join doctors
            ->leftJoin('patients', 'pet.id', '=', 'patients.uid') // Corrected join with patients table
            ->leftJoin('users as famdoc', 'patients.family_doctor_id', '=', 'famdoc.id') // Join family doctor
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
                'appointments.*' // All appointment fields
            )
            ->where(function ($query) use ($currentDateTime) {
                $query->whereDate('appointments.date', '>', $currentDateTime->toDateString()) // Future dates
                    ->orWhere(function ($query) use ($currentDateTime) {
                        $query->whereDate('appointments.date', '=', $currentDateTime->toDateString()) // Same day
                            ->whereTime('appointments.time', '>', $currentDateTime->toTimeString()); // Future times
                    });
            })
            ->orderBy('appointments.date')
            ->orderBy('appointments.time')
            ->get();

        return view('appointmentCalendar', ['appointments' => $appointments]);
    }

    public function getDoctorAvailability($doctorId)
    {
        $availabilities = Doctor_availables::where('doctor_id', $doctorId)
            ->whereDate('to_date', '>=', Carbon::now()->toDateString()) // Ensure to_date is in the future or today
            ->where('status', 1) // Only active slots
            ->orderBy('from_date', 'ASC') // Order by date in ascending order
            ->get();

        $slots = [];
        $now = Carbon::now(); // Current date and time

        foreach ($availabilities as $availability) {
            // Set the starting date for the loop
            $currentDate = Carbon::parse($availability->from_date);

            // If from_date is in the past, start from today
            if ($currentDate->lessThan($now->copy()->startOfDay())) {
                $currentDate = $now->copy()->startOfDay();
            }

            // Define the end date
            $endDate = Carbon::parse($availability->to_date);

            // Loop through each date, including the end date
            while ($currentDate->lessThanOrEqualTo($endDate)) {
                // Generate time slots for the current date
                $startTime = Carbon::createFromTimeString($availability->start_time);
                $endTime = Carbon::createFromTimeString($availability->end_time);

                // Set the date for time comparison
                $startTime->setDate($currentDate->year, $currentDate->month, $currentDate->day);
                $endTime->setDate($currentDate->year, $currentDate->month, $currentDate->day);

                while ($startTime->lessThan($endTime)) {
                    // Only add slot if it's in the future (for today) or if it's a future date
                    $isToday = $currentDate->isSameDay($now);
                    $isFutureTime = $startTime->greaterThan($now);

                    if (!$isToday || $isFutureTime) {
                        $slots[] = [
                            'date' => $currentDate->format('Y-m-d'),
                            'time' => $startTime->format('h:i A'),
                        ];
                    }

                    $startTime->addMinutes($availability->duration);
                }

                // Move to the next date
                $currentDate->addDay();
            }
        }

        return response()->json($slots);
    }

    function manageAppointment(Request $request)
    {

        $appointments = Appointments::where('id', '=', ($request->id ?? ''))->first();
        $patients = User::where('role', '=', '5')->where('status', '=', '1')->get();
        $doctors = User::where('role', '=', '4')->where('status', '=', '1')->get();

        return view('manageAppointment', ['appointments' => $appointments, 'doctors' => $doctors, 'patients' => $patients]);
    }

    public function cancelAppointmentPost($appointmentId)
    {

        $bookAppointment = Appointments::where('id', '=', ($appointmentId ?? ''))->first();
        $bookAppointment->status = '2';
        $bookAppointment->save();

        return back()->with('success', 'Sorry, your health card is not valid or expired.');
    }

    // public function manageAppointmentPost(Request $request){
    //     // Validate input
    //     $request->validate([
    //         'patient_id' => 'required|integer', // Ensure patient_id corresponds to a valid patient ID
    //         'doctor_id' => 'required|integer', // Ensure doctor_id corresponds to a valid doctor ID
    //         'appointment_date' => 'required|date', // Validate appointment_date as a proper date format
    //         'appointment_time' => 'required|date_format:h:i A', // Validate appointment_time in 'HH:mm' format
    //         'problems' => 'nullable|string|max:500', // Optional problems field, max 500 characters
    //         'payment_status' => 'required|string|in:paid,unpaid,health_card', // Ensure valid payment_status
    //     ]);

    //     $patients = Patients::where('uid','=',($request->patient_id ?? ''))->first();

    //     if ($request->payment_status == 'health_card' && (empty($patients->health_card) || $patients->health_card_file <= now())) {
    //         return back()->with('error', 'Sorry, your health card is not valid or expired.');
    //     }

    //     $getappointment = Appointments::where('id','=',($request->id ?? ''))->first();

    //     // Create appointment
    //     $bookAppointment = $getappointment ? $getappointment : new Appointments(); // Fixed typo in variable name
    //     $bookAppointment->pid = $request->patient_id;
    //     $bookAppointment->did = $request->doctor_id;
    //     $bookAppointment->date = $request->appointment_date;
    //     $appointmentTime = date_create($request->appointment_time);
    //     $bookAppointment->time = $appointmentTime->format('H:i');
    //     $bookAppointment->note = $request->problems;
    //     $bookAppointment->medical_file = $patients->medical_file ?? null;
    //     $bookAppointment->payment_mode = $request->payment_mode;
    //     $bookAppointment->payment_status = $request->payment_status;
    //     $bookAppointment->status = '0'; // Default status for new appointment
    //     $bookAppointment->save();

    //     if($getappointment){
    //         // Redirect with success message
    //         return redirect('/admin/upcoming-appointments')->with('success', 'Appointment booking details successfully updated.');
    //     }

    //     // Redirect with success message
    //     return redirect('/admin/upcoming-appointments')->with('success', 'Appointment booked successfully.');
    // }

    public function manageAppointmentPost(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer', // Added validation for ID
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:h:i A',
            'problems' => 'nullable|string|max:500',
            'payment_status' => 'required|string|in:paid,unpaid,health_card',
            'meeting_provider' => 'nullable|string',
            'meeting_link' => 'nullable|string',
        ]);

        $patients = Patients::where('uid', $request->patient_id)->first();
        $docs = Doctors::where('uid', $request->doctor_id)->first();

        if (!$patients) {
            return back()->with('error', 'Patient not found.');
        }

        if (!$docs) {
            return back()->with('error', 'Doctor not found.');
        }

        // Health Card Validation
        if ($request->payment_status == 'health_card') {
            // Ensure the field exists and is compared as a date
            if (empty($patients->health_card) || \Carbon\Carbon::parse($patients->health_card_file)->isPast()) {
                return back()->with('error', 'Sorry, your health card is not valid or expired.');
            }
        }

        // Find existing or create new
        $getAppointment = Appointments::find($request->id);
        $bookAppointment = $getAppointment ?? new Appointments();

        $bookAppointment->pid = $request->patient_id;
        $bookAppointment->did = $request->doctor_id;
        $bookAppointment->date = $request->appointment_date;

        // Time formatting
        $appointmentTime = \Carbon\Carbon::createFromFormat('h:i A', $request->appointment_time);
        $bookAppointment->time = $appointmentTime->format('H:i');

        $bookAppointment->note = $request->problems;
        $bookAppointment->medical_file = $patients->medical_file ?? null;
        $bookAppointment->payment_mode = $request->payment_mode ?? 'offline'; // Default if null
        $bookAppointment->meeting_provider = $request->meeting_provider;
        $bookAppointment->meeting_link = $request->meeting_link;
        $bookAppointment->fees = $docs->fees ?? 0; // Set fees from doctor profile

        // FIXED: Only check payment_status if $getAppointment exists
        if (!$getAppointment || $getAppointment->payment_status != 'paid') {
            $bookAppointment->payment_status = $request->payment_status;
        }

        $bookAppointment->status = '0';
        $bookAppointment->save();

        // Handle Wallet logic if newly paid
        if ($request->payment_status == 'paid') {
            // Logic: Only credit doctor if it wasn't already paid (to prevent double-pay on updates)
            $alreadyPaid = $getAppointment && $getAppointment->payment_status == 'paid';

            if (!$alreadyPaid) {
                $appointmentFee = $docs->fees ?? 0;

                // Update doctor wallet
                $docs->increment('wallet', $appointmentFee);

                Wallets::create([
                    'did' => $docs->id,
                    'aid' => $bookAppointment->id,
                    'details' => 'Appointment payment received for patient ID: ' . $request->patient_id,
                    'amount' => $appointmentFee,
                    'status' => 'credit',
                ]);
            }
        }

        $msg = $getAppointment ? 'Appointment details updated successfully.' : 'Appointment booked successfully.';
        return redirect('/admin/upcoming-appointments')->with('success', $msg);
    }

}
