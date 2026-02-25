@extends('layout')
@section('title', 'Doctor Availability Slots - Easy Doctor')

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
    @endphp

    <section class="task__section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-0 text-dark fw-bold" style="font-size: 1.5rem;">Doctor Availability Slots</h2>
                <div class="text-muted small mt-1">
                    Home / Users / Doctor Availability Slots
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                @if(in_array('slot_add', $roleArray) || in_array('All', $roleArray))
                    <a href="/admin/manage-slot" class="btn btn-default rounded-pill shadow-sm px-4">
                        <i class="bx bx-plus me-1 border-0 bg-transparent text-white p-0"></i> <span>Add New Slot</span>
                    </a>
                @endif
                <button class="btn btn-outline-secondary rounded-pill shadow-sm px-4" title="Export to CSV">
                    <i class="bx bx-download me-1"></i> Export
                </button>
            </div>
        </div>

        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-12 pb-3">
                    <div class="card border-0 shadow-sm rounded-4 w-100">
                        <div class="card-body p-3 table-responsive">
                            <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="50px" class="text-center">Sr. No.</th>
                                        <th>Photo</th>
                                        <th>Doctor</th>
                                        <th>Date Range</th>
                                        <th>Days Active</th>
                                        <th>Time Slot</th>
                                        <th class="text-center">Status</th>
                                        <th class="wpx-100 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($daSlots as $k => $daSlot)
                                        <tr>
                                            <td class="text-center">{{ $k + 1 }}</td>
                                            <td>
                                                <img src="/public/assets/images/profiles/{{$daSlot->photo ?? '--'}}"
                                                    class="media-icon"
                                                    onerror="this.src='/public/assets/images/doctor-placeholder.png'" />
                                            </td>
                                            <td>
                                                {{$daSlot->first_name . ' ' . $daSlot->last_name ?? '--'}}<br>
                                                <span class="small font-weight-bold">{{ $daSlot->specialist ?? '' }}</span>
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
                                                        class="font-weight-bold badge bg-success text-white px-3 py-2 rounded-pill shadow-sm rowStatus text-decoration-none"
                                                        data-id="{{ $daSlot->id ?? '' }}">Active</a>
                                                @elseif($daSlot->status == '1' && ($daSlot->to_date < now()->toDateString() || ($daSlot->to_date === now()->toDateString() && $daSlot->end_time < now()->format('H:i'))))
                                                    <span
                                                        class="font-weight-bold badge bg-danger text-white px-3 py-2 rounded-pill shadow-sm">Expired</span>
                                                @else
                                                    <a href="javascript:void(0)"
                                                        class="font-weight-bold badge bg-danger text-white px-3 py-2 rounded-pill shadow-sm rowStatus text-decoration-none"
                                                        data-id="{{ $daSlot->id ?? '' }}">Deactive</a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('slot_edit', $roleArray) || in_array('All', $roleArray))
                                                    <a href="/admin/manage-slot?id={{ $daSlot->id }}" class="btn btn-info btn-sm"
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