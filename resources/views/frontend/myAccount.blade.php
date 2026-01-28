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
                        {{-- NEW DASHBOARD UI STATS GRID --}}
                        <div class="row gx-3 gy-3 mb-4">
                            @if(Auth::user()->role == 2)
                                {{-- DOCTOR STATS --}}
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-stat-card">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon-circle"><i class="bx bx-calendar-check"></i></div>
                                            <div class="stat-details">
                                                <p>Total Appointment</p>
                                                <h3>{{ $appointmentsCount ?? 0 }}</h3>
                                                <small>15 Today</small>
                                            </div>
                                        </div>
                                        <i class="bx bx-heart-circle stat-bg-icon"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-stat-card">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon-circle"><i class="bx bx-check-circle"></i></div>
                                            <div class="stat-details">
                                                <p>Done Appointment</p>
                                                <h3>{{ $appointmentsCount ?? 0 }}</h3> {{-- Needs 'completed' count logic --}}
                                                <small>12 Today</small>
                                            </div>
                                        </div>
                                        <i class="bx bx-heart-circle stat-bg-icon"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-stat-card">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon-circle"><i class="bx bx-time"></i></div>
                                            <div class="stat-details">
                                                <p>Pending Appointment</p>
                                                <h3>0</h3> {{-- Needs 'pending' count logic --}}
                                                <small>5 Today</small>
                                            </div>
                                        </div>
                                        <i class="bx bx-heart-circle stat-bg-icon"></i>
                                    </div>
                                </div>

                            @else
                                {{-- PATIENT STATS --}}
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-stat-card">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon-circle"><i class="bx bx-calendar-check"></i></div>
                                            <div class="stat-details">
                                                <p>Total Appointment</p>
                                                <h3>{{ $appointmentsCount ?? 255 }}</h3>
                                                <small class="d-none">15 Today</small>
                                            </div>
                                        </div>
                                        <i class="bx bx-heart-circle stat-bg-icon"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-stat-card">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon-circle"><i class="bx bx-check-circle"></i></div>
                                            <div class="stat-details">
                                                <p>Done Appointment</p>
                                                <h3>{{ $appointmentsCount ?? 220 }}</h3>
                                                <small class="d-none">12 Today</small>
                                            </div>
                                        </div>
                                        <i class="bx bx-heart-circle stat-bg-icon"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-stat-card">
                                        <div class="d-flex align-items-center">
                                            {{-- Using file icon for 'Pending' or 'Reports' for now --}}
                                            <div class="stat-icon-circle"><i class="bx bx-file"></i></div>
                                            <div class="stat-details">
                                                <p>Pending Appointment</p>
                                                <h3>{{ $reportsCount ?? 35 }}</h3>
                                                <small class="d-none">5 Today</small>
                                            </div>
                                        </div>
                                        <i class="bx bx-heart-circle stat-bg-icon"></i>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-stat-card">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon-circle"><i class="bx bx-dollar-circle"></i></div>
                                            <div class="stat-details">
                                                <p>Total Payment</p>
                                                <h3>{{ $billingAmount ?? 255 }}</h3>
                                                <small class="d-none">15 Today</small>
                                            </div>
                                        </div>
                                        <i class="bx bx-heart-circle stat-bg-icon"></i>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-stat-card">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon-circle"><i class="bx bx-star"></i></div>
                                            <div class="stat-details">
                                                <p>Total Review</p>
                                                <h3>{{ $favoritesCount ?? 220 }}</h3>
                                                <small class="d-none">5 Today</small>
                                            </div>
                                        </div>
                                        <i class="bx bx-heart-circle stat-bg-icon"></i>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="dashboard-stat-card">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon-circle"><i class="bx bx-grid-alt"></i></div>
                                            <div class="stat-details">
                                                <p>Other Stats</p>
                                                <h3>35</h3>
                                                <small class="d-none">5 Today</small>
                                            </div>
                                        </div>
                                        <i class="bx bx-heart-circle stat-bg-icon"></i>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- PROFILE INFORMATION SECTION --}}
                        <div class="profile-info-header">
                            <h4 class="profile-info-title">Profile Information</h4>
                            <a href="/my-profile" class="btn-edit-profile">edit</a>
                        </div>

                        <div class="profile-content">
                            <div class="profile-row clearfix">
                                <span class="profile-label">Name:</span>
                                <span class="profile-value">{{ Auth::user()->first_name }}
                                    {{ Auth::user()->last_name }}</span>
                            </div>
                            <div class="profile-row clearfix">
                                <span class="profile-label">Phone:</span>
                                <span class="profile-value">{{ Auth::user()->mobile }}</span>
                            </div>
                            <div class="profile-row clearfix">
                                <span class="profile-label">Email:</span>
                                <span class="profile-value">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="profile-row clearfix">
                                <span class="profile-label">Gender:</span>
                                <span class="profile-value">{{ Auth::user()->gender ?? 'Not Specified' }}</span>
                            </div>
                            <!--
                                <div class="profile-row clearfix">
                                    <span class="profile-label">Weight:</span>
                                    <span class="profile-value">64kg</span>
                                </div>
                                <div class="profile-row clearfix">
                                    <span class="profile-label">Age:</span>
                                    <span class="profile-value">35</span>
                                </div>
                                -->
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