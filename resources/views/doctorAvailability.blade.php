@extends('layout')
@section('title','Doctor Availability Slots - Easy Doctor')

@section('content')
    @php
    
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    
    @endphp
    <section class="task__section">
        <div class="text">
            Doctor Availability Slots
            
            @if(in_array('slot_add',$roleArray) || in_array('All',$roleArray))
            <div class="btn-group">
                <a href="/admin/manage-slot" class="btn btn-default btn-sm"><i class="bx bx-plus"></i> <span>Add New</span></a>
            </div>
            @endif
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pb-3 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">Sr. No.</th>
                                <th>Doctors</th>
                                <th>Date</th>
                                <th>Days</th>
                                <th>Time</th>
                                <th class="text-center">Status</th>
                                <th class="wpx-100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daSlots as $k => $daSlot)
                            <tr>
                                <td width="40px" class="text-center">{{ $k+1; }}</td>
                                <td>{!! ($daSlot->first_name ?? '').' '.($daSlot->last_name ?? '').'<br><span class="small">'.($daSlot->specialist ?? '').'</span>' !!}</td>
                                <td>{!! date_format(date_create($daSlot->from_date ?? ''),'d M, Y').' - '.date_format(date_create($daSlot->to_date ?? ''),'d M, Y') !!}</td>
                                <td>{!! ($daSlot->available_days ?? '') !!}</td>
                                <td>{!! date_format(date_create($daSlot->start_time ?? ''),'h:i A') !!} - {!! date_format(date_create($daSlot->end_time ?? ''),'h:i A') !!}</td>
                                <td class="text-center">
                                    @if($daSlot->status == '1' && ($daSlot->to_date > now()->toDateString() || ($daSlot->to_date === now()->toDateString() && $daSlot->end_time >= now()->format('H:i'))))
                                        <a href="javascript:void(0)" class="font-weight-bold badge bg-success rowStatus" data-id="{{ $daSlot->id ?? '' }}">Active</a>
                                    @elseif($daSlot->status == '1' && ($daSlot->to_date < now()->toDateString() || ($daSlot->to_date === now()->toDateString() && $daSlot->end_time < now()->format('H:i'))))
                                        <span class="badge bg-danger">Expired</span>
                                    @else
                                        <a href="javascript:void(0)" class="font-weight-bold badge bg-danger rowStatus" data-id="{{ $daSlot->id ?? '' }}">Deactive</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(in_array('slot_edit',$roleArray) || in_array('All',$roleArray))
                                    <a href="/admin/manage-slot?id={{ $daSlot->id }}" class="btn btn-info btn-sm" title="Edit"><i class="bx bx-edit"></i></a>
                                    @endif
                                    @if(in_array('slot_delete',$roleArray) || in_array('All',$roleArray))
                                    <!--<a class="btn btn-danger btn-sm m-none" title="Delete"><i class="bx bx-trash"></i></a>-->
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection