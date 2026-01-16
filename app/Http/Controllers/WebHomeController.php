<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Appointments;
use App\Models\Medicines;
use App\Models\PharmacyMaster;
use App\Models\Store_locations;

use Carbon\Carbon;

class WebHomeController extends Controller
{
    function home()
    {
        // Define the current date and time
        $currentDateTime = Carbon::now();
    
        $upcomingAppointmentCount = Appointments::where(function ($query) use ($currentDateTime) {
                $query->whereDate('date', '>', $currentDateTime->toDateString())
                      ->orWhere(function ($query) use ($currentDateTime) {
                          $query->whereDate('date', '=', $currentDateTime->toDateString())
                                ->whereTime('time', '>', $currentDateTime->toTimeString());
                      });
            })
            ->count();
    
        $patientCount = User::where('branch', Auth::user()->branch ?? '')
            ->where('role', '5')
            ->count();
    
        $doctorCount = User::where('branch', Auth::user()->branch ?? '')
            ->where('role', '4')
            ->count();
    
        $medicineCount = Medicines::where('branch', Auth::user()->branch ?? '')
            ->where('status', '1')
            ->count();
    
        $pharmacyCount = PharmacyMaster::where('branch', Auth::user()->branch ?? '')
            ->where('status', '1')
            ->count();
    
        $storesCount = Store_locations::where('status', '1')
            ->count();
    
        // Appointment Chart Data (Example: Appointments per month for the last 6 months)
        $appointmentData = [];
        $appointmentLabels = [];
    
        $start = Carbon::now()->subMonths(5)->startOfMonth(); // Get data for the last 6 months
        $end = Carbon::now()->endOfMonth();
    
        while ($start <= $end) {
            $month = $start->format('M'); // Month name (e.g., Jan, Feb)
            $count = Appointments::whereMonth('date', $start->month)
                                 ->whereYear('date', $start->year)
                                 ->count();
    
            $appointmentLabels[] = $month;
            $appointmentData[] = $count;
            $start->addMonth();
        }
    
        // Patient Chart Data (Example: Patient gender distribution)
        $patientChartLabels = ['Male', 'Female', 'Other'];  // Replace with relevant categories
        $patientChartData = [
            User::where('branch', Auth::user()->branch ?? '')->where('role', '5')->where('gender', '1')->count(), // Replace 'gender' with actual column
            User::where('branch', Auth::user()->branch ?? '')->where('role', '5')->where('gender', '2')->count(),// Replace 'gender' with actual column
            User::where('branch', Auth::user()->branch ?? '')->where('role', '5')->where('gender', '3')->count(), // Replace 'gender' with actual column
        ];
    
    
        return view('home', [
            'appointments' => $upcomingAppointmentCount,
            'patients' => $patientCount,
            'doctors' => $doctorCount,
            'medicines' => $medicineCount,
            'pharmacyCount' => $pharmacyCount,
            'medicalStores' => $storesCount,
            'appointmentChartLabels' => $appointmentLabels,
            'appointmentChartData' => $appointmentData,
            'patientChartLabels' => $patientChartLabels,
            'patientChartData' => $patientChartData,
        ]);
    }
}