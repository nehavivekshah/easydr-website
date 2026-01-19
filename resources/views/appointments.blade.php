@extends('layout')
@section('title', ($pagename ?? 'Appointments') . ' - Easy Doctor')


@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
        $no_doc = 'No Family Doctor Assigned';
    @endphp

    <section class="task__section">
        <div class="text">
            {{ $pagename ?? '' }}
            <div class="bradcrum">
                Home / Appointments / {{ $pagename ?? '' }}
            </div>
        </div>

        <div class="container-fluid mb-3">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    @if(in_array('permission_add', $roleArray) || in_array('All', $roleArray))
                        <div class="btn-group">
                            <a href="/admin/manage-appointment" class="btn btn-default btn-sm">
                                <i class="bx bx-plus"></i> <span>Add New</span>
                            </a>
                        </div>
                    @else
                        <div></div>
                    @endif

                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-secondary" title="Export to PDF">
                            <i class="bx bx-download"></i> Export
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pb-3 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th width="70px">Sr. No.</th>
                                @if(Request::segment(2) == 'patient-appointment-history' || Request::segment(2) == 'upcoming-appointments' || Request::segment(2) == 'appointment-history')
                                    <th>Patient</th>
                                    <th>Family Doctor</th>
                                    <th>Medical File</th>
                                    <th>Health Card</th>
                                    <th>Consulting Doctor</th>
                                @endif

                                @if(Request::segment(2) == 'doctor-appointment-history')
                                    <th>Doctor Name</th>
                                @endif
                                <th>Schedule Time</th>

                                @if(Request::segment(2) == 'doctor-appointment-history')
                                    <th>Patient</th>
                                @endif

                                <th class="text-center">Payment Mode</th>
                                <th class="text-center">Payment Status</th>
                                <th class="text-center">Status</th>
                                @if(Request::segment(2) == 'upcoming-appointments')
                                    <th class="text-center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $k => $appointment)
                                <tr>
                                    <td>{{ $k + 1 }}</td>

                                    @if(Request::segment(2) == 'patient-appointment-history' || Request::segment(2) == 'upcoming-appointments' || Request::segment(2) == 'appointment-history')
                                        <td>
                                            {{ $appointment->patient_first_name ?? '--' }}
                                            {{ $appointment->patient_last_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $appointment->famdoctor_first_name ?? $no_doc }}
                                            {{ $appointment->famdoctor_last_name ?? '' }}
                                        </td>
                                        <td>
                                            <a href="{{ !empty($appointment->medical_file) ? asset('public/assets/images/medicals/' . $appointment->medical_file) : '#' }}"
                                                target="{{ !empty($appointment->medical_file) ? '_blank' : '' }}"
                                                class="btn btn-link btn-sm font-weight-bold {{ empty($appointment->medical_file) ? 'text-muted disabled' : 'text-primary' }}"
                                                title="{{ !empty($appointment->medical_file) ? 'View Medical File' : 'No Medical File Available' }}">
                                                View File
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ !empty($appointment->health_card_file) ? asset('public/assets/images/healthCards/' . $appointment->health_card_file) : '#' }}"
                                                target="{{ !empty($appointment->health_card_file) ? '_blank' : '' }}"
                                                class="btn btn-link btn-sm font-weight-bold {{ empty($appointment->health_card_file) ? 'text-muted disabled' : 'text-primary' }}"
                                                title="{{ !empty($appointment->health_card_file) ? 'View Health Card' : 'No Health Card Available' }}">
                                                View Card
                                            </a>
                                        </td>
                                    @endif

                                    @if(Request::segment(2) == 'doctor-appointment-history' || Request::segment(2) == 'upcoming-appointments' || Request::segment(2) == 'appointment-history' || Request::segment(2) == 'patient-appointment-history')
                                        <td>
                                            {{ $appointment->doctor_first_name ?? '--' }}
                                            {{ $appointment->doctor_last_name ?? '' }}<br><span
                                                class="text-danger small">({{ $appointment->specialist ?? '' }})</span>
                                        </td>
                                    @endif

                                    <td>
                                        {{ !empty($appointment->date) ? \Carbon\Carbon::createFromFormat('Y-m-d', $appointment->date)->format('d M, Y') : '--' }}
                                        <span class="text-primary">-</span>
                                        {{ !empty($appointment->time) ? \Carbon\Carbon::createFromFormat('H:i:s', $appointment->time)->format('h:i A') : '--' }}
                                    </td>

                                    @if(Request::segment(2) == 'doctor-appointment-history')
                                        <td>
                                            {{ $appointment->patient_first_name ?? '--' }}
                                            {{ $appointment->patient_last_name ?? '' }}
                                        </td>
                                    @endif
                                    <td class="text-center">
                                        {{ $appointment->payment_mode ?? '--' }}
                                    </td>
                                    <td class="text-center">
                                        @if($appointment->payment_status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @else
                                            <span class="badge bg-danger">Unpaid</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($appointment->status === 1)
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($appointment->status === 2)
                                            <span class="badge bg-danger">Cancelled</span>
                                        @elseif($appointment->status === 0 && ($appointment->date < now()->toDateString() || ($appointment->date === now()->toDateString() && $appointment->time < now()->format('H:i'))))
                                            <span class="badge bg-danger">Expired</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    @if(Request::segment(2) == 'upcoming-appointments')
                                        <td class="text-center">
                                            @if(in_array('permission_edit', $roleArray) || in_array('All', $roleArray))
                                                <a href="/admin/manage-appointment?id={{ $appointment->id }}"
                                                    class="btn btn-sm {{ ($appointment->status === 2) ? 'text-muted disabled' : 'btn-info' }}"
                                                    title="Edit Appointment">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                            @endif

                                            @if(in_array('permission_delete', $roleArray) || in_array('All', $roleArray))
                                                <form action="/admin/cancel-appointment/{{ $appointment->id }}" method="POST"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn {{ ($appointment->status === 2) ? 'text-muted disabled' : 'btn-danger' }} btn-sm"
                                                        title="Cancel Appointment">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection