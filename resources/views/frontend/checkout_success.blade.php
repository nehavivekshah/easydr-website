@extends('frontend.layout')

@section('content')
    <main>
        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex align-items-center"
            style="background-image:url({{ asset('public/assets/frontend/img/testimonial/test-bg.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                        <div class="breadcrumb-wrap text-center">
                            <div class="breadcrumb-title mb-30">
                                <h2>Order Successful</h2>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Checkout Complete</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <section class="checkout-success-area pt-100 pb-100 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="card border-0 shadow-sm rounded-4 text-center p-5">
                            <div class="mb-4 d-flex justify-content-center">
                                <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 100px; height: 100px;">
                                    <i class="fas fa-check-circle" style="font-size: 4rem;"></i>
                                </div>
                            </div>
                            <h2 class="fw-bold text-dark mb-2">Thank you for your order!</h2>
                            <p class="text-secondary lead mb-4">Your prescribed medicines order has been placed
                                successfully.</p>

                            <div class="bg-light rounded p-4 mb-4 text-start">
                                <h5 class="fw-bold mb-3 border-bottom pb-2">Order Details</h5>
                                <div class="row">
                                    <div class="col-sm-6 mb-2">
                                        <small class="text-muted d-block">Order ID</small>
                                        <span
                                            class="fw-bold text-dark">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <small class="text-muted d-block">Date</small>
                                        <span
                                            class="fw-bold text-dark">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</span>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <small class="text-muted d-block">Total Amount</small>
                                        <span
                                            class="fw-bold text-success">${{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <small class="text-muted d-block">Status</small>
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm"><i
                                                class="fas fa-clock me-1"></i> Pending Verification</span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-muted small mb-4">Our pharmacy team will review your order and prescription
                                shortly. You will receive an update once it is confirmed and ready for dispatch or pickup.
                            </p>

                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="/my-account" class="btn btn-outline-primary rounded-pill px-4 shadow-sm fw-bold">
                                    Go to Dashboard
                                </a>
                                <a href="/patient-prescriptions"
                                    class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                                    View More Prescriptions
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection