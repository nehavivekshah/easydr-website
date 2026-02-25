@extends('layout')
@section('title', 'Pharmacy - Easy Doctor')

@section('content')
    @php

        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));

    @endphp
    <section class="task__section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-0 text-dark fw-bold" style="font-size: 1.5rem;">Pharmacy Directory</h2>
                <div class="text-muted small mt-1">
                    Home / Pharmacy / Directory
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                @if(in_array('stores_add', $roleArray) || in_array('All', $roleArray))
                    <a href="/admin/manage-pharmacy" class="btn btn-default rounded-pill shadow-sm px-4">
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
                                        <th>Pharmacy Name</th>
                                        <th>Head office Address</th>
                                        <th>Contact Person</th>
                                        <th class="m-none">Email Id</th>
                                        <th class="m-none">Phone No.</th>
                                        <th class="wpx-100 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pharmacyMaster as $pharmacy)
                                        <tr>
                                            <td class="text-center">{{ $pharmacy->PharmacyID }}</td>
                                            <td class="font-weight-bold">{{ $pharmacy->PharmacyName }}</td>
                                            <td>{{ $pharmacy->Address }}, {{ $pharmacy->City }}, {{ $pharmacy->State }} -
                                                {{ $pharmacy->ZipCode }}</td>
                                            <td>{{ $pharmacy->PrimaryContactName }}</td>
                                            <td class="m-none">{{ $pharmacy->EmailAddress ?? '--' }}</td>
                                            <td class="m-none">{{ $pharmacy->PhoneNumber ?? '--' }}</td>
                                            <td class="text-center">
                                                <a href="/admin/medicine-listings?PharmacyID={{ $pharmacy->PharmacyID ?? '' }}"
                                                    class="btn btn-primary btn-sm rounded-pill shadow-sm mb-1 px-3 d-inline-flex align-items-center" title="View Medicines">
                                                    <i class="bx bx-show me-1"></i></a>
                                                <a href="/admin/manage-pharmacy?id={{ $pharmacy->PharmacyID ?? '' }}"
                                                    class="btn btn-info btn-sm rounded-pill shadow-sm mb-1 px-3 d-inline-flex align-items-center" title="Edit">
                                                    <i class="bx bx-edit me-1"></i></a>
                                                <form action="{{ route('pharmacy.destroy', $pharmacy->PharmacyID) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this pharmacy? This action cannot be undone.');"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill shadow-sm mb-1 px-3 d-inline-flex align-items-center" title="Delete">
                                                        <i class="bx bx-trash me-1"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center mt-3">
                    {{ $pharmacyMaster->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>
@endsection