@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>
        <!-- otp-verification-area -->
        <section id="otp-verification" class="team-area pt-100 pb-20">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-6">
                        <div class="card auth-card">
                            <div class="card-body">
                                <h4 class="text-center mb-4">OTP Verification</h4>
                                <p class="text-center mb-4">
                                    We've sent a one-time verification code to your email (or phone).
                                    Please enter the code below to continue.
                                </p>
                                <form method="POST" action="/verify-otp">
                                    @csrf
                                    <div class="form-group">
                                        <label for="otp_code">Verification Code*</label>
                                        <input type="text" class="form-control" id="otp_code" name="otp_code" required
                                            placeholder="Enter 6-digit code">
                                    </div>
                                    <button type="submit" class="btn auth-btn btn-block mb-3">
                                        Verify
                                    </button>
                                    <!-- Optionally add a link or button to resend OTP -->
                                    <div class="text-center mt-3">
                                        <a href="/resend-otp" class="auth-footer-link">Didn't receive a code? Resend OTP</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- otp-verification-area-end -->
    </main>
    <!-- main-area-end -->
@endsection