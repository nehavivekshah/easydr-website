@extends('frontend.layout')

@section('content')
    <style>
        .appointment-card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
            overflow: hidden;
            background: #fff;
            border: 1px solid #f0f0f0 !important;
            padding: 1.5rem !important;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
        }
        .appointment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
        }
        .profile-img-modern {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .status-ribbon {
            position: absolute;
            top: 12px;
            left: -32px;
            transform: rotate(-45deg);
            width: 120px;
            text-align: center;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 0;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .ribbon-pending { background: #fff3cd; color: #856404; }
        .ribbon-confirmed { background: #d1e7dd; color: #0f5132; }
        .ribbon-cancelled { background: #f8d7da; color: #721c24; }
        .ribbon-completed { background: #cfe2ff; color: #084298; }
        .ribbon-expired { background: #e2e8f0; color: #4a5568; }

        .btn-action-modern {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            border: none;
            text-decoration: none !important;
        }
        .btn-action-modern:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-confirm-modern {
            background: #1a4b8c;
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            border: none;
            transition: all 0.2s;
        }
        .btn-confirm-modern:hover {
            background: #0d6efd;
            box-shadow: 0 4px 12px rgba(26, 75, 140, 0.2);
        }
        .badge-pill-modern {
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 50px;
        }
    </style>
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
                                            $isExpired = $now->gt($slotEndTime) && $isPendingOrConfirmed; 
                                            // Future/Active Logic
                                            $isFutureActive = $isPendingOrConfirmed && $now->lte($slotEndTime);

                                            // Payment Check
                                            $paymentStatus = $appointment->payment_status;
                                            $isPaid = in_array($paymentStatus, ['paid', 'health_card']);

                                            // Session Time Calculation (Standardized for all Live Actions)
                                            // Active 5 mins before start until end time
                                            $sessionStartTime = $apptDateTime->copy()->subMinutes(5);
                                            $isSessionTime = $now->between($sessionStartTime, $slotEndTime);

                                            // Action Availability
                                            
                                            // Chat: Now aligned with Session Time (User: "on shedule time to active chat")
                                            // Still allows Unpaid chat (if previously requested), but only during session.
                                            // If we want to strictly follow "Only Chat if Unpaid", we keep that, but add Time Check.
                                            $canChat = $isSessionTime && $isPendingOrConfirmed;

                                            // Cancel: Enabled for Future Active (Before or During), Paid Only
                                            $canCancel = $isFutureActive; // && $isPaid

                                            // Call/Video: Requires Paid + Session Time + Confirmed
                                            $canCallVideo = $isPaid && $isSessionTime && $appointment->status == '1';
                                            
                                            // Complete: Requires Paid + Active
                                            $canComplete = $isPaid && $appointment->status == '1' && !$isExpired;

                                            // Profile Data
                                            $age = null;
                                            if (!empty($appointment->patient_dob)) {
                                                try { $age = \Carbon\Carbon::parse($appointment->patient_dob)->age . ' Yrs'; } catch (\Exception $e) {}
                                            }
                                            $gender = !empty($appointment->patient_gender) ? ucfirst($appointment->patient_gender) : null;
                                        @endphp

                                        <div class="col-lg-6 col-md-12 mb-4 wow fadeInUp">
                                            <div class="appointment-card border-left-primary">
                                                <!-- Status Ribbon -->
                                                @if($appointment->status == '0' && !$isExpired)
                                                    <div class="status-ribbon ribbon-pending">PENDING</div>
                                                @elseif($appointment->status == '1' && !$isExpired)
                                                    <div class="status-ribbon ribbon-confirmed">CONFIRMED</div>
                                                @elseif($appointment->status == '2')
                                                    <div class="status-ribbon ribbon-cancelled">CANCELLED</div>
                                                @elseif($appointment->status == '3')
                                                    <div class="status-ribbon ribbon-completed">COMPLETED</div>
                                                @elseif($isExpired)
                                                    <div class="status-ribbon ribbon-expired">EXPIRED</div>
                                                @endif
                                                
                                                <!-- Header: Profile & Payment Badge -->
                                                <div class="d-flex justify-content-between align-items-start mb-4">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="{{ $appointment->patient_photo ? asset('public/assets/images/profiles/' . $appointment->patient_photo) : 'https://ui-avatars.com/api/?name=' . $appointment->patient_first_name . '+' . $appointment->patient_last_name . '&background=0D8ABC&color=fff' }}"
                                                             alt="Profile" class="profile-img-modern shadow-sm">
                                                        <div class="profile-info">
                                                            <h5 class="fw-bold text-dark mb-1">{{ $appointment->patient_first_name }} {{ $appointment->patient_last_name }}</h5>
                                                            <div class="text-muted small d-flex align-items-center gap-2">
                                                                @if($gender == '1') <i class="fas fa-mars text-primary"></i> Male
                                                                @elseif($gender == '2') <i class="fas fa-venus text-danger"></i> Female 
                                                                @endif
                                                                @if($age) • {{ $age }} @endif
                                                            </div>
                                                            <div class="text-muted small mt-1">
                                                                <i class="fas fa-phone-alt mr-1"></i> {{ $appointment->patient_mobile }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-column align-items-end gap-2">
                                                        @if($paymentStatus == 'paid')
                                                            <span class="badge badge-soft-success badge-pill-modern">PAID</span>
                                                        @elseif($paymentStatus == 'health_card')
                                                            <span class="badge badge-soft-info badge-pill-modern">HEALTH CARD</span>
                                                        @else
                                                            <div class="d-flex flex-column align-items-end">
                                                                <span class="badge badge-soft-danger badge-pill-modern mb-2">UNPAID</span>
                                                                @if($appointment->status != '2' && !$isExpired)
                                                                    <form action="{{ route('markAppointmentPaid', $appointment->id) }}" method="POST"
                                                                        onsubmit="return confirm('Mark this appointment as PAID manually?');">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">
                                                                            Mark Paid
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        @if(!empty($appointment->payment_mode))
                                                            <span class="text-muted extra-small fw-bold opacity-75" style="font-size: 9px;">via {{ strtoupper($appointment->payment_mode) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- Date & Time Info -->
                                                <div class="bg-light rounded-3 p-3 mb-4 d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="text-center">
                                                            <p class="text-muted extra-small mb-0 text-uppercase fw-bold opacity-50">Date</p>
                                                            <p class="text-dark small fw-bold mb-0">{{ $apptDateTime->format('d M, Y') }}</p>
                                                        </div>
                                                        <div class="border-start h-100 mx-2" style="width: 1px; min-height: 24px;"></div>
                                                        <div class="text-center">
                                                            <p class="text-muted extra-small mb-0 text-uppercase fw-bold opacity-50">Time</p>
                                                            <p class="text-dark small fw-bold mb-0">{{ $apptDateTime->format('h:i A') }}</p>
                                                        </div>
                                                    </div>

                                                    @if($appointment->status != '2' && !$isExpired)
                                                        <div class="timer-countdown text-end" 
                                                            data-start="{{ $apptDateTime->timestamp * 1000 }}" 
                                                            data-end="{{ $slotEndTime->timestamp * 1000 }}">
                                                            <p class="text-muted extra-small mb-0 text-uppercase fw-bold opacity-50">Starts In</p>
                                                            <p class="dt-item text-danger fw-bold mb-0" style="font-size: 14px;"></p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <!-- Problem Section -->
                                                <div class="problem-section">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewProblemModal{{ $appointment->id }}" class="text-decoration-none" style="font-size: 0.85rem; font-weight: 500;">
                                                        <i class="fas fa-paperclip me-1 text-primary" style="font-size: 0.85rem; font-weight: 500;"></i> Reported Problem
                                                    </a>
                                                    <!-- <span class="problem-label">Reported Problem</span> -->
                                                    <!-- <p class="problem-text mb-2">
                                                        {{ Str::limit($appointment->note, 80, '...') }}
                                                    </p> -->
                                                    <div class="dt-divider"></div>
                                                    @if(!empty($appointment->referral_file))
                                                        <a href="{{ asset('public/assets/images/referrals/' . $appointment->referral_file) }}" target="_blank" class="text-decoration-none" style="font-size: 0.85rem; font-weight: 500;">
                                                            <i class="fas fa-paperclip me-1 text-primary" style="font-size: 0.85rem; font-weight: 500;"></i> Referral Document
                                                        </a>
                                                    @endif
                                                </div>

                                                <!-- Problem Modal -->
                                                <div class="modal fade" id="viewProblemModal{{ $appointment->id }}" tabindex="-1" aria-labelledby="viewProblemModalLabel{{ $appointment->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="viewProblemModalLabel{{ $appointment->id }}">Reported Problem</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="problem-text">{{ $appointment->note ?: 'No specific problem reported.' }}</p>
                                                            </div>
                                                            <!-- <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Confirm Button (If Status 0) -->
                                                @if($appointment->status == '0' && !$isExpired)
                                                    <form action="{{ route('confirmAppointment', $appointment->id) }}" method="POST" class="mb-3">
                                                        @csrf
                                                        <button type="submit" class="btn-confirm-modern w-100 py-3 shadow-sm">
                                                            <i class="fas fa-check-circle mr-2"></i> Confirm Appointment
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Action Buttons Row -->
                                                <div class="d-flex justify-content-between align-items-center gap-2 mt-auto pt-3 border-top">
                                                    <div class="d-flex gap-2">
                                                        {{-- 1. Chat --}}
                                                        @if($canChat)
                                                            <a href="/messages" class="btn-action-modern badge-soft-primary" title="Chat">
                                                                <i class="fas fa-comment-dots"></i>
                                                            </a>
                                                        @else
                                                            <button class="btn-action-modern bg-light text-muted opacity-50" disabled title="Chat unavailable">
                                                                <i class="fas fa-comment-dots"></i>
                                                            </button>
                                                        @endif

                                                        {{-- 2. Call --}}
                                                        @if(!empty($appointment->patient_mobile) && $canCallVideo)
                                                            <a href="tel:{{ $appointment->patient_mobile }}" class="btn-action-modern badge-soft-success" title="Call">
                                                                <i class="fas fa-phone-alt"></i>
                                                            </a>
                                                        @else
                                                            <button class="btn-action-modern bg-light text-muted opacity-50" disabled>
                                                                <i class="fas fa-phone-alt"></i>
                                                            </button>
                                                        @endif

                                                        {{-- 3. Video --}}
                                                        @if(!empty($appointment->meeting_link) && $canCallVideo)
                                                            <a href="{{ $appointment->meeting_provider == 'whatsapp' ? 'https://wa.me/' . $appointment->meeting_link : $appointment->meeting_link }}" target="_blank" class="btn-action-modern badge-soft-info" title="Video Call">
                                                                <i class="fas fa-video"></i>
                                                            </a>
                                                        @else
                                                            <button class="btn-action-modern bg-light text-muted opacity-50" disabled>
                                                                <i class="fas fa-video"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="d-flex gap-2 align-items-center">
                                                        {{-- Complete --}}
                                                        @if($canComplete)
                                                            <form action="{{ route('completeAppointment', $appointment->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" title="Mark as Completed">
                                                                    Complete
                                                                </button>
                                                            </form>
                                                        @elseif($appointment->status == '3')
                                                            <span class="text-success small fw-bold"><i class="fas fa-check-double mr-1"></i> Finished</span>
                                                        @endif

                                                        {{-- Cancel --}}
                                                        @if($appointment->status != '3' && $appointment->status != '2' && !$isExpired)
                                                            <form action="{{ route('cancelAppointment', $appointment->id) }}" method="POST" onsubmit="return confirm('Cancel this appointment?');">
                                                                @csrf
                                                                <button type="submit" class="btn-action-modern badge-soft-danger" title="Cancel">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

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
                    display.classList.add('text-danger');
                    display.classList.remove('text-success');
                } else if (now >= start && now <= end) {
                    // Ongoing
                    display.innerText = "Ongoing";
                    display.classList.remove('text-danger');
                    display.classList.add('text-success');
                } else {
                    // Ended
                    display.innerText = "Ended";
                    display.classList.remove('text-danger', 'text-success');
                    display.style.color = '#6c757d';
                    display.style.fontSize = '14px';
                }
            });
        }

        // Initialize and run every second
        setInterval(updateCountdowns, 1000);
        updateCountdowns();
    </script>
@endpush