@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    <!-- Content Area -->
                    <div class="col-lg-9">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h4 class="mb-4">Dashboard Overview</h4>

                                <div class="row text-center">
                                    {{-- DOCTOR DASHBOARD (Role 2) --}}
                                    @if(Auth::user()->role == 2)
                                        <div class="col-md-6 col-lg-3 mb-3">
                                            <div class="p-3 border rounded">
                                                <h5 class="mb-1 text-primary">{{ $appointmentsCount ?? 0 }}</h5>
                                                <small class="text-muted">Today's Appointments</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-3">
                                            <div class="p-3 border rounded">
                                                <h5 class="mb-1 text-success">{{ $patientsCount ?? 0 }}</h5>
                                                <small class="text-muted">My Patients</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-3">
                                            <div class="p-3 border rounded">
                                                <h5 class="mb-1 text-info">₹{{ $walletAmount ?? '0.00' }}</h5>
                                                <small class="text-muted">Wallet Balance</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-3">
                                            <div class="p-3 border rounded">
                                                <h5 class="mb-1 text-warning">₹{{ $totalRevenue ?? '0.00' }}</h5>
                                                <small class="text-muted">Total Revenue</small>
                                            </div>
                                        </div>

                                        {{-- PATIENT DASHBOARD (Role 3) --}}
                                    @else
                                        <div class="col-md-6 col-lg-3 mb-3">
                                            <div class="p-3 border rounded">
                                                <h5 class="mb-1 text-primary">{{ $appointmentsCount ?? 0 }}</h5>
                                                <small class="text-muted">Appointments</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-3">
                                            <div class="p-3 border rounded">
                                                <h5 class="mb-1 text-success">{{ $reportsCount ?? 0 }}</h5>
                                                <small class="text-muted">Medical Reports</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-3">
                                            <div class="p-3 border rounded">
                                                <h5 class="mb-1 text-danger">{{ $favoritesCount ?? 0 }}</h5>
                                                <small class="text-muted">Favorites</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-3">
                                            <div class="p-3 border rounded">
                                                <h5 class="mb-1 text-info">₹{{ $billingAmount ?? '0.00' }}</h5>
                                                <small class="text-muted">Total Billing</small>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Additional Dashboard Content (Recent Activity, etc.) could go here --}}
                        @if(Auth::user()->role == 2)
                            <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">Recent Appointments</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Patient</th>
                                                    <th>Date/Time</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($recentAppointments ?? [] as $appt)
                                                    <tr>
                                                        <td>{{ $appt->patient_first_name }} {{ $appt->patient_last_name }}</td>
                                                        <td>{{ $appt->date }} <br> <small>{{ $appt->time }}</small></td>
                                                        <td>
                                                            @if($appt->status == 1)
                                                                <span class="badge bg-success">Completed</span>
                                                            @elseif($appt->status == 2)
                                                                <span class="badge bg-danger">Cancelled</span>
                                                            @else
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="/appointments/{{ $appt->id }}"
                                                                class="btn btn-sm btn-outline-primary">View</a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-3">No recent appointments.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Patient Recent Stuff --}}
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection