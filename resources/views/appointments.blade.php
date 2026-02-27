@extends('layout')
@section('title', ($pagename ?? 'Appointments') . ' - Easy Doctor')

@push('styles')
    <style>
        .page-header-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        /* ---- Card Table ---- */
        .card-table-wrap {
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .card-table-wrap .table {
            margin: 0;
        }

        .card-table-wrap .table thead th {
            background: #f8f9fb;
            font-size: .73rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #2563eb;
            border-bottom: 2px solid #dbeafe;
            padding: 12px 14px;
            white-space: nowrap;
        }

        .card-table-wrap .table tbody td {
            padding: 11px 14px;
            vertical-align: middle;
            font-size: .86rem;
            color: #374151;
        }

        .card-table-wrap .table tbody tr:hover {
            background: #f8f9fb;
        }

        .card-table-wrap .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ---- Person chip ---- */
        .person-chip {
            display: flex;
            flex-direction: column;
        }

        .person-name-main {
            font-weight: 700;
            font-size: .88rem;
            color: #1e293b;
        }

        .person-sub {
            font-size: .75rem;
            color: #dc2626;
            margin-top: 1px;
        }

        /* ---- Family doctor ---- */
        .fam-doc {
            font-size: .82rem;
            color: #64748b;
            font-style: italic;
        }

        /* ---- File/card links ---- */
        .btn-file-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #f0f9ff;
            color: #0ea5e9;
            border: 1.5px solid #bae6fd;
            border-radius: 50px;
            padding: 3px 10px;
            font-size: .76rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .18s;
        }

        .btn-file-link:hover {
            background: #e0f2fe;
            color: #0284c7;
        }

        .btn-file-link.disabled {
            background: #f1f5f9;
            color: #94a3b8;
            border-color: #e2e8f0;
            pointer-events: none;
        }

        /* ---- Schedule ---- */
        .schedule-cell {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .schedule-date {
            font-size: .82rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .schedule-time {
            font-size: .78rem;
            color: #6d28d9;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ---- Payment mode ---- */
        .pay-mode {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f0f4ff;
            border: 1px solid #c7d2fe;
            border-radius: 7px;
            padding: 3px 9px;
            font-size: .78rem;
            font-weight: 600;
            color: #4338ca;
        }

        /* ---- Payment status ---- */
        .badge-paid {
            background: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            border-radius: 50px;
            padding: 3px 11px;
            font-size: .75rem;
            font-weight: 700;
        }

        .badge-unpaid {
            background: #fff1f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 50px;
            padding: 3px 11px;
            font-size: .75rem;
            font-weight: 700;
        }

        /* ---- Appt status ---- */
        .badge-completed {
            background: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            border-radius: 50px;
            padding: 3px 11px;
            font-size: .75rem;
            font-weight: 700;
        }

        .badge-cancelled {
            background: #fff1f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 50px;
            padding: 3px 11px;
            font-size: .75rem;
            font-weight: 700;
        }

        .badge-expired {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: 3px 11px;
            font-size: .75rem;
            font-weight: 700;
        }

        .badge-pending {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde68a;
            border-radius: 50px;
            padding: 3px 11px;
            font-size: .75rem;
            font-weight: 700;
        }

        /* ---- Action buttons ---- */
        .btn-add {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 9px 22px;
            font-weight: 600;
            font-size: .88rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, .3);
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-add:hover {
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-export {
            background: #fff;
            color: #374151;
            border: 1.5px solid #d1d5db;
            border-radius: 50px;
            padding: 9px 20px;
            font-weight: 600;
            font-size: .88rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-tbl-edit {
            background: #eff6ff;
            color: #2563eb;
            border: 1.5px solid #bfdbfe;
            border-radius: 50px;
            padding: 5px 11px;
            font-size: .79rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all .18s;
        }

        .btn-tbl-edit:hover {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-tbl-edit.disabled {
            opacity: .4;
            pointer-events: none;
        }

        .btn-tbl-del {
            background: #fff1f2;
            color: #dc2626;
            border: 1.5px solid #fecaca;
            border-radius: 50px;
            padding: 5px 11px;
            font-size: .79rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            transition: all .18s;
        }

        .btn-tbl-del:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-tbl-del.disabled {
            opacity: .4;
            pointer-events: none;
        }
    </style>
@endpush

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
        $no_doc = 'No Family Doctor Assigned';
        $seg = Request::segment(2);
        $isGeneral = in_array($seg, ['appointment-history', 'patient-appointment-history', 'upcoming-appointments']);
        $isDoctor = $seg === 'doctor-appointment-history';
        $isUpcoming = $seg === 'upcoming-appointments';
        $canEdit = in_array('permission_edit', $roleArray) || in_array('All', $roleArray);
        $canDelete = in_array('permission_delete', $roleArray) || in_array('All', $roleArray);
    @endphp

    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">{{ $pagename ?? 'Appointments' }}</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active text-muted">{{ $pagename ?? 'Appointments' }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if(in_array('permission_add', $roleArray) || in_array('All', $roleArray))
                        <a href="/admin/manage-appointment" class="btn-add">
                            <i class="bx bx-plus"></i> Add New
                        </a>
                    @endif
                    <button class="btn-export" title="Export to PDF">
                        <i class="bx bx-download"></i> Export
                    </button>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="card-table-wrap">
                <div class="table-responsive">
                    <table id="lists" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:4%">#</th>

                                @if($isGeneral)
                                    <th>Patient</th>
                                    <th>Family Doctor</th>
                                    <th class="text-center">Medical File</th>
                                    <th class="text-center">Health Card</th>
                                    <th>Consulting Doctor</th>
                                @endif

                                @if($isDoctor)
                                    <th>Doctor Name</th>
                                @endif

                                <th>Schedule</th>

                                @if($isDoctor)
                                    <th>Patient</th>
                                @endif

                                <th class="text-center">Payment Mode</th>
                                <th class="text-center">Payment</th>
                                <th class="text-center">Status</th>

                                @if($isUpcoming)
                                    <th class="text-center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $k => $appointment)
                                @php
                                    $nowDate = now()->toDateString();
                                    $nowTime = now()->format('H:i');
                                    $isExpiredAppt = $appointment->status === 0 && (
                                        $appointment->date < $nowDate ||
                                        ($appointment->date === $nowDate && $appointment->time < $nowTime)
                                    );
                                @endphp
                                <tr>
                                    <td class="fw-semibold text-muted">{{ $k + 1 }}</td>

                                    @if($isGeneral)
                                        <td>
                                            <div class="person-chip">
                                                <span class="person-name-main">
                                                    {{ $appointment->patient_first_name ?? '--' }}
                                                    {{ $appointment->patient_last_name ?? '' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fam-doc">
                                                <i class="bx bx-heart text-danger" style="font-size:.85rem;"></i>
                                                {{ trim(($appointment->famdoctor_first_name ?? '') . ' ' . ($appointment->famdoctor_last_name ?? '')) ?: $no_doc }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if(!empty($appointment->medical_file))
                                                <a href="{{ asset('public/assets/images/medicals/' . $appointment->medical_file) }}"
                                                    target="_blank" class="btn-file-link" title="View Medical File">
                                                    <i class="bx bx-file"></i> View
                                                </a>
                                            @else
                                                <span class="btn-file-link disabled"><i class="bx bx-file"></i> None</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(!empty($appointment->health_card_file))
                                                <a href="{{ asset('public/assets/images/healthCards/' . $appointment->health_card_file) }}"
                                                    target="_blank" class="btn-file-link" title="View Health Card">
                                                    <i class="bx bx-id-card"></i> View
                                                </a>
                                            @else
                                                <span class="btn-file-link disabled"><i class="bx bx-id-card"></i> None</span>
                                            @endif
                                        </td>
                                    @endif

                                    @if($isDoctor || $isGeneral)
                                        <td>
                                            <div class="person-chip">
                                                <span class="person-name-main">
                                                    {{ $appointment->doctor_first_name ?? '--' }}
                                                    {{ $appointment->doctor_last_name ?? '' }}
                                                </span>
                                                @if($appointment->specialist)
                                                    <span class="person-sub">{{ $appointment->specialist }}</span>
                                                @endif
                                            </div>
                                        </td>
                                    @endif

                                    <td>
                                        <div class="schedule-cell">
                                            <div class="schedule-date">
                                                <i class="bx bx-calendar" style="color:#2563eb;"></i>
                                                {{ !empty($appointment->date) ? \Carbon\Carbon::createFromFormat('Y-m-d', $appointment->date)->format('d M, Y') : '--' }}
                                            </div>
                                            <div class="schedule-time">
                                                <i class="bx bx-time"></i>
                                                {{ !empty($appointment->time) ? \Carbon\Carbon::createFromFormat('H:i:s', $appointment->time)->format('h:i A') : '--' }}
                                            </div>
                                        </div>
                                    </td>

                                    @if($isDoctor)
                                        <td>
                                            {{ $appointment->patient_first_name ?? '--' }}
                                            {{ $appointment->patient_last_name ?? '' }}
                                        </td>
                                    @endif

                                    <td class="text-center">
                                        @if($appointment->payment_mode)
                                            <span class="pay-mode">
                                                <i class="bx bx-credit-card"></i>
                                                {{ $appointment->payment_mode }}
                                            </span>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if($appointment->payment_status === 'paid')
                                            <span class="badge-paid">✓ Paid</span>
                                        @else
                                            <span class="badge-unpaid">✕ Unpaid</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if($appointment->status === 1)
                                            <span class="badge-completed">✓ Completed</span>
                                        @elseif($appointment->status === 2)
                                            <span class="badge-cancelled">✕ Cancelled</span>
                                        @elseif($isExpiredAppt)
                                            <span class="badge-expired">⌛ Expired</span>
                                        @else
                                            <span class="badge-pending">⏳ Pending</span>
                                        @endif
                                    </td>

                                    @if($isUpcoming)
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-1">
                                                @if($canEdit)
                                                    <a href="/admin/manage-appointment?id={{ $appointment->id }}"
                                                        class="btn-tbl-edit {{ ($appointment->status === 2) ? 'disabled' : '' }}"
                                                        title="Edit Appointment">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </a>
                                                @endif
                                                @if($canDelete)
                                                    <form action="/admin/cancel-appointment/{{ $appointment->id }}" method="POST"
                                                        class="d-inline m-0 p-0"
                                                        onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn-tbl-del {{ ($appointment->status === 2) ? 'disabled' : '' }}"
                                                            title="Cancel Appointment">
                                                            <i class="bx bx-x"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center py-5 text-muted">
                                        <i class="bx bx-calendar-x" style="font-size:2.5rem;color:#bfdbfe;"></i>
                                        <p class="mt-2 mb-0 fw-semibold">No appointments found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection