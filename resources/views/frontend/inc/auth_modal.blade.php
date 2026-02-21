<!-- Auth Modal -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered border-0">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header border-0 pb-0 position-relative" style="background-color: #f8f9fa;">
                <button type="button" class="btn-close position-absolute" style="top: 15px; right: 15px; z-index: 10;"
                    data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="w-100 text-center pt-3 pb-2">
                    <img src="{{ asset('public/assets/frontend/img/logo/logo.jpeg') }}" alt="EasyDoctor Logo"
                        style="height: 50px; object-fit: contain; max-width: 200px;" class="mb-2">
                </div>
            </div>
            <div class="modal-body pt-4 px-4 pb-4">

                <!-- Login View -->
                <div id="authLoginView">
                    <h4 class="text-center mb-1 fw-bold" id="authModalLabel" style="color: #1E0B9B;">Welcome Back</h4>
                    <p class="text-center text-muted small mb-4">Please enter your credentials to login.</p>
                    <form method="POST" action="/login" id="modalLoginForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="modalLoginEmail">Email address*</label>
                            <input type="email" class="form-control" id="modalLoginEmail" name="email" required
                                placeholder="Enter email*">
                        </div>
                        <div class="form-group mb-4">
                            <label for="modalLoginPassword">Password*</label>
                            <input type="password" class="form-control" id="modalLoginPassword" name="password" required
                                placeholder="Password*">
                            <div class="text-right mt-1">
                                <a href="javascript:void(0)" class="auth-footer-link text-sm text-decoration-none"
                                    onclick="switchAuthView('forgotPassword')">Forgot Password?</a>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                        <div class="text-center mt-3">
                            <span class="text-muted">Don't have an account? </span>
                            <a href="javascript:void(0)" class="auth-footer-link text-decoration-none fw-bold"
                                onclick="switchAuthView('register')">Sign Up</a>
                        </div>
                    </form>
                </div>

                <!-- Register View -->
                <div id="authRegisterView" class="d-none">
                    <h4 class="text-center mb-1 fw-bold" style="color: #1E0B9B;">Create Account</h4>
                    <p class="text-center text-muted small mb-4">Join us to book appointments and manage health records.
                    </p>
                    <form method="POST" action="/signup" id="modalRegisterForm"
                        onsubmit="return validateModalPasswords()">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="modalRegFirstName">First Name*</label>
                                <input type="text" class="form-control" id="modalRegFirstName" name="first_name"
                                    required placeholder="First name">
                            </div>
                            <div class="col-md-6">
                                <label for="modalRegLastName">Last Name*</label>
                                <input type="text" class="form-control" id="modalRegLastName" name="last_name" required
                                    placeholder="Last name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="modalRegMobile">Mobile Number*</label>
                                <input type="text" class="form-control" id="modalRegMobile" name="mobile" required
                                    placeholder="Mobile number">
                            </div>
                            <div class="col-md-6">
                                <label for="modalRegEmail">Email address*</label>
                                <input type="email" class="form-control" id="modalRegEmail" name="email" required
                                    placeholder="Email">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="modalRegPassword">Password*</label>
                                <input type="password" class="form-control" id="modalRegPassword" name="password"
                                    required placeholder="Password">
                            </div>
                            <div class="col-md-6">
                                <label for="modalRegConfirm">Confirm*</label>
                                <input type="password" class="form-control" id="modalRegConfirm"
                                    name="password_confirmation" required placeholder="Confirm">
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="modalRegTerms" name="terms" required>
                            <label class="form-check-label" for="modalRegTerms">I accept the <a href="#">terms &
                                    conditions</a></label>
                        </div>
                        <div id="modal-password-error" class="text-danger small mb-3 d-none">Passwords do not match.
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Register</button>
                        <div class="text-center mt-3">
                            <span class="text-muted">Already have an account? </span>
                            <a href="javascript:void(0)" class="auth-footer-link text-decoration-none fw-bold"
                                onclick="switchAuthView('login')">Login</a>
                        </div>
                    </form>
                </div>

                <!-- Forgot Password View -->
                <div id="authForgotPasswordView" class="d-none">
                    <h4 class="text-center mb-1 fw-bold" style="color: #1E0B9B;">Reset Password</h4>
                    <p class="text-center text-muted small mb-4">Enter your registered email below to receive password
                        reset instructions.</p>
                    <form method="POST" action="/forgot-password" id="modalForgotForm">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="modalForgotEmail">Email address*</label>
                            <input type="email" class="form-control" id="modalForgotEmail" name="email" required
                                placeholder="Enter your registered email*">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">Submit</button>
                        <div class="text-center mt-3">
                            <a href="javascript:void(0)" class="auth-footer-link text-decoration-none fw-bold"
                                onclick="switchAuthView('login')"><i class="fas fa-arrow-left me-1"></i> Back to
                                Login</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function switchAuthView(view) {
        // Hide all views first
        document.getElementById('authLoginView').classList.add('d-none');
        document.getElementById('authRegisterView').classList.add('d-none');
        document.getElementById('authForgotPasswordView').classList.add('d-none');

        // Show requested view
        if (view === 'login') {
            document.getElementById('authLoginView').classList.remove('d-none');
        } else if (view === 'register') {
            document.getElementById('authRegisterView').classList.remove('d-none');
        } else if (view === 'forgotPassword') {
            document.getElementById('authForgotPasswordView').classList.remove('d-none');
        }
    }

    function validateModalPasswords() {
        const password = document.getElementById("modalRegPassword").value;
        const confirmPassword = document.getElementById("modalRegConfirm").value;
        const error = document.getElementById("modal-password-error");

        if (password !== confirmPassword) {
            error.classList.remove("d-none");
            return false;
        }

        error.classList.add("d-none");
        return true;
    }

    // Reset to login view when modal is closed
    document.addEventListener('DOMContentLoaded', function () {
        const authModal = document.getElementById('authModal');
        if (authModal) {
            authModal.addEventListener('hidden.bs.modal', function () {
                switchAuthView('login');

                // Optional: clear form fields
                document.getElementById('modalLoginForm').reset();
                document.getElementById('modalRegisterForm').reset();
                document.getElementById('modalForgotForm').reset();
                document.getElementById("modal-password-error").classList.add("d-none");
            });
        }
    });
</script>