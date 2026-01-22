<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Appointments;
use App\Models\Medicines;
use App\Models\PharmacyMaster;
use App\Models\Store_locations;
use App\Models\Reports;

use Carbon\Carbon;

class WebHomeController extends Controller
{
    function home()
    {
        $user = Auth::user();
        $roles = \App\Models\Roles::find($user->role);
        $rolePermissions = explode(',', $roles->features ?? '');

        // Define the current date and time
        $currentDateTime = Carbon::now();

        // Base Flags
        $isDoctor = ($user->role == '4');
        $isAdmin = ($user->role == '1'); // Assuming 1 is Admin
        $hasPharmacyAccess = in_array('stores', $rolePermissions) || in_array('All', $rolePermissions);
        $hasAppointmentAccess = in_array('appointments', $rolePermissions) || in_array('All', $rolePermissions);

        // --- Appointments ---
        $upcomingAppointmentCount = 0;
        if ($hasAppointmentAccess || $isDoctor) {
            $query = Appointments::query();
            if ($isDoctor) {
                $query->where('did', $user->id);
            }
            $query->where(function ($q) use ($currentDateTime) {
                $q->whereDate('date', '>', $currentDateTime->toDateString())
                    ->orWhere(function ($q2) use ($currentDateTime) {
                        $q2->whereDate('date', '=', $currentDateTime->toDateString())
                            ->whereTime('time', '>', $currentDateTime->toTimeString());
                    });
            });
            $upcomingAppointmentCount = $query->count();
        }

        // --- Patients ---
        $patientCount = User::where('branch', $user->branch ?? '')
            ->where('role', '5')
            ->count();

        // --- Doctors ---
        $doctorCount = 0;
        if ($isAdmin) {
            $doctorCount = User::where('branch', $user->branch ?? '')
                ->where('role', '4')
                ->count();
        }

        // --- Pharmacy / Medicines ---
        $medicineCount = 0;
        $pharmacyCount = 0;
        $storesCount = 0;
        if ($hasPharmacyAccess) {
            $medicineCount = Medicines::where('branch', $user->branch ?? '')
                ->where('status', '1')
                ->count();

            $pharmacyCount = PharmacyMaster::where('branch', $user->branch ?? '')
                ->where('status', '1')
                ->count();

            $storesCount = Store_locations::where('status', '1')
                ->count();
        }

        // --- Reports ---
        $reportsCount = 0;
        if (in_array('reports', $rolePermissions) || in_array('All', $rolePermissions)) {
            $reportsCount = \App\Models\Reports::count();
        }

        // --- Appointment Chart Data ---
        $appointmentData = [];
        $appointmentLabels = [];
        if ($hasAppointmentAccess || $isDoctor) {
            $start = Carbon::now()->subMonths(5)->startOfMonth();
            $end = Carbon::now()->endOfMonth();

            while ($start <= $end) {
                $month = $start->format('M');
                $q = Appointments::whereMonth('date', $start->month)->whereYear('date', $start->year);
                if ($isDoctor) {
                    $q->where('did', $user->id);
                }
                $count = $q->count();

                $appointmentLabels[] = $month;
                $appointmentData[] = $count;
                $start->addMonth();
            }
        }

        // --- Patient Chart Data ---
        $patientChartLabels = ['Male', 'Female', 'Other'];
        $patientChartData = [
            User::where('branch', $user->branch ?? '')->where('role', '5')->where('gender', '1')->count(),
            User::where('branch', $user->branch ?? '')->where('role', '5')->where('gender', '2')->count(),
            User::where('branch', $user->branch ?? '')->where('role', '5')->where('gender', '3')->count(),
        ];


        return view('home', [
            'appointments' => $upcomingAppointmentCount,
            'patients' => $patientCount,
            'doctors' => $doctorCount,
            'medicines' => $medicineCount,
            'pharmacyCount' => $pharmacyCount,
            'medicalStores' => $storesCount,
            'reports' => $reportsCount,
            'appointmentChartLabels' => $appointmentLabels,
            'appointmentChartData' => $appointmentData,
            'patientChartLabels' => $patientChartLabels,
            'patientChartData' => $patientChartData,
            'isDoctor' => $isDoctor,
            'isAdmin' => $isAdmin,
            'hasPharmacyAccess' => $hasPharmacyAccess
        ]);
    }
}