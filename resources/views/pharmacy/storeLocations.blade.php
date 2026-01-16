@extends('layout')
@section('title','Store Locations - Easy Doctor')

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    @endphp
    <section class="task__section">
        <div class="text">
            Store Locations
            
            @if(in_array('stores_add',$roleArray) || in_array('All',$roleArray))
            <div class="btn-group m-0">
                <a href="/admin/manage-store" class="btn btn-default btn-sm"><i class="bx bx-plus"></i> <span>Add New</span></a>
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
                                <th>Store Name</th>
                                <th>Manager Name</th>
                                <th>Phone Number</th>
                                <th>Office Address</th>
                                <th>Hours Of Operation</th>
                                <!-- <th>Latitude</th> -->
                                <th>Map</th>
                                <th>Square Footage</th>
                                <th>Accessibility Features</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stores as $store)
                            @php
                                $HoursOfOperation = $store->HoursOfOperation ?? [];
                            @endphp
                                <tr>
                                    <td>{{ $store->LocationID }}</td>
                                    <td>{{ $store->LocationName }}</td>
                                    <td>{{ $store->ManagerName ?? '-' }}</td>
                                    <td>{{ $store->PhoneNumber }}</td>
                                    <td>{{ $store->Address }}<br>{{ $store->City }}, {{ $store->State }} - {{ $store->ZipCode }}</td>
                                    <td>{!! date_format(date_create($HoursOfOperation[0] ?? null),'h:i A') .'-'. date_format(date_create($HoursOfOperation[1] ?? null),'h:i A')  !!}</td>
                                    <!-- <td>{{ $store->Latitude ?? '-' }}</td> -->
                                    <td><a href="{{ $store->MapLink ?? '#' }}" class="btn btn-warning btn-sm" target="_blank">View</a></td>
                                    <td>{{ $store->SquareFootage ?? '-' }}</td>
                                    <td>{{ $store->AccessibilityFeatures ?? '-' }}</td>
                                    <td class="wpx-90">
                                        <a href="/admin/medicine-listings?storeid={{ $store->LocationID ?? '' }}" class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                        <a href="/admin/manage-store?id={{ $store->LocationID ?? '' }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                        <form action="{{ route('stores.destroy', $store->LocationID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Store?');" class="d-inline">
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
            </div>
        </div>
    </section>
@endsection
