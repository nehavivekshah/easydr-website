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

                                            // Chat starts 15 mins before, ends when slot ends
                                            $chatStartTime = $apptDateTime->copy()->subMinutes(15);
                                            $isChatActive = $now->between($chatStartTime, $slotEndTime) && $appointment->status == '1';

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
                                                        <img src="{{ $appointment->doctor_photo ? asset('public/assets/images/profiles/' . $appointment->doctor_photo) : 'https://ui-avatars.com/api/?name='.$appointment->doctor_first_name.'+'.$appointment->doctor_last_name.'&background=0D8ABC&color=fff' }}"
                                                             alt="{{ $appointment->doctor_first_name }}">
                                                    </div>
                                                    <div class="appointment-info">
                                                        <h5>Dr. {{ $appointment->doctor_first_name }} {{ $appointment->doctor_last_name }}</h5>
                                                        <p>{{ $appointment->specialist ?? 'General' }}</p>
                                                    </div>
                                                </div>

                                                {{-- Date Time --}}
                                                <div class="appointment-datetime">
                                                    {{ $apptDateTime->format('d M, Y') }} | {{ $apptDateTime->format('h:i A') }}
                                                </div>

                                                {{-- Action Buttons --}}
                                                <div class="appointment-actions">
                                                    {{-- Call Button --}}
                                                    @if(!empty($appointment->doctor_phone))
                                                        <a href="tel:{{ $appointment->doctor_phone }}" class="action-btn btn-call" title="Call Doctor">
                                                            <i class="fas fa-phone"></i>
                                                        </a>
                                                    @else
                                                        <button class="action-btn btn-call" disabled title="No phone provided">
                                                            <i class="fas fa-phone"></i>
                                                        </button>
                                                    @endif

                                                    {{-- Chat Button --}}
                                                    @if($isChatActive && !$isExpired)
                                                        <a href="/messages" class="action-btn btn-chat" title="Message">
                                                            <i class="fas fa-comment-alt"></i>
                                                        </a>
                                                    @else
                                                        <button class="action-btn btn-chat" disabled title="{{ $now->lt($chatStartTime) ? 'Chat opens 15m before' : 'Messaging closed' }}">
                                                            <i class="fas fa-comment-alt"></i>
                                                        </button>
                                                    @endif
                                                    
                                                    {{-- Call Button --}}
                                                    @if($isSessionActive && !$isExpired)
                                                        <a href="tel:{{ $appointment->doctor_phone ?? '#' }}" class="action-btn btn-call" title="Call">
                                                            <i class="fas fa-phone-alt"></i>
                                                        </a>
                                                    @else
                                                        <button class="action-btn btn-call" disabled title="Calling active during session duration">
                                                            <i class="fas fa-phone-alt"></i>
                                                        </button>
                                                    @endif

                                                    {{-- Video Button --}} 
                                                    {{-- Only enabled if On Time logic is met AND link exists AND status is confirmed (1) --}}
                                                    @if(!empty($appointment->meeting_link) && $isSessionActive && !$isExpired)
                                                        @if($appointment->meeting_provider == 'whatsapp')
                                                            <a href="https://wa.me/{{ $appointment->meeting_link }}" target="_blank" class="action-btn btn-video pulsate-active" title="Join WhatsApp Video" style="background: #17a2b8; color: #fff;">
                                                                <i class="fab fa-whatsapp"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ $appointment->meeting_link }}" target="_blank" class="action-btn btn-video pulsate-active" title="Join Video Call" style="background: #17a2b8; color: #fff;">
                                                                <i class="fas fa-video"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        {{-- Disabled State --}}
                                                        <button class="action-btn btn-video" disabled title="{{ $isExpired ? 'Meeting Expired' : 'Join active during session' }}">
                                                            <i class="fas fa-video{{ !empty($appointment->meeting_link) ? '' : '-slash' }}"></i>
                                                        </button>
                                                    @endif

                                                    {{-- Cancel Button (Hide calculation logic: only cancellable if upcoming and pending/confirmed) --}}
                                                    @php
                                                        $isCancellable = ($appointment->status == '0' || $appointment->status == '1') && $now->lt($apptDateTime->copy()->subMinutes(30));
                                                    @endphp
                                                    @if($isCancellable)
                                                        <form action="{{ route('cancelAppointment', $appointment->id) }}" method="POST" class="flex-grow-1" style="flex: 1; display: flex;" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                                            @csrf
                                                            <button type="submit" class="action-btn btn-cancel" title="Cancel Appointment" style="width: 100%;">
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
                                            <a href="/manage-appointment" class="btn btn-primary ss-btn">Book your first appointment</a>
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