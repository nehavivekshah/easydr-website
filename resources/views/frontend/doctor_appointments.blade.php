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
                            <h5>My Appointments</h5>
                            <div style="background: #fff; padding: 25px; border-radius: 5px; box-shadow: var(--shadow-sm);">
                                @if(isset($appointments) && count($appointments) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Patient</th>
                                                    <th>Problem</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                                        $sessionStartTime = $apptDateTime->copy()->subMinutes(5);
                                                        $isSessionActive = $now->between($sessionStartTime, $slotEndTime) && $appointment->status == '1';

                                                        // Expired after slot ends
                                                        $isExpired = $now->gt($slotEndTime) && $appointment->status != '3' && $appointment->status != '2';
                                                        $isOnTime = $isSessionActive; 
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $apptDateTime->format('d M, Y') }}</td>
                                                        <td>{{ $apptDateTime->format('h:i A') }}</td>
                                                        <td>
                                                            {{ $appointment->patient_first_name }}
                                                            {{ $appointment->patient_last_name }}
                                                            <br>
                                                            <small class="text-muted">{{ $appointment->patient_mobile }}</small>
                                                        </td>
                                                        <td>{{ Str::limit($appointment->note, 30) }}</td>
                                                        <td>
                                                            @if($appointment->status == '0')
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            @elseif($appointment->status == '1')
                                                                <span class="badge bg-success">Confirmed</span>
                                                            @elseif($appointment->status == '2')
                                                                <span class="badge bg-danger">Cancelled</span>
                                                            @elseif($isExpired)
                                                                <span class="badge bg-secondary">Expired</span>
                                                            @else
                                                                <span class="badge bg-info">Completed</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                {{-- Join Button --}}
                                                                @if(!empty($appointment->meeting_link) && $appointment->status == '1' && $isOnTime && !$isExpired)
                                                                    <a href="{{ $appointment->meeting_provider == 'whatsapp' ? 'https://wa.me/' . $appointment->meeting_link : $appointment->meeting_link }}"
                                                                        target="_blank" class="btn btn-sm btn-info text-white"
                                                                        title="Join Meeting">
                                                                        <i class="fas fa-video"></i> Join
                                                                    </a>
                                                                @else
                                                                    <button class="btn btn-sm btn-secondary" disabled
                                                                        title="Meeting not active">
                                                                        <i class="fas fa-video"></i>
                                                                    </button>
                                                                @endif

                                                                {{-- Cancel Button --}}
                                                                @if(!$isExpired && ($appointment->status == '0' || $appointment->status == '1'))
                                                                    <form action="{{ route('cancelAppointment', $appointment->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Cancel this appointment?');">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                            title="Cancel">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <button class="btn btn-sm btn-outline-danger" disabled
                                                                        title="Cannot cancel">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <p class="text-muted mb-3">No appointments found.</p>
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