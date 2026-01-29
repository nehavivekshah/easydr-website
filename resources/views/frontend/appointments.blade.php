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

                            <div style="background: #fff; padding: 25px; border-radius: 5px; box-shadow: var(--shadow-sm);">
                                @if(isset($appointments) && count($appointments) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Doctor</th>
                                                    <th>Problem</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($appointments as $appointment)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d M, Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                                                        <td>
                                                            Dr. {{ $appointment->doctor_first_name }}
                                                            {{ $appointment->doctor_last_name }}
                                                            <small class="d-block text-muted">{{ $appointment->specialist }}</small>
                                                        </td>
                                                        <td>{{ Str::limit($appointment->note, 30) }}</td>
                                                        <td>
                                                            @if($appointment->status == '0')
                                                                <span class="badge bg-warning">Pending</span>
                                                            @elseif($appointment->status == '1')
                                                                <span class="badge bg-success">Confirmed</span>
                                                            @elseif($appointment->status == '2')
                                                                <span class="badge bg-danger">Cancelled</span>
                                                            @else
                                                                <span class="badge bg-secondary">Completed</span>
                                                            @endif

                                                            @if($appointment->status == '0')
                                                                <form action="{{ route('cancelAppointment', $appointment->id) }}"
                                                                    method="POST" class="d-inline-block ms-2"
                                                                    onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-outline-danger">Cancel</button>
                                                                </form>
                                                            @endif

                                                            @if(!empty($appointment->meeting_link) && $appointment->status == '1')
                                                                <div class="mt-2">
                                                                    @if($appointment->meeting_provider == 'google_meet')
                                                                        <a href="{{ $appointment->meeting_link }}" target="_blank"
                                                                            class="btn btn-sm btn-outline-primary">
                                                                            <i class="bi bi-camera-video"></i> Join Meet
                                                                        </a>
                                                                    @elseif($appointment->meeting_provider == 'whatsapp')
                                                                        <a href="https://wa.me/{{ $appointment->meeting_link }}"
                                                                            target="_blank" class="btn btn-sm btn-outline-success">
                                                                            <i class="bi bi-whatsapp"></i> WhatsApp Call
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <p class="text-muted mb-3">No appointments found.</p>
                                        <a href="/manage-appointment" class="btn btn-outline-primary">Book your first
                                            appointment</a>
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