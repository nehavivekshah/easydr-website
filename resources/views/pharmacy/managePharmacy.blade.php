@extends('layout')
@section('title','Manage Pharmacy - Easy Doctor')

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
        gap: 0;
    }
    .wizard-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
        cursor: pointer;
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
        font-size: 0.9rem;
        border: 2px solid #dee2e6;
        background: #fff;
        color: #adb5bd;
        z-index: 1;
        transition: all 0.25s;
    }
    .wizard-step.active .step-circle {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
        box-shadow: 0 4px 12px rgba(37,99,235,.35);
    }
    .wizard-step.done .step-circle {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }
    .step-label {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #adb5bd;
        margin-top: 8px;
    }
    .wizard-step.active .step-label,
    .wizard-step.done .step-label {
        color: #2563eb;
    }

    /* ---- Form Panel ---- */
    .wizard-panel { display: none; }
    .wizard-panel.active { display: block; }

    /* ---- Section Header ---- */
    .form-section-title {
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #6c757d;
        margin: 8px 0 18px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e9ecef;
    }

    /* ---- Input Group ---- */
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

    /* ---- Buttons ---- */
    .btn-wizard-next, .btn-wizard-submit {
        background: linear-gradient(135deg, #1d4ed8, #2563eb);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 10px 32px;
        font-weight: 600;
        font-size: 0.92rem;
        letter-spacing: 0.02em;
        box-shadow: 0 4px 14px rgba(37,99,235,.3);
        transition: all 0.2s;
    }
    .btn-wizard-next:hover, .btn-wizard-submit:hover {
        background: linear-gradient(135deg, #1e40af, #1d4ed8);
        box-shadow: 0 6px 20px rgba(37,99,235,.4);
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
        font-size: 0.92rem;
        transition: all 0.2s;
    }
    .btn-wizard-back:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }

    /* ---- Card ---- */
    .page-header-title { font-size:1.35rem; font-weight:700; color:#111827; margin:0; }
    .wizard-card { background:#fff; border-radius:16px; border:1px solid #e5e7eb; box-shadow:0 4px 24px rgba(0,0,0,.07); overflow:hidden; }
    .wizard-banner { background:linear-gradient(135deg,#1d4ed8,#2563eb); padding:22px 32px; display:flex; align-items:center; gap:16px; }
    .wizard-banner-icon { width:46px; height:46px; background:rgba(255,255,255,.18); border-radius:13px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.4rem; flex-shrink:0; }
    .wizard-banner-title { color:#fff; font-size:1.05rem; font-weight:700; margin:0; }
    .wizard-banner-sub   { color:rgba(255,255,255,.8); font-size:.78rem; margin:2px 0 0; }
    .wizard-back-btn { width:36px; height:36px; background:rgba(255,255,255,.18); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; font-size:1rem; flex-shrink:0; transition:background .2s; margin-right:4px; }
    .wizard-back-btn:hover { background:rgba(255,255,255,.3); color:#fff; }
    .wizard-card-body { padding:28px 32px 32px; }
</style>
@endpush

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
        $HoursOfOperation = $pharmacyMaster->HoursOfOperation ?? [];
        $TaxID = $pharmacyMaster->TaxID ?? [];
        $isEdit = !empty($pharmacyMaster);
    @endphp

    <section class="task__section">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">{{ $isEdit ? 'Edit Pharmacy' : 'Add New Pharmacy' }}</h4>
                    <nav aria-label="breadcrumb" class="mt-1"><ol class="breadcrumb mb-0" style="font-size:.8rem;">
                        <li class="breadcrumb-item"><a href="/admin/dashboard" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/pharmacy" class="text-decoration-none text-muted">Pharmacy</a></li>
                        <li class="breadcrumb-item active text-muted">{{ $isEdit ? 'Edit Pharmacy' : 'Add Pharmacy' }}</li>
                    </ol></nav>
                </div>
            </div>
            <div class="wizard-card">
                <div class="wizard-banner">
                    <a href="/admin/pharmacy" class="wizard-back-btn" title="Back"><i class="bx bx-arrow-back"></i></a>
                    <div class="wizard-banner-icon"><i class="bx bx-store"></i></div>
                    <div>
                        <p class="wizard-banner-title">{{ $isEdit ? 'Edit Pharmacy' : 'Add New Pharmacy' }}</p>
                        <p class="wizard-banner-sub">Configure pharmacy info, contact details, licensing &amp; payment across 3 steps</p>
                    </div>
                </div>
                <div class="wizard-card-body">

                        {{-- Stepper --}}
                        <div class="wizard-stepper">
                            <div class="wizard-step active" data-step="1">
                                <div class="step-circle">1</div>
                                <div class="step-label">Pharmacy Info</div>
                            </div>
                            <div class="wizard-step" data-step="2">
                                <div class="step-circle">2</div>
                                <div class="step-label">Contact &amp; Location</div>
                            </div>
                            <div class="wizard-step" data-step="3">
                                <div class="step-circle">3</div>
                                <div class="step-label">Licensing &amp; Payment</div>
                            </div>
                        </div>

                        <form action="{{ route('managePharmacy') }}" method="POST" id="pharmacyWizardForm">
                            @csrf
                            <input type="hidden" name="PharmacyID" value="{{ $pharmacyMaster->PharmacyID ?? '' }}">

                            {{-- ============================
                                 STEP 1: Pharmacy Information
                                 ============================ --}}
                            <div class="wizard-panel active" id="step-1">
                                <div class="form-section-title"><i class="bx bx-store me-2"></i>Pharmacy Information</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Pharmacy Code <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-code-alt"></i></span>
                                            <input type="text" name="PharmacyCode" class="form-control" maxlength="20"
                                                placeholder="Enter Pharmacy Code"
                                                value="{{ $pharmacyMaster->PharmacyCode ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Pharmacy Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-store"></i></span>
                                            <input type="text" name="PharmacyName" class="form-control"
                                                placeholder="Enter Pharmacy Name"
                                                value="{{ $pharmacyMaster->PharmacyName ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Pharmacy Type <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-category"></i></span>
                                            <select name="PharmacyType" class="form-control" required>
                                                @foreach($pharmacy_types as $pharmacy_type)
                                                    <option value="{{ $pharmacy_type->title }}"
                                                        @if($pharmacy_type->title == ($pharmacyMaster->PharmacyType ?? '')) selected @endif>
                                                        {{ $pharmacy_type->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Ownership Type</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-copyright"></i></span>
                                            <input type="text" name="OwnershipType" class="form-control"
                                                placeholder="Enter Ownership Type"
                                                value="{{ $pharmacyMaster->OwnershipType ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Start Time</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-time"></i></span>
                                            <input type="time" name="HoursOfOperation[]" class="form-control"
                                                value="{{ $HoursOfOperation[0] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">End Time</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-time"></i></span>
                                            <input type="time" name="HoursOfOperation[]" class="form-control"
                                                value="{{ $HoursOfOperation[1] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Emergency Services</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-alarm-exclamation"></i></span>
                                            <select name="EmergencyServices" class="form-control">
                                                <option value="1" @if(isset($pharmacyMaster->EmergencyServices) && $pharmacyMaster->EmergencyServices == 1) selected @endif>Yes</option>
                                                <option value="0" @if(isset($pharmacyMaster->EmergencyServices) && $pharmacyMaster->EmergencyServices == 0) selected @endif>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Services Offered</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-list-check"></i></span>
                                            <textarea name="ServicesOffered" class="form-control" rows="1"
                                                placeholder="Enter Services Offered">{{ $pharmacyMaster->ServicesOffered ?? '' }}</textarea>
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
                                 STEP 2: Contact & Location
                                 ============================ --}}
                            <div class="wizard-panel" id="step-2">
                                <div class="form-section-title"><i class="bx bx-phone me-2"></i>Contact Details</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Primary Contact Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                                            <input type="text" name="PrimaryContactName" class="form-control"
                                                placeholder="Enter Primary Contact Name"
                                                value="{{ $pharmacyMaster->PrimaryContactName ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Designation</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                            <input type="text" name="Designation" class="form-control"
                                                placeholder="Enter Designation"
                                                value="{{ $pharmacyMaster->Designation ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                            <input type="text" name="PhoneNumber" class="form-control"
                                                placeholder="Enter Phone Number"
                                                value="{{ $pharmacyMaster->PhoneNumber ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Mobile Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-mobile-alt"></i></span>
                                            <input type="text" name="MobileNumber" class="form-control"
                                                placeholder="Enter Mobile Number"
                                                value="{{ $pharmacyMaster->MobileNumber ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Fax Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-printer"></i></span>
                                            <input type="text" name="FaxNumber" class="form-control"
                                                placeholder="Enter Fax Number"
                                                value="{{ $pharmacyMaster->FaxNumber ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Email Address <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                            <input type="email" name="EmailAddress" class="form-control"
                                                placeholder="Enter Email Address"
                                                value="{{ $pharmacyMaster->EmailAddress ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Website URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-world"></i></span>
                                            <input type="url" name="WebsiteURL" class="form-control"
                                                placeholder="Enter Website URL"
                                                value="{{ $pharmacyMaster->WebsiteURL ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-title mt-4"><i class="bx bx-map-pin me-2"></i>Head Office Location</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Address <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-home"></i></span>
                                            <input type="text" name="Address" class="form-control"
                                                placeholder="Enter Address"
                                                value="{{ $pharmacyMaster->Address ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">City <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                            <input type="text" name="City" class="form-control"
                                                placeholder="Enter City"
                                                value="{{ $pharmacyMaster->City ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">State <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-flag"></i></span>
                                            <input type="text" name="State" class="form-control"
                                                placeholder="Enter State"
                                                value="{{ $pharmacyMaster->State ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Zip Code <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-map-pin"></i></span>
                                            <input type="text" name="ZipCode" class="form-control"
                                                placeholder="Enter Zip Code"
                                                value="{{ $pharmacyMaster->ZipCode ?? '' }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn-wizard-back" onclick="goToStep(1)">
                                        <i class="bx bx-left-arrow-alt me-1"></i> Back
                                    </button>
                                    <button type="button" class="btn-wizard-next" onclick="goToStep(3)">
                                        Next <i class="bx bx-right-arrow-alt ms-1"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- ============================
                                 STEP 3: Licensing & Payment
                                 ============================ --}}
                            <div class="wizard-panel" id="step-3">
                                <div class="form-section-title"><i class="bx bx-key me-2"></i>Licensing Details</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">NPI</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                                            <input type="text" name="NPI" class="form-control"
                                                placeholder="Enter NPI"
                                                value="{{ $pharmacyMaster->NPI ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">DEA Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-shield-alt-2"></i></span>
                                            <input type="text" name="DEANumber" class="form-control"
                                                placeholder="Enter DEA Number"
                                                value="{{ $pharmacyMaster->DEANumber ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">License Number <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-key"></i></span>
                                            <input type="text" name="LicenseNumber" class="form-control"
                                                placeholder="Enter License Number"
                                                value="{{ $pharmacyMaster->LicenseNumber ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">License Expiration Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input type="date" name="LicenseExpirationDate" class="form-control"
                                                value="{{ $pharmacyMaster->LicenseExpirationDate ?? '' }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-title mt-4"><i class="bx bxs-bank me-2"></i>Payment Details</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Bank Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bxs-bank"></i></span>
                                            <input type="text" name="BankName" class="form-control"
                                                placeholder="Enter Bank Name"
                                                value="{{ $pharmacyMaster->bankname ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Bank Branch</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-git-branch"></i></span>
                                            <input type="text" name="BranchName" class="form-control"
                                                placeholder="Enter Bank Branch Name/Location"
                                                value="{{ $pharmacyMaster->branchname ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Account Type</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-list-ul"></i></span>
                                            <select name="AccountType" class="form-control">
                                                <option value="" @if(empty($pharmacyMaster->account_type)) selected @endif>Select Type</option>
                                                <option value="Savings" @if(($pharmacyMaster->account_type ?? '') == 'Savings') selected @endif>Savings</option>
                                                <option value="Checking" @if(($pharmacyMaster->account_type ?? '') == 'Checking') selected @endif>Checking / Current</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Account Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-hash"></i></span>
                                            <input type="text" name="AccountNumber" class="form-control"
                                                placeholder="Enter Account Number"
                                                value="{{ $pharmacyMaster->account_number ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Account Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user-check"></i></span>
                                            <input type="text" name="AccountName" class="form-control"
                                                placeholder="Enter Name Associated with Account"
                                                value="{{ $pharmacyMaster->account_name ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Bank / Account Code</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-barcode-reader"></i></span>
                                            <input type="text" name="AccountCode" class="form-control"
                                                placeholder="e.g., IFSC, SWIFT, Sort Code"
                                                value="{{ $pharmacyMaster->ifsccode ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Account Status</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-toggle-right"></i></span>
                                            <select name="AccountStatus" class="form-control">
                                                <option value="" @if(empty($pharmacyMaster->status)) selected @endif>Select Status</option>
                                                <option value="1" @if(($pharmacyMaster->status ?? '') == '1') selected @endif>Active</option>
                                                <option value="0" @if(($pharmacyMaster->status ?? '') == '0') selected @endif>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-title mt-4"><i class="bx bx-calculator me-2"></i>Tax Codes</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Tax Code 1</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calculator"></i></span>
                                            <input type="text" name="TaxID[]" class="form-control"
                                                placeholder="Enter Tax ID"
                                                value="{{ $TaxID[0] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Tax Code 2</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calculator"></i></span>
                                            <input type="text" name="TaxID[]" class="form-control"
                                                placeholder="Enter Tax ID"
                                                value="{{ $TaxID[1] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Tax Code 3</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calculator"></i></span>
                                            <input type="text" name="TaxID[]" class="form-control"
                                                placeholder="Enter Tax ID"
                                                value="{{ $TaxID[2] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Tax Code 4</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calculator"></i></span>
                                            <input type="text" name="TaxID[]" class="form-control"
                                                placeholder="Enter Tax ID"
                                                value="{{ $TaxID[3] ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn-wizard-back" onclick="goToStep(2)">
                                        <i class="bx bx-left-arrow-alt me-1"></i> Back
                                    </button>
                                    <button type="submit" id="submitButton" class="btn-wizard-submit">
                                        <i class="bx bx-check me-1"></i> {{ $isEdit ? 'Update Pharmacy' : 'Save Pharmacy' }}
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
        const totalSteps = 3;

        // Validate required fields in current step before going forward
        const panels = document.querySelectorAll('.wizard-panel');
        const currentPanel = document.querySelector('.wizard-panel.active');

        if (stepNum > parseInt(currentPanel.id.split('-')[1])) {
            // Going forward — validate required fields in current panel
            const requiredFields = currentPanel.querySelectorAll('[required]');
            let valid = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    valid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            if (!valid) {
                // Shake the Next button
                const nextBtn = currentPanel.querySelector('.btn-wizard-next');
                if (nextBtn) {
                    nextBtn.style.transform = 'translateX(4px)';
                    setTimeout(() => nextBtn.style.transform = '', 200);
                }
                return;
            }
        }

        // Hide all panels
        panels.forEach(p => p.classList.remove('active'));

        // Show target panel
        document.getElementById('step-' + stepNum).classList.add('active');

        // Update stepper UI
        const steps = document.querySelectorAll('.wizard-step');
        steps.forEach((step, idx) => {
            const num = idx + 1;
            step.classList.remove('active', 'done');
            if (num < stepNum) step.classList.add('done');
            if (num === stepNum) step.classList.add('active');
        });

        // Smooth scroll to top of wizard
        document.querySelector('.wizard-banner').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Remove is-invalid on input
    document.querySelectorAll('[required]').forEach(field => {
        field.addEventListener('input', () => field.classList.remove('is-invalid'));
    });
</script>
@endpush
