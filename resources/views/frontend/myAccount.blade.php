@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        <div class="list-group shadow-sm">
                            <a href="/my-account" class="list-group-item list-group-item-action active">Dashboard</a>
                            <a href="/appointments" class="list-group-item list-group-item-action">Appointments</a>
                            <a href="/my-profile" class="list-group-item list-group-item-action">My Profile</a>
                            <a href="/logout" class="list-group-item list-group-item-action">Logout</a>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="col-lg-9">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h4 class="mb-4">Dashboard Overview</h4>
                                <div class="row text-center">
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <div class="p-3 border rounded">
                                            <h5 class="mb-1">{{ $appointmentsCount ?? 0 }}</h5>
                                            <small class="text-muted">Appointments</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <div class="p-3 border rounded">
                                            <h5 class="mb-1">{{ $reportsCount ?? 0 }}</h5>
                                            <small class="text-muted">Reports</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <div class="p-3 border rounded">
                                            <h5 class="mb-1">{{ $favoritesCount ?? 0 }}</h5>
                                            <small class="text-muted">Favorites</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <div class="p-3 border rounded">
                                            <h5 class="mb-1">₹{{ $billingAmount ?? '0.00' }}</h5>
                                            <small class="text-muted">Total Billing</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Additional content can go here --}}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection