@extends('layout')
@section('title', 'Manage Video Call Gateway - Easy Doctor')

@push('styles')
    <style>
        /* ---- Wizard Stepper ---- */
        .wizard-stepper {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px 30px;
            margin-bottom: 28px;
        }

        .wizard-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
        }

        .wizard-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 18px;
            left: calc(50% + 22px);
            width: calc(100% - 44px);
            height: 2px;
            background: #dee2e6;
            z-index: 0;
            transition: background .3s;
        }

        .wizard-step.active:not(:last-child)::after,
        .wizard-step.done:not(:last-child)::after {
            background: #2563eb;
        }

        .step-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .9rem;
            border: 2px solid #dee2e6;
            background: #fff;
            color: #adb5bd;
            z-index: 1;
            transition: all .25s;
        }

        .wizard-step.active .step-circle {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, .35);
        }

        .wizard-step.done .step-circle {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
        }

        .step-label {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #adb5bd;
            margin-top: 8px;
        }

        .wizard-step.active .step-label,
        .wizard-step.done .step-label {
            color: #2563eb;
        }

        .wizard-panel {
            display: none;
        }

        .wizard-panel.active {
            display: block;
        }

        /* ---- Card ---- */
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

        .wizard-back-btn {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, .18);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            flex-shrink: 0;
            transition: background .2s;
            margin-right: 4px;
        }

        .wizard-back-btn:hover {
            background: rgba(255, 255, 255, .3);
            color: #fff;
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

        .input-group .form-control,
        .input-group .form-select {
            border-left: none;
            background: #f8f9fb;
        }

        .input-group .form-control:focus,
        .input-group .form-select:focus {
            border-color: #2563eb;
            box-shadow: none;
            background: #fff;
        }

        /* ---- Secret toggle ---- */
        .secret-wrap {
            position: relative;
        }

        .secret-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
            font-size: 1.1rem;
            z-index: 10;
            transition: color .2s;
        }

        .secret-toggle:hover {
            color: #2563eb;
        }

        /* ---- JSON textarea ---- */
        .json-textarea {
            font-family: 'Courier New', monospace;
            font-size: .83rem;
            background: #1e293b;
            color: #7dd3fc;
            border-radius: 10px;
            border: none;
            padding: 14px;
            resize: vertical;
            min-height: 110px;
        }

        .json-textarea:focus {
            box-shadow: 0 0 0 2px rgba(37, 99, 235, .3);
            outline: none;
        }

        /* ---- Security note ---- */
        .security-note {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: .8rem;
            color: #92400e;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .security-note i {
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* ---- Buttons ---- */
        .btn-wizard-next,
        .btn-wizard-submit {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 10px 32px;
            font-weight: 600;
            font-size: .92rem;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .3);
            transition: all .2s;
            cursor: pointer;
        }

        .btn-wizard-next:hover,
        .btn-wizard-submit:hover {
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            box-shadow: 0 6px 20px rgba(37, 99, 235, .4);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-wizard-back {
            background: #fff;
            color: #374151;
            border: 1.5px solid #d1d5db;
            border-radius: 50px;
            padding: 10px 28px;
            font-weight: 600;
            font-size: .92rem;
            transition: all .2s;
            cursor: pointer;
        }

        .btn-wizard-back:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
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
        }
    </style>
@endpush

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
        $isEdit = !empty($_GET['id']);
    @endphp

    <section class="task__section">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">{{ $isEdit ? 'Edit Video Call Gateway' : 'Add New Video Call Gateway' }}
                    </h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/video-call-gateway-configs"
                                    class="text-decoration-none text-muted">Video Call Gateways</a></li>
                            <li class="breadcrumb-item active text-muted">{{ $isEdit ? 'Edit' : 'Add' }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="wizard-card">
                <div class="wizard-banner">
                    <a href="/admin/video-call-gateway-configs" class="wizard-back-btn" title="Back"><i
                            class="bx bx-arrow-back"></i></a>
                    <div class="wizard-banner-icon"><i class="bx bx-video"></i></div>
                    <div>
                        <p class="wizard-banner-title">
                            {{ $isEdit ? 'Edit Video Call Gateway' : 'Add New Video Call Gateway' }}</p>
                        <p class="wizard-banner-sub">Configure provider identity and API credentials across 2 steps</p>
                    </div>
                </div>
                <div class="wizard-card-body">
                    {{-- Stepper --}}
                    <div class="wizard-stepper">
                        <div class="wizard-step active" data-step="1">
                            <div class="step-circle">1</div>
                            <div class="step-label">Provider Identity</div>
                        </div>
                        <div class="wizard-step" data-step="2">
                            <div class="step-circle">2</div>
                            <div class="step-label">API Credentials</div>
                        </div>
                    </div>

                    <form action="{{ route('manageVideoCallGatewayConfig') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}">

                        {{-- ============================
                        STEP 1: Provider Identity
                        ============================ --}}
                        <div class="wizard-panel active" id="step-1">
                            <div class="form-section-title"><i class="bx bx-video me-2"></i>Provider Information</div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Provider Name <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-video-plus"></i></span>
                                        <input type="text" name="provider_name" class="form-control"
                                            placeholder="e.g. Agora, Twilio, Zegocloud"
                                            value="{{ $vcgc->provider_name ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">App ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-barcode"></i></span>
                                        <input type="text" name="app_id" class="form-control" placeholder="Enter App ID"
                                            value="{{ $vcgc->app_id ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Environment</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-server"></i></span>
                                        <select name="environment" class="form-select">
                                            <option value="sandbox" {{ (isset($vcgc) && $vcgc->environment == 'sandbox') ? 'selected' : '' }}>🟡 Sandbox (Testing)</option>
                                            <option value="production" {{ (isset($vcgc) && $vcgc->environment == 'production') ? 'selected' : '' }}>🔴 Production
                                                (Live)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Status</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-check-circle"></i></span>
                                        <select name="is_active" class="form-select">
                                            <option value="1" {{ (isset($vcgc) && $vcgc->is_active == 1) ? 'selected' : '' }}>
                                                ✅ Active</option>
                                            <option value="0" {{ (isset($vcgc) && $vcgc->is_active == 0) ? 'selected' : '' }}>
                                                ⛔ Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn-wizard-next" onclick="goToStep(2)">
                                    Next <i class="bx bx-right-arrow-alt ms-1"></i>
                                </button>
                            </div>
                        </div>

                        {{-- ============================
                        STEP 2: API Credentials
                        ============================ --}}
                        <div class="wizard-panel" id="step-2">
                            <div class="form-section-title"><i class="bx bx-key me-2"></i>API Credentials</div>

                            <div class="security-note mb-4">
                                <i class="bx bx-shield-quarter text-warning"></i>
                                <span>App secrets and API keys are sensitive. Copy these directly from your provider's
                                    dashboard. They will be securely stored.</span>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">App Secret</label>
                                    <div class="input-group secret-wrap">
                                        <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                        <input type="password" name="app_secret" id="app_secret" class="form-control pe-5"
                                            placeholder="Enter App Secret" value="{{ $vcgc->app_secret ?? '' }}">
                                        <i class="bx bx-hide secret-toggle" data-target="app_secret"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">API Key</label>
                                    <div class="input-group secret-wrap">
                                        <span class="input-group-text"><i class="bx bx-key"></i></span>
                                        <input type="password" name="api_key" id="api_key" class="form-control pe-5"
                                            placeholder="Enter API Key" value="{{ $vcgc->api_key ?? '' }}">
                                        <i class="bx bx-hide secret-toggle" data-target="api_key"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">API Secret</label>
                                    <div class="input-group secret-wrap">
                                        <span class="input-group-text"><i class="bx bx-lock-open-alt"></i></span>
                                        <input type="password" name="api_secret" id="api_secret" class="form-control pe-5"
                                            placeholder="Enter API Secret" value="{{ $vcgc->api_secret ?? '' }}">
                                        <i class="bx bx-hide secret-toggle" data-target="api_secret"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Webhook Secret</label>
                                    <div class="input-group secret-wrap">
                                        <span class="input-group-text"><i class="bx bx-link-alt"></i></span>
                                        <input type="password" name="webhook_secret" id="webhook_secret"
                                            class="form-control pe-5" placeholder="Enter Webhook Secret"
                                            value="{{ $vcgc->webhook_secret ?? '' }}">
                                        <i class="bx bx-hide secret-toggle" data-target="webhook_secret"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-semibold d-flex justify-content-between">
                                        <span>Additional Config <span class="text-muted fw-normal">(JSON)</span></span>
                                        <small class="text-muted">e.g. {"region": "ap-south-1"}</small>
                                    </label>
                                    <textarea name="additional_config" class="form-control json-textarea" rows="5"
                                        placeholder='{"key": "value"}'>{{ $vcgc->additional_config ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4 pt-3" style="border-top:1px solid #e9ecef;">
                                <button type="button" class="btn-wizard-back" onclick="goToStep(1)">
                                    <i class="bx bx-left-arrow-alt me-1"></i> Back
                                </button>
                                <div class="d-flex gap-2">
                                    <button type="reset" class="btn-wizard-reset">
                                        <i class="bx bx-reset me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn-wizard-submit">
                                        <i class="bx bx-save me-1"></i>
                                        {{ $isEdit ? 'Update Gateway' : 'Save Gateway' }}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>{{-- /.wizard-card-body --}}
            </div>{{-- /.wizard-card --}}
        </div>{{-- /.container-fluid --}}
    </section>
@endsection

@push('scripts')
    <script>
        function goToStep(stepNum) {
            const currentPanel = document.querySelector('.wizard-panel.active');
            if (stepNum > parseInt(currentPanel.id.split('-')[1])) {
                const required = currentPanel.querySelectorAll('[required]');
                let valid = true;
                required.forEach(f => {
                    if (!f.value.trim()) { f.classList.add('is-invalid'); valid = false; }
                    else f.classList.remove('is-invalid');
                });
                if (!valid) {
                    if (typeof Swal !== 'undefined') Swal.fire({ icon: 'warning', title: 'Incomplete Step', text: 'Please fill in all required fields.', confirmButtonColor: '#2563eb' });
                    return;
                }
            }
            document.querySelectorAll('.wizard-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('step-' + stepNum).classList.add('active');
            document.querySelectorAll('.wizard-step').forEach((s, i) => {
                s.classList.remove('active', 'done');
                if (i + 1 < stepNum) s.classList.add('done');
                if (i + 1 === stepNum) s.classList.add('active');
            });
            document.querySelector('.wizard-banner').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        document.querySelectorAll('[required]').forEach(f => f.addEventListener('input', () => f.classList.remove('is-invalid')));

        document.querySelectorAll('.secret-toggle').forEach(function (icon) {
            icon.addEventListener('click', function () {
                const input = document.getElementById(this.dataset.target);
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                this.classList.toggle('bx-hide', !isHidden);
                this.classList.toggle('bx-show', isHidden);
            });
        });
    </script>
@endpush