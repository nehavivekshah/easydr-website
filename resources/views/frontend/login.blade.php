@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>
        <!-- login-area -->
        <section id="login" class="team-area pt-100 pb-20">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-6">
                        <div class="card auth-card">
                            <div class="card-body">
                                <h4 class="text-center mb-4">Login</h4>
                                <form method="POST" action="/login">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email address*</label>
                                        <input type="email" class="form-control" id="email" name="email" required
                                            placeholder="Enter email*">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password*</label>
                                        <input type="password" class="form-control" id="password" name="password" required
                                            placeholder="Password*">
                                        <div class="text-right mt-1">
                                            <a href="/forgot-password" class="auth-footer-link text-sm">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn auth-btn btn-block mb-3">Login</button>
                                    <div class="text-center mt-3">
                                        <a href="/signup" class="auth-footer-link">Don't have an account? Sign Up</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- login-area-end -->
    </main>
    <!-- main-area-end -->
@endsection