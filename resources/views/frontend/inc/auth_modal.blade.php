<!-- Auth Modal -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered border-0">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header border-0 pb-0 position-relative" style="background-color: #f8f9fa;">
                <button type="button" class="btn text-muted position-absolute"
                    style="top: 10px; right: 15px; z-index: 10; font-size: 1.2rem; background: transparent; border: none; outline: none; box-shadow: none; padding: 0px;"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
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
                                <input type="tel" class="form-control" id="modalRegMobile" name="mobile" required
                                    pattern="[0-9]{10}" maxlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    title="Please enter a valid 10-digit mobile number" placeholder="10-digit number">
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

                        <button type="submit" class="btn btn-primary w-100 mb-3" id="modalRegSubmitBtn">Register
                            <span class="spinner-border spinner-border-sm d-none ms-2" role="status" aria-hidden="true"
                                id="modalRegSpinner"></span>
                        </button>
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
                        <button type="submit" class="btn btn-primary w-100 mb-3" id="modalForgotSubmitBtn">Submit
                            <span class="spinner-border spinner-border-sm d-none ms-2" role="status" aria-hidden="true"
                                id="modalForgotSpinner"></span>
                        </button>
                        <div class="text-center mt-3">
                            <a href="javascript:void(0)" class="auth-footer-link text-decoration-none fw-bold"
                                onclick="switchAuthView('login')"><i class="fas fa-arrow-left me-1"></i> Back to
                                Login</a>
                        </div>
                    </form>
                </div>

                <!-- OTP View -->
                <div id="authOtpView" class="d-none">
                    <h4 class="text-center mb-1 fw-bold" style="color: #1E0B9B;">OTP Verification</h4>
                    <p class="text-center text-muted small mb-4">
                        We've sent a 6-digit verification code to your email.
                        Please enter the code below to continue.
                    </p>
                    <form method="POST" action="/verify-otp" id="modalOtpForm">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="modalOtpCode">Verification Code*</label>
                            <input type="text" class="form-control text-center" id="modalOtpCode" name="otp_code"
                                required placeholder="------" maxlength="6"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                style="letter-spacing: 4px; font-size: 1.2rem;">
                        </div>
                        <div id="modal-otp-error" class="text-danger small mb-3 text-center d-none"></div>
                        <button type="submit" class="btn btn-primary w-100 mb-3" id="modalOtpSubmitBtn">Verify Code
                            <span class="spinner-border spinner-border-sm d-none ms-2" role="status" aria-hidden="true"
                                id="modalOtpSpinner"></span>
                        </button>
                        <div class="text-center mt-3">
                            <a href="/resend-otp" class="auth-footer-link text-decoration-none small text-muted">Didn't
                                receive a code? Resend</a>
                        </div>
                    </form>
                </div>

                <!-- Create New Password View -->
                <div id="authCreatePasswordView" class="d-none">
                    <h4 class="text-center mb-1 fw-bold" style="color: #1E0B9B;">Create New Password</h4>
                    <p class="text-center text-muted small mb-4">Please enter a new password for your account.</p>
                    <form method="POST" action="/create-new-password" id="modalCreatePasswordForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="modalNewPassword">New Password*</label>
                            <input type="password" class="form-control" id="modalNewPassword" name="password" required
                                placeholder="Enter new password" style="padding: 10px; min-height: 45px;">
                        </div>
                        <div class="form-group mb-4">
                            <label for="modalNewPasswordConfirm">Confirm Password*</label>
                            <input type="password" class="form-control" id="modalNewPasswordConfirm"
                                name="password_confirmation" required placeholder="Confirm new password"
                                style="padding: 10px; min-height: 45px;">
                        </div>
                        <div id="modal-create-password-error" class="text-danger small mb-3 text-center d-none"></div>
                        <button type="submit" class="btn btn-primary w-100 mb-3"
                            id="modalCreatePasswordSubmitBtn">Update Password
                            <span class="spinner-border spinner-border-sm d-none ms-2" role="status" aria-hidden="true"
                                id="modalCreatePasswordSpinner"></span>
                        </button>
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
        document.getElementById('authOtpView').classList.add('d-none');
        document.getElementById('authCreatePasswordView').classList.add('d-none');

        // Show requested view
        if (view === 'login') {
            document.getElementById('authLoginView').classList.remove('d-none');
        } else if (view === 'register') {
            document.getElementById('authRegisterView').classList.remove('d-none');
        } else if (view === 'forgotPassword') {
            document.getElementById('authForgotPasswordView').classList.remove('d-none');
        } else if (view === 'otp') {
            document.getElementById('authOtpView').classList.remove('d-none');
        } else if (view === 'createPassword') {
            document.getElementById('authCreatePasswordView').classList.remove('d-none');
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
                document.getElementById('modalOtpForm').reset();
                document.getElementById('modalCreatePasswordForm').reset();
                document.getElementById("modal-password-error").classList.add("d-none");
                document.getElementById("modal-otp-error").classList.add("d-none");
                document.getElementById("modal-create-password-error").classList.add("d-none");
            });
        }
    });

    // AJAX Form Setup
    function handleAjaxFormSubmit(formId, url, targetView, successMsg, btnId, spinnerId) {
        const form = document.getElementById(formId);
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // For register form, check passwords first
            if (formId === 'modalRegisterForm' && !validateModalPasswords()) {
                return;
            }

            // For create password form, check passwords first
            if (formId === 'modalCreatePasswordForm') {
                const p1 = document.getElementById("modalNewPassword").value;
                const p2 = document.getElementById("modalNewPasswordConfirm").value;
                const err = document.getElementById("modal-create-password-error");

                if (p1 !== p2) {
                    err.innerText = "Passwords do not match.";
                    err.classList.remove("d-none");
                    return;
                } else if (p1.length < 8) {
                    err.innerText = "Password must be at least 8 characters.";
                    err.classList.remove("d-none");
                    return;
                }
                err.classList.add("d-none");
            }

            const btn = document.getElementById(btnId);
            const spinner = document.getElementById(spinnerId);
            const originalBtnText = btn.innerText;

            // UI Loading state
            btn.disabled = true;
            spinner.classList.remove('d-none');

            const formData = new FormData(form);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === true || data.success === true) {
                        if (data.action) {
                            if (window.showGlobalToast) window.showGlobalToast('success', successMsg || data.message);
                            switchAuthView(data.action);
                        } else if (targetView === 'redirect') {
                            window.location.href = data.redirect_url || '/login';
                        } else {
                            // Form specific handling
                            if (formId === 'modalOtpForm') {
                                window.location.href = data.redirect_url;
                            } else {
                                if (window.showGlobalToast) window.showGlobalToast('success', successMsg || data.message || 'Success! Check your email for the OTP.');
                                switchAuthView(targetView);
                            }
                        }
                    } else {
                        // Handle Validation errors or normal errors
                        let errorMsg = data.message || 'An error occurred. Please try again.';
                        if (data.errors) {
                            errorMsg = Object.values(data.errors).flat().join('\n');
                        }
                        if (formId === 'modalOtpForm') {
                            const errDiv = document.getElementById("modal-otp-error");
                            errDiv.innerText = errorMsg;
                            errDiv.classList.remove('d-none');
                        } else if (formId === 'modalCreatePasswordForm') {
                            const errDiv = document.getElementById("modal-create-password-error");
                            errDiv.innerText = errorMsg;
                            errDiv.classList.remove('d-none');
                        } else {
                            if (window.showGlobalToast) window.showGlobalToast('error', errorMsg);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (window.showGlobalToast) window.showGlobalToast('error', 'An unexpected error occurred. Please try again later.');
                })
                .finally(() => {
                    btn.disabled = false;
                    spinner.classList.add('d-none');
                });
        });
    }

    // Initialize AJAX handlers
    document.addEventListener('DOMContentLoaded', function () {
        handleAjaxFormSubmit('modalRegisterForm', '/signup', 'otp', 'Registration successful! Please enter the OTP sent to your email.', 'modalRegSubmitBtn', 'modalRegSpinner');
        handleAjaxFormSubmit('modalForgotForm', '/forgot-password', 'otp', 'Password reset instructions sent. Please enter the OTP.', 'modalForgotSubmitBtn', 'modalForgotSpinner');
        handleAjaxFormSubmit('modalOtpForm', '/verify-otp', 'redirect', '', 'modalOtpSubmitBtn', 'modalOtpSpinner');
        handleAjaxFormSubmit('modalCreatePasswordForm', '/create-new-password', 'login', 'Password created successfully. Please login.', 'modalCreatePasswordSubmitBtn', 'modalCreatePasswordSpinner');

        // Auto-open modal if ?auth=login is present in URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('auth') === 'login') {
            const authModalEl = document.getElementById('authModal');
            if (authModalEl) {
                // Initialize modal and show it
                const authModal = new bootstrap.Modal(authModalEl);
                switchAuthView('login');
                authModal.show();

                // Clean up the URL to prevent re-opening on manual refresh
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        }
    });
</script>