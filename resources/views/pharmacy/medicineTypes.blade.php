@extends('layout')
@section('title','Medicine Types - Easy Doctor')

@section('content')
    @php
    
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    
    @endphp
    <section class="task__section">
        <div class="text">
            Medicine Types
            
            @if(in_array('medicinetype_add',$roleArray) || in_array('All',$roleArray))
            <div class="btn-group m-0">
                <a href="/admin/manage-medicine-type" class="btn btn-default btn-sm"><i class="bx bx-plus"></i> <span>Add New</span></a>
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
                            @foreach($types as $k => $type)
                            <tr>
                                <td>{{ $k+1; }}</td>
                                <td>{{$type->name ?? '--'}}</td>
                                <td>{{$type->icon ?? '--'}}</td>
                                <td class="text-center">
                                    @if(in_array('medicinetype_edit',$roleArray) || in_array('All',$roleArray))
                                    <a href="/admin/manage-medicine-type?id={{ $type->id }}" class="btn btn-info btn-sm" title="Edit"><i class="bx bx-edit"></i></a>
                                    @endif
                                    @if(in_array('medicinetype_delete',$roleArray) || in_array('All',$roleArray))
                                    <form action="{{ route('medicineType.destroy', $type->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this medicine type?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bx bx-x"></i></button>
                                    </form>
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