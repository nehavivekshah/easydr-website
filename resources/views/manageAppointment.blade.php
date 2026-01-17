@extends('layout')
@section('title', 'Doctor Appointment - Easy Doctors')

@section('content')
    <section class="task__section">
        <div class="text">
            <a href="/admin/upcoming-appointments" class="btn btn-default btn-sm back-btn"><i
                    class="bx bx-arrow-back"></i></a>
            {{ $pagename ?? 'Book an Appointment' }}
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="/admin/manage-appointment" method="post" class="row g-3 px-2"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 bg-white rounded border shadow-sm py-3 px-4">
                            <div class="row">
                                <!-- Patient Selection -->
                                <div class="form-group col-md-6">
                                    <label for="patient_id">Select Patient*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-user'></i></span>
                                        <select class="form-control" id="patient_id" name="patient_id" required>
                                            <option value="">Select Patient</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" @if(($appointments->pid ?? '') == ($patient->id ?? '')) selected @endif>{{ $patient->first_name . ' ' . $patient->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" />
                                    </div>
                                </div>

                                <!-- Doctor Selection -->
                                <div class="form-group col-md-6">
                                    <label for="doctor_id">Select Doctor*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-user-plus'></i></span>
                                        <select class="form-control" id="doctor_id" name="doctor_id" required>
                                            <option value="">Select Doctor</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}" @if(($appointments->did ?? '') == ($doctor->id ?? '')) selected @endif>{{ $doctor->first_name . ' ' . $doctor->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Appointment Date -->
                                <div class="form-group col-md-6">
                                    <label for="appointment_date">Appointment Date*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                                        <select class="form-control" id="appointment_date" name="appointment_date" required>
                                            <option value="">Select Date</option>
                                            @if(!empty($appointments->date))
                                                <option class="{{$appointments->date ?? ''}}" selected>
                                                    {{ $appointments->date ?? '' }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- Appointment Time -->
                                <div class="form-group col-md-6">
                                    <label for="appointment_time">Appointment Time*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-time'></i></span>
                                        <select class="form-control" id="appointment_time" name="appointment_time" required>
                                            <option value="">Select Time</option>
                                            @if(!empty($appointments->time))
                                                <option class="{{date_format(date_create($appointments->time ?? null), 'H:i')}}"
                                                    selected>{{date_format(date_create($appointments->time ?? null), 'h:i A')}}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Problems -->
                            <div class="form-group col-md-12">
                                <label for="problems">Problems*</label>
                                <textarea class="form-control border" id="problems" name="problems" rows="3" required
                                    placeholder="Describe the patient's problems...">{{ $appointments->note ?? '' }}</textarea>
                            </div>

                            <div class="row">
                                <!-- Payment Mode -->
                                <div class="form-group col-md-6">
                                    <label for="payment_status">Payment Mode*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-wallet'></i></span>
                                        <select class="form-control" id="payment_mode" name="payment_mode" required>
                                            <option value="Online Payment" @if(($appointments->payment_mode ?? '') == 'Online Payment') selected @endif>Online Payment</option>
                                            <option value="Cash Payment" @if(($appointments->payment_mode ?? '') == 'Cash Payment') selected @endif>Cash Payment</option>
                                            <option value="Health Card" @if(($appointments->payment_mode ?? '') == 'Health Card') selected @endif>Health Card</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Payment Status -->
                                <div class="form-group col-md-6">
                                    <label for="payment_status">Payment Status*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-wallet'></i></span>
                                        <select class="form-control" id="payment_status" name="payment_status">
                                            <option value="">None</option>
                                            <option value="paid" @if(($appointments->payment_status ?? '') == 'paid') selected
                                            @endif>Paid</option>
                                            @if(($appointments->payment_status ?? '') != 'paid')
                                                <option value="unpaid" @if(($appointments->payment_status ?? '') == 'unpaid')
                                                selected @endif>Unpaid</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Meeting Provider -->
                                <div class="form-group col-md-6">
                                    <label for="meeting_provider">Consultation Mode</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-video'></i></span>
                                        <select class="form-control" id="meeting_provider" name="meeting_provider">
                                            <option value="in_person" @if(($appointments->meeting_provider ?? '') == 'in_person') selected @endif>In-Person Visit</option>
                                            <option value="google_meet" @if(($appointments->meeting_provider ?? '') == 'google_meet') selected @endif>Google Meet</option>
                                            <option value="whatsapp" @if(($appointments->meeting_provider ?? '') == 'whatsapp') selected @endif>WhatsApp Video</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Meeting Link -->
                                <div class="form-group col-md-6">
                                    <label for="meeting_link">Meeting Link / WhatsApp Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-link'></i></span>
                                        <input type="text" class="form-control" id="meeting_link" name="meeting_link"
                                            value="{{ $appointments->meeting_link ?? '' }}"
                                            placeholder="https://meet.google.com/... or 919876543210">
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="form-group text-right mt-2 pt-2">
                                <button type="submit" class="btn btn-default px-4">Book Appointment</button>
                                <button type="reset" class="btn btn-light border px-4">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection