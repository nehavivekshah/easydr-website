@extends('layout')
@section('title', 'Manage Appointment - Easy Doctor')

@push('styles')
<style>
    /* ---- Wizard Stepper ---- */
    .wizard-stepper { display:flex; align-items:center; justify-content:center; background:#f8f9fa; border-radius:12px; padding:20px 30px; margin-bottom:28px; }
    .wizard-step { display:flex; flex-direction:column; align-items:center; flex:1; position:relative; }
    .wizard-step:not(:last-child)::after { content:''; position:absolute; top:18px; left:calc(50% + 22px); width:calc(100% - 44px); height:2px; background:#dee2e6; z-index:0; transition:background .3s; }
    .wizard-step.active:not(:last-child)::after, .wizard-step.done:not(:last-child)::after { background:#2563eb; }
    .step-circle { width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.9rem; border:2px solid #dee2e6; background:#fff; color:#adb5bd; z-index:1; transition:all .25s; }
    .wizard-step.active .step-circle { background:#2563eb; border-color:#2563eb; color:#fff; box-shadow:0 4px 12px rgba(37,99,235,.35); }
    .wizard-step.done .step-circle { background:#2563eb; border-color:#2563eb; color:#fff; }
    .step-label { font-size:.7rem; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#adb5bd; margin-top:8px; }
    .wizard-step.active .step-label, .wizard-step.done .step-label { color:#2563eb; }
    .wizard-panel { display:none; }
    .wizard-panel.active { display:block; }

    /* ---- Card ---- */
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
    .input-group .form-control[readonly] { background:#f1f5f9; color:#94a3b8; cursor:not-allowed; }
    label.form-label, .form-group label { font-weight:600; color:#374151; font-size:.875rem; margin-bottom:.4rem; display:block; }

    /* ---- Availability info chip ---- */
    .slot-info { display:inline-flex; align-items:center; gap:6px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:6px 12px; font-size:.8rem; color:#2563eb; font-weight:600; margin-top:8px; }

    /* ---- Buttons ---- */
    .btn-wizard-next, .btn-wizard-submit { background:linear-gradient(135deg,#1d4ed8,#2563eb); color:#fff; border:none; border-radius:50px; padding:10px 32px; font-weight:600; font-size:.92rem; box-shadow:0 4px 14px rgba(37,99,235,.3); transition:all .2s; cursor:pointer; }
    .btn-wizard-next:hover, .btn-wizard-submit:hover { background:linear-gradient(135deg,#1e40af,#1d4ed8); box-shadow:0 6px 20px rgba(37,99,235,.4); transform:translateY(-1px); color:#fff; }
    .btn-wizard-back { background:#fff; color:#374151; border:1.5px solid #d1d5db; border-radius:50px; padding:10px 28px; font-weight:600; font-size:.92rem; transition:all .2s; cursor:pointer; }
    .btn-wizard-back:hover { background:#f3f4f6; border-color:#9ca3af; }
    .btn-wizard-reset { background:#fff; color:#374151; border:1.5px solid #d1d5db; border-radius:50px; padding:10px 24px; font-weight:600; font-size:.92rem; transition:all .2s; }
    .btn-wizard-reset:hover { background:#f3f4f6; }
</style>
@endpush

@section('content')
    <section class="task__section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10 col-md-12 offset-lg-1 my-4 p-0">

                    {{-- Page Header --}}
                    <div class="wizard-page-header">
                        <a href="/admin/upcoming-appointments" class="wizard-back-btn" title="Back">
                            <i class="bx bx-chevron-left"></i>
                        </a>
                        <h5>{{ $pagename ?? 'Book an Appointment' }}</h5>
                    </div>

                    <div class="wizard-card">

                        {{-- Stepper --}}
                        <div class="wizard-stepper">
                            <div class="wizard-step active" data-step="1">
                                <div class="step-circle">1</div>
                                <div class="step-label">People &amp; Schedule</div>
                            </div>
                            <div class="wizard-step" data-step="2">
                                <div class="step-circle">2</div>
                                <div class="step-label">Consultation &amp; Payment</div>
                            </div>
                        </div>

                        <form action="/admin/manage-appointment" method="POST" enctype="multipart/form-data" id="appointmentForm">
                            @csrf
                            <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}">

                            {{-- ============================
                                 STEP 1: People & Schedule
                                 ============================ --}}
                            <div class="wizard-panel active" id="step-1">
                                <div class="form-section-title"><i class="bx bx-group me-2"></i>Patient &amp; Doctor</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Select Patient <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                                            <select class="form-control" id="patient_id" name="patient_id" required>
                                                <option value="">Select Patient</option>
                                                @foreach($patients as $patient)
                                                    <option value="{{ $patient->id }}"
                                                        @if(($appointments->pid ?? '') == ($patient->id ?? '')) selected @endif>
                                                        {{ $patient->first_name . ' ' . $patient->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Select Doctor <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user-plus"></i></span>
                                            <select class="form-control" id="doctor_id" name="doctor_id" required>
                                                <option value="">Select Doctor</option>
                                                @foreach($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}"
                                                        @if(($appointments->did ?? '') == ($doctor->id ?? '')) selected @endif>
                                                        {{ $doctor->first_name . ' ' . $doctor->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-title mt-4"><i class="bx bx-calendar-event me-2"></i>Date &amp; Time Slot</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Appointment Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <select class="form-control" id="appointment_date" name="appointment_date" required>
                                                <option value="">Select Date</option>
                                                @if(!empty($appointments->date))
                                                    <option value="{{ $appointments->date }}" selected>{{ $appointments->date }}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="slot-info mt-2" id="slotHint" style="display:none;">
                                            <i class="bx bx-info-circle"></i> Select a doctor first to load available dates
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Appointment Time <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-time"></i></span>
                                            <select class="form-control" id="appointment_time" name="appointment_time" required>
                                                <option value="">Select Time</option>
                                                @if(!empty($appointments->time))
                                                    <option value="{{ date_format(date_create($appointments->time), 'H:i') }}" selected>
                                                        {{ date_format(date_create($appointments->time), 'h:i A') }}
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-title mt-4"><i class="bx bx-notepad me-2"></i>Patient Concerns</div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Problems / Symptoms <span class="text-danger">*</span></label>
                                        <div class="input-group align-items-start">
                                            <span class="input-group-text" style="padding-top:10px;"><i class="bx bx-edit"></i></span>
                                            <textarea class="form-control" id="problems" name="problems" rows="3" required
                                                placeholder="Describe the patient's problems or symptoms...">{{ $appointments->note ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn-wizard-next" onclick="goToStep(2)">
                                        Next <i class="bx bx-right-arrow-alt ms-1"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- ============================
                                 STEP 2: Consultation & Payment
                                 ============================ --}}
                            <div class="wizard-panel" id="step-2">
                                <div class="form-section-title"><i class="bx bx-wallet me-2"></i>Payment Details</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Payment Mode <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-credit-card-alt"></i></span>
                                            <select class="form-control" id="payment_mode" name="payment_mode" required>
                                                @if($hasActiveGateways ?? true)
                                                    <option value="Online Payment" @if(($appointments->payment_mode ?? '') == 'Online Payment') selected @endif>💳 Online Payment</option>
                                                @endif
                                                <option value="Cash Payment" @if(($appointments->payment_mode ?? '') == 'Cash Payment') selected @endif>💵 Cash Payment</option>
                                                <option value="Health Card" @if(($appointments->payment_mode ?? '') == 'Health Card') selected @endif>🏥 Health Card</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Payment Status</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-check-shield"></i></span>
                                            <select class="form-control" id="payment_status" name="payment_status">
                                                <option value="">None</option>
                                                <option value="paid" @if(($appointments->payment_status ?? '') == 'paid') selected @endif>✅ Paid</option>
                                                @if(($appointments->payment_status ?? '') != 'paid')
                                                    <option value="unpaid" @if(($appointments->payment_status ?? '') == 'unpaid') selected @endif>⏳ Unpaid</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-title mt-4"><i class="bx bx-video me-2"></i>Consultation Mode</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Consultation Mode</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-broadcast"></i></span>
                                            <select class="form-control" id="meeting_provider" name="meeting_provider">
                                                <option value="in_person" @if(($appointments->meeting_provider ?? '') == 'in_person') selected @endif>🏥 In-Person Visit</option>
                                                @if($hasActiveVideoGateways ?? true)
                                                    <option value="integrated" @if(($appointments->meeting_provider ?? '') == 'integrated') selected @endif>🔒 Integrated Video Room</option>
                                                @endif
                                                <option value="google_meet" @if(($appointments->meeting_provider ?? '') == 'google_meet') selected @endif>📹 Google Meet</option>
                                                <option value="microsoft_teams" @if(($appointments->meeting_provider ?? '') == 'microsoft_teams') selected @endif>💼 Microsoft Teams</option>
                                                <option value="whatsapp" @if(($appointments->meeting_provider ?? '') == 'whatsapp') selected @endif>📱 WhatsApp Video</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Meeting Link / WhatsApp Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-link"></i></span>
                                            <input type="text" class="form-control" id="meeting_link" name="meeting_link"
                                                value="{{ $appointments->meeting_link ?? '' }}"
                                                placeholder="https://meet.google.com/... or WhatsApp No.">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4 pt-3" style="border-top:1px solid #e9ecef;">
                                    <button type="button" class="btn-wizard-back" onclick="goToStep(1)">
                                        <i class="bx bx-left-arrow-alt me-1"></i> Back
                                    </button>
                                    <div class="d-flex gap-2">
                                        <button type="reset" class="btn-wizard-reset">
                                            <i class="bx bx-reset me-1"></i> Reset
                                        </button>
                                        <button type="submit" class="btn-wizard-submit">
                                            <i class="bx bx-calendar-check me-1"></i> Book Appointment
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    /* ---- Wizard Navigation ---- */
    function goToStep(stepNum) {
        const currentPanel = document.querySelector('.wizard-panel.active');
        if (stepNum > parseInt(currentPanel.id.split('-')[1])) {
            const required = currentPanel.querySelectorAll('[required]');
            let valid = true;
            required.forEach(f => {
                if (!f.value.trim()) { f.classList.add('is-invalid'); valid = false; }
                else { f.classList.remove('is-invalid'); }
            });
            if (!valid) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon:'warning', title:'Incomplete Step', text:'Please fill in all required fields marked with *', confirmButtonColor:'#2563eb' });
                }
                return;
            }
        }
        document.querySelectorAll('.wizard-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('step-' + stepNum).classList.add('active');
        document.querySelectorAll('.wizard-step').forEach((s, i) => {
            s.classList.remove('active', 'done');
            if (i + 1 < stepNum) s.classList.add('done');
            if (i + 1 === stepNum) s.classList.add('active');
        });
        document.querySelector('.wizard-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    document.querySelectorAll('[required]').forEach(f => f.addEventListener('input', () => f.classList.remove('is-invalid')));

    /* ---- Appointment Logic ---- */
    $(document).ready(function () {
        let doctorSlots = [];

        // Handle doctor selection change → load available dates
        $('#doctor_id').on('change', function () {
            const doctorId = $(this).val();
            const $dateSelect = $('#appointment_date');
            const $timeSelect = $('#appointment_time');

            $dateSelect.html('<option value="">Select Date</option>').prop('disabled', true);
            $timeSelect.html('<option value="">Select Time</option>').prop('disabled', true);

            if (!doctorId) { doctorSlots = []; return; }

            $dateSelect.html('<option value="">Loading dates...</option>');
            $('#slotHint').hide();

            $.ajax({
                url: `/admin/get-doctor-availability/${doctorId}`,
                method: 'GET',
                success: function (response) {
                    doctorSlots = response;
                    if (doctorSlots.length === 0) {
                        $dateSelect.html('<option value="">No availability</option>');
                        if (typeof Swal !== 'undefined') Swal.fire({ icon:'info', title:'No Availability', text:'This doctor has no available time slots.', confirmButtonColor:'#2563eb' });
                        return;
                    }
                    const uniqueDates = [...new Set(doctorSlots.map(slot => slot.date))];
                    let dateOptions = '<option value="">Select Date</option>';
                    uniqueDates.forEach(date => {
                        const formattedDate = new Date(date).toLocaleDateString('en-US', { weekday:'short', year:'numeric', month:'short', day:'numeric' });
                        dateOptions += `<option value="${date}">${formattedDate}</option>`;
                    });
                    $dateSelect.html(dateOptions).prop('disabled', false);
                },
                error: function () {
                    $dateSelect.html('<option value="">Error loading dates</option>');
                    if (typeof Swal !== 'undefined') Swal.fire({ icon:'error', title:'Error', text:'Failed to load doctor availability. Please try again.', confirmButtonColor:'#2563eb' });
                }
            });
        });

        // Handle date selection → load times
        $('#appointment_date').on('change', function () {
            const selectedDate = $(this).val();
            const $timeSelect = $('#appointment_time');
            $timeSelect.html('<option value="">Select Time</option>').prop('disabled', true);
            if (!selectedDate) return;
            const timeSlotsForDate = doctorSlots.filter(slot => slot.date === selectedDate);
            if (timeSlotsForDate.length === 0) {
                $timeSelect.html('<option value="">No times available</option>');
                return;
            }
            let timeOptions = '<option value="">Select Time</option>';
            timeSlotsForDate.forEach(slot => { timeOptions += `<option value="${slot.time}">${slot.time}</option>`; });
            $timeSelect.html(timeOptions).prop('disabled', false);
        });

        // If editing — trigger doctor change to reload slots and pre-select date/time
        @if(!empty($appointments->did))
            const existingDoctorId = $('#doctor_id').val();
            if (existingDoctorId) {
                $('#doctor_id').trigger('change');
                setTimeout(function () {
                    const existingDate = '{{ $appointments->date ?? '' }}';
                    const existingTime = '{{ !empty($appointments->time) ? date_format(date_create($appointments->time), "h:i A") : "" }}';
                    if (existingDate) {
                        $('#appointment_date').val(existingDate).trigger('change');
                        setTimeout(function () {
                            if (existingTime) $('#appointment_time').val(existingTime);
                        }, 500);
                    }
                }, 1000);
            }
        @endif

        /* ---- Meeting link auto-generation ---- */
        const $meetingProvider = $('#meeting_provider');
        const $meetingLink = $('#meeting_link');

        function updateMeetingLink() {
            const provider = $meetingProvider.val();
            $meetingLink.prop('readonly', false);
            if (provider === 'google_meet') {
                const chars = 'abcdefghijklmnopqrstuvwxyz';
                const rand = len => Array.from({ length: len }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
                $meetingLink.val(`https://meet.google.com/${rand(3)}-${rand(4)}-${rand(3)}`);
            } else if (provider === 'microsoft_teams') {
                const randomId = Math.random().toString(36).substring(2, 15);
                $meetingLink.val(`https://teams.microsoft.com/l/meetup-join/19%3ameeting_${randomId}%40thread.v2/0`);
            } else if (provider === 'integrated') {
                $meetingLink.val('Auto-generated securely via EasyDoctor').prop('readonly', true);
            } else {
                const curr = $meetingLink.val();
                if (curr === 'Auto-generated securely via EasyDoctor' || curr.includes('meet.google.com') || curr.includes('teams.microsoft.com')) {
                    $meetingLink.val('');
                }
            }
        }

        $meetingProvider.on('change', updateMeetingLink);
        if ($meetingProvider.val() === 'integrated') {
            $meetingLink.val('Auto-generated securely via EasyDoctor').prop('readonly', true);
        }
    });
</script>
@endpush