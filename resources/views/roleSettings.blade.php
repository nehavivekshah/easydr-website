@extends('layout')
@section('title','Role Settings - Easy Doctors')

@section('content')
    <section class="task__section">
        <div class="text">
            Role Settings
            
            <div class="btn-group m-0">
                <a href="/admin/manage-role-setting" class="btn btn-default btn-sm"><i class="bx bx-plus"></i> <span>Add New</span></a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table id="lists" class="table table-condensed m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Designation</th>
                                <th class="m-none">Features</th>
                                <th>Status</th>
                                <th class="wpx-100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            
                            @php $features = ucwords(str_replace(',',', ',($role->features ?? ''))); @endphp
                            
                            <tr>
                                <td>{{$role->title ?? '--'}}</td>
                                <td>{{$role->subtitle ?? '--'}}</td>
                                <td class="m-none">{{$features}}</td>
                                <td>@if($role->status == '1')<span class="font-weight-bold text-success">Active</span>@else<span class="font-weight-bold text-danger">Deactive</span>@endif</td>
                                <td class="text-center">
                                    <a @if($features == 'All')href="javascript:void(0)"@else href="/admin/manage-role-setting?id={{ $role->id }}" @endif class="btn btn-info btn-sm @if($features == 'All') op-4 @endif" title="Edit"><i class="bx bx-edit"></i></a>
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