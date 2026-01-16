@extends('layout')
@section('title','Cities - Easy Doctor')

@section('content')
    @php
    
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    
    @endphp
    <section class="task__section">
        <div class="text">
            Cities
            
            @if(in_array('cities_add',$roleArray) || in_array('All',$roleArray))
            <div class="btn-group m-0">
                <a href="/admin/manage-city" class="btn btn-default btn-sm"><i class="bx bx-plus"></i> <span>Add New</span></a>
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
                                <th>Country</th>
                                <th>State</th>
                                <th>Name</th>
                                <th>Icon</th>
                                <th class="wpx-100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cities as $k => $city)
                            <tr>
                                <td>{{ $k+1; }}</td>
                                <td>{{$city->country ?? '--'}}</td>
                                <td>{{$city->state ?? '--'}}</td>
                                <td>{{$city->name ?? '--'}}</td>
                                <td>{{$city->icon ?? '--'}}</td>
                                <td class="text-center">
                                    @if(in_array('cities_edit',$roleArray) || in_array('All',$roleArray))
                                    <a href="/admin/manage-city?id={{ $city->id }}" class="btn btn-info btn-sm" title="Edit"><i class="bx bx-edit"></i></a>
                                    @endif
                                    @if(in_array('cities_delete',$roleArray) || in_array('All',$roleArray))
                                    <a class="btn btn-danger btn-sm m-none delete" data-id="{{ $city->id }}" data-page="city" title="Delete"><i class="bx bx-trash"></i></a>
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