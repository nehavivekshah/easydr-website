@extends('layout')
@section('title', 'Medicine Types - Easy Doctor')

@section('content')
    @php

        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));

    @endphp
    <section class="task__section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-0 text-dark fw-bold" style="font-size: 1.5rem;">Medicine Types</h2>
                <div class="text-muted small mt-1">Home / Pharmacy / Medicine Types</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if(in_array('medicinetype_add', $roleArray) || in_array('All', $roleArray))
                    <a href="/admin/manage-medicine-type" class="btn btn-default rounded-pill shadow-sm px-4">
                        <i class="bx bx-plus me-1 border-0 bg-transparent text-white p-0"></i> <span>Add New</span>
                    </a>
                @endif
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
                                        <th>Title</th>
                                        <th>Icon</th>
                                        <th class="wpx-100 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($types as $k => $type)
                                        <tr>
                                            <td class="text-center">{{ $k + 1 }}</td>
                                            <td>{{$type->name ?? '--'}}</td>
                                            <td>{{$type->icon ?? '--'}}</td>
                                            <td class="text-center">
                                                @if(in_array('medicinetype_edit', $roleArray) || in_array('All', $roleArray))
                                                    <a href="/admin/manage-medicine-type?id={{ $type->id }}"
                                                        class="btn btn-info btn-sm rounded-pill shadow-sm mb-1 px-3 d-inline-flex align-items-center"
                                                        title="Edit"><i class="bx bx-edit"></i></a>
                                                @endif
                                                @if(in_array('medicinetype_delete', $roleArray) || in_array('All', $roleArray))
                                                    <form action="{{ route('medicineType.destroy', $type->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this medicine type? This action cannot be undone.');"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm rounded-pill shadow-sm mb-1 px-3 d-inline-flex align-items-center"
                                                            title="Delete"><i class="bx bx-trash"></i></button>
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
            </div>
        </div>
    </section>
@endsection