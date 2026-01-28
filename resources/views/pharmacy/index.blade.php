@extends('layout')
@section('title', 'Pharmacy - Easy Doctor')

@section('content')
    @php

        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));

    @endphp
    <section class="task__section">
        <div class="text">
            Pharmacy

            @if(in_array('stores_add', $roleArray) || in_array('All', $roleArray))
                <div class="btn-group m-0">
                    <a href="/admin/manage-pharmacy" class="btn btn-default btn-sm"><i class="bx bx-plus"></i> <span>Add
                            New</span></a>
                </div>
            @endif
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pharmacy Name</th>
                                <th>Head office Address</th>
                                <th>Contact Person</th>
                                <th>Email Id</th>
                                <th>Phone No.</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pharmacyMaster as $pharmacy)
                                <tr>
                                    <td>{{ $pharmacy->PharmacyID }}</td>
                                    <td>{{ $pharmacy->PharmacyName }}</td>
                                    <td>{{ $pharmacy->Address }}, {{ $pharmacy->City }}, {{ $pharmacy->State }} -
                                        {{ $pharmacy->ZipCode }}</td>
                                    <td>{{ $pharmacy->PrimaryContactName }}</td>
                                    <td>{{ $pharmacy->EmailAddress }}</td>
                                    <td>{{ $pharmacy->PhoneNumber }}</td>
                                    <td class="wpx-90">
                                        <a href="/admin/medicine-listings?PharmacyID={{ $pharmacy->PharmacyID ?? '' }}"
                                            class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                        <a href="/admin/manage-pharmacy?id={{ $pharmacy->PharmacyID ?? '' }}"
                                            class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                        <form action="{{ route('pharmacy.destroy', $pharmacy->PharmacyID) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this pharmacy?');"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bx bx-x"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center mt-3">
                    {{ $pharmacyMaster->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>
@endsection