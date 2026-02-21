@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>

        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex align-items-center"
            style="background-image:url(/public/assets/frontend/img/testimonial/test-bg.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                        <div class="breadcrumb-wrap text-center">
                            <div class="breadcrumb-title mb-30"> {{-- mb-30 seems custom, BS4 uses mb-1 to mb-5 --}}
                                <h2>Doctor Details</h2>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item"><a href="/doctors">Doctors</a></li>
                                    {{-- BS4 doesn't automatically add an active class, you might need it explicitly --}}
                                    {{-- <li class="breadcrumb-item active" aria-current="page">Doctor Details</li> --}}
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <!-- doctor-details-area -->
        <section class="doctor-details-area pt-5 pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-5">
                        <div class="card shadow-sm mb-4">
                            <div class="text-center pt-3 bg-light">
                                <img src="{{ asset(!empty($doctor->photo) ? 'public/assets/images/profiles/' . $doctor->photo : 'public/assets/images/doctor-placeholder.png') }}"
                                    alt="Dr. {{ $doctor->first_name ?? '' }} {{ $doctor->last_name ?? '' }}"
                                    class="img-fluid img-thumbnail rounded-circle"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            <div class="card-body text-center">
                                <h4 class="card-title font-weight-bold mb-1">Dr. {{ $doctor->first_name ?? '' }}
                                    {{ $doctor->last_name ?? '' }}
                                </h4>
                                <p class="text-muted mb-2">{{ $doctor->specialist ?? 'Specialist' }}</p>

                                {{-- Rating --}}
                                <div class="mb-3 font-14"> {{-- font-14 is custom --}}
                                    @if(isset($doctor->avg_rating) && $doctor->avg_rating > 0)
                                        @php
                                            $rating = round($doctor->avg_rating);
                                            $maxRating = 5;
                                        @endphp
                                        <span class="text-warning">
                                            @for ($i = 1; $i <= $maxRating; $i++)
                                                <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star"></i>
                                            @endfor
                                        </span>
                                        <span class="ms-1 text-muted">({{ number_format($doctor->avg_rating, 1) }})</span>
                                    @else
                                        <span class="text-muted fst-italic">No ratings yet</span>
                                    @endif
                                </div>

                                {{-- Experience & Location --}}
                                <div class="mb-4">
                                    @if(!empty($doctor->experience))
                                        <p class="mb-2 text-dark fw-bold">
                                            <i class="fas fa-briefcase text-primary me-2"></i>{{ $doctor->experience }}
                                        </p>
                                    @endif

                                    <p class="mb-0 text-muted">
                                        <i
                                            class="fas fa-map-marker-alt text-danger me-2"></i>{{ $doctor->hospital_name ?? $doctor->address ?? 'Main Hospital, NY' }}
                                    </p>
                                </div>

                                @if($doctor->fees)
                                    <p class="mb-3"><strong>Consultation Fee:</strong> ${{ number_format($doctor->fees, 2) }}
                                    </p>
                                @endif

                                <button type="button" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal"
                                    data-bs-target="#appointmentModal">
                                    <i class="fas fa-calendar-check me-2"></i> Book Appointment
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Right Side: Details Tabs (About, Education, Reviews) --}}
                    <div class="col-xl-8 col-lg-8 col-md-7">
                        <div class="card shadow-sm details-tabs">
                            <div class="card-header bg-light p-0">
                                <ul class="nav nav-tabs nav-justified" id="doctorTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active py-3" id="doctor-about-tab" data-bs-toggle="tab"
                                            data-bs-target="#doctor-about" type="button" role="tab"
                                            aria-controls="doctor-about" aria-selected="true">Doctor About</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link py-3" id="reviews-tab" data-bs-toggle="tab"
                                            data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews"
                                            aria-selected="false">Patient Reviews ({{ $reviews->count() }})</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content" id="doctorTabsContent">
                                    {{-- Doctor About Tab --}}
                                    <div class="tab-pane fade show active" id="doctor-about" role="tabpanel"
                                        aria-labelledby="doctor-about-tab">

                                        {{-- About Section --}}
                                        <div class="mb-5">
                                            <!-- <h5 class="mb-3">About Dr. {{ $doctor->first_name ?? '' }}
                                                                                                                                    {{ $doctor->last_name ?? '' }}</h5> -->
                                            @if(!empty($doctor->about))
                                                <p>{!! nl2br(e($doctor->about)) !!}</p>
                                            @else
                                                <p class="text-muted">Information not available.</p>
                                            @endif
                                        </div>

                                        {{-- Education & License Section --}}
                                        <div class="mb-5">
                                            <h5 class="mb-3">Education & Credentials</h5>
                                            @if(!empty($doctor->education))
                                                <p><strong>Education:</strong> {!! nl2br(e($doctor->education)) !!}</p>
                                            @else
                                                <p><strong>Education:</strong> Information not available.</p>
                                            @endif

                                            @if(!empty($doctor->license))
                                                <p><strong>License:</strong> {{ $doctor->license }}</p>
                                            @else
                                                <p><strong>License:</strong> Information not available.</p>
                                            @endif
                                        </div>

                                        {{-- Availability Section --}}
                                        <div class="mb-5">
                                            <h5 class="mb-3">Doctor Availability</h5>
                                            <div class="availability-wrap">
                                                {{-- Date Range --}}
                                                <div class="row mb-3">
                                                    <div class="col-md-6 mb-3 mb-md-0">
                                                        <div class="d-flex align-items-start">
                                                            <div class="icon-box me-3 text-success bg-light rounded p-2"
                                                                style="font-size: 1.2rem;">
                                                                <i class="far fa-calendar-check"></i>
                                                            </div>
                                                            <div class="ms-3">
                                                                <h6 class="mb-1 fw-bold text-dark">
                                                                    {{ $doctor->available_from ?? '07 Jan, 2026' }}
                                                                </h6>
                                                                <p class="text-muted small mb-0">From Date</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-start">
                                                            <div class="icon-box me-3 text-danger bg-light rounded p-2"
                                                                style="font-size: 1.2rem;">
                                                                <i class="far fa-calendar-times"></i>
                                                            </div>
                                                            <div class="ms-3">
                                                                <h6 class="mb-1 fw-bold text-dark">
                                                                    {{ $doctor->available_to ?? '31 Jan, 2026' }}
                                                                </h6>
                                                                <p class="text-muted small mb-0">To Date</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Available Days --}}
                                                <div class="d-flex align-items-start mb-3">
                                                    <div class="icon-box me-3 text-warning bg-light rounded p-2"
                                                        style="font-size: 1.2rem;">
                                                        <i class="fas fa-grip-vertical"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h6 class="mb-1 fw-bold text-dark">
                                                            {{ $doctor->available_days ?? 'Monday | Tuesday | Wednesday | Thursday | Friday | Saturday | Sunday' }}
                                                        </h6>
                                                        <p class="text-muted small mb-0">Available Days</p>
                                                    </div>
                                                </div>

                                                {{-- Available Hours --}}
                                                <div class="d-flex align-items-start mb-3">
                                                    <div class="icon-box me-3 text-primary bg-light rounded p-2"
                                                        style="font-size: 1.2rem;">
                                                        <i class="far fa-clock"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h6 class="mb-1 fw-bold text-dark">
                                                            {{ $doctor->start_time ?? '09:00 AM' }} -
                                                            {{ $doctor->end_time ?? '08:00 PM' }}
                                                        </h6>
                                                        <p class="text-muted small mb-0">Available Hours</p>
                                                    </div>
                                                </div>

                                                {{-- Slot Duration --}}
                                                <div class="d-flex align-items-start">
                                                    <div class="icon-box me-3 text-purple bg-light rounded p-2"
                                                        style="color: #6f42c1; font-size: 1.2rem;">
                                                        <i class="fas fa-hourglass-half"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h6 class="mb-1 fw-bold text-dark">
                                                            {{ $doctor->slot_duration ?? '30 minutes' }}
                                                        </h6>
                                                        <p class="text-muted small mb-0">Slot Duration</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Extra Info Section --}}
                                        @if(!empty($doctor->extra))
                                            <div class="mb-3">
                                                <h5 class="mb-3">Additional Information</h5>
                                                <p>{!! nl2br(e($doctor->extra)) !!}</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Reviews Tab --}}
                                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                        <h5 class="mb-4">Patient Reviews</h5>
                                        @forelse ($reviews as $review)
                                            <div class="d-flex mb-4 pb-3 border-bottom">
                                                {{-- Placeholder for reviewer image --}}
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="fas fa-user-circle fa-3x text-secondary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Anonymous Patient</h6>
                                                    <small
                                                        class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                                    <div class="my-1">
                                                        @php $reviewRating = round($review->rating); @endphp
                                                        <span class="text-warning">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="{{ $i <= $reviewRating ? 'fas' : 'far' }} fa-star"></i>
                                                            @endfor
                                                        </span>
                                                    </div>
                                                    <p class="mb-0">{{ $review->comment ?? 'No comment provided.' }}</p>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-light text-center" role="alert">
                                                <i class="far fa-comment-dots fa-2x mb-2 d-block"></i>
                                                No reviews have been submitted for this doctor yet.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- doctor-details-area-end -->

        <!-- Appointment Booking Modal -->
        {{-- Added id="appointmentModal" --}}
        <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="/appointment" method="POST" id="appointmentForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="doctor_id" value="{{ $doctor->uid }}">
                        {{-- Maybe include the token if needed --}}
                        {{-- <input type="hidden" name="token" value="{{ request()->route('token') }}"> --}}

                        <div class="modal-header">
                            <h5 class="modal-title" id="appointmentModalLabel">Book Appointment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-3">Booking appointment with: <br><strong>Dr. {{ $doctor->first_name ?? '' }}
                                    {{ $doctor->last_name ?? '' }}</strong> ({{ $doctor->specialist ?? 'Specialist' }})</p>
                            <hr>

                            {{-- BS4 uses form-group typically to wrap label and input --}}
                            <div class="form-group mb-3">
                                <label for="appointment_date" class="form-label">Select Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="appointment_date" name="appointment_date"
                                    required min="{{ date('Y-m-d') }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="appointment_time" class="form-label">Select Time Slot <span
                                        class="text-danger">*</span></label>
                                {{-- Changed form-select to form-control --}}
                                <select class="form-control" id="appointment_time" name="appointment_time" required>
                                    <option value="" selected disabled>-- Select a time --</option>
                                    {{-- Time slots remain the same logic --}}
                                    <option value="09:00">09:00 AM - 09:30 AM</option>
                                    <option value="09:30">09:30 AM - 10:00 AM</option>
                                    <option value="10:00">10:00 AM - 10:30 AM</option>
                                    <option value="10:30">10:30 AM - 11:00 AM</option>
                                    <option value="11:00">11:00 AM - 11:30 AM</option>
                                    <option value="11:30">11:30 AM - 12:00 PM</option>
                                    <option value="14:00">02:00 PM - 02:30 PM</option>
                                    <option value="14:30">02:30 PM - 03:00 PM</option>
                                    <option value="15:00">03:00 PM - 03:30 PM</option>
                                </select>
                                {{-- BS4 uses form-text text-muted for helper text --}}
                                <small id="time-slot-availability" class="form-text text-muted">Select a date first to see
                                    available times.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="payment_mode" class="form-label">Payment Mode <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="payment_mode" name="payment_mode" required>
                                    <option value="" selected disabled>-- Select Payment Option --</option>
                                    <option value="Online Payment">Online Payment</option>
                                    <option value="Cash Payment">Cash Payment</option>
                                    <option value="Health Card">Health Card</option>
                                </select>
                            </div>

                            {{-- Dynamic Payment Gateway Dropdown --}}
                            <div class="form-group mb-3 d-none" id="payment-gateway-group">
                                <label for="payment_gateway" class="form-label">Select Online Payment Gateway <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="payment_gateway" name="payment_gateway">
                                    <option value="" selected disabled>-- Select Gateway --</option>
                                    {{-- Options loaded via JS --}}
                                </select>
                            </div>

                            <div class="form-group mb-3 d-none" id="health-card-group">
                                <label for="health_card_number" class="form-label">Health Card Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="health_card_number" name="health_card_number"
                                    placeholder="Enter your Health Card No.">
                            </div>

                            {{-- Referral Document Upload --}}
                            <div class="form-group mb-3">
                                <label for="referral_file" class="form-label" id="referral_file_label">Referral Document
                                    <span class="text-danger d-none" id="referral_required_asterisk">*</span> <small
                                        class="text-muted">(Optional)</small></label>
                                <input type="file" class="form-control" id="referral_file" name="referral_file"
                                    accept=".jpg,.jpeg,.png,.pdf">
                                <small class="form-text text-muted">Mandatory for Health Card. Accepted: JPG, PNG, PDF (Max
                                    2MB).</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="problem_description" class="form-label">State your problem <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="problem_description" name="problem_description" rows="3"
                                    required minlength="10"
                                    placeholder="Briefly describe your health problem (min 10 chars)..."></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="terms_accepted"
                                        name="terms_accepted" required>
                                    <label class="form-check-label" for="terms_accepted">
                                        I accept the terms and conditions. <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Confirm Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Appointment Booking Modal End -->

    </main>
    <!-- main-area-end -->
@endsection

@push('scripts')
    <script>
        // This JavaScript does not rely heavily on Bootstrap-specific classes
        // so it should work fine with Bootstrap 4.5 as well.
        // The modal is triggered by data-toggle/data-target attributes handled by Bootstrap's JS.
        document.addEventListener('DOMContentLoaded', function () {
            const today = new Date().toISOString().split('T')[0];
            const appointmentDateInput = document.getElementById('appointment_date');

            // --- Payment Mode Logic ---
            const paymentModeSelect = document.getElementById('payment_mode');
            const gatewayGroup = document.getElementById('payment-gateway-group');
            const gatewaySelect = document.getElementById('payment_gateway');
            const healthCardGroup = document.getElementById('health-card-group');
            const healthCardInput = document.getElementById('health_card_number');

            // Load gateways once
            let gatewaysLoaded = false;

            const referralFile = document.getElementById('referral_file');
            const referralRequiredAsterisk = document.getElementById('referral_required_asterisk');

            if (paymentModeSelect) {
                paymentModeSelect.addEventListener('change', function () {
                    const mode = this.value;

                    // Reset visibility/requirements
                    gatewayGroup.classList.add('d-none');
                    gatewaySelect.removeAttribute('required');

                    healthCardGroup.classList.add('d-none');
                    healthCardInput.removeAttribute('required');

                    // Reset Referral Requirement
                    referralFile.removeAttribute('required');
                    referralRequiredAsterisk.classList.add('d-none');

                    if (mode === 'Online Payment') {
                        gatewayGroup.classList.remove('d-none');
                        gatewaySelect.setAttribute('required', 'required');

                        if (!gatewaysLoaded) {
                            fetchGateways();
                        }
                    } else if (mode === 'Health Card') {
                        healthCardGroup.classList.remove('d-none');
                        healthCardInput.setAttribute('required', 'required');

                        // Make Referral Mandatory for Health Card
                        referralFile.setAttribute('required', 'required');
                        referralRequiredAsterisk.classList.remove('d-none');
                    }
                });
            }

            function fetchGateways() {
                gatewaySelect.innerHTML = '<option value="">Loading...</option>';
                fetch('/api/v1/payment-gateways')
                    .then(res => res.json())
                    .then(data => {
                        // API returns { status: true, message: "...", data: [ {id, gateway_name}, ... ] }
                        // OR directly the list depending on controller. 
                        // DoctorController::getPaymentGateways calls successResponse which wraps in data.

                        gatewaySelect.innerHTML = '<option value="" selected disabled>-- Select Gateway --</option>';

                        let gateways = [];
                        if (data.data && Array.isArray(data.data)) {
                            gateways = data.data;
                        } else if (Array.isArray(data)) {
                            gateways = data;
                        }

                        if (gateways.length > 0) {
                            gateways.forEach(g => {
                                const option = new Option(g.gateway_name, g.gateway_name);
                                gatewaySelect.add(option);
                            });
                            gatewaysLoaded = true;
                        } else {
                            gatewaySelect.innerHTML = '<option value="" disabled>No gateways available</option>';
                        }
                    })
                    .catch(e => {
                        console.error('Error fetching gateways:', e);
                        gatewaySelect.innerHTML = '<option value="" disabled>Error loading gateways</option>';
                    });
            }

            if (appointmentDateInput) {
                appointmentDateInput.setAttribute('min', today);
            }


            // --- IMPORTANT ---
            // The AJAX logic for fetching time slots remains the same conceptually.
            // Ensure your backend endpoint `/api/doctor/${doctorId}/available-slots` exists
            // and returns data in the expected format (e.g., array of objects like { value: 'HH:MM', label: 'HH:MM AM/PM - HH:MM AM/PM' }).

            // Example of how you might fetch time slots (pseudo-code):
            const dateInput = document.getElementById('appointment_date');
            const timeSelect = document.getElementById('appointment_time');
            const doctorIdInput = document.querySelector('input[name="doctor_id"]'); // Get doctor ID input
            const timeSlotHelpText = document.getElementById('time-slot-availability');

            if (dateInput && timeSelect && doctorIdInput && timeSlotHelpText) {
                const doctorId = doctorIdInput.value;

                dateInput.addEventListener('change', function () {
                    const selectedDate = this.value;
                    if (!selectedDate) {
                        timeSelect.innerHTML = '<option value="" selected disabled>-- Select a time --</option>';
                        timeSlotHelpText.textContent = 'Select a date first to see available times.';
                        timeSelect.disabled = true;
                        return;
                    };

                    // Show loading state
                    timeSelect.innerHTML = '<option value="">Loading times...</option>';
                    timeSelect.disabled = true;
                    timeSlotHelpText.textContent = 'Loading available times...';
                    console.log(`/api/doctor/${doctorId}/available-slots?date=${selectedDate}`);

                    // Replace with your actual endpoint URL
                    // Use fetch API (modern browsers) or XMLHttpRequest
                    fetch(`/api/doctor/${doctorId}/available-slots?date=${selectedDate}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json', // Expect JSON response
                            'X-Requested-With': 'XMLHttpRequest' // Often needed for frameworks to detect AJAX
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                // Try to get error message from response body if possible
                                return response.text().then(text => {
                                    throw new Error(`Network response was not ok (${response.status}): ${text || 'Server error'}`);
                                });
                            }
                            return response.json(); // Parse JSON body
                        })
                        .then(slots => {
                            timeSelect.innerHTML = '<option value="" selected disabled>-- Select a time --</option>'; // Reset
                            if (slots && Array.isArray(slots) && slots.length > 0) {
                                slots.forEach(slot => {
                                    // Assuming slot object has 'value' (e.g., "09:00") and 'label' (e.g., "09:00 AM - 09:30 AM")
                                    const option = new Option(slot.label, slot.value);
                                    // You might want to add checks here if a slot is already booked
                                    // e.g., if (slot.is_available) { timeSelect.add(option); }
                                    timeSelect.add(option);
                                });
                                timeSelect.disabled = false;
                                timeSlotHelpText.textContent = 'Please select an available time.';
                            } else {
                                timeSelect.innerHTML = '<option value="">No slots available</option>';
                                timeSlotHelpText.textContent = 'No time slots available for this date.';
                                // Keep it disabled if no slots are available
                                timeSelect.disabled = true;
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching time slots:', error);
                            timeSelect.innerHTML = '<option value="">Error loading times</option>';
                            timeSlotHelpText.textContent = `Error loading time slots: ${error.message}. Please try again or select a different date.`;
                            // Keep it disabled on error
                            timeSelect.disabled = true;
                        });
                });

                // Initialize state on page load
                timeSelect.disabled = true;

            } else {
                console.warn('Appointment date, time select, doctor ID input, or help text element not found. Dynamic time slot loading disabled.');
            }

            @if(request()->query('book') == 'true')
                // Auto-open the appointment modal if the user clicked "Book Again"
                var appointmentModal = new bootstrap.Modal(document.getElementById('appointmentModal'));
                appointmentModal.show();
            @endif

            });
    </script>
@endpush