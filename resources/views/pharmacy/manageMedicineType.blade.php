@extends('layout')
@section('title', 'Manage Medicine Type - Easy Doctor')

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
        }

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
        }

        .btn-wizard-back:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
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
                    <h4 class="page-header-title">{{ $isEdit ? 'Edit Medicine Type' : 'Add New Medicine Type' }}</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/medicine-type"
                                    class="text-decoration-none text-muted">Medicine Types</a></li>
                            <li class="breadcrumb-item active text-muted">{{ $isEdit ? 'Edit Type' : 'Add Type' }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="wizard-card">
                <div class="wizard-banner">
                    <a href="/admin/medicine-type" class="wizard-back-btn" title="Back"><i class="bx bx-arrow-back"></i></a>
                    <div class="wizard-banner-icon"><i class="bx bx-category"></i></div>
                    <div>
                        <p class="wizard-banner-title">{{ $isEdit ? 'Edit Medicine Type' : 'Add New Medicine Type' }}</p>
                        <p class="wizard-banner-sub">Define the medicine type name and optional icon class</p>
                    </div>
                </div>
                <div class="wizard-card-body">
                    <div class="form-section-title"><i class="bx bx-category me-2"></i>Medicine Type Details</div>

                    <form action="{{ route('manageMedicineType') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}">

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-category"></i></span>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter Medicine Type Name" value="{{ $types->name ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Icon Class <span
                                        class="text-muted fw-normal">(optional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-image-alt"></i></span>
                                    <input type="text" name="icon" class="form-control" placeholder="e.g. bx bx-capsule"
                                        value="{{ $types->icon ?? '' }}">
                                </div>
                                <small class="text-muted">Enter a BoxIcon class name to display an icon for this
                                    type.</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="/admin/medicine-type" class="btn-wizard-back">
                                <i class="bx bx-left-arrow-alt me-1"></i> Cancel
                            </a>
                            <button type="submit" id="submitButton" class="btn-wizard-submit">
                                <i class="bx bx-check me-1"></i> {{ $isEdit ? 'Update Type' : 'Save Type' }}
                            </button>
                        </div>
                    </form>
                </div>{{-- /.wizard-card-body --}}
            </div>{{-- /.wizard-card --}}
        </div>{{-- /.container-fluid --}}
    </section>
@endsection