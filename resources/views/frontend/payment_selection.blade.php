@extends('frontend.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/css/dashboard-modern.css') }}">
    <main class="dashboard-container">
        <section class="pt-100 pb-40" style="background: #f8fafc;">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>
                    <!-- Content Area -->
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="col-md-12 p-0">
                                    <div class="card border-0 shadow-sm rounded-4">
                                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                                            <h4 class="fw-bold text-dark mb-1">Select Payment Method</h4>
                                            <p class="text-muted small">Choose how you would like to pay for your
                                                appointment with
                                                Dr. {{ $doctor_name }}</p>
                                        </div>
                                        <div class="card-body p-4">

                                            <div
                                                class="alert alert-info border-0 bg-light-primary text-primary d-flex align-items-center mb-4 rounded-3">
                                                <i class="fas fa-coins me-3 fs-4"></i>
                                                <div>
                                                    <p class="mb-0 fw-semibold">Amount to Pay</p>
                                                    <h3 class="mb-0 fw-bold">${{ number_format($amount, 2) }}</h3>
                                                </div>
                                            </div>

                                            <div class="d-grid gap-3">
                                                @foreach($gateways as $gateway)
                                                    <a href="{{ route('payment', ['gateway' => $gateway->gateway_name]) }}"
                                                        class="btn btn-outline-light text-dark p-3 mb-3 d-flex align-items-center justify-content-between border rounded-3 shadow-sm hover-shadow transition-all"
                                                        style="background: #fff; border-color: #e9ecef;">
                                                        <div class="d-flex align-items-center">
                                                            @if(strtolower($gateway->gateway_name) == 'paypal')
                                                                <i class="fab fa-paypal fa-2x text-primary me-3"
                                                                    style="width: 40px; text-align: center;"></i>
                                                                <div class="text-start">
                                                                    <h6 class="mb-0 fw-bold">PayPal</h6>
                                                                    <small class="text-muted">Pay safely with your PayPal
                                                                        account</small>
                                                                </div>
                                                            @elseif(strtolower($gateway->gateway_name) == 'stripe')
                                                                <i class="fab fa-stripe fa-2x text-primary me-3"
                                                                    style="width: 40px; text-align: center; color: #6772e5;"></i>
                                                                <div class="text-start">
                                                                    <h6 class="mb-0 fw-bold">Credit / Debit Card</h6>
                                                                    <small class="text-muted">Structured by Stripe</small>
                                                                </div>
                                                            @else
                                                                <i class="fas fa-wallet fa-2x text-secondary me-3"
                                                                    style="width: 40px; text-align: center;"></i>
                                                                <div class="text-start">
                                                                    <h6 class="mb-0 fw-bold">
                                                                        {{ ucfirst($gateway->gateway_name) }}
                                                                    </h6>
                                                                    <small class="text-muted">Secure Payment</small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <i class="fas fa-chevron-right text-muted"></i>
                                                    </a>
                                                @endforeach
                                            </div>

                                            <div class="text-center mt-4">
                                                <a href="{{ url('/my-account') }}"
                                                    class="text-muted text-decoration-none small">
                                                    <i class="fas fa-arrow-left me-1"></i> Cancel and return to
                                                    dashboard
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <style>
        .hover-shadow:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
            border-color: var(--primary-color) !important;
            background-color: #f8f9fa !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .bg-light-primary {
            background-color: rgba(13, 110, 253, 0.05);
        }
    </style>
@endsection