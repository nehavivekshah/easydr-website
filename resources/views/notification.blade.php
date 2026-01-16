@extends('layout')
@section('title','Notification Settings - Easy Doctor')

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    @endphp
    <section class="task__section">
        <div class="text">
            Notification Settings
            
            @if(in_array('notifications_manage',$roleArray) || in_array('All',$roleArray))
            <div class="btn-group m-0">
                <a href="/admin/manage-notification" class="btn btn-default btn-sm"><i class="bx bx-plus"></i> <span>Manage Notifications</span></a>
            </div>
            @endif
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Notification Type</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="wpx-100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifications as $k => $notification)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{$notification->type ?? '--'}}</td>
                                <td>{{$notification->description ?? '--'}}</td>
                                <td>
                                    @if($notification->status == 1)
                                        <span class="badge badge-success">Enabled</span>
                                    @else
                                        <span class="badge badge-danger">Disabled</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(in_array('notifications_edit',$roleArray) || in_array('All',$roleArray))
                                    <a href="/admin/manage-notification?id={{ $notification->id }}" class="btn btn-info btn-sm" title="Edit"><i class="bx bx-edit"></i></a>
                                    @endif
                                    @if(in_array('notifications_delete',$roleArray) || in_array('All',$roleArray))
                                    <a class="btn btn-danger btn-sm m-none delete" data-id="{{ $notification->id }}" data-page="notification" title="Delete"><i class="bx bx-trash"></i></a>
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
