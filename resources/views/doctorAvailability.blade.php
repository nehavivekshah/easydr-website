@extends('layout')
@section('title', 'Doctor Availability Slots - Easy Doctor')

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
            font-size: .74rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #2563eb;
            border-bottom: 2px solid #dbeafe;
            padding: 13px 16px;
            white-space: nowrap;
        }

        .card-table-wrap .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            font-size: .87rem;
            color: #374151;
        }

        .card-table-wrap .table tbody tr:hover {
            background: #f8f9fb;
        }

        .card-table-wrap .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ---- Doctor avatar ---- */
        .doctor-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #dbeafe;
            box-shadow: 0 2px 6px rgba(37, 99, 235, .15);
        }

        /* ---- Doctor name cell ---- */
        .doctor-name-main {
            font-weight: 700;
            font-size: .9rem;
            color: #1e293b;
        }

        .doctor-specialist {
            font-size: .76rem;
            color: #64748b;
            margin-top: 1px;
        }

        /* ---- Date range ---- */
        .date-range {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .date-range-line {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: .8rem;
            color: #475569;
        }

        .date-range-sep {
            font-size: .72rem;
            color: #94a3b8;
            margin-left: 18px;
        }

        /* ---- Days pills ---- */
        .days-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 3px;
            max-width: 180px;
        }

        .day-pill {
            background: #ede9fe;
            border: 1px solid #c4b5fd;
            border-radius: 5px;
            padding: 1px 6px;
            font-size: .72rem;
            font-weight: 600;
            color: #6d28d9;
        }

        /* ---- Time slot ---- */
        .time-slot {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 7px;
            padding: 4px 10px;
            font-size: .8rem;
            font-weight: 700;
            color: #0369a1;
        }

        /* ---- Status badges ---- */
        .badge-slot-active {
            background: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            border-radius: 50px;
            padding: 4px 13px;
            font-size: .76rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            transition: all .2s;
        }

        .badge-slot-active:hover {
            background: #bbf7d0;
            color: #15803d;
        }

        .badge-slot-expired {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: 4px 13px;
            font-size: .76rem;
            font-weight: 700;
            display: inline-block;
        }

        .badge-slot-deactive {
            background: #fff1f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 50px;
            padding: 4px 13px;
            font-size: .76rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            transition: all .2s;
        }

        .badge-slot-deactive:hover {
            background: #fecaca;
            color: #b91c1c;
        }

        /* ---- Buttons ---- */
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
            box-shadow: 0 6px 18px rgba(37, 99, 235, .4);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-export {
            background: #fff;
            color: #374151;
            border: 1.5px solid #d1d5db;
            border-radius: 50px;
            padding: 9px 20px;
            font-weight: 600;
            font-size: .88rem;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-export:hover {
            background: #f3f4f6;
        }

        .btn-tbl-edit {
            background: #eff6ff;
            color: #2563eb;
            border: 1.5px solid #bfdbfe;
            border-radius: 50px;
            padding: 5px 13px;
            font-size: .8rem;
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
    </style>
@endpush

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
        $canAdd = in_array('slot_add', $roleArray) || in_array('All', $roleArray);
        $canEdit = in_array('slot_edit', $roleArray) || in_array('All', $roleArray);
    @endphp

    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">Doctor Availability Slots</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/users/doctor-directory"
                                    class="text-decoration-none text-muted">Users</a></li>
                            <li class="breadcrumb-item active text-muted">Doctor Availability</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if($canAdd)
                        <a href="/admin/manage-slot" class="btn-add">
                            <i class="bx bx-plus"></i> Add New Slot
                        </a>
                    @endif
                    <button class="btn-export" title="Export to CSV">
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
                                <th style="width:5%">Photo</th>
                                <th style="width:18%">Doctor</th>
                                <th style="width:16%">Date Range</th>
                                <th style="width:20%">Days Active</th>
                                <th style="width:15%">Time Slot</th>
                                <th style="width:10%" class="text-center">Status</th>
                                <th style="width:7%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daSlots as $k => $daSlot)
                                @php
                                    $nowDate = now()->toDateString();
                                    $nowTime = now()->format('H:i');
                                    $isActive = $daSlot->status == '1' && (
                                        $daSlot->to_date > $nowDate ||
                                        ($daSlot->to_date === $nowDate && $daSlot->end_time >= $nowTime)
                                    );
                                    $isExpired = $daSlot->status == '1' && (
                                        $daSlot->to_date < $nowDate ||
                                        ($daSlot->to_date === $nowDate && $daSlot->end_time < $nowTime)
                                    );
                                    $days = array_map('trim', explode(',', $daSlot->available_days ?? ''));
                                @endphp
                                <tr>
                                    <td class="fw-semibold text-muted">{{ $k + 1 }}</td>
                                    <td>
                                        <img src="/public/assets/images/profiles/{{ $daSlot->photo ?? '' }}"
                                            class="doctor-avatar"
                                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($daSlot->first_name . ' ' . $daSlot->last_name) }}&background=2563eb&color=fff&size=40'" />
                                    </td>
                                    <td>
                                        <div class="doctor-name-main">{{ $daSlot->first_name . ' ' . $daSlot->last_name }}</div>
                                        @if($daSlot->specialist)
                                            <div class="doctor-specialist">{{ $daSlot->specialist }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="date-range">
                                            <div class="date-range-line">
                                                <i class="bx bx-calendar" style="color:#2563eb;"></i>
                                                {!! date_format(date_create($daSlot->from_date ?? ''), 'd M, Y') !!}
                                            </div>
                                            <div class="date-range-sep">↓ to</div>
                                            <div class="date-range-line">
                                                <i class="bx bx-calendar-check" style="color:#16a34a;"></i>
                                                {!! date_format(date_create($daSlot->to_date ?? ''), 'd M, Y') !!}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="days-wrap">
                                            @foreach($days as $day)
                                                @if($day)
                                                    <span class="day-pill">{{ $day }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <span class="time-slot">
                                            <i class="bx bx-time"></i>
                                            {!! date_format(date_create($daSlot->start_time ?? ''), 'h:i A') !!}
                                            &ndash;
                                            {!! date_format(date_create($daSlot->end_time ?? ''), 'h:i A') !!}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($isActive)
                                            <a href="javascript:void(0)" class="badge-slot-active rowStatus"
                                                data-id="{{ $daSlot->id ?? '' }}">✓ Active</a>
                                        @elseif($isExpired)
                                            <span class="badge-slot-expired">⌛ Expired</span>
                                        @else
                                            <a href="javascript:void(0)" class="badge-slot-deactive rowStatus"
                                                data-id="{{ $daSlot->id ?? '' }}">✕ Inactive</a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($canEdit)
                                            <a href="/admin/manage-slot?id={{ $daSlot->id }}" class="btn-tbl-edit" title="Edit">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bx bx-calendar-x" style="font-size:2.5rem;color:#bfdbfe;"></i>
                                        <p class="mt-2 mb-0 fw-semibold">No availability slots found.</p>
                                        @if($canAdd)
                                            <a href="/admin/manage-slot" class="btn-add mt-3 d-inline-flex mx-auto">
                                                <i class="bx bx-plus"></i> Add First Slot
                                            </a>
                                        @endif
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