@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>
        <!-- signup-area -->
        <section id="signup" class="team-area pt-70 pb-80">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-7 col-md-8">
                        <div class="card auth-card">
                            <div class="card-body">
                                <h4 class="text-center mb-4">Sign Up</h4>
                                <form method="POST" action="/signup" onsubmit="return validatePasswords()">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                required placeholder="Enter first name">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" required
                                                placeholder="Enter last name">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="mobile">Mobile Number</label>
                                            <input type="tel" class="form-control" id="mobile" name="mobile" required
                                                pattern="[0-9]{10}" maxlength="10"
                                                title="Please enter a valid 10-digit mobile number"
                                                placeholder="Enter 10-digit mobile number">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control" id="email" name="email" required
                                                placeholder="Enter email">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                required placeholder="Password">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" required placeholder="Confirm password">
                                        </div>
                                    </div>
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                        <label class="form-check-label" for="terms">I accept the <a href="#">terms &
                                                conditions</a></label>
                                    </div>
                                    <div id="password-error" style="color: red; display: none;">Passwords do not match.
                                    </div>
                                    <button type="submit" class="btn auth-btn btn-block mb-3">Register</button>
                                    <div class="text-center mt-3">
                                        <a href="/login" class="auth-footer-link">Already have an account? Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- signup-area-end -->
    </main>
    <!-- main-area-end -->
    <script>
        function validatePasswords() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("password_confirmation").value;
            const error = document.getElementById("password-error");

            if (password !== confirmPassword) {
                error.style.display = "block";
                return false;
            }

            error.style.display = "none";
            return true;
        }
    </script>
@endsection