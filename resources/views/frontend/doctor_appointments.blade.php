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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($appointments as $appointment)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d M, Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                                                        <td>
                                                            {{ $appointment->patient_first_name }}
                                                            {{ $appointment->patient_last_name }}
                                                            <br>
                                                            <small class="text-muted">{{ $appointment->patient_mobile }}</small>
                                                        </td>
                                                        <td>{{ Str::limit($appointment->note, 30) }}</td> {{-- Mobile app uses
                                                        'problem', we use 'note' --}}
                                                        <td>
                                                            @if($appointment->status == '0')
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            @elseif($appointment->status == '1')
                                                                <span class="badge bg-success">Confirmed</span>
                                                            @elseif($appointment->status == '2')
                                                                <span class="badge bg-danger">Cancelled</span>
                                                            @else
                                                                <span class="badge bg-secondary">Completed</span>
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