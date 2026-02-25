@extends('layout')
@section('title', 'Manage Payment Gateway - Easy Doctor')

@push('styles')
<style>
    /* ---- Wizard Stepper ---- */
    .wizard-stepper { display:flex; align-items:center; justify-content:center; background:#f8f9fa; border-radius:12px; padding:20px 30px; margin-bottom:28px; }
    .wizard-step { display:flex; flex-direction:column; align-items:center; flex:1; position:relative; }
    .wizard-step:not(:last-child)::after { content:''; position:absolute; top:18px; left:calc(50% + 22px); width:calc(100% - 44px); height:2px; background:#dee2e6; z-index:0; transition:background .3s; }
    .wizard-step.active:not(:last-child)::after, .wizard-step.done:not(:last-child)::after { background:#2563eb; }
    .step-circle { width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.9rem; border:2px solid #dee2e6; background:#fff; color:#adb5bd; z-index:1; transition:all .25s; }
    .wizard-step.active .step-circle { background:#2563eb; border-color:#2563eb; color:#fff; box-shadow:0 4px 12px rgba(37,99,235,.35); }
    .wizard-step.done .step-circle { background:#2563eb; border-color:#2563eb; color:#fff; }
    .step-label { font-size:.7rem; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#adb5bd; margin-top:8px; }
    .wizard-step.active .step-label, .wizard-step.done .step-label { color:#2563eb; }
    .wizard-panel { display:none; }
    .wizard-panel.active { display:block; }

    /* ---- Card ---- */
    .wizard-card { background:#fff; border-radius:16px; border:1px solid #e5e7eb; box-shadow:0 4px 24px rgba(0,0,0,.07); padding:30px 36px; }
    .wizard-page-header { display:flex; align-items:center; gap:12px; margin-bottom:24px; }
    .wizard-back-btn { width:36px; height:36px; background:#2563eb; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; font-size:1rem; flex-shrink:0; transition:background .2s; }
    .wizard-back-btn:hover { background:#1d4ed8; color:#fff; }
    .wizard-page-header h5 { margin:0; font-weight:700; font-size:1.15rem; color:#111827; }
    .form-section-title { font-size:.8rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#6c757d; margin:8px 0 18px; padding-bottom:8px; border-bottom:1px solid #e9ecef; }

    /* ---- Inputs ---- */
    .input-group-text { background:#f0f4ff; border-right:none; color:#2563eb; min-width:42px; justify-content:center; }
    .input-group .form-control, .input-group .form-select { border-left:none; background:#f8f9fb; }
    .input-group .form-control:focus, .input-group .form-select:focus { border-color:#2563eb; box-shadow:none; background:#fff; }

    /* ---- Secret field toggle ---- */
    .secret-wrap { position:relative; }
    .secret-toggle { position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#9ca3af; font-size:1.1rem; z-index:10; transition:color .2s; }
    .secret-toggle:hover { color:#2563eb; }

    /* ---- JSON textarea ---- */
    .json-textarea { font-family:'Courier New', monospace; font-size:.83rem; background:#1e293b; color:#7dd3fc; border-radius:10px; border:none; padding:14px; resize:vertical; min-height:120px; }
    .json-textarea:focus { box-shadow:0 0 0 2px rgba(37,99,235,.3); outline:none; }
    .json-label { display:flex; align-items:center; justify-content:space-between; }

    /* ---- Environment selector ---- */
    .env-sandbox { color:#854d0e; font-weight:600; }
    .env-production { color:#dc2626; font-weight:600; }

    /* ---- Buttons ---- */
    .btn-wizard-next, .btn-wizard-submit { background:linear-gradient(135deg,#1d4ed8,#2563eb); color:#fff; border:none; border-radius:50px; padding:10px 32px; font-weight:600; font-size:.92rem; box-shadow:0 4px 14px rgba(37,99,235,.3); transition:all .2s; cursor:pointer; }
    .btn-wizard-next:hover, .btn-wizard-submit:hover { background:linear-gradient(135deg,#1e40af,#1d4ed8); box-shadow:0 6px 20px rgba(37,99,235,.4); transform:translateY(-1px); color:#fff; }
    .btn-wizard-back { background:#fff; color:#374151; border:1.5px solid #d1d5db; border-radius:50px; padding:10px 28px; font-weight:600; font-size:.92rem; transition:all .2s; cursor:pointer; }
    .btn-wizard-back:hover { background:#f3f4f6; border-color:#9ca3af; }
    .btn-wizard-reset { background:#fff; color:#374151; border:1.5px solid #d1d5db; border-radius:50px; padding:10px 24px; font-weight:600; font-size:.92rem; transition:all .2s; }
    .btn-wizard-reset:hover { background:#f3f4f6; }

    /* ---- Security note ---- */
    .security-note { background:#fffbeb; border:1px solid #fde68a; border-radius:10px; padding:12px 16px; font-size:.8rem; color:#92400e; display:flex; align-items:flex-start; gap:10px; }
    .security-note i { font-size:1.1rem; flex-shrink:0; margin-top:1px; }
</style>
@endpush

@section('content')
    @php
        $roles     = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
        $isEdit    = !empty($_GET['id']);
    @endphp

    <section class="task__section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-10 col-sm-12 offset-lg-2 offset-md-1 my-4 p-0">

                    {{-- Page Header --}}
                    <div class="wizard-page-header">
                        <a href="/admin/payment-gateway-configs" class="wizard-back-btn" title="Back">
                            <i class="bx bx-chevron-left"></i>
                        </a>
                        <h5>{{ $isEdit ? 'Edit Payment Gateway' : 'Add New Payment Gateway' }}</h5>
                    </div>

                    <div class="wizard-card">

                        {{-- Stepper --}}
                        <div class="wizard-stepper">
                            <div class="wizard-step active" data-step="1">
                                <div class="step-circle">1</div>
                                <div class="step-label">Gateway Identity</div>
                            </div>
                            <div class="wizard-step" data-step="2">
                                <div class="step-circle">2</div>
                                <div class="step-label">API Credentials</div>
                            </div>
                        </div>

                        <form action="/admin/manage-payment-gateway-config" method="POST" enctype="multipart/form-data" id="pgcForm">
                            @csrf
                            <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}">

                            {{-- ============================
                                 STEP 1: Gateway Identity
                                 ============================ --}}
                            <div class="wizard-panel active" id="step-1">
                                <div class="form-section-title"><i class="bx bx-credit-card me-2"></i>Gateway Information</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Gateway Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-globe"></i></span>
                                            <input type="text" name="gateway_name" class="form-control"
                                                placeholder="e.g. Stripe, Razorpay, PayPal"
                                                value="{{ $pgc->gateway_name ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Merchant ID <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-barcode"></i></span>
                                            <input type="text" name="merchant_id" class="form-control"
                                                placeholder="Enter Merchant ID"
                                                value="{{ $pgc->merchant_id ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Environment <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-server"></i></span>
                                            <select name="environment" class="form-select" required>
                                                <option value="">-- Select Environment --</option>
                                                <option value="sandbox" {{ (isset($pgc->environment) && $pgc->environment == 'sandbox') ? 'selected' : '' }}>
                                                    🟡 Sandbox (Testing)
                                                </option>
                                                <option value="production" {{ (isset($pgc->environment) && $pgc->environment == 'production') ? 'selected' : '' }}>
                                                    🔴 Production (Live)
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Status <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-check-circle"></i></span>
                                            <select name="is_active" class="form-select" required>
                                                <option value="1" {{ (isset($pgc->is_active) && $pgc->is_active == 1) ? 'selected' : '' }}>✅ Active</option>
                                                <option value="0" {{ (isset($pgc->is_active) && $pgc->is_active == 0) ? 'selected' : '' }}>⛔ Inactive</option>
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
                                    <span>API keys and secrets are sensitive. Ensure you are copying these from your gateway dashboard directly. They will be securely stored.</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold">API Key <span class="text-danger">*</span></label>
                                        <div class="input-group secret-wrap">
                                            <span class="input-group-text"><i class="bx bx-key"></i></span>
                                            <input type="password" name="api_key" id="api_key" class="form-control pe-5"
                                                placeholder="Enter API Key"
                                                value="{{ $pgc->api_key ?? '' }}" required>
                                            <i class="bx bx-hide secret-toggle" data-target="api_key"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold">API Secret <span class="text-danger">*</span></label>
                                        <div class="input-group secret-wrap">
                                            <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                            <input type="password" name="api_secret" id="api_secret" class="form-control pe-5"
                                                placeholder="Enter API Secret"
                                                value="{{ $pgc->api_secret ?? '' }}" required>
                                            <i class="bx bx-hide secret-toggle" data-target="api_secret"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold">Webhook Secret
                                            <span class="text-muted fw-normal">(optional)</span>
                                        </label>
                                        <div class="input-group secret-wrap">
                                            <span class="input-group-text"><i class="bx bx-link-alt"></i></span>
                                            <input type="password" name="webhook_secret" id="webhook_secret" class="form-control pe-5"
                                                placeholder="Enter Webhook Secret"
                                                value="{{ $pgc->webhook_secret ?? '' }}">
                                            <i class="bx bx-hide secret-toggle" data-target="webhook_secret"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold json-label">
                                            <span>Additional Config <span class="text-muted fw-normal">(JSON)</span></span>
                                            <small class="text-muted">e.g. {"currency": "INR"}</small>
                                        </label>
                                        <textarea name="additional_config" class="form-control json-textarea" rows="5"
                                            placeholder='{"key": "value"}'>{{ $pgc->additional_config ?? '{}' }}</textarea>
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
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    /* ---- Wizard Navigation ---- */
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
                if (typeof Swal !== 'undefined') Swal.fire({ icon:'warning', title:'Incomplete Step', text:'Please fill in all required fields.', confirmButtonColor:'#2563eb' });
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
        document.querySelector('.wizard-card').scrollIntoView({ behavior:'smooth', block:'start' });
    }
    document.querySelectorAll('[required]').forEach(f => f.addEventListener('input', () => f.classList.remove('is-invalid')));

    /* ---- Secret field visibility toggle ---- */
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
