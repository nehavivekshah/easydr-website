@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>
        <!-- forgot-password-area -->
        <section id="forgot-password" class="team-area pt-40 pb-40">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-6">
                        <div class="card auth-card">
                            <div class="card-body">
                                <h4 class="text-center mb-4">Forgot Password</h4>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form method="POST" action="/forgot-password">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email address*</label>
                                        <input type="email" class="form-control" id="email" name="email" required
                                            placeholder="Enter your registered email*">
                                    </div>
                                    <button type="submit" class="btn auth-btn btn-block mb-3">Submit</button>
                                    <div class="text-center mt-3">
                                        <a href="/login" class="auth-footer-link">Back to Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- forgot-password-area-end -->
    </main>
    <!-- main-area-end -->
@endsection