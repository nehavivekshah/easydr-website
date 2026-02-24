@extends('layout')
@section('title', 'Manage Slots - Easy Doctors')

@push('styles')
<style>
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { font-weight: 600; color: #475569; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; }
    .task__section .text { font-size: 1.2rem; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; }
    
    .days-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 12px;
    }
    .day-checkbox {
        position: relative;
    }
    .day-checkbox input[type="checkbox"] {
        position: absolute;
        opacity: 0;
    }
    .day-checkbox label {
        display: block;
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        margin: 0;
        text-transform: none;
        letter-spacing: normal;
        font-weight: 500;
        color: #64748b;
    }
    .day-checkbox input[type="checkbox"]:checked + label {
        background: rgba(7, 204, 236, 0.1);
        border-color: var(--color-second);
        color: var(--color-default);
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(7, 204, 236, 0.15);
    }
</style>
@endpush

@section('content')

<section class="task__section">
    <div class="d-flex align-items-center mb-4 text-dark" style="font-size: 1.5rem; font-weight: 700;">
        <a href="/admin/doctor-availability" class="btn btn-default btn-sm back-btn me-3"><i class="bx bx-arrow-back mb-0"></i></a>
        {{ request()->get('id') ? 'Edit Slot' : 'Add New Slot' }}
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="manage-slot" method="POST" class="row">
                    @csrf
                    <input type="hidden" name="id" value="{{ request('id') ?? '' }}" required>

                    <div class="card border-0 shadow-sm rounded-4 w-100">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                            <h5 class="fw-bold text-primary mb-0"><i class="bx bx-time-five me-2 text-info"></i>Slot Configuration</h5>
                        </div>
                        <div class="card-body px-4 py-4">
                            <div class="row">
                                <!-- Doctor Selection -->
                                <div class="col-md-6 form-group">
                                    <label for="doctor">Doctor*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-user'></i></span>
                                        <select class="form-control" name="doctor" required>
                                            <option value="">Select Doctor</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->uid }}" {{ ($daSlots->doctor_id ?? '') == $doctor->uid ? 'selected' : '' }}>
                                                    {!! ($doctor->first_name ?? '').' '.($doctor->last_name ?? '').' ('.($doctor->specialist ?? '').')' !!}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Duration -->
                                <div class="col-md-6 form-group">
                                    <label for="duration">Appointment Duration (min)*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-stopwatch'></i></span>
                                        <input type="number" class="form-control" name="duration" min="5" max="120" value="{{ $daSlots->duration ?? '30' }}" required>
                                    </div>
                                </div>

                                <!-- From Date -->
                                <div class="col-md-6 form-group">
                                    <label for="fromDate">From Date*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-calendar-event'></i></span>
                                        <input type="date" class="form-control" name="fromDate" value="{{ $daSlots->from_date ?? now()->format('Y-m-d') }}" required>
                                    </div>
                                </div>

                                <!-- To Date -->
                                <div class="col-md-6 form-group">
                                    <label for="toDate">To Date*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-calendar-event'></i></span>
                                        <input type="date" class="form-control" name="toDate" value="{{ $daSlots->to_date ?? now()->format('Y-m-d') }}" required>
                                    </div>
                                </div>

                                <!-- Start Time -->
                                <div class="col-md-6 form-group">
                                    <label for="startTime">Start Time*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-time'></i></span>
                                        <input type="time" class="form-control" name="startTime" value="{{ $daSlots->start_time ?? now()->format('H:i') }}" required>
                                    </div>
                                </div>

                                <!-- End Time -->
                                <div class="col-md-6 form-group">
                                    <label for="endTime">End Time*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-time'></i></span>
                                        <input type="time" class="form-control" name="endTime" value="{{ $daSlots->end_time ?? now()->format('H:i') }}" required>
                                    </div>
                                </div>

                                <!-- Days Available -->
                                @php
                                    $availableDays = isset($daSlots->available_days) ? explode(',', $daSlots->available_days) : [];
                                @endphp
                                <div class="col-md-12 form-group mb-0">
                                    <label for="daysAvailable" class="mb-3">Days Available*</label>
                                    <div class="days-grid">
                                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                            <div class="day-checkbox">
                                                <input id="day_{{ $day }}" type="checkbox" name="daysAvailable[]" value="{{ $day }}" 
                                                {{ in_array($day, $availableDays) ? 'checked' : '' }}>
                                                <label for="day_{{ $day }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="card-footer bg-white border-top-0 px-4 py-4 rounded-bottom-4 text-end">
                            <button type="reset" class="btn btn-light border px-4 py-2 me-2 shadow-sm rounded-pill fw-bold text-muted">Reset</button>
                            <button type="submit" name="slotSubmit" class="btn btn-primary px-5 py-2 shadow-sm rounded-pill fw-bold">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
