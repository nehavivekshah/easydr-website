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
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4>My Appointments</h4>
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

                                            // Status Checks
                                            $isPendingOrConfirmed = in_array($appointment->status, ['0', '1']);
                                            $isExpired = $now->gt($slotEndTime) && !$isPendingOrConfirmed; 
                                            // Fix Expired Logic: if status is 2 (cancel) or 3 (complete), it's not "expired" in the pending sense, but done.
                                            // User said "available appointment in future".
                                            // Let's define "Future/Active" as: Not Cancelled, Not Completed, Not Time-Expired.
                                            $isFutureActive = $isPendingOrConfirmed && $now->lte($slotEndTime);

                                            // Payment Check
                                            $isPaid = in_array($appointment->payment_status, ['paid', 'health_card']);

                                            // Chat: Enabled for any Future/Active appointment (Paid or Unpaid)
                                            // User said: "if available appointment in future... enable chat"
                                            // We remove the 15m restriction for enabling the button, but maybe keep the "active" check?
                                            // Let's allow it as long as the appointment is active/future.
                                            $canChat = $isFutureActive;

                                            // Cancel: Enabled for any Future/Active appointment
                                            $canCancel = $isFutureActive;

                                            // Session (Call/Video): Requires Paid + On Time (accordingly)
                                            $sessionStartTime = $apptDateTime->copy()->subMinutes(5);
                                            $isSessionTime = $now->between($sessionStartTime, $slotEndTime);
                                            
                                            $canCallVideo = $isPaid && $isSessionTime && $appointment->status == '1'; // Must be confirmed too? Usually yes.
                                        @endphp
                                        <div class="col-lg-6 col-md-12 mb-4 wow fadeInUp">
                                            <div class="appointment-card">

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

                                                <!-- Payment Status Badge -->
                                                @if($appointment->payment_status == 'paid')
                                                    <span class="appointment-status-badge bg-success text-white ms-1">Paid</span>
                                                @elseif($appointment->payment_status == 'health_card')
                                                    <span class="appointment-status-badge bg-info text-white ms-1">Health Card</span>
                                                @else
                                                    <span class="appointment-status-badge bg-danger text-white ms-1">Unpaid</span>
                                                @endif


                                                <div class="appointment-header">
                                                    <div class="appointment-img-wrapper">
                                                        <img src="{{ $appointment->patient_photo ? asset('public/assets/images/profiles/' . $appointment->patient_photo) : 'https://ui-avatars.com/api/?name=' . $appointment->patient_first_name . '+' . $appointment->patient_last_name . '&background=0D8ABC&color=fff' }}"
                                                            alt="{{ $appointment->patient_first_name }}">
                                                    </div>
                                                    <div class="appointment-info">
                                                        <h5>{{ $appointment->patient_first_name }}
                                                            {{ $appointment->patient_last_name }}
                                                        </h5>
                                                        <p class="mb-0">{{ $appointment->patient_mobile }}</p>
                                                        @php
                                                            $age = null;
                                                            if (!empty($appointment->patient_dob)) {
                                                                try {
                                                                    $age = \Carbon\Carbon::parse($appointment->patient_dob)->age . ' Yrs';
                                                                } catch (\Exception $e) {
                                                                }
                                                            }
                                                            $gender = !empty($appointment->patient_gender) ? ucfirst($appointment->patient_gender) : null;
                                                        @endphp
                                                        @if($age || $gender)
                                                            <small class="text-muted">
                                                                {{ $gender }}{{ $age && $gender ? ', ' : '' }}{{ $age }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="appointment-problem mt-2 mb-3">
                                                    <small class="text-muted d-block">Problem:</small>
                                                    <p class="mb-0">{{ Str::limit($appointment->note, 60) }}</p>
                                                </div>


                                                <div class="appointment-datetime">
                                                    <i class="far fa-calendar-alt me-2"></i> {{ $apptDateTime->format('d M, Y') }} |
                                                    <i class="far fa-clock ms-2 me-2"></i> {{ $apptDateTime->format('h:i A') }}
                                                </div>


                                                @if($appointment->status == '0')
                                                    <form action="{{ route('confirmAppointment', $appointment->id) }}" method="POST"
                                                        class="mt-3 mb-3">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success w-100"
                                                            style="border-radius: 8px; font-weight: 600; padding: 10px;">
                                                            <i class="fas fa-check me-2"></i> Confirm Appointment
                                                        </button>
                                                    </form>
                                                @endif


                                                <div class="appointment-actions">

                                                    {{-- 1. Chat Button --}}
                                                    @if($canChat)
                                                        <a href="/messages" class="action-btn btn-chat" title="Message Patient">
                                                            <i class="fas fa-comment-alt"></i>
                                                        </a>
                                                    @else
                                                        <button class="action-btn btn-chat" disabled
                                                            title="Available for active future appointments">
                                                            <i class="fas fa-comment-alt"></i>
                                                        </button>
                                                    @endif

                                                    {{-- 2. Call Button --}}
                                                    @if(!empty($appointment->patient_mobile) && $canCallVideo)
                                                        <a href="tel:{{ $appointment->patient_mobile }}" class="action-btn btn-call"
                                                            title="Call Patient">
                                                            <i class="fas fa-phone"></i>
                                                        </a>
                                                    @else
                                                        <button class="action-btn btn-call" disabled title="{{ $canCallVideo ? 'No phone' : 'Available during paid session' }}">
                                                            <i class="fas fa-phone"></i>
                                                        </button>
                                                    @endif

                                                    {{-- 3. Video Call Button --}}
                                                    @if(!empty($appointment->meeting_link) && $canCallVideo)
                                                        @php
                                                            $meetingUrl = $appointment->meeting_provider == 'whatsapp' ? 'https://wa.me/' . $appointment->meeting_link : $appointment->meeting_link;
                                                        @endphp
                                                        <a href="{{ $meetingUrl }}" target="_blank"
                                                            class="action-btn btn-video pulsate-active" title="Join Meeting"
                                                            style="background: #17a2b8; color: #fff;">
                                                            <i class="fas fa-video"></i>
                                                        </a>
                                                    @else
                                                        <button class="action-btn btn-video" disabled
                                                            title="{{ $isExpired ? 'Meeting Expired' : 'Join active during session' }}">
                                                            <i class="fas fa-video"></i>
                                                        </button>
                                                    @endif


                                                    @if($appointment->status == '1' && !$isExpired)
                                                        <form action="{{ route('completeAppointment', $appointment->id) }}"
                                                            method="POST" class="flex-grow-1" style="flex: 1; display: flex;">
                                                            @csrf
                                                            <button type="submit" class="action-btn" title="Mark as Completed"
                                                                style="width: 100%; background: #6f42c1; color: #fff; border-color: #6f42c1;">
                                                                <i class="fas fa-flag-checkered"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- 4. Cancel Button --}}
                                                    @if($canCancel)
                                                        <form action="{{ route('cancelAppointment', $appointment->id) }}" method="POST"
                                                            class="flex-grow-1" style="flex: 1; display: flex;"
                                                            onsubmit="return confirm('Cancel this appointment?');">
                                                            @csrf
                                                            <button type="submit" class="action-btn btn-cancel"
                                                                title="Cancel Appointment" style="width: 100%;">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="action-btn btn-cancel" disabled title="Cannot cancel">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="col-12 mt-4 d-flex justify-content-center">
                                        {{ $appointments->appends(request()->input())->links('pagination::bootstrap-5') }}
                                    </div>
                                @else
                                    <div class="col-12">
                                        <div class="text-center py-5 bg-white shadow-sm rounded">
                                            <p class="text-muted mb-0">No appointments found.</p>
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