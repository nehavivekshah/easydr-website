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
                                        {{-- Changed ms-1 to ml-1 --}}
                                        <span class="ml-1 text-muted">({{ number_format($doctor->avg_rating, 1) }})</span>
                                    @else
                                        {{-- Changed fst-italic to font-italic --}}
                                        <span class="text-muted font-italic">No ratings yet</span>
                                    @endif
                                </div>

                                {{-- Experience & Location --}}
                                <div class="mb-4">
                                    @if(!empty($doctor->experience))
                                        <p class="mb-2 text-dark font-weight-bold">
                                            <i class="fas fa-briefcase text-primary mr-2"></i>{{ $doctor->experience }}
                                        </p>
                                    @endif

                                    <p class="mb-0 text-muted">
                                        <i
                                            class="fas fa-map-marker-alt text-danger mr-2"></i>{{ $doctor->hospital_name ?? $doctor->address ?? 'Main Hospital, NY' }}
                                    </p>
                                </div>

                                @if($doctor->fees)
                                    <p class="mb-3"><strong>Consultation Fee:</strong> ${{ number_format($doctor->fees, 2) }}
                                    </p>
                                @endif

                                {{-- Changed data-bs-toggle & data-bs-target to data-toggle & data-target --}}
                                <button type="button" class="btn btn-primary btn-lg w-100" data-toggle="modal"
                                    data-target="#appointmentModal">
                                    {{-- Changed me-2 to mr-2 --}}
                                    <i class="fas fa-calendar-check mr-2"></i> Book Appointment
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
                                        {{-- Changed data-bs-toggle & data-bs-target to data-toggle & data-target --}}
                                        <button class="nav-link active py-3" id="availability-tab" data-toggle="tab"
                                            data-target="#availability" type="button" role="tab"
                                            aria-controls="availability" aria-selected="true">Availability</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        {{-- Changed data-bs-toggle & data-bs-target to data-toggle & data-target --}}
                                        <button class="nav-link py-3" id="about-tab" data-toggle="tab" data-target="#about"
                                            type="button" role="tab" aria-controls="about" aria-selected="false">About
                                            Doctor</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        {{-- Changed data-bs-toggle & data-bs-target to data-toggle & data-target --}}
                                        <button class="nav-link py-3" id="education-tab" data-toggle="tab"
                                            data-target="#education" type="button" role="tab" aria-controls="education"
                                            aria-selected="false">Education & License</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        {{-- Changed data-bs-toggle & data-bs-target to data-toggle & data-target --}}
                                        <button class="nav-link py-3" id="reviews-tab" data-toggle="tab"
                                            data-target="#reviews" type="button" role="tab" aria-controls="reviews"
                                            aria-selected="false">Reviews ({{ $reviews->count() }})</button>
                                    </li>
                                    {{-- Add more tabs if needed --}}
                                    @if(!empty($doctor->extra))
                                        <li class="nav-item" role="presentation">
                                            {{-- Changed data-bs-toggle & data-bs-target to data-toggle & data-target --}}
                                            <button class="nav-link py-3" id="extra-tab" data-toggle="tab" data-target="#extra"
                                                type="button" role="tab" aria-controls="extra" aria-selected="false">More
                                                Info</button>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content" id="doctorTabsContent">
                                    {{-- Availability Tab --}}
                                    <div class="tab-pane fade show active" id="availability" role="tabpanel"
                                        aria-labelledby="availability-tab">
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

                                    {{-- About Tab (No longer active by default) --}}
                                    <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                                        <h5 class="mb-3">About Dr. {{ $doctor->first_name ?? '' }}
                                            {{ $doctor->last_name ?? '' }}
                                        </h5>
                                        @if(!empty($doctor->about))
                                            <p>{!! nl2br(e($doctor->about)) !!}</p>
                                        @else
                                            <p class="text-muted">Information not available.</p>
                                        @endif
                                    </div>

                                    {{-- Education Tab --}}
                                    <div class="tab-pane fade" id="education" role="tabpanel"
                                        aria-labelledby="education-tab">
                                        <h5 class="mb-3">Education & Credentials</h5>
                                        @if(!empty($doctor->education))
                                            <p><strong>Education:</strong><br> {!! nl2br(e($doctor->education)) !!}</p>
                                        @else
                                            <p><strong>Education:</strong> Information not available.</p>
                                        @endif
                                        <hr>
                                        @if(!empty($doctor->license))
                                            <p><strong>License:</strong><br> {{ $doctor->license }}</p>
                                        @else
                                            <p><strong>License:</strong> Information not available.</p>
                                        @endif
                                    </div>

                                    {{-- Reviews Tab --}}
                                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                        <h5 class="mb-4">Patient Reviews</h5>
                                        @forelse ($reviews as $review)
                                            <div class="d-flex mb-4 pb-3 border-bottom">
                                                {{-- Placeholder for reviewer image --}}
                                                {{-- Changed me-3 to mr-3 --}}
                                                <div class="flex-shrink-0 mr-3">
                                                    <i class="fas fa-user-circle fa-3x text-secondary"></i>
                                                    {{-- If you store reviewer info, use it: <img src="..."
                                                        class="rounded-circle" width="50"> --}}
                                                </div>
                                                <div class="flex-grow-1">
                                                    {{-- You'll need to join with users table or store reviewer name on review
                                                    --}}
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
                                        {{-- Optional: Add link to view more reviews if pagination is implemented --}}
                                    </div>

                                    {{-- Extra Info Tab --}}
                                    @if(!empty($doctor->extra))
                                        <div class="tab-pane fade" id="extra" role="tabpanel" aria-labelledby="extra-tab">
                                            <h5 class="mb-3">Additional Information</h5>
                                            <p>{!! nl2br(e($doctor->extra)) !!}</p>
                                        </div>
                                    @endif

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
                    <form action="/appointment" method="POST" id="appointmentForm">
                        @csrf
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                        {{-- Maybe include the token if needed --}}
                        {{-- <input type="hidden" name="token" value="{{ request()->route('token') }}"> --}}

                        <div class="modal-header">
                            <h5 class="modal-title" id="appointmentModalLabel">Book Appointment</h5>
                            {{-- Changed close button markup and added data-dismiss --}}
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
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
                                {{-- Changed form-select to form-control --}}
                                <select class="form-control" id="payment_mode" name="payment_mode" required>
                                    <option value="" selected disabled>-- Select payment method --</option>
                                    <option value="health-card">Health Card</option>
                                    <option value="online">Online Payment</option>
                                    <option value="cash">Cash on Payment</option>
                                </select>
                            </div>

                            <div class="form-group mb-3"> {{-- Changed mb-3 to form-group wrapper --}}
                                <label for="visit_reason" class="form-label">Reason for Visit (Optional)</label>
                                <textarea class="form-control" id="visit_reason" name="visit_reason" rows="2"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            {{-- Changed data-bs-dismiss to data-dismiss --}}
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

        });
    </script>
@endpush