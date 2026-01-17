@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        <div class="list-group shadow-sm">
                            <a href="/my-account" class="list-group-item list-group-item-action">Dashboard</a>
                            <a href="/appointments" class="list-group-item list-group-item-action">Appointments</a>
                            <a href="/my-profile" class="list-group-item list-group-item-action">My Profile</a>
                            <a href="/logout" class="list-group-item list-group-item-action">Logout</a>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="col-lg-9">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h4 class="mb-0">Book Appointment</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('manageAppointment') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="patient_id" value="{{ Auth::user()->id }}">

                                    <div class="mb-3">
                                        <label for="doctor_id" class="form-label">Select Doctor</label>
                                        <select class="form-select" name="doctor_id" id="doctor_id" required>
                                            <option value="">Choose a proper doctor</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->uid }}">
                                                    Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
                                                    ({{ $doctor->specialist }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="appointment_date" class="form-label">Date</label>
                                            <input type="date" class="form-control" name="appointment_date"
                                                id="appointment_date" required min="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="appointment_time" class="form-label">TimeSlot</label>
                                            <input type="time" class="form-control" name="appointment_time"
                                                id="appointment_time" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="problems" class="form-label">Problem Description</label>
                                        <textarea class="form-control" name="problems" id="problems" rows="3"
                                            placeholder="Describe your health issue..."></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Payment Method</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_status"
                                                id="pay_unpaid" value="unpaid" checked>
                                            <label class="form-check-label" for="pay_unpaid">
                                                Pay Later (at Clinic)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_status"
                                                id="pay_health_card" value="health_card">
                                            <label class="form-check-label" for="pay_health_card">
                                                Pay with Health Card
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">Book Appointment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection