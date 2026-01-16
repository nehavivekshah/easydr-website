@extends('layout')
@section('title', 'Manage Slots - Easy Doctors')

@section('content')

<section class="task__section">
    
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card rounded bg-white shadow-sm border mt-4 p-0">
                    <div class="text py-3 px-3 border border-left-0 border-right-0 border-top-0">
                        <h6 class="m-0">
                            <a href="/admin/doctor-availability" class="text-dark" title="Back"><i class="bx bx-arrow-back h6"></i></a>  
                            <label class="px-3">{{ request()->get('id') ? 'Edit Slot' : 'Add New Slot' }}</label>
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="manage-slot" method="POST" class="row">
                            @csrf
                            <div class="col-md-12 mb-3">
                                <label for="doctor" class="form-label">Doctor*</label>
                                <select class="form-select border py-2" name="doctor" required>
                                    <option value="">Select*</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->uid }}" {{ ($daSlots->doctor_id ?? '') == $doctor->uid ? 'selected' : '' }}>
                                            {!! ($doctor->first_name ?? '').' '.($doctor->last_name ?? '').' <span class="small text-muted">('.($doctor->specialist ?? '').')</span>' !!}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fromDate" class="form-label">From Date*</label>
                                <input type="date" class="form-control border py-2" name="fromDate" value="{{ $daSlots->from_date ?? now() }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="toDate" class="form-label">To Date*</label>
                                <input type="date" class="form-control border py-2" name="toDate" value="{{ $daSlots->to_date ?? now() }}" required>
                            </div>
                            @php
                                // Convert available_days to an array, or use an empty array if null
                                $availableDays = isset($daSlots->available_days) ? explode(',', $daSlots->available_days) : [];
                            @endphp
                            <div class="col-md-12 mb-3">
                                <label for="daysAvailable" class="form-label">Days Available*</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="daysAvailable[]" value="{{ $day }}" 
                                            {{ in_array($day, $availableDays) ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $day }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="startTime" class="form-label">Start Time*</label>
                                <input type="time" class="form-control border py-2" name="startTime" value="{{ $daSlots->start_time ?? now() }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="endTime" class="form-label">End Time*</label>
                                <input type="time" class="form-control border py-2" name="endTime" value="{{ $daSlots->end_time ?? now() }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="duration" class="form-label">Appointment Duration*</label>
                                <input type="number" class="form-control border py-2" name="duration" min="5" max="120" value="{{ $daSlots->duration ?? '30' }}" required>
                            </div>
                            <div class="text-right">
                                <button type="submit" name="slotSubmit" class="btn btn-default px-4 py-2">Submit</button>
                                <button type="button" name="slotReset" class="btn btn-ehite border px-4 py-2" onclick="this.form.reset();">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
