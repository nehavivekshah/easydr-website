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
                        <div class="dashboard_content">
                            <h5>overview</h5>

                            <div class="row">

                                @if(Auth::user()->role == 5)
                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview">
                                            <div class="icon"><i class="fas fa-handshake" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>Total Appointment</p>
                                                <h3>{{ $appointmentsCount ?? 0 }}</h3>
                                                <p>{{ $todayAppointmentsCount ?? 0 }} Today</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview bg-success">
                                            <div class="icon"><i class="far fa-check-circle" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>Done Appointment</p>
                                                <h3>{{ $completedAppointmentsCount ?? 0 }}</h3>
                                                <p>{{ $todayCompletedCount ?? 0 }} Today</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview bg-warning">
                                            <div class="icon"><i class="far fa-file-alt" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>Pending Appointment</p>
                                                <h3>{{ $pendingAppointmentsCount ?? 0 }}</h3>
                                                <p>{{ $todayPendingCount ?? 0 }} Today</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview bg-purple">
                                            <div class="icon"><i class="fas fa-hand-holding-usd" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>Total Payment</p>
                                                <h3>{{ $billingAmount ?? 0 }}</h3>
                                                <p>{{ $todayPaymentCount ?? 0 }} Today</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview bg-info">
                                            <div class="icon"><i class="fal fa-stars" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>Total Review</p>
                                                <h3>{{ $favoritesCount ?? 0 }}</h3>
                                                <p>0 Today</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>

                                @else

                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview">
                                            <div class="icon"><i class="fas fa-handshake" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>Total Appointment</p>
                                                <h3>{{ $appointmentsCount ?? 0 }}</h3>
                                                <p>{{ $todayAppointmentsCount ?? 0 }} Today</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview bg-success">
                                            <div class="icon"><i class="fas fa-users" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>My Patients</p>
                                                <h3>{{ $patientsCount ?? 0 }}</h3>
                                                <p>Unique Patients</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview bg-purple">
                                            <div class="icon"><i class="fas fa-wallet" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>Wallet Balance</p>
                                                <h3>{{ $walletAmount ?? 0 }}</h3>
                                                <p>Total Revenue: {{ $totalRevenue ?? 0 }}</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>
                                @endif

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection