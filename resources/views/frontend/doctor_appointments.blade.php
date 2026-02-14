@extends('frontend.layout')

@section('content')
    <style>
        /* Card Container */
        .appointment-card {
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }
        .appointment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        /* Profile & Header */
        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .profile-section {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .profile-img {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #eef2f6;
        }
        .profile-info h5 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 2px;
            display: inline-block;
        }
        .profile-meta {
            font-size: 0.85rem;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .profile-meta i {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        /* Payment Badge */
        .badge-payment {
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 100px;
            text-align: center;
            margin-top: 7px;
        }
        .badge-markPaid {
            padding: 5px 10px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 100px;
            text-align: center;
            margin-top: 7px;
            height: 35px;
        }
        .badge-payment.paid { background: #d1e7dd; color: #0f5132; }
        .badge-payment.unpaid { background: #fad7d7; color: #842029; }
        .badge-payment.health_card { background: #cff4fc; color: #055160; }
        
        /* Appointment Status Badge (Equal Style) */
        .badge-status {
            padding: 5px 10px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 135px;
            text-align: center;
            display: inline-block;
        }
        .badge-status.pending { background: #fff3cd; color: #856404; }
        .badge-status.confirmed { background: #d1e7dd; color: #0f5132; }
        .badge-status.cancelled { background: #f8d7da; color: #721c24; }
        .badge-status.completed { background: #cfe2ff; color: #084298; }

        /* Reported Problem */
        .problem-section {
            margin-bottom: 20px;
        }
        .problem-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: #adb5bd;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 5px;
        }
        .problem-text {
            font-size: 0.95rem;
            color: #495057;
            line-height: 1.5;
        }

        /* Date Time Pill Box */
        .date-time-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 50px;
            padding: 12px 20px;
            margin-bottom: 20px;
        }
        .dt-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #34495e;
        }
        .dt-divider {
            width: 1px;
            height: 20px;
            background: #dee2e6;
        }
        .dt-item i {
            color: #6c757d;
        }

        /* Confirm Button */
        .btn-confirm-appt {
            width: 100%;
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            margin-bottom: 15px;
        }
        .btn-confirm-appt:hover {
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            transform: translateY(-1px);
        }

        /* Pastel Action Buttons */
        .action-row {
            display: flex;
            gap: 12px;
        }
        .btn-pastel {
            flex: 1;
            height: 48px;
            border-radius: 12px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-pastel i {
            font-size: 1.2rem;
        }
        .btn-pastel:hover:not(:disabled) {
            transform: translateY(-3px);
            filter: brightness(0.95);
        }

        /* Colors */
        /* Chat: Light Grayish Blue */
        .btn-pastel-chat { background: #f1f3f5; color: #495057; }
        
        /* Call: Light Green */
        .btn-pastel-call { background: #d1e7dd; color: #198754; }
        
        /* Video: Light Blue */
        .btn-pastel-video { background: #cff4fc; color: #0dcaf0; } /* Bootstrap info-ish */
        
        /* Complete: Light Purple */
        .btn-pastel-complete { background: #e0cffc; color: #6f42c1; }

        /* Cancel: Light Red */
        .btn-pastel-cancel { background: #fad7d7; color: #dc3545; }

        /* Disabled State */
        .btn-pastel:disabled, .btn-pastel.disabled {
            background: #f8f9fa;
            color: #dee2e6;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
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
                                            $isExpired = $now->gt($slotEndTime) && !$isPendingOrConfirmed; 
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
                                            $canCancel = $isFutureActive && $isPaid;

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
                                            <div class="appointment-card">
                                                
                                                <!-- Header: Profile & Payment Badge -->
                                                <div class="card-header-flex">
                                                    <div class="profile-section">
                                                        <img src="{{ $appointment->patient_photo ? asset('public/assets/images/profiles/' . $appointment->patient_photo) : 'https://ui-avatars.com/api/?name=' . $appointment->patient_first_name . '+' . $appointment->patient_last_name . '&background=0D8ABC&color=fff' }}"
                                                             alt="Profile" class="profile-img">
                                                        <div class="profile-info">
                                                            <h5>{{ $appointment->patient_first_name }} {{ $appointment->patient_last_name }}</h5>
                                                            @if($paymentStatus != 'paid' && $paymentStatus != 'health_card')
                                                            * <span class="badge-status text-danger" style="min-width: auto;margin-left: 5px;">UNPAID</span>
                                                            @endif
                                                            
                                                            <div class="profile-meta">
                                                                @if($gender || $age)
                                                                    <span>
                                                                        @if($gender == '1') <i class="fas fa-mars"></i> Male
                                                                        @elseif($gender == '2') <i class="fas fa-venus"></i> Female 
                                                                        @endif
                                                                        • {{ $age }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="profile-meta" style="margin-top: 2px;">
                                                                <i class="fas fa-phone-alt"></i> {{ $appointment->patient_mobile }}
                                                            </div>
                                                            <!-- Date & Time Pill Box -->
                                                            <div class="date-time-box" style="border: 0; padding: 0; margin: 0; gap: 5px; justify-content: start; background: #fff;">
                                                                <div class="dt-item" style=" color: #6c757d; font-size: 13px; ">
                                                                    <!-- <i class="far fa-calendar-alt"></i> -->
                                                                    {{ $apptDateTime->format('d M, Y') }}
                                                                </div>
                                                                <div class="dt-divider"></div>
                                                                <div class="dt-item" style=" color: #6c757d; font-size: 13px; ">
                                                                    <!-- <i class="far fa-clock"></i> -->
                                                                    {{ $apptDateTime->format('h:i A') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Right Side: Status & Payment (Vertical Stack) -->
                                                    <div class="d-flex flex-column align-items-end gap-2">
                                                        <!-- Appointment Status -->
                                                        @if($appointment->status == '0')
                                                            <span class="badge-status pending" style=" position: absolute; left: -28px; transform: rotate(-45deg); ">PENDING</span>
                                                        @elseif($appointment->status == '1')
                                                            <span class="badge-status confirmed" style=" position: absolute; left: -28px; transform: rotate(-45deg); ">CONFIRMED</span>
                                                        @elseif($appointment->status == '2')
                                                            <span class="badge-status cancelled" style=" position: absolute; left: -28px; transform: rotate(-45deg); ">CANCELLED</span>
                                                        @elseif($appointment->status == '3')
                                                            <span class="badge-status completed" style=" position: absolute; left: -28px; transform: rotate(-45deg); ">COMPLETED</span>
                                                        @endif

                                                        <!-- Payment Badge -->
                                                        @if($paymentStatus == 'paid')
                                                            <span class="badge-payment paid">PAID</span>
                                                        @elseif($paymentStatus == 'health_card')
                                                            <span class="badge-payment health_card">HEALTH CARD</span>
                                                        @else
                                                            <div class="d-flex flex-column align-items-end gap-1">
                                                                @if($appointment->status != '2' && !$isExpired)
                                                                    <form action="{{ route('markAppointmentPaid', $appointment->id) }}" method="POST"
                                                                        onsubmit="return confirm('Mark this appointment as PAID manually?');">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm badge-markPaid">
                                                                            Mark Paid
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        <!-- Payment Mode Display -->
                                                        @if(!empty($appointment->payment_mode))
                                                            <small class="text-muted fw-bold" style="font-size: 0.7rem; margin-top: -2px;">
                                                                Via {{ $appointment->payment_mode }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Problem Section -->
                                                <div class="problem-section">
                                                    <span class="problem-label">Reported Problem</span>
                                                    <p class="problem-text mb-2">
                                                        {{ Str::limit($appointment->note, 80, '...') }}
                                                    </p>
                                                    @if(!empty($appointment->referral_file))
                                                        <div class="mt-2">
                                                            <a href="{{ asset('public/assets/images/referrals/' . $appointment->referral_file) }}" target="_blank" class="text-decoration-none" style="font-size: 0.85rem; font-weight: 500;">
                                                                <i class="fas fa-paperclip me-1 text-primary" style="font-size: 0.85rem; font-weight: 500;"></i> View Referral Document
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Date & Time Pill Box -->
                                                <div class="date-time-box" style="
                                                position: absolute;
                                                right: 6%;
                                                top: 25%;
                                                /* border-bottom-right-radius: 0; */
                                                /* border-top-right-radius: 0; */
                                                border-right: 0;
                                            ">
                                                    <div class="dt-item">
                                                        01:15 </div>
                                                </div>

                                                <!-- Confirm Button (If Status 0) -->
                                                @if($appointment->status == '0')
                                                    <form action="{{ route('confirmAppointment', $appointment->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn-confirm-appt" {{ !$isPaid ? 'disabled title=Payment_Required style=opacity:0.6' : '' }}>
                                                            <i class="fas fa-check-circle"></i> Confirm Appointment
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Action Buttons Row -->
                                                <div class="action-row">
                                                    
                                                    {{-- 1. Chat --}}
                                                    @if($canChat)
                                                        <a href="/messages" class="btn-pastel btn-pastel-chat" title="Chat">
                                                            <i class="fas fa-comment-dots"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn-pastel btn-pastel-chat" disabled title="{{ !$isSessionTime ? 'Available 5 mins before appointment' : 'Unavailable' }}">
                                                            <i class="fas fa-comment-dots"></i>
                                                        </button>
                                                    @endif

                                                    {{-- 2. Call --}}
                                                    @if(!empty($appointment->patient_mobile) && $canCallVideo)
                                                        <a href="tel:{{ $appointment->patient_mobile }}" class="btn-pastel btn-pastel-call" title="Call">
                                                            <i class="fas fa-phone-alt"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn-pastel btn-pastel-call" disabled title="{{ !$isPaid ? 'Payment Required' : 'Available during session' }}">
                                                            <i class="fas fa-phone-alt"></i>
                                                        </button>
                                                    @endif

                                                    {{-- 3. Video --}}
                                                    @if(!empty($appointment->meeting_link) && $canCallVideo)
                                                         @php
                                                            $meetingUrl = $appointment->meeting_provider == 'whatsapp' ? 'https://wa.me/' . $appointment->meeting_link : $appointment->meeting_link;
                                                        @endphp
                                                        <a href="{{ $meetingUrl }}" target="_blank" class="btn-pastel btn-pastel-video" title="Video Call">
                                                            <i class="fas fa-video"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn-pastel btn-pastel-video" disabled title="{{ !$isPaid ? 'Payment Required' : 'Available during session' }}">
                                                            <i class="fas fa-video"></i>
                                                        </button>
                                                    @endif
                                                    
                                                    {{-- Complete (If Confirmed & Active) OR Show Completed State --}}
                                                    @if($canComplete)
                                                        <form action="{{ route('completeAppointment', $appointment->id) }}" method="POST" style="flex:1; display:flex;">
                                                            @csrf
                                                            <button type="submit" class="btn-pastel btn-pastel-complete" title="Mark as Completed" style="width:100%;">
                                                                <i class="fas fa-check-circle"></i>
                                                            </button>
                                                        </form>
                                                    @elseif($appointment->status == '3')
                                                        {{-- Completed State Indicator --}}
                                                        <button class="btn-pastel btn-pastel-complete" disabled title="Appointment Completed" style="opacity: 0.7;">
                                                            <i class="fas fa-check-double"></i>
                                                        </button>
                                                    @endif

                                                    {{-- 4. Cancel (Hidden if Completed) --}}
                                                    @if($appointment->status != '3')
                                                        @if($canCancel)
                                                            <form action="{{ route('cancelAppointment', $appointment->id) }}" method="POST" style="flex:1; display:flex;"
                                                                  onsubmit="return confirm('Cancel this appointment?');">
                                                                @csrf
                                                                <button type="submit" class="btn-pastel btn-pastel-cancel" title="Cancel" style="width:100%;">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button class="btn-pastel btn-pastel-cancel" disabled title="{{ !$isPaid ? 'Payment Required' : 'Cannot Cancel' }}">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                    @endif

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