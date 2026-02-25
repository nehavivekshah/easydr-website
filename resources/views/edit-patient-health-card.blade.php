@extends('layout')
@section('title', 'Edit Health Card - Easy Doctor')

@push('styles')
    <style>
        .wizard-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
            padding: 30px 36px;
        }

        .wizard-page-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .wizard-back-btn {
            width: 36px;
            height: 36px;
            background: #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            flex-shrink: 0;
            transition: background .2s;
        }

        .wizard-back-btn:hover {
            background: #1d4ed8;
            color: #fff;
        }

        .wizard-page-header h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.15rem;
            color: #111827;
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

        .btn-wizard-submit:hover {
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            box-shadow: 0 6px 20px rgba(37, 99, 235, .4);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-wizard-cancel {
            background: #fff;
            color: #374151;
            border: 1.5px solid #d1d5db;
            border-radius: 50px;
            padding: 10px 28px;
            font-weight: 600;
            font-size: .92rem;
            transition: all .2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-wizard-cancel:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
            color: #111;
        }

        .health-card-preview {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
            padding: 10px 14px;
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 10px;
        }

        .health-card-preview i {
            color: #0ea5e9;
            font-size: 1.2rem;
        }

        .health-card-preview a {
            color: #0284c7;
            font-weight: 600;
            font-size: .875rem;
            text-decoration: none;
        }

        .health-card-preview a:hover {
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
    <section class="task__section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 col-md-10 col-sm-12 offset-lg-2 offset-md-1 my-4 p-0">

                    {{-- Page Header --}}
                    <div class="wizard-page-header">
                        <a href="/admin/patient-health-card" class="wizard-back-btn" title="Back to Health Cards">
                            <i class="bx bx-chevron-left"></i>
                        </a>
                        <h5>Edit Patient Health Card</h5>
                    </div>

                    <div class="wizard-card">
                        <div class="form-section-title"><i class="bx bx-id-card me-2"></i>Health Card Information</div>

                        <form action="{{ route('admin.patient.healthcard.update', $patient->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                {{-- Health Card Number --}}
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Health Card Number <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-credit-card"></i></span>
                                        <input type="text" name="health_card" class="form-control"
                                            value="{{ $patient->health_card }}" placeholder="Enter Health Card Number"
                                            required>
                                    </div>
                                </div>

                                {{-- Issue Date --}}
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Issue Date <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-calendar-plus"></i></span>
                                        <input type="date" name="hc_issue_date" class="form-control"
                                            value="{{ $patient->hc_issue_date }}" required>
                                    </div>
                                </div>

                                {{-- Expiry Date --}}
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Expiry Date <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-calendar-x"></i></span>
                                        <input type="date" name="hc_expairy_date" class="form-control"
                                            value="{{ $patient->hc_expairy_date }}" required>
                                    </div>
                                </div>

                                {{-- Health Card File --}}
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Health Card File
                                        <span class="text-muted fw-normal">(optional — replaces current)</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-upload"></i></span>
                                        <input type="file" name="health_card_file" class="form-control"
                                            accept="image/*,.pdf">
                                    </div>
                                    @if($patient->health_card_file)
                                        <div class="health-card-preview mt-2">
                                            <i class="bx bx-file"></i>
                                            <a href="{{ asset('public/assets/images/healthCards/' . $patient->health_card_file) }}"
                                                target="_blank">
                                                <i class="bx bx-link-external me-1"></i> View Current File
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3"
                                style="border-top:1px solid #e9ecef;">
                                <a href="/admin/patient-health-card" class="btn-wizard-cancel">
                                    <i class="bx bx-left-arrow-alt me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn-wizard-submit">
                                    <i class="bx bx-save me-1"></i> Update Health Card
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection