@extends('layout')
@section('title','Pharmacy Types - Easy Doctor')

@section('content')
    @php
    
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    
    @endphp
    <section class="task__section">
        <div class="text">
            Pharmacy Types
            
            @if(in_array('specialists_add',$roleArray) || in_array('All',$roleArray))
            <div class="btn-group m-0">
                <a href="/admin/manage-pharmacy-type" class="btn btn-default btn-sm"><i class="bx bx-plus"></i> <span>Add New</span></a>
            </div>
            @endif
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pb-3 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Title</th>
                                <th>Icon</th>
                                <th class="wpx-100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pharmacyTypes as $k => $pharmacyType)
                            <tr>
                                <td>{{ $k+1; }}</td>
                                <td>{{$pharmacyType->title ?? '--'}}</td>
                                <td>{{$pharmacyType->icon ?? '--'}}</td>
                                <td class="text-center">
                                    @if(in_array('specialists_edit',$roleArray) || in_array('All',$roleArray))
                                    <a href="/admin/manage-pharmacy-type?id={{ $pharmacyType->id }}" class="btn btn-info btn-sm" title="Edit"><i class="bx bx-edit"></i></a>
                                    @endif
                                    @if(in_array('specialists_delete',$roleArray) || in_array('All',$roleArray))
                                    <a class="btn btn-danger btn-sm m-none delete" data-id="{{ $pharmacyType->id }}" data-page="specialist" title="Delete"><i class="bx bx-trash"></i></a>
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