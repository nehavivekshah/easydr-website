@extends('layout')

@php

    $pagename = explode('-', $type);

@endphp

@section('title', ucfirst($pagename[0] ?? 'User') . "s - Easy Doctors")

@section('content')
    @php

        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));

    @endphp
    <section class="task__section">
        <div class="text">
            @if($pagename[0] == 'doctor' || $pagename[0] == 'patient')
                {{ucwords($pagename[0] . ' ' . $pagename[1] ?? "Listings")}}
            @else
                {{ucwords($pagename[0] ?? "User") . "s"}}
            @endif
            <div class="bradcrum">
                Home / Users /
                @if($pagename[0] == 'doctor' || $pagename[0] == 'patient')
                    {{ucwords($pagename[0] . ' ' . $pagename[1] ?? "")}}
                @else
                    {{ucwords($pagename[0] ?? "User") . "s"}}
                @endif
            </div>
        </div>

        <div class="container-fluid mb-3">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    @if(
                            in_array('users_add', $roleArray) || in_array('patients_add', $roleArray) || in_array('doctors_add', $roleArray)
                            || in_array('admin_accounts_add', $roleArray) || in_array('staff_accounts_add', $roleArray) || in_array('All', $roleArray)
                        )
                        <div class="btn-group">
                            <a href="/admin/manage-user/{{$type}}" class="btn btn-default btn-sm">
                                <i class="bx bx-plus"></i> <span>Add New</span>
                            </a>
                        </div>
                    @else
                        <div></div>
                    @endif

                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-secondary" title="Export to CSV">
                            <i class="bx bx-download"></i> Export
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50px">Sr. No.</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th class="m-none">Email Id</th>
                                <th class="m-none">Mobile No.</th>
                                @if($type == 'doctor-directory')
                                    <th class="m-none">Fees</th>
                                    <th class="m-none">Wallets</th>
                                    <th class="m-none">License</th>
                                @endif
                                @if($type == 'patient-directory')
                                    <th class="m-none text-center">Medical File</th>
                                    <th class="m-none text-center">Health Card No.</th>
                                @endif
                                <th>Location</th>
                                @if($type != 'patient-directory' && $type != 'doctor-directory')
                                    <th class="m-none">Role</th>
                                @endif
                                <th class="text-center">Status</th>
                                <th class="wpx-100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $k => $user)
                                <tr>
                                    <td class="text-center">{{ $k + 1 }}</td>
                                    <td><img src="/public/assets/images/profiles/{{$user->photo ?? '--'}}" class="media-icon" />
                                    </td>
                                    <td>{{$user->first_name . ' ' . $user->last_name ?? '--'}}<br>
                                        <span class="small font-weight-bold">
                                            @if($type == 'doctor-directory')
                                                {{ $user->specialist ?? '' }} - {{ $user->education ?? '' }}
                                            @elseif($type == 'patient-directory')
                                                {{ !empty($user->blood_group) ? 'Blood Group: ' . $user->blood_group : '' }}
                                            @endif

                                        </span>
                                    </td>
                                    <td class="m-none">{{$user->email ?? '--'}}</td>
                                    <td class="m-none">{{$user->mobile ?? '--'}}</td>
                                    @if($type == 'doctor-directory')
                                        <td class="m-none">Rs. {{$user->fees ?? '--'}}</td>
                                        <td class="m-none">Rs. {{$user->wallet ?? '--'}}</td>
                                        <td class="m-none">{{$user->license ?? '--'}}</td>
                                    @endif
                                    @if($type == 'patient-directory')
                                        <td class="m-none text-center">
                                            <a href="{{ !empty($user->medical_file) ? asset('public/assets/images/medicals/' . $user->medical_file) : '#' }}"
                                                target="{{ !empty($user->medical_file) ? '_blank' : '' }}"
                                                class="btn btn-link btn-sm font-weight-bold {{ empty($user->medical_file) ? 'text-muted disabled' : 'text-primary' }}"
                                                title="{{ !empty($user->medical_file) ? 'View Medical File' : 'No Medical File Available' }}">
                                                View File
                                            </a>
                                        </td>
                                        <td class="m-none text-center">
                                            @php
                                                $isVerified = $user->hc_verified_at && $user->hc_expairy_date > now();
                                                $isExpired = $user->hc_verified_at && $user->hc_expairy_date <= now();
                                                $badgeClass = $isVerified
                                                    ? 'badge bg-success border-success certified'
                                                    : ($isExpired
                                                        ? 'badge bg-danger border-danger certified'
                                                        : 'badge bg-secondary text-dark certified');
                                            @endphp

                                            <span class="rounded py-1 px-2 text-white {{ $badgeClass }}">
                                                @if($isVerified)
                                                    <i class="bx bx-check-shield h5 me-1"></i> Verified
                                                @elseif($isExpired)
                                                    <i class="bx bx-error h5 me-1"></i> Expired
                                                @else
                                                    <i class="bx bx-time h5 me-1"></i> Not Verified
                                                @endif
                                                {{ $user->health_card ? ' - ' . $user->health_card : '' }}
                                            </span>
                                        </td>

                                    @endif
                                    <td>{{$user->city . ' - ' . $user->country ?? '--'}}</td>
                                    @if($user->role != '4' && $user->role != '5')
                                        <td class="m-none">
                                            {{ $user->title ?? '--' }}
                                            @if(!empty($user->subtitle)) - {{ $user->subtitle }} @endif
                                        </td>
                                    @endif
                                    <td class="text-center">@if($user->status == '1')<span
                                    class="font-weight-bold badge bg-success">Active</span>@else<span
                                            class="font-weight-bold badge bg-danger">Deactive</span>@endif</td>
                                    <td class="text-center">
                                        @if(
                                                in_array('users_edit', $roleArray) || in_array('patients_edit', $roleArray) || in_array('doctors_edit', $roleArray)
                                                || in_array('admin_accounts_edit', $roleArray) || in_array('staff_accounts_edit', $roleArray) || in_array('All', $roleArray)
                                            )
                                            <a href="/admin/manage-user/{{$type}}/{{ $user->id }}" class="btn btn-info btn-sm"
                                                title="Edit"><i class="bx bx-edit"></i></a>
                                        @endif

                                        @if(
                                                in_array('users_delete', $roleArray) || in_array('patients_delete', $roleArray) || in_array('doctors_delete', $roleArray)
                                                || in_array('admin_accounts_delete', $roleArray) || in_array('staff_accounts_delete', $roleArray) || in_array('All', $roleArray)
                                            )
                                            <a href="/admin/users/delete/{{ $user->id }}" class="btn btn-danger btn-sm"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.');"><i
                                                    class="bx bx-trash"></i></a>
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