@extends('layout')
@section('title', 'Reset Password - Easy Doctor')

@push('styles')
    <style>
        .page-header-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .wizard-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
            overflow: hidden;
        }

        .wizard-banner {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            padding: 22px 32px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .wizard-banner-icon {
            width: 46px;
            height: 46px;
            background: rgba(255, 255, 255, .18);
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .wizard-banner-title {
            color: #fff;
            font-size: 1.05rem;
            font-weight: 700;
            margin: 0;
        }

        .wizard-banner-sub {
            color: rgba(255, 255, 255, .8);
            font-size: .78rem;
            margin: 2px 0 0;
        }

        .wizard-card-body {
            padding: 28px 32px 32px;
        }



        .form-section-title {
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #6c757d;
            margin: 8px 0 18px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e9ecef;
        }

        /* ---- Inputs ---- */
        .input-group-text {
            background: #f0f4ff;
            border-right: none;
            color: #2563eb;
            min-width: 42px;
            justify-content: center;
        }

        .input-group .form-control {
            border-left: none;
            background: #f8f9fb;
        }

        .input-group .form-control:focus {
            border-color: #2563eb;
            box-shadow: none;
            background: #fff;
        }

        /* ---- Password toggle ---- */
        .pw-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
            z-index: 10;
            font-size: 1.1rem;
            transition: color .2s;
        }

        .pw-toggle:hover {
            color: #2563eb;
        }

        .input-group {
            position: relative;
        }

        /* ---- Strength bar ---- */
        .strength-bar {
            height: 4px;
            border-radius: 4px;
            background: #e5e7eb;
            margin-top: 6px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0;
            border-radius: 4px;
            transition: width .3s, background .3s;
        }

        /* ---- Match indicator ---- */
        .match-msg {
            font-size: .8rem;
            font-weight: 600;
            margin-top: 5px;
            display: none;
        }

        .match-msg.ok {
            color: #16a34a;
        }

        .match-msg.err {
            color: #dc2626;
        }

        /* ---- Buttons ---- */
        .btn-wizard-submit {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 10px 36px;
            font-weight: 600;
            font-size: .92rem;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .3);
            transition: all .2s;
        }

        .btn-wizard-submit:hover:not(:disabled) {
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            box-shadow: 0 6px 20px rgba(37, 99, 235, .4);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-wizard-submit:disabled {
            opacity: .55;
            cursor: not-allowed;
            transform: none;
        }

        .btn-wizard-reset {
            background: #fff;
            color: #374151;
            border: 1.5px solid #d1d5db;
            border-radius: 50px;
            padding: 10px 24px;
            font-weight: 600;
            font-size: .92rem;
            transition: all .2s;
        }

        .btn-wizard-reset:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        /* ---- Security tips ---- */
        .security-tip {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 14px 16px;
            font-size: .82rem;
            color: #166534;
        }

        .security-tip li {
            margin-bottom: 4px;
        }
    </style>
@endpush

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
    @endphp

    <section class="task__section">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">Reset Password</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active text-muted">Reset Password</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="wizard-card">
                <div class="wizard-banner">
                    <div class="wizard-banner-icon"><i class="bx bx-lock-alt"></i></div>
                    <div>
                        <p class="wizard-banner-title">Reset Password</p>
                        <p class="wizard-banner-sub">Update your account password securely</p>
                    </div>
                </div>
                <div class="wizard-card-body">
                    <div class="form-section-title"><i class="bx bx-shield-alt-2 me-2"></i>Change Your Password</div>

                    <form action="{{ route('resetPassword') }}" method="POST">
                        @csrf
                        <div class="row g-3">

                            {{-- Current Password --}}
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Current Password <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-lock"></i></span>
                                    <input type="password" name="cur_password" id="cur_password" class="form-control pe-5"
                                        placeholder="Enter current password" required>
                                    <i class="bx bx-hide pw-toggle" data-target="cur_password"></i>
                                </div>
                            </div>

                            {{-- New Password --}}
                            <div class="col-12">
                                <label class="form-label small fw-semibold">New Password <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-lock-open-alt"></i></span>
                                    <input type="password" name="new_password" id="new_password" class="form-control pe-5"
                                        placeholder="Enter new password" required>
                                    <i class="bx bx-hide pw-toggle" data-target="new_password"></i>
                                </div>
                                <div class="strength-bar mt-2">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <small id="strengthLabel" class="text-muted" style="font-size:.75rem;"></small>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Confirm New Password <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-check-shield"></i></span>
                                    <input type="password" name="new_password_confirmation" id="cn_password"
                                        class="form-control pe-5" placeholder="Re-enter new password" required>
                                    <i class="bx bx-hide pw-toggle" data-target="cn_password"></i>
                                </div>
                                <div class="match-msg ok" id="matchOk"><i class="bx bx-check me-1"></i>Passwords match
                                </div>
                                <div class="match-msg err" id="matchErr"><i class="bx bx-x me-1"></i>Passwords do not
                                    match</div>
                            </div>

                            {{-- Security Tips --}}
                            <div class="col-12">
                                <div class="security-tip">
                                    <strong class="d-block mb-1">💡 Tips for a strong password:</strong>
                                    <ul class="mb-0 ps-3">
                                        <li>At least 8 characters long</li>
                                        <li>Mix of uppercase &amp; lowercase letters</li>
                                        <li>Include numbers and special characters (!@#$...)</li>
                                        <li>Avoid reusing previous passwords</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3"
                            style="border-top:1px solid #e9ecef;">
                            <button type="reset" class="btn-wizard-reset" onclick="resetForm()">
                                <i class="bx bx-reset me-1"></i> Clear
                            </button>
                            <button type="submit" id="submitButtonv" class="btn-wizard-submit">
                                <i class="bx bx-save me-1"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>{{-- /.wizard-card-body --}}
            </div>{{-- /.wizard-card --}}
        </div>{{-- /.container-fluid --}}
    </section>
@endsection

@push('scripts')
    <script>
        /* ---- Password visibility toggle ---- */
        document.querySelectorAll('.pw-toggle').forEach(function (icon) {
            icon.addEventListener('click', function () {
                const input = document.getElementById(this.dataset.target);
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                this.classList.toggle('bx-hide', !isHidden);
                this.classList.toggle('bx-show', isHidden);
            });
        });

        /* ---- Password strength ---- */
        document.getElementById('new_password').addEventListener('input', function () {
            const val = this.value;
            const fill = document.getElementById('strengthFill');
            const label = document.getElementById('strengthLabel');
            let strength = 0;
            if (val.length >= 8) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;

            const levels = [
                { pct: '0%', color: '#e5e7eb', text: '' },
                { pct: '25%', color: '#ef4444', text: 'Weak' },
                { pct: '50%', color: '#f97316', text: 'Fair' },
                { pct: '75%', color: '#eab308', text: 'Good' },
                { pct: '100%', color: '#22c55e', text: 'Strong' },
            ];
            fill.style.width = levels[strength].pct;
            fill.style.background = levels[strength].color;
            label.textContent = levels[strength].text;
            label.style.color = levels[strength].color;
            validatePasswordMatch();
        });

        /* ---- Password match validation ---- */
        document.getElementById('cn_password').addEventListener('keyup', validatePasswordMatch);

        function validatePasswordMatch() {
            const newPw = document.getElementById('new_password').value;
            const confPw = document.getElementById('cn_password').value;
            const btn = document.getElementById('submitButtonv');
            const ok = document.getElementById('matchOk');
            const err = document.getElementById('matchErr');

            if (confPw.length === 0) {
                ok.style.display = err.style.display = 'none';
                btn.disabled = false;
                return;
            }
            if (newPw === confPw) {
                ok.style.display = 'block'; err.style.display = 'none';
                btn.disabled = false;
            } else {
                err.style.display = 'block'; ok.style.display = 'none';
                btn.disabled = true;
            }
        }

        function resetForm() {
            document.getElementById('strengthFill').style.width = '0';
            document.getElementById('strengthLabel').textContent = '';
            document.getElementById('matchOk').style.display = 'none';
            document.getElementById('matchErr').style.display = 'none';
            document.getElementById('submitButtonv').disabled = false;
        }
    </script>
@endpush