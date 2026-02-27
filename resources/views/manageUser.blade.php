@extends('layout')

@php
    $pagename = explode('-', $type);
    $isProfile = Request::segment(2) == 'my-profile';
    $isPatient = Request::segment(3) == 'patient-directory';
    $isDoctor = Request::segment(3) == 'doctor-directory';
@endphp

@section('title', "Manage " . ucfirst($pagename[0] ?? 'User') . " - Easy Doctor")

@push('styles')
    <style>
        /* ---- Page header ---- */
        .page-header-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        /* ---- Wizard Card ---- */
        .wizard-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
            overflow: hidden;
        }

        /* ---- Gradient banner header ---- */
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

        /* ---- Card body padding ---- */
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

        /* ---- Stepper ---- */
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

        /* ---- Steps show/hide ---- */
        .form-step {
            display: none;
        }

        .form-step-active {
            display: block !important;
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

        label.form-label,
        .form-group label {
            font-weight: 600;
            color: #374151;
            font-size: .875rem;
            margin-bottom: .4rem;
            display: block;
        }

        /* ---- Media preview ---- */
        .media-icon {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            margin-right: 6px;
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
    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">
                        @if($isProfile) Profile Settings
                        @elseif(!empty($id)) Edit {{ ucfirst($pagename[0] ?? 'User') }}
                        @else Add New {{ ucfirst($pagename[0] ?? 'User') }}
                        @endif
                    </h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            @if(!$isProfile)
                                <li class="breadcrumb-item"><a href="/admin/users/{{ $type ?? '' }}"
                                        class="text-decoration-none text-muted">{{ ucwords(str_replace('-', ' ', $type ?? 'Users')) }}</a>
                                </li>
                            @endif
                            <li class="breadcrumb-item active text-muted">
                                @if($isProfile) Profile Settings
                                @elseif(!empty($id)) Edit
                                @else Add New
                                @endif
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="wizard-card">

                {{-- Gradient Banner --}}
                <div class="wizard-banner">
                    @if(!$isProfile)
                        <a href="/admin/users/{{ $type ?? '' }}" class="wizard-back-btn" title="Back">
                            <i class="bx bx-arrow-back"></i>
                        </a>
                    @endif
                    <div class="wizard-banner-icon">
                        @if($isProfile) <i class="bx bx-cog"></i>
                        @elseif($isDoctor) <i class="bx bx-plus-medical"></i>
                        @elseif($isPatient) <i class="bx bx-user-pin"></i>
                        @else <i class="bx bx-user-circle"></i>
                        @endif
                    </div>
                    <div>
                        <p class="wizard-banner-title">
                            @if($isProfile) Profile Settings
                            @elseif(!empty($id)) Edit {{ ucfirst($pagename[0] ?? 'User') }}
                            @else Add New {{ ucfirst($pagename[0] ?? 'User') }}
                            @endif
                        </p>
                        <p class="wizard-banner-sub">
                            @if($isProfile) Update your personal account details
                            @elseif(!empty($id)) Update the {{ strtolower($pagename[0] ?? 'user') }}'s information across 3
                                steps
                            @else Fill in the details across 3 steps to create the account
                            @endif
                        </p>
                    </div>
                </div>

                <div class="wizard-card-body">
                    {{-- Stepper --}}
                    <div class="wizard-stepper">
                        <div class="wizard-step active" id="ind-1">
                            <div class="step-circle">1</div>
                            <div class="step-label">Account Info</div>
                        </div>
                        <div class="wizard-step" id="ind-2">
                            <div class="step-circle">2</div>
                            <div class="step-label">Personal Info</div>
                        </div>
                        <div class="wizard-step" id="ind-3">
                            <div class="step-circle">3</div>
                            <div class="step-label">Location &amp; Role</div>
                        </div>
                    </div>

                    <form id="multiStepForm" action="{{ $isProfile ? '/admin/my-profile' : '/admin/manage-user' }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pagetype" value="{{ $type ?? '' }}">
                        <input type="hidden" name="id" value="{{ $id ?? '' }}">

                        {{-- ============================
                        STEP 1: Account Info
                        ============================ --}}
                        <div class="form-step form-step-active" id="step-1">
                            <div class="form-section-title"><i class="bx bx-user-circle me-2"></i>Account Information</div>
                            <div class="row g-3">
                                <div class="col-md-4 form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ trim(($users->first_name ?? '') . ' ' . ($users->last_name ?? '')) }}"
                                            placeholder="Enter Full Name" required>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Email Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                        <input type="email" class="form-control" name="email"
                                            placeholder="Enter Email Address" value="{{ $users->email ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Mobile No. <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                        <input type="text" class="form-control" name="mob" placeholder="Enter Mobile No."
                                            value="{{ $users->mobile ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Alternative Mobile No.</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-phone-call"></i></span>
                                        <input type="text" class="form-control" name="mob2"
                                            placeholder="Enter Alternative Mobile No."
                                            value="{{ $users->altr_mobile ?? '' }}">
                                    </div>
                                </div>
                                @if(!$isProfile)
                                    <div class="col-md-4 form-group">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-lock"></i></span>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Enter Password (leave blank to keep)">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn-wizard-next next-step">
                                    Next <i class="bx bx-right-arrow-alt ms-1"></i>
                                </button>
                            </div>
                        </div>

                        {{-- ============================
                        STEP 2: Personal Info
                        ============================ --}}
                        <div class="form-step" id="step-2">
                            <div class="form-section-title"><i class="bx bx-id-card me-2"></i>Personal Information</div>
                            <div class="row g-3">
                                <div class="col-md-4 form-group">
                                    <label>Profile Photo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-upload"></i></span>
                                        @if(!empty($users->photo))
                                            <img src="/public/assets/images/profiles/{{ $users->photo }}" class="media-icon">
                                        @endif
                                        <input type="file" class="form-control" name="profile_photo"
                                            accept="image/jpg,image/jpeg,image/png">
                                    </div>
                                    <small class="text-muted">Jpg, Jpeg, Png only</small>
                                </div>

                                @if($isPatient)
                                    <div class="col-md-4 form-group">
                                        <label>Date of Birth</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input type="date" class="form-control" name="dob" value="{{ $users->dob ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Gender</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-male-female"></i></span>
                                            <select class="form-control" name="gender">
                                                <option value="1" @if(($users->gender ?? '') == '1') selected @endif>Male</option>
                                                <option value="2" @if(($users->gender ?? '') == '2') selected @endif>Female
                                                </option>
                                                <option value="3" @if(($users->gender ?? '') == '3') selected @endif>Other
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Blood Group</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-droplet"></i></span>
                                            <input type="text" class="form-control" name="bloodgroup" placeholder="e.g. A+"
                                                value="{{ $users->blood_group ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Marital Status</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-heart"></i></span>
                                            <select class="form-control" name="marital_status">
                                                <option value="1" @if(($users->marital_status ?? '') == '1') selected @endif>
                                                    Single
                                                </option>
                                                <option value="2" @if(($users->marital_status ?? '') == '2') selected @endif>
                                                    Married
                                                </option>
                                                <option value="3" @if(($users->marital_status ?? '') == '3') selected @endif>
                                                    Divorced
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Height (Inch)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-ruler"></i></span>
                                            <input type="text" class="form-control" name="height" placeholder="e.g. 68"
                                                value="{{ $users->height ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Weight (Kg)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-bar-chart-alt-2"></i></span>
                                            <input type="text" class="form-control" name="weight" placeholder="e.g. 72"
                                                value="{{ $users->weight ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Health Card No.</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                                            <input type="text" class="form-control" name="health_card"
                                                placeholder="Enter Health Card No." value="{{ $users->health_card ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Health Card (Image)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-upload"></i></span>
                                            @if(!empty($users->health_card_file))
                                                <img src="/public/assets/images/healthCards/{{ $users->health_card_file }}"
                                                    class="media-icon">
                                            @endif
                                            <input type="file" class="form-control" name="health_card_file" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Medical File (Image)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-upload"></i></span>
                                            @if(!empty($users->medical_file))
                                                <img src="/public/assets/images/medicals/{{ $users->medical_file }}"
                                                    class="media-icon">
                                            @endif
                                            <input type="file" class="form-control" name="medical_file" accept="image/*">
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-4 form-group">
                                    <label>Aadhaar Card No.</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                                        <input type="text" class="form-control" name="adhar" placeholder="Enter Aadhaar No."
                                            value="{{ $users->adhar ?? '' }}" maxlength="12">
                                    </div>
                                </div>

                                @if($isDoctor)
                                    <div class="col-md-4 form-group">
                                        <label>Specialization <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-briefcase-alt-2"></i></span>
                                            <input type="text" class="form-control" name="specialization"
                                                placeholder="e.g. Cardiologist" value="{{ $users->specialist ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Education <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-book"></i></span>
                                            <input type="text" class="form-control" name="education" placeholder="e.g. MBBS, MD"
                                                value="{{ $users->education ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Medical License No. <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-certification"></i></span>
                                            <input type="text" class="form-control" name="license"
                                                placeholder="Enter License No." value="{{ $users->license ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>About</label>
                                        <textarea class="form-control border" name="about"
                                            placeholder="Short bio or professional summary..." rows="3"
                                            style="border-radius:.375rem;">{{ $users->about ?? '' }}</textarea>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn-wizard-back prev-step">
                                    <i class="bx bx-left-arrow-alt me-1"></i> Back
                                </button>
                                <button type="button" class="btn-wizard-next next-step">
                                    Next <i class="bx bx-right-arrow-alt ms-1"></i>
                                </button>
                            </div>
                        </div>

                        {{-- ============================
                        STEP 3: Location & Role
                        ============================ --}}
                        <div class="form-step" id="step-3">
                            <div class="form-section-title"><i class="bx bx-map-alt me-2"></i>Location Details</div>
                            <div class="row g-3">
                                <div class="col-md-4 form-group">
                                    <label>Designation</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                        <input type="text" class="form-control" name="designation"
                                            placeholder="e.g. Senior Consultant" value="{{ $users->designation ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label>Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-home"></i></span>
                                        <input type="text" class="form-control" name="address"
                                            placeholder="Enter Full Address" value="{{ $users->address ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>City</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                        <input type="text" class="form-control" name="city" placeholder="Enter City"
                                            value="{{ $users->city ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>State</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-map"></i></span>
                                        <input type="text" class="form-control" name="state" placeholder="Enter State"
                                            value="{{ $users->state ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Country</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-globe"></i></span>
                                        <input type="text" class="form-control" name="country" placeholder="Enter Country"
                                            value="{{ $users->country ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Pincode</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-map-pin"></i></span>
                                        <input type="text" class="form-control" name="pincode" placeholder="Enter Pincode"
                                            value="{{ $users->pincode ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            @if(!$isProfile)
                                <div class="form-section-title mt-4"><i class="bx bx-shield-alt-2 me-2"></i>Role &amp; Status
                                </div>
                                <div class="row g-3">
                                    @if($isPatient || $isDoctor)
                                        <input type="hidden" name="role" value="{{ $roles[0]->id ?? '' }}">
                                    @else
                                        <div class="col-md-4 form-group">
                                            <label>Role <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-shield-quarter"></i></span>
                                                <select class="form-control" name="role" required>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" @if(($users->role ?? '') == $role->id) selected
                                                        @endif>{{ $role->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-4 form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-check-circle"></i></span>
                                            <select class="form-control" name="status" required>
                                                <option value="1" @if(($users->status ?? '') == '1') selected @endif>Active
                                                </option>
                                                <option value="2" @if(($users->status ?? '') == '2') selected @endif>Deactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between mt-4 pt-3" style="border-top:1px solid #e9ecef;">
                                <button type="button" class="btn-wizard-back prev-step">
                                    <i class="bx bx-left-arrow-alt me-1"></i> Back
                                </button>
                                <div class="d-flex gap-2">
                                    <button type="reset" class="btn-wizard-reset">
                                        <i class="bx bx-reset me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn-wizard-submit">
                                        <i class="bx bx-check me-1"></i>
                                        @if(!empty($id)) Update {{ ucfirst($pagename[0] ?? 'User') }}
                                        @else Save {{ ucfirst($pagename[0] ?? 'User') }}
                                        @endif
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
        $(document).ready(function () {
            var currentStep = 1;

            function updateDisplay() {
                // Show/hide panels
                $('.form-step').removeClass('form-step-active');
                $('#step-' + currentStep).addClass('form-step-active');

                // Update stepper circles
                $('.wizard-step').each(function (i) {
                    $(this).removeClass('active done');
                    var stepNum = i + 1;
                    if (stepNum < currentStep) $(this).addClass('done');
                    if (stepNum === currentStep) $(this).addClass('active');
                });

                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            // Next Step
            $('.next-step').on('click', function () {
                var isValid = true;
                $('#step-' + currentStep + ' [required]').each(function () {
                    if ($(this).val().trim() === '') {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (isValid) {
                    currentStep++;
                    updateDisplay();
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Incomplete Step',
                            text: 'Please fill in all required fields marked with *',
                            confirmButtonColor: '#2563eb'
                        });
                    } else {
                        alert('Please fill in all required fields marked with *');
                    }
                }
            });

            // Previous Step
            $('.prev-step').on('click', function () {
                if (currentStep > 1) {
                    currentStep--;
                    updateDisplay();
                }
            });

            // Remove is-invalid on input
            $(document).on('input change', '[required]', function () {
                $(this).removeClass('is-invalid');
            });
        });
    </script>
@endpush