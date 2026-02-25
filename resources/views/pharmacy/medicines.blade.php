@extends('layout')
@section('title', 'Medicines - Easy Doctor')

@section('content')
    @php

        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));

    @endphp
    <section class="task__section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-0 text-dark fw-bold" style="font-size: 1.5rem;">Medicines</h2>
                <div class="text-muted small mt-1">Home / Pharmacy / Medicines</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if(in_array('medicine_add', $roleArray) || in_array('All', $roleArray))
                    <a href="/admin/manage-medicine" class="btn btn-default rounded-pill shadow-sm px-4">
                        <i class="bx bx-plus me-1 border-0 bg-transparent text-white p-0"></i> <span>Add New</span>
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
                                        <th width="50px" class="text-center">ID</th>
                                        <th width="45px">Photo</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Purpose</th>
                                        <th>Price</th>
                                        <th>Expiration Date</th>
                                        <th class="text-center">Stock</th>
                                        <th class="wpx-100 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medicines as $medicine)
                                        <tr>
                                            <td class="text-center">{{ $medicine->id }}</td>
                                            <td width="45px">
                                                @if(!empty($medicine->img))
                                                    <img src="/public/{{ $medicine->img }}" class="thumbnail rounded-start"
                                                        style="width:40px;" />
                                                @endif
                                            </td>
                                            <td>{{ $medicine->name }}</td>
                                            <td>{{ $medicine->type_name }}</td>
                                            <td>{{ $medicine->purpose }}</td>
                                            <td>Rs. {{ number_format($medicine->cost, 2) }}</td>
                                            <td>{!! date_format(date_create($medicine->expiration_date), 'd M, Y') !!}</td>
                                            <td class="text-center">
                                                @if($medicine->available == '1')
                                                    <span class="font-weight-bold badge bg-success">Available</span>
                                                @else
                                                    <span class="font-weight-bold badge bg-danger">Unavailable</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('medicine_edit', $roleArray) || in_array('All', $roleArray))
                                                    <a href="/admin/manage-medicine?id={{ $medicine->id }}"
                                                        class="btn btn-info btn-sm rounded-pill shadow-sm mb-1 px-3 d-inline-flex align-items-center"
                                                        title="Edit"><i class="bx bx-edit"></i></a>
                                                @endif
                                                @if(in_array('medicine_delete', $roleArray) || in_array('All', $roleArray))
                                                    <form action="{{ route('medicine.destroy', $medicine->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this medicine? This action cannot be undone.');"
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
                <div class="col-md-12 text-center mt-3">
                    {{ $medicines->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>
@endsection