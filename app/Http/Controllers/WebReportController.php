<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Patients;
use App\Models\Appointments;
use App\Models\Doctors;
use App\Models\Wallets;
use Carbon\Carbon;

class WebReportController extends Controller
{
    // 1. Patient Reports
    public function patientReports()
    {
        // Summary Counts
        $totalPatients = Patients::count();
        $verifiedHealthCards = Patients::whereNotNull('hc_verified_at')->count();

        // Patients by Blood Group
        $bloodGroups = Patients::select('blood_group', DB::raw('count(*) as total'))
            ->whereNotNull('blood_group')
            ->groupBy('blood_group')
            ->get();

        // Recent Registrations
        $recentPatients = User::where('role', '5') // 5 = Patient
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.analytics.patient_reports', compact('totalPatients', 'verifiedHealthCards', 'bloodGroups', 'recentPatients'));
    }

    // 2. Patient Statistics
    public function patientStatistics()
    {
        // Monthly Registrations for current year
        $registrations = User::where('role', '5')
            ->select(DB::raw('count(id) as count'), DB::raw('MONTH(created_at) as month'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Gender Distribution
        $genderDist = User::where('role', '5')
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get();

        return view('admin.analytics.patient_statistics', compact('registrations', 'genderDist'));
    }

    // 3. Appointment Reports
    public function appointmentReports()
    {
        $totalAppointments = Appointments::count();
        $pending = Appointments::where('status', '0')->count();
        $confirmed = Appointments::where('status', '1')->count();
        $cancelled = Appointments::where('status', '2')->count();
        $completed = Appointments::where('status', '3')->count(); // Assuming 3 is completed

        // Appointments by Specialist (via Doctor)
        $bySpecialist = Appointments::join('users as doc', 'appointments.did', '=', 'doc.id')
            ->join('doctors', 'doc.id', '=', 'doctors.uid')
            ->select('doctors.specialist', DB::raw('count(*) as total'))
            ->groupBy('doctors.specialist')
            ->get();

        return view('admin.analytics.appointment_reports', compact('totalAppointments', 'pending', 'confirmed', 'cancelled', 'completed', 'bySpecialist'));
    }

    // 4. Revenue Reports
    public function revenueReports()
    {
        // Total Revenue (assuming payment_status 'paid' implies revenue collected)
        // Here we sum doctor's fees for paid appointments. 
        // Note: Actual implementation depends on where the transaction amount is stored. 
        // Based on WebAppointmentController, fees are added to doctor's wallet.

        $totalRevenue = Wallets::where('status', 'credit')->sum('amount');

        // Revenue by Doctor
        $revenueByDoctor = Wallets::join('users', 'wallets.did', '=', 'users.id')
            ->select('users.first_name', 'users.last_name', DB::raw('sum(wallets.amount) as total'))
            ->where('wallets.status', 'credit')
            ->groupBy('wallets.did', 'users.first_name', 'users.last_name')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        // Recent Transactions
        $recentTransactions = Wallets::with('doctor') // Assuming relationship exists or we can join
            ->join('users', 'wallets.did', '=', 'users.id')
            ->select('wallets.*', 'users.first_name', 'users.last_name')
            ->orderBy('wallets.created_at', 'desc')
            ->take(20)
            ->get();

        return view('admin.analytics.revenue_reports', compact('totalRevenue', 'revenueByDoctor', 'recentTransactions'));
    }
}
