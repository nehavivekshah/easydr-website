@extends('layout')
@section('title', 'Manage Slots - Easy Doctors')

@push('styles')
<style>
    .form-group { margin-bottom: 1.2rem; }
    .task__section .text { font-size: 1.2rem; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; }
</style>
@endpush

@section('content')

<section class="task__section">
    <div class="text mb-0">
        <a href="/admin/doctor-availability" class="btn btn-default btn-sm back-btn me-2"><i class="bx bx-arrow-back"></i></a>
        {{ request()->get('id') ? 'Edit Slot' : 'Add New Slot' }}
    </div>
    
    <div class="container-fluid">
        <div class="row g-3 px-2">
            <div class="col-md-12 bg-white rounded border shadow-sm p-4">
                <form action="manage-slot" method="POST" class="row">
                    @csrf
                    <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" required>

                    <!-- Doctor Selection -->
                    <div class="col-md-6 form-group">
                        <label for="doctor">Doctor*</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-user'></i></span>
                            <select class="form-control" name="doctor" required>
                                <option value="">Select Doctor*</option>
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
                            <span class="input-group-text"><i class='bx bx-time-five'></i></span>
                            <input type="number" class="form-control" name="duration" min="5" max="120" value="{{ $daSlots->duration ?? '30' }}" required>
                        </div>
                    </div>

                    <!-- From Date -->
                    <div class="col-md-6 form-group">
                        <label for="fromDate">From Date*</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                            <input type="date" class="form-control" name="fromDate" value="{{ $daSlots->from_date ?? now()->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <!-- To Date -->
                    <div class="col-md-6 form-group">
                        <label for="toDate">To Date*</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-calendar'></i></span>
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
                    <div class="col-md-12 form-group">
                        <label for="daysAvailable" class="mb-2">Days Available*</label>
                        <div class="d-flex flex-wrap gap-3 p-2 border rounded bg-light">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="daysAvailable[]" value="{{ $day }}" 
                                    {{ in_array($day, $availableDays) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $day }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-12 text-end mt-3">
                        <button type="submit" name="slotSubmit" class="btn btn-default px-4 py-2">Submit</button>
                        <button type="reset" class="btn btn-light border px-4 py-2">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
