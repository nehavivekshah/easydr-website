@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    <!-- Content Area -->
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            @php
                                $pageTitle = 'Appointment';
                                if (request('filter') == 'past')
                                    $pageTitle = 'Meeting History';
                                if (request('filter') == 'upcoming')
                                    $pageTitle = 'Upcoming Meeting';
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <h5>{{ $pageTitle }}</h5>
                                <a href="/manage-appointment" class="btn btn-primary btn-sm mb-4">Book New Appointment</a>
                            </div>

                            <div class="row">
                                @if(isset($appointments) && count($appointments) > 0)
                                    @foreach($appointments as $appointment)
                                        @php
                                            $apptDateTime = \Carbon\Carbon::parse($appointment->date . ' ' . $appointment->time);
                                            $now = \Carbon\Carbon::now();

                                            // Duration: Use specific duration if available, else 30 mins
                                            $duration = $appointment->duration ?? 30;
                                            $slotEndTime = $apptDateTime->copy()->addMinutes($duration);

                                            // Chat starts 2 hours before, ends 24 hours after
                                            $chatStartTime = $apptDateTime->copy()->subHours(2);
                                            $chatEndTime = $slotEndTime->copy()->addHours(24);
                                            $isChatActive = $now->between($chatStartTime, $chatEndTime) && ($appointment->status == '1' || $appointment->status == '3');

                                            // Session (Call/Video) starts at appt time, ends when slot ends
                                            // We add a small 5 min early window for convenience
                                            $sessionStartTime = $apptDateTime->copy()->subMinutes(5);
                                            $isSessionActive = $now->between($sessionStartTime, $slotEndTime) && $appointment->status == '1';

                                            // Expired after slot ends
                                            $isExpired = $now->gt($slotEndTime) && $appointment->status != '3' && $appointment->status != '2';
                                            $isOnTime = $isSessionActive; // Reusing logic for consistency
                                        @endphp
                                        <div class="col-lg-6 col-md-12 mb-4 wow fadeInUp">
                                            <div class="appointment-card">
                                                {{-- Status Badge --}}
                                                @if($appointment->status == '2')
                                                    <span class="appointment-status-badge status-cancelled">Cancelled</span>
                                                @elseif($appointment->status == '3')
                                                    <span class="appointment-status-badge status-completed">Completed</span>
                                                @elseif($isExpired)
                                                    <span class="appointment-status-badge status-expired">Expired</span>
                                                @elseif($appointment->status == '1')
                                                    <span class="appointment-status-badge status-upcoming">Confirmed</span>
                                                @else
                                                    <span class="appointment-status-badge status-upcoming">Pending</span>
                                                @endif

                                                {{-- Header --}}
                                                <div class="appointment-header">
                                                    <div class="appointment-img-wrapper">
                                                        <img src="{{ $appointment->doctor_photo ? asset('public/assets/images/profiles/' . $appointment->doctor_photo) : 'https://ui-avatars.com/api/?name=' . $appointment->doctor_first_name . '+' . $appointment->doctor_last_name . '&background=0D8ABC&color=fff' }}"
                                                            alt="{{ $appointment->doctor_first_name }}">
                                                    </div>
                                                    <div class="appointment-info">
                                                        <h5>Dr. {{ $appointment->doctor_first_name }}
                                                            {{ $appointment->doctor_last_name }}
                                                        </h5>
                                                        <p>{{ $appointment->specialist ?? 'General' }}</p>
                                                    </div>
                                                </div>

                                                {{-- Date Time & Countdown Row --}}
                                                <div class="d-flex align-items-center flex-wrap gap-2 mb-3 mt-1"
                                                    style="font-size: 0.95rem; color: #4b5563;">
                                                    <div class="d-flex align-items-center">
                                                        <i class="far fa-calendar-alt me-2 text-muted"></i>
                                                        <span class="font-weight-bold">{{ $apptDateTime->format('d M, Y') }}</span>
                                                    </div>

                                                    <div style="width: 1px; height: 16px; background: #dee2e6; margin: 0 4px;">
                                                    </div>

                                                    <div class="d-flex align-items-center">
                                                        <i class="far fa-clock me-2 text-muted"></i>
                                                        <span class="font-weight-bold">{{ $apptDateTime->format('h:i A') }}</span>
                                                    </div>

                                                    {{-- Countdown Timer --}}
                                                    @if(!$isExpired && ($appointment->status == '0' || $appointment->status == '1'))
                                                        <div class="timer-countdown inline-timer ms-3"
                                                            data-start="{{ $apptDateTime->timestamp * 1000 }}"
                                                            data-end="{{ $slotEndTime->timestamp * 1000 }}">
                                                            <div class="dt-item text-danger font-weight-bold"
                                                                style="font-size: 1.05rem;"></div>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Action Buttons --}}
                                                <div class="appointment-actions">

                                                    {{-- Chat Button --}}
                                                    @if($isChatActive && !$isExpired)
                                                        <a href="/messages" class="action-btn btn-chat" title="Message">
                                                            <i class="fas fa-comment-alt"></i>
                                                        </a>
                                                    @else
                                                        <button class="action-btn btn-chat" disabled
                                                            title="{{ $now->lt($chatStartTime) ? 'Chat opens 15m before' : 'Messaging closed' }}">
                                                            <i class="fas fa-comment-alt"></i>
                                                        </button>
                                                    @endif

                                                    {{-- Call Button --}}
                                                    @if($isSessionActive && !$isExpired)
                                                        <a href="tel:{{ $appointment->doctor_phone ?? '#' }}"
                                                            class="action-btn btn-call" title="Call">
                                                            <i class="fas fa-phone-alt"></i>
                                                        </a>
                                                    @else
                                                        <button class="action-btn btn-call" disabled
                                                            title="Calling active during session duration">
                                                            <i class="fas fa-phone-alt"></i>
                                                        </button>
                                                    @endif

                                                    {{-- Video Button --}}
                                                    {{-- Only enabled if On Time logic is met AND link exists AND status is
                                                    confirmed (1) --}}
                                                    @if(!empty($appointment->meeting_link) && $isSessionActive && !$isExpired)
                                                        @if($appointment->meeting_provider == 'whatsapp')
                                                            <a href="https://wa.me/{{ $appointment->meeting_link }}" target="_blank"
                                                                class="action-btn btn-video pulsate-active" title="Join WhatsApp Video"
                                                                style="background: #17a2b8; color: #fff;">
                                                                <i class="fab fa-whatsapp"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ $appointment->meeting_link }}" target="_blank"
                                                                class="action-btn btn-video pulsate-active" title="Join Video Call"
                                                                style="background: #17a2b8; color: #fff;">
                                                                <i class="fas fa-video"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        {{-- Disabled State --}}
                                                        <button class="action-btn btn-video" disabled
                                                            title="{{ $isExpired ? 'Meeting Expired' : 'Join active during session' }}">
                                                            <i
                                                                class="fas fa-video{{ !empty($appointment->meeting_link) ? '' : '-slash' }}"></i>
                                                        </button>
                                                    @endif

                                                    {{-- Cancel Button (Hide calculation logic: only cancellable if upcoming and
                                                    pending/confirmed) --}}
                                                    @php
                                                        $isCancellable = ($appointment->status == '0' || $appointment->status == '1') && $now->lt($apptDateTime->copy()->subMinutes(30));
                                                    @endphp
                                                    @if($isCancellable)
                                                        <form action="{{ route('cancelAppointment', $appointment->id) }}" method="POST"
                                                            class="flex-grow-1" style="flex: 1; display: flex;"
                                                            onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                                            @csrf
                                                            <button type="submit" class="action-btn btn-cancel"
                                                                title="Cancel Appointment" style="width: 100%;">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="action-btn btn-cancel" disabled title="Cancel window closed">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Pagination Links --}}
                                    <div class="col-12 mt-4 d-flex justify-content-center">
                                        {{ $appointments->appends(request()->input())->links('pagination::bootstrap-5') }}
                                    </div>

                                @else
                                    <div class="col-12 text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                                            <p class="text-muted mb-3">No appointments found.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        function updateCountdowns() {
            document.querySelectorAll('.timer-countdown').forEach(el => {
                const start = parseInt(el.dataset.start);
                const end = parseInt(el.dataset.end);
                const now = new Date().getTime();
                const display = el.querySelector('.dt-item');

                if (!display) return;

                if (now < start) {
                    // Future: show countdown to start
                    const diff = start - now;
                    const h = Math.floor(diff / 3600000);
                    const m = Math.floor((diff % 3600000) / 60000);
                    const s = Math.floor((diff % 60000) / 1000);

                    let timeStr = "";
                    if (h > 0) timeStr += h + "h ";
                    timeStr += m + "m " + s + "s";

                    display.innerText = timeStr;
                    el.classList.remove('ongoing', 'ended');
                } else if (now >= start && now <= end) {
                    // Ongoing
                    display.innerText = "Session Ongoing";
                    el.classList.add('ongoing');
                    el.classList.remove('ended');
                } else {
                    // Ended
                    display.innerText = "Session Ended";
                    el.classList.add('ended');
                    el.classList.remove('ongoing');
                }
            });
        }

        // Initialize and run every second
        setInterval(updateCountdowns, 1000);
        updateCountdowns();
    </script>
@endpush