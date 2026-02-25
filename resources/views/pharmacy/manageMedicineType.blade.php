@extends('layout')
@section('title', 'Manage Medicine Type - Easy Doctor')

@push('styles')
<style>
    .wizard-card { background:#fff; border-radius:16px; border:1px solid #e5e7eb; box-shadow:0 4px 24px rgba(0,0,0,.07); padding:30px 36px; }
    .wizard-page-header { display:flex; align-items:center; gap:12px; margin-bottom:24px; }
    .wizard-back-btn { width:36px; height:36px; background:#2563eb; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; font-size:1rem; flex-shrink:0; transition:background .2s; }
    .wizard-back-btn:hover { background:#1d4ed8; color:#fff; }
    .wizard-page-header h5 { margin:0; font-weight:700; font-size:1.15rem; color:#111827; }
    .form-section-title { font-size:.8rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#6c757d; margin:8px 0 18px; padding-bottom:8px; border-bottom:1px solid #e9ecef; }
    .input-group-text { background:#f0f4ff; border-right:none; color:#2563eb; min-width:42px; justify-content:center; }
    .input-group .form-control, .input-group .form-select { border-left:none; background:#f8f9fb; }
    .input-group .form-control:focus, .input-group .form-select:focus { border-color:#2563eb; box-shadow:none; background:#fff; }
    .btn-wizard-submit { background:linear-gradient(135deg,#1d4ed8,#2563eb); color:#fff; border:none; border-radius:50px; padding:10px 32px; font-weight:600; font-size:.92rem; box-shadow:0 4px 14px rgba(37,99,235,.3); transition:all .2s; }
    .btn-wizard-submit:hover { background:linear-gradient(135deg,#1e40af,#1d4ed8); box-shadow:0 6px 20px rgba(37,99,235,.4); transform:translateY(-1px); color:#fff; }
    .btn-wizard-back { background:#fff; color:#374151; border:1.5px solid #d1d5db; border-radius:50px; padding:10px 28px; font-weight:600; font-size:.92rem; transition:all .2s; }
    .btn-wizard-back:hover { background:#f3f4f6; border-color:#9ca3af; }
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
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12 offset-lg-3 offset-md-2 my-4 p-0">

                    <div class="wizard-page-header">
                        <a href="/admin/medicine-type" class="wizard-back-btn" title="Back">
                            <i class="bx bx-chevron-left"></i>
                        </a>
                        <h5>{{ $isEdit ? 'Edit Medicine Type' : 'Add New Medicine Type' }}</h5>
                    </div>

                    <div class="wizard-card">
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
                                            placeholder="Enter Medicine Type Name"
                                            value="{{ $types->name ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-semibold">Icon Class <span class="text-muted fw-normal">(optional)</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-image-alt"></i></span>
                                        <input type="text" name="icon" class="form-control"
                                            placeholder="e.g. bx bx-capsule"
                                            value="{{ $types->icon ?? '' }}">
                                    </div>
                                    <small class="text-muted">Enter a BoxIcon class name to display an icon for this type.</small>
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
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection