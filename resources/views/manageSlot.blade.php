@extends('layout')
@section('title', 'Manage Slots - Easy Doctor')

@push('styles')
<style>
    /* ---- Wizard Card ---- */
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
    label.form-label { font-weight:600; color:#374151; font-size:.875rem; }

    /* ---- Days Grid ---- */
    .days-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(120px, 1fr)); gap:10px; margin-top:4px; }
    .day-checkbox { position:relative; }
    .day-checkbox input[type="checkbox"] { position:absolute; opacity:0; width:0; height:0; }
    .day-checkbox label {
        display:block; width:100%; padding:10px 12px; border:1.5px solid #e5e7eb;
        border-radius:10px; background:#f8f9fb; text-align:center; cursor:pointer;
        transition:all .2s; font-weight:500; color:#6b7280; font-size:.87rem;
        text-transform:none; letter-spacing:normal; margin:0;
    }
    .day-checkbox input[type="checkbox"]:checked + label {
        background:#eff6ff; border-color:#2563eb; color:#2563eb;
        font-weight:700; box-shadow:0 2px 8px rgba(37,99,235,.15);
    }
    .day-checkbox label:hover { border-color:#93c5fd; background:#eff6ff; }

    /* ---- Buttons ---- */
    .btn-wizard-submit { background:linear-gradient(135deg,#1d4ed8,#2563eb); color:#fff; border:none; border-radius:50px; padding:10px 36px; font-weight:600; font-size:.92rem; box-shadow:0 4px 14px rgba(37,99,235,.3); transition:all .2s; }
    .btn-wizard-submit:hover { background:linear-gradient(135deg,#1e40af,#1d4ed8); box-shadow:0 6px 20px rgba(37,99,235,.4); transform:translateY(-1px); color:#fff; }
    .btn-wizard-reset { background:#fff; color:#374151; border:1.5px solid #d1d5db; border-radius:50px; padding:10px 28px; font-weight:600; font-size:.92rem; transition:all .2s; }
    .btn-wizard-reset:hover { background:#f3f4f6; border-color:#9ca3af; }
</style>
@endpush

@section('content')
    @php
        $availableDays = isset($daSlots->available_days) ? explode(',', $daSlots->available_days) : [];
        $isEdit = (bool) request()->get('id');
    @endphp

    <section class="task__section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9 col-md-11 col-sm-12 offset-lg-1 my-4 p-0">

                    {{-- Page Header --}}
                    <div class="wizard-page-header">
                        <a href="/admin/doctor-availability" class="wizard-back-btn" title="Back">
                            <i class="bx bx-chevron-left"></i>
                        </a>
                        <h5>{{ $isEdit ? 'Edit Slot' : 'Add New Slot' }}</h5>
                    </div>

                    <div class="wizard-card">
                        <form action="manage-slot" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ request('id') ?? '' }}">

                            {{-- Section: Slot Configuration --}}
                            <div class="form-section-title"><i class="bx bx-time-five me-2"></i>Slot Configuration</div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Doctor <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-user-md"></i></span>
                                        <select class="form-control" name="doctor" required>
                                            <option value="">Select Doctor</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->uid }}"
                                                    {{ ($daSlots->doctor_id ?? '') == $doctor->uid ? 'selected' : '' }}>
                                                    {!! ($doctor->first_name ?? '') . ' ' . ($doctor->last_name ?? '') . ' (' . ($doctor->specialist ?? '') . ')' !!}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Appointment Duration (min) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-stopwatch"></i></span>
                                        <input type="number" class="form-control" name="duration"
                                            min="5" max="120"
                                            value="{{ $daSlots->duration ?? '30' }}" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Section: Date & Time --}}
                            <div class="form-section-title mt-4"><i class="bx bx-calendar-event me-2"></i>Date &amp; Time Range</div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">From Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                        <input type="date" class="form-control" name="fromDate"
                                            value="{{ $daSlots->from_date ?? now()->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">To Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-calendar-check"></i></span>
                                        <input type="date" class="form-control" name="toDate"
                                            value="{{ $daSlots->to_date ?? now()->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-time"></i></span>
                                        <input type="time" class="form-control" name="startTime"
                                            value="{{ $daSlots->start_time ?? now()->format('H:i') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">End Time <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-time-five"></i></span>
                                        <input type="time" class="form-control" name="endTime"
                                            value="{{ $daSlots->end_time ?? now()->format('H:i') }}" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Section: Days Available --}}
                            <div class="form-section-title mt-4"><i class="bx bx-calendar-week me-2"></i>Days Available <span class="text-danger">*</span></div>
                            <div class="days-grid">
                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                    <div class="day-checkbox">
                                        <input id="day_{{ $day }}" type="checkbox"
                                            name="daysAvailable[]" value="{{ $day }}"
                                            {{ in_array($day, $availableDays) ? 'checked' : '' }}>
                                        <label for="day_{{ $day }}">{{ $day }}</label>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Actions --}}
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3" style="border-top:1px solid #e9ecef;">
                                <button type="reset" class="btn-wizard-reset">
                                    <i class="bx bx-reset me-1"></i> Reset
                                </button>
                                <button type="submit" name="slotSubmit" class="btn-wizard-submit">
                                    <i class="bx bx-check me-1"></i> {{ $isEdit ? 'Update Slot' : 'Save Slot' }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
