@extends('layout')
@section('title','Manage Store - Easy Doctor')

@push('styles')
<style>
    /* ---- Wizard Stepper ---- */
    .page-header-title { font-size:1.35rem; font-weight:700; color:#111827; margin:0; }
    .wizard-card { background:#fff; border-radius:16px; border:1px solid #e5e7eb; box-shadow:0 4px 24px rgba(0,0,0,.07); overflow:hidden; }
    .wizard-banner { background:linear-gradient(135deg,#1d4ed8,#2563eb); padding:22px 32px; display:flex; align-items:center; gap:16px; }
    .wizard-banner-icon { width:46px; height:46px; background:rgba(255,255,255,.18); border-radius:13px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.4rem; flex-shrink:0; }
    .wizard-banner-title { color:#fff; font-size:1.05rem; font-weight:700; margin:0; }
    .wizard-banner-sub   { color:rgba(255,255,255,.8); font-size:.78rem; margin:2px 0 0; }
    .wizard-back-btn { width:36px; height:36px; background:rgba(255,255,255,.18); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; font-size:1rem; flex-shrink:0; transition:background .2s; margin-right:4px; }
    .wizard-back-btn:hover { background:rgba(255,255,255,.3); color:#fff; }
    .wizard-card-body { padding:28px 32px 32px; }
    .form-section-title { font-size:.8rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#6c757d; margin:8px 0 18px; padding-bottom:8px; border-bottom:1px solid #e9ecef; }
</style>
@endpush

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
        $isEdit = !empty($_GET['id']);
    @endphp

    <section class="task__section">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">{{ $isEdit ? 'Edit Store' : 'Add New Store' }}</h4>
                    <nav aria-label="breadcrumb" class="mt-1"><ol class="breadcrumb mb-0" style="font-size:.8rem;">
                        <li class="breadcrumb-item"><a href="/admin/dashboard" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/store-locations" class="text-decoration-none text-muted">Store Locations</a></li>
                        <li class="breadcrumb-item active text-muted">{{ $isEdit ? 'Edit Store' : 'Add Store' }}</li>
                    </ol></nav>
                </div>
            </div>
            <div class="wizard-card">
                <div class="wizard-banner">
                    <a href="/admin/store-locations" class="wizard-back-btn" title="Back"><i class="bx bx-arrow-back"></i></a>
                    <div class="wizard-banner-icon"><i class="bx bx-store-alt"></i></div>
                    <div>
                        <p class="wizard-banner-title">{{ $isEdit ? 'Edit Store' : 'Add New Store' }}</p>
                        <p class="wizard-banner-sub">Configure store information, contact details and operating hours</p>
                    </div>
                </div>
                <div class="wizard-card-body">
                {{-- Stepper --}}
                <div class="wizard-stepper">
                    <div class="wizard-step active" data-step="1"><div class="step-circle">1</div><div class="step-label">Store Info</div></div>
                    <div class="wizard-step" data-step="2"><div class="step-circle">2</div><div class="step-label">Contact &amp; Hours</div></div>
                </div>

                        <form action="{{ route('manageStore') }}" method="POST" id="storeWizardForm">
                            @csrf
                            <input type="hidden" name="LocationID" value="{{ $store->LocationID ?? '' }}">

                            {{-- ============================
                                 STEP 1: Store Information & Location
                                 ============================ --}}
                            <div class="wizard-panel active" id="step-1">
                                <div class="form-section-title"><i class="bx bx-store me-2"></i>Store Information</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Store Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-store"></i></span>
                                            <input type="text" name="LocationName" class="form-control"
                                                placeholder="Enter Store Name"
                                                value="{{ $store->LocationName ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Pharmacy <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-clinic"></i></span>
                                            <select name="PharmacyID" class="form-control" required>
                                                <option value="">Select Pharmacy</option>
                                                @foreach($pharmacyMasters as $pharmacy)
                                                    <option value="{{ $pharmacy->PharmacyID }}"
                                                        @if(isset($store->PharmacyID) && $store->PharmacyID == $pharmacy->PharmacyID) selected @endif>
                                                        {{ $pharmacy->PharmacyName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Address <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-home"></i></span>
                                            <input type="text" name="Address" class="form-control"
                                                placeholder="Enter Address"
                                                value="{{ $store->Address ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">City <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                            <input type="text" name="City" class="form-control"
                                                placeholder="Enter City"
                                                value="{{ $store->City ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">State <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-flag"></i></span>
                                            <input type="text" name="State" class="form-control"
                                                placeholder="Enter State"
                                                value="{{ $store->State ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Zip Code <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-map-pin"></i></span>
                                            <input type="text" name="ZipCode" class="form-control" maxlength="10"
                                                placeholder="Enter Zip Code"
                                                value="{{ $store->ZipCode ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Map Link</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bxs-map"></i></span>
                                            <input type="url" name="MapLink" class="form-control"
                                                placeholder="Enter Google Maps Link"
                                                value="{{ $store->MapLink ?? '' }}">
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
                                 STEP 2: Contact & Hours
                                 ============================ --}}
                            <div class="wizard-panel" id="step-2">
                                <div class="form-section-title"><i class="bx bx-phone me-2"></i>Contact Information</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Manager Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                                            <input type="text" name="ContactName" class="form-control"
                                                placeholder="Enter Manager Name"
                                                value="{{ $store->ContactName ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Designation</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                            <input type="text" name="Designation" class="form-control"
                                                placeholder="Enter Designation"
                                                value="{{ $store->Designation ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Contact Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                            <input type="email" name="ContactEmail" class="form-control"
                                                placeholder="Enter Contact Email"
                                                value="{{ $store->ContactEmail ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                            <input type="text" name="PhoneNumber" class="form-control phone" maxlength="12"
                                                placeholder="Enter Phone Number"
                                                value="{{ $store->PhoneNumber ?? '' }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-title mt-4"><i class="bx bx-time me-2"></i>Hours &amp; Details</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Opening Time</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-time"></i></span>
                                            <input type="time" name="HoursOfOperation[]" class="form-control"
                                                value="{{ $store->HoursOfOperation[0] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Closing Time</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-time"></i></span>
                                            <input type="time" name="HoursOfOperation[]" class="form-control"
                                                value="{{ $store->HoursOfOperation[1] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Square Footage</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-ruler"></i></span>
                                            <input type="text" name="SquareFootage" class="form-control"
                                                placeholder="Enter Square Footage"
                                                value="{{ $store->SquareFootage ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Accessibility Features</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-accessibility"></i></span>
                                            <textarea name="AccessibilityFeatures" class="form-control" rows="1"
                                                placeholder="e.g. Wheelchair ramp, Elevator access">{{ $store->AccessibilityFeatures ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn-wizard-back" onclick="goToStep(1)">
                                        <i class="bx bx-left-arrow-alt me-1"></i> Back
                                    </button>
                                    <button type="submit" id="submitButton" class="btn-wizard-submit">
                                        <i class="bx bx-check me-1"></i> {{ $isEdit ? 'Update Store' : 'Save Store' }}
                                    </button>
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
            required.forEach(f => { if (!f.value.trim()) { f.classList.add('is-invalid'); valid = false; } else { f.classList.remove('is-invalid'); } });
            if (!valid) return;
        }
        document.querySelectorAll('.wizard-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('step-' + stepNum).classList.add('active');
        document.querySelectorAll('.wizard-step').forEach((s, i) => {
            s.classList.remove('active','done');
            if (i + 1 < stepNum) s.classList.add('done');
            if (i + 1 === stepNum) s.classList.add('active');
        });
        document.querySelector('.wizard-banner').scrollIntoView({ behavior:'smooth', block:'start' });
    }
    document.querySelectorAll('[required]').forEach(f => f.addEventListener('input', () => f.classList.remove('is-invalid')));
</script>
@endpush