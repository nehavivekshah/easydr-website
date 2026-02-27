@extends('layout')
@section('title', 'Manage Meal - Easy Doctor')

@push('styles')
<style>
    .wizard-card { max-width:480px; margin:0 auto; border-radius:18px; border:1px solid #e5e7eb; box-shadow:0 8px 32px rgba(0,0,0,.08); overflow:hidden; background:#fff; }
    .wizard-header { background:linear-gradient(135deg,#1d4ed8,#2563eb); padding:22px 28px; display:flex; align-items:center; gap:14px; }
    .wizard-header-icon { width:42px; height:42px; background:rgba(255,255,255,.18); border-radius:12px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.3rem; flex-shrink:0; }
    .wizard-header-title { color:#fff; font-size:1rem; font-weight:700; margin:0; }
    .wizard-header-sub   { color:rgba(255,255,255,.8); font-size:.78rem; margin:2px 0 0; }
    .back-btn { width:34px; height:34px; background:rgba(255,255,255,.18); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; font-size:1rem; transition:.2s; margin-right:4px; flex-shrink:0; }
    .back-btn:hover { background:rgba(255,255,255,.3); color:#fff; }
    .wizard-body { padding:28px; }
    .form-label-styled { font-size:.82rem; font-weight:700; color:#374151; margin-bottom:6px; display:block; }
    .input-group-styled .input-group-text { background:#eff6ff; border-right:none; color:#2563eb; min-width:44px; justify-content:center; border-radius:10px 0 0 10px !important; }
    .input-group-styled .form-control { border-left:none; background:#f8f9fb; border-radius:0 10px 10px 0 !important; font-size:.88rem; }
    .input-group-styled .form-control:focus { background:#fff; border-color:#2563eb; box-shadow:none; }
    .wizard-footer { padding:16px 28px 24px; display:flex; justify-content:flex-end; gap:10px; }
    .btn-submit { background:linear-gradient(135deg,#1d4ed8,#2563eb); color:#fff; border:none; border-radius:50px; padding:10px 28px; font-weight:700; font-size:.88rem; box-shadow:0 4px 14px rgba(37,99,235,.35); transition:all .2s; display:inline-flex; align-items:center; gap:6px; cursor:pointer; }
    .btn-submit:hover { background:linear-gradient(135deg,#1e40af,#1d4ed8); transform:translateY(-1px); }
    .btn-reset  { background:#f1f5f9; color:#374151; border:1.5px solid #e2e8f0; border-radius:50px; padding:10px 22px; font-weight:600; font-size:.88rem; cursor:pointer; }
    .btn-reset:hover { background:#e2e8f0; }
</style>
@endpush

@section('content')
    @php $isEdit = !empty($_GET['id']); @endphp
    <section class="task__section">
        <div class="container-fluid">
            <div class="row justify-content-center mt-4">
                <div class="col-12">
                    <div class="wizard-card">
                        <div class="wizard-header">
                            <a href="/admin/meals" class="back-btn" title="Back"><i class="bx bx-arrow-back"></i></a>
                            <div class="wizard-header-icon"><i class="bx bx-food-menu"></i></div>
                            <div>
                                <p class="wizard-header-title">{{ $isEdit ? 'Edit Meal Instruction' : 'Add New Meal Instruction' }}</p>
                                <p class="wizard-header-sub">{{ $isEdit ? 'Update the meal instruction' : 'Define when a medication should be taken relative to meals' }}</p>
                            </div>
                        </div>
                        <form action="{{ route('manageMeal') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" />
                            <div class="wizard-body">
                                <label class="form-label-styled">Meal Instruction <span class="text-danger">*</span></label>
                                <div class="input-group input-group-styled">
                                    <span class="input-group-text"><i class="bx bx-food-menu"></i></span>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="e.g. Before Meal, After Meal, With Food"
                                        value="{{ $meal->name ?? '' }}" required />
                                </div>
                                <div class="mt-2" style="font-size:.76rem;color:#64748b;"><i class="bx bx-info-circle me-1"></i>e.g. <em>Before Meal</em>, <em>After Meal</em>, <em>With Food</em>, <em>On Empty Stomach</em>.</div>
                            </div>
                            <div class="wizard-footer">
                                <button type="reset" class="btn-reset"><i class="bx bx-reset me-1"></i> Reset</button>
                                <button type="submit" id="submitButton" class="btn-submit"><i class="bx bx-save me-1"></i>{{ $isEdit ? 'Update Meal' : 'Save Meal' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
