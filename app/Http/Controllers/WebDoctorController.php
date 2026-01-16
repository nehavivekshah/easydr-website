<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

use Carbon\Carbon; 

use App\Models\Branches;
use App\Models\Doctors;
use App\Models\Doctor_availables;
use App\Models\Appointments;

class WebDoctorController extends Controller
{
    function assignedDoctors(){
        return view('assignedDoctors');
    }
    public function doctorAvailability()
    {
        // Fetch all doctor availability slots with necessary joins and ordering
        $daSlots = Doctor_availables::leftJoin('users', 'doctor_availables.doctor_id', '=', 'users.id')
            ->leftJoin('doctors', 'doctor_availables.doctor_id', '=', 'doctors.uid')
            ->select(
                'users.first_name', 
                'users.last_name', 
                'doctors.specialist', 
                'doctor_availables.*'
            )
            ->orderBy('doctor_availables.to_date', 'DESC') // Order by date descending
            ->orderBy('doctor_availables.start_time', 'ASC') // Order by start time ascending
            ->get();
    
        // Return the view with the fetched data
        return view('doctorAvailability', [
            'daSlots' => $daSlots
        ]);
    }
    public function manageSlot(Request $request)
    {
        // Retrieve the specific slot details if an ID is provided, else return null
        $daSlots = null;
        if ($request->filled('id')) {
            $daSlots = Doctor_availables::leftJoin('users', 'doctor_availables.doctor_id', '=', 'users.id')
                ->leftJoin('doctors', 'doctor_availables.doctor_id', '=', 'doctors.uid')
                ->select(
                    'users.first_name', 
                    'users.last_name', 
                    'doctors.specialist', 
                    'doctor_availables.*'
                )
                ->where('doctor_availables.id', '=', $request->id)
                ->first();
        }
    
        // Retrieve the list of all doctors
        $doctors = Doctors::leftJoin('users', 'doctors.uid', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.last_name',
                'doctors.*'
            )
            ->get();
    
        // Return the view with the data
        return view('manageSlot', [
            'daSlots' => $daSlots,
            'doctors' => $doctors
        ]);
    }
    public function manageSlotPost(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'doctor' => 'required|integer|exists:doctors,uid',
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after_or_equal:fromDate',
            'daysAvailable' => 'required|array',
            'daysAvailable.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'startTime' => 'required',
            'endTime' => 'required|after:startTime',
            'duration' => 'required|integer|min:1|max:120',
        ]);
    
        // Convert availableDays array to a comma-separated string
        $availableDays = implode(',', $validatedData['daysAvailable']);
    
        if (empty($request->id)) {
            // Create a new record
            $docAvailable = new Doctor_availables();
            $docAvailable->doctor_id = $validatedData['doctor'];
            $docAvailable->from_date = $validatedData['fromDate'];
            $docAvailable->to_date = $validatedData['toDate'];
            $docAvailable->available_days = $availableDays;
            $docAvailable->start_time = $validatedData['startTime'];
            $docAvailable->end_time = $validatedData['endTime'];
            $docAvailable->duration = $validatedData['duration'];
            $docAvailable->save();
    
            return redirect('/admin/doctor-availability')
                ->with('success', 'Successfully Added.');
        } else {
            // Update the existing record
            $docAvailable = Doctor_availables::findOrFail($request->id);
            $docAvailable->doctor_id = $validatedData['doctor'];
            $docAvailable->from_date = $validatedData['fromDate'];
            $docAvailable->to_date = $validatedData['toDate'];
            $docAvailable->available_days = $availableDays;
            $docAvailable->start_time = $validatedData['startTime'];
            $docAvailable->end_time = $validatedData['endTime'];
            $docAvailable->duration = $validatedData['duration'];
            $docAvailable->save();
    
            return back()->with('success', 'Successfully Updated.');
        }
    }
}
