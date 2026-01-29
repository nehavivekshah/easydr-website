@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
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
                                        <div class="col-lg-6 col-md-12 mb-4 wow fadeInUp">
                                            <div class="appointment-card">
                                                {{-- Status Badge --}}
                                                @if($appointment->status == '0')
                                                    <span class="appointment-status-badge status-upcoming">Pending</span>
                                                @elseif($appointment->status == '1')
                                                    <span class="appointment-status-badge status-upcoming">Confirmed</span>
                                                @elseif($appointment->status == '2')
                                                    <span class="appointment-status-badge status-cancelled">Cancelled</span>
                                                @elseif($appointment->status == '3')
                                                    <span class="appointment-status-badge status-completed">Completed</span>
                                                @else
                                                    <span class="appointment-status-badge status-expired">Expired</span>
                                                @endif

                                                {{-- Header --}}
                                                <div class="appointment-header">
                                                    <div class="appointment-img-wrapper">
                                                        <img src="{{ $appointment->doctor_photo ? asset('public/assets/images/doctors/' . $appointment->doctor_photo) : 'https://ui-avatars.com/api/?name='.$appointment->doctor_first_name.'+'.$appointment->doctor_last_name.'&background=0D8ABC&color=fff' }}"
                                                             alt="{{ $appointment->doctor_first_name }}">
                                                    </div>
                                                    <div class="appointment-info">
                                                        <h5>Dr. {{ $appointment->doctor_first_name }} {{ $appointment->doctor_last_name }}</h5>
                                                        <p>{{ $appointment->specialist ?? 'General' }}</p>
                                                    </div>
                                                </div>

                                                {{-- Date Time --}}
                                                <div class="appointment-datetime">
                                                    {{ \Carbon\Carbon::parse($appointment->date)->format('d M, Y') }} | {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                                                </div>

                                                {{-- Action Buttons --}}
                                                <div class="appointment-actions">
                                                    <a href="/messages" class="action-btn btn-chat" title="Message">
                                                        <i class="fas fa-comment-alt"></i>
                                                    </a>
                                                    
                                                    {{-- Call Button --}}
                                                    <a href="tel:{{ $appointment->doctor_phone ?? '#' }}" class="action-btn btn-call" title="Call">
                                                        <i class="fas fa-phone-alt"></i>
                                                    </a>

                                                    {{-- Video Button (Only if link is available) --}} 
                                                    @if(!empty($appointment->meeting_link) && $appointment->status == '1')
                                                        @if($appointment->meeting_provider == 'whatsapp')
                                                            <a href="https://wa.me/{{ $appointment->meeting_link }}" target="_blank" class="action-btn btn-video" title="WhatsApp Video">
                                                                <i class="fab fa-whatsapp"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ $appointment->meeting_link }}" target="_blank" class="action-btn btn-video" title="Video Call">
                                                                <i class="fas fa-video"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <button class="action-btn btn-video" disabled style="opacity: 0.5; cursor: not-allowed;">
                                                            <i class="fas fa-video-slash"></i>
                                                        </button>
                                                    @endif

                                                    {{-- Cancel Button --}}
                                                    @if($appointment->status == '0' || $appointment->status == '1')
                                                        <form action="{{ route('cancelAppointment', $appointment->id) }}" method="POST" class="flex-grow-1" style="flex: 1; display: flex;" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                                            @csrf
                                                            <button type="submit" class="action-btn btn-cancel" title="Cancel Appointment" style="width: 100%;">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                         <button class="action-btn btn-cancel" disabled style="opacity: 0.5; cursor: not-allowed;">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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