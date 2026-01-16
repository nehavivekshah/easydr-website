@extends('layout')
@section('title','Specialists - Easy Doctor')

@section('content')
    @php
    
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    
    @endphp
    <section class="task__section">
        <div class="text">
            Specialists
            
            @if(in_array('specialists_add',$roleArray) || in_array('All',$roleArray))
            <div class="btn-group m-0">
                <a href="/admin/manage-specialist" class="btn btn-default btn-sm"><i class="bx bx-plus"></i> <span>Add New</span></a>
            </div>
            @endif
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pb-3 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="wpx-100 text-center">Icons</th>
                                <th>Title</th>
                                <th class="wpx-100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($specialists as $k => $specialist)
                            <tr>
                                <td>{{ $k+1; }}</td>
                                <td class="wpx-100 text-center">
                                @if (!empty($specialist->icons))
                                <img src="{{ asset('/public/assets/images/specialists/' . $specialist->icons) }}" alt="{{$specialist->title ?? '--'}}" style="width: 80px; margin:auto;" />
                                @else
                                <img src="{{ asset('/public/assets/icons/upload.svg') }}" alt="{{$specialist->title ?? '--'}}" style="width: 80px; margin:auto;" />
                                @endif
                                </td>
                                <td>{{$specialist->title ?? '--'}}</td>
                                <td class="text-center">
                                    @if(in_array('specialists_edit',$roleArray) || in_array('All',$roleArray))
                                    <a href="/admin/manage-specialist?id={{ $specialist->id }}" class="btn btn-info btn-sm" title="Edit"><i class="bx bx-edit"></i></a>
                                    @endif
                                    @if(in_array('specialists_delete',$roleArray) || in_array('All',$roleArray))
                                    <a class="btn btn-danger btn-sm m-none delete" data-id="{{ $specialist->id }}" data-page="specialist" title="Delete"><i class="bx bx-trash"></i></a>
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