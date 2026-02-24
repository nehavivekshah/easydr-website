@extends('layout')
@section('title', 'Doctor Availability Slots - Easy Doctor')

@push('styles')
    <style>
        .task__section .text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-responsive {
            border-radius: 16px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .table thead th {
            background: var(--color-default) !important;
            color: white !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 15px !important;
            border: none;
        }

        .table thead tr th:first-child {
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .table thead tr th:last-child {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .table tbody td {
            padding: 15px !important;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
            font-size: 0.95rem;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge {
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 20px;
            letter-spacing: 0.5px;
        }

        .bg-success {
            background-color: rgba(16, 185, 129, 0.15) !important;
            color: #059669 !important;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .bg-danger {
            background-color: rgba(239, 68, 68, 0.15) !important;
            color: #dc2626 !important;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(7, 204, 236, 0.2);
        }

        .btn-action i {
            font-size: 1.1rem;
        }

        .btn-action.btn-info {
            background: linear-gradient(135deg, #07CCEC 0%, #05a7c2 100%);
            border: none;
            color: white;
        }

        .btn-action.btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(7, 204, 236, 0.3);
        }
    </style>
@endpush

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
    @endphp

    <section class="task__section">
        <div class="text">
            <span>Doctor Availability Slots</span>
            @if(in_array('slot_add', $roleArray) || in_array('All', $roleArray))
                <a href="/admin/manage-slot"
                    class="btn btn-primary rounded-pill shadow-sm px-4 py-2 d-flex align-items-center fw-bold"
                    style="font-size: 0.95rem;">
                    <i class="bx bx-plus me-2" style="font-size: 1.2rem;"></i> Add New Slot
                </a>
            @endif
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pb-3">
                    <div class="card border-0 shadow-sm rounded-4 w-100">
                        <div class="card-body p-4 table-responsive">
                            <table id="lists" class="table m-table border-0 w-100 align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">Sr. No.</th>
                                        <th width="20%">Doctor</th>
                                        <th width="20%">Date Range</th>
                                        <th width="25%">Days Active</th>
                                        <th width="15%">Time Slot</th>
                                        <th class="text-center" width="10%">Status</th>
                                        <th class="text-center" width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($daSlots as $k => $daSlot)
                                        <tr>
                                            <td class="text-center fw-bold text-muted">{{ $k + 1 }}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="fw-bold text-dark">{!! ($daSlot->first_name ?? '') . ' ' . ($daSlot->last_name ?? '') !!}</span>
                                                    <span class="small text-muted">{!! ($daSlot->specialist ?? '') !!}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-calendar text-info me-2"></i>
                                                    {!! date_format(date_create($daSlot->from_date ?? ''), 'd M, Y') !!} - <br>
                                                    {!! date_format(date_create($daSlot->to_date ?? ''), 'd M, Y') !!}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-calendar-check text-info me-2"></i>
                                                    <span class="text-truncate"
                                                        style="max-width: 200px; display: inline-block;">
                                                        {!! str_replace(',', ', ', ($daSlot->available_days ?? '')) !!}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center fw-bold">
                                                    <i class="bx bx-time text-info me-2"></i>
                                                    {!! date_format(date_create($daSlot->start_time ?? ''), 'h:i A') !!} -
                                                    {!! date_format(date_create($daSlot->end_time ?? ''), 'h:i A') !!}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($daSlot->status == '1' && ($daSlot->to_date > now()->toDateString() || ($daSlot->to_date === now()->toDateString() && $daSlot->end_time >= now()->format('H:i'))))
                                                    <a href="javascript:void(0)"
                                                        class="badge bg-success rowStatus text-decoration-none"
                                                        data-id="{{ $daSlot->id ?? '' }}">Active</a>
                                                @elseif($daSlot->status == '1' && ($daSlot->to_date < now()->toDateString() || ($daSlot->to_date === now()->toDateString() && $daSlot->end_time < now()->format('H:i'))))
                                                    <span class="badge bg-danger">Expired</span>
                                                @else
                                                    <a href="javascript:void(0)"
                                                        class="badge bg-danger rowStatus text-decoration-none"
                                                        data-id="{{ $daSlot->id ?? '' }}">Deactive</a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('slot_edit', $roleArray) || in_array('All', $roleArray))
                                                    <a href="/admin/manage-slot?id={{ $daSlot->id }}" class="btn-action btn-info"
                                                        title="Edit">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection