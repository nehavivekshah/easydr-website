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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-0 text-dark fw-bold" style="font-size: 1.5rem;">
                    @if($pagename[0] == 'doctor' || $pagename[0] == 'patient')
                        {{ucwords($pagename[0] . ' ' . $pagename[1] ?? "Listings")}}
                    @else
                        {{ucwords($pagename[0] ?? "User") . "s"}}
                    @endif
                </h2>
                <div class="text-muted small mt-1">
                    Home / Users /
                    @if($pagename[0] == 'doctor' || $pagename[0] == 'patient')
                        {{ucwords($pagename[0] . ' ' . $pagename[1] ?? "")}}
                    @else
                        {{ucwords($pagename[0] ?? "User") . "s"}}
                    @endif
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                @if(
                        in_array('users_add', $roleArray) || in_array('patients_add', $roleArray) || in_array('doctors_add', $roleArray)
                        || in_array('admin_accounts_add', $roleArray) || in_array('staff_accounts_add', $roleArray) || in_array('All', $roleArray)
                        || $pagename[0] == 'pharmacy'
                    )
                    <a href="/admin/manage-user/{{$type}}" class="btn btn-default rounded-pill shadow-sm px-4">
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
                                            <td><img src="/public/assets/images/profiles/{{$user->photo ?? '--'}}"
                                                    class="media-icon" />
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
                                                @if($type == 'patient-directory')
                                                    <button
                                                        class="btn btn-primary btn-sm view-patient-btn rounded-pill shadow-sm mb-1 px-3 d-inline-flex align-items-center"
                                                        data-user="{{ json_encode($user) }}" title="View Profile">
                                                        <i class="bx bx-show me-1"></i> View
                                                    </button>
                                                @endif

                                                @if(
                                                        in_array('users_edit', $roleArray) || in_array('patients_edit', $roleArray) || in_array('doctors_edit', $roleArray)
                                                        || in_array('admin_accounts_edit', $roleArray) || in_array('staff_accounts_edit', $roleArray) || in_array('All', $roleArray)
                                                    )
                                                    <a href="/admin/manage-user/{{$type}}/{{ $user->id }}"
                                                        class="btn btn-info btn-sm" title="Edit"><i class="bx bx-edit"></i></a>
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
            </div>
        </div>
    </section>

    <!-- Patient Profile View Modal -->
    <div class="modal fade" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-light border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold text-dark" id="viewPatientModalLabel">
                        <i class="bx bx-user-circle text-primary me-2"></i>Patient Profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row align-items-center mb-4 pb-3 border-bottom">
                        <div class="col-auto">
                            <img id="modalPatientPhoto" src="" alt="Profile Photo" class="rounded-circle shadow-sm"
                                style="width: 80px; height: 80px; object-fit: cover; border: 3px solid white;">
                        </div>
                        <div class="col">
                            <h4 id="modalPatientName" class="mb-1 fw-bold text-primary"></h4>
                            <p id="modalPatientLocation" class="text-muted mb-0 small"><i
                                    class="bx bx-map shadow-sm rounded-circle p-1 me-1 bg-white"></i> <span></span></p>
                        </div>
                        <div class="col-auto text-end">
                            <span id="modalPatientStatus" class="badge rounded-pill px-3 py-2 fs-6 shadow-sm"></span>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Contact Information -->
                        <div class="col-md-6">
                            <h6 class="fw-bold text-secondary text-uppercase mb-3"
                                style="font-size: 0.85rem; letter-spacing: 0.5px;">Contact Information</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2 d-flex align-items-start"><i
                                        class="bx bx-envelope text-primary mt-1 me-2"></i> <strong
                                        class="me-2">Email:</strong> <span id="modalPatientEmail"
                                        class="text-break text-muted"></span></li>
                                <li class="mb-2 d-flex align-items-start"><i class="bx bx-phone text-primary mt-1 me-2"></i>
                                    <strong class="me-2">Mobile:</strong> <span id="modalPatientMobile"
                                        class="text-muted"></span>
                                </li>
                                <li class="mb-2 d-flex align-items-start"><i
                                        class="bx bx-phone-call text-primary mt-1 me-2"></i> <strong class="me-2">Alt
                                        Mobile:</strong> <span id="modalPatientAltMobile" class="text-muted"></span></li>
                                <li class="mb-0 d-flex align-items-start"><i class="bx bx-home text-primary mt-1 me-2"></i>
                                    <strong class="me-2 text-nowrap">Address:</strong> <span id="modalPatientAddress"
                                        class="text-muted"></span>
                                </li>
                            </ul>
                        </div>

                        <!-- Health & Physical Information -->
                        <div class="col-md-6">
                            <h6 class="fw-bold text-secondary text-uppercase mb-3"
                                style="font-size: 0.85rem; letter-spacing: 0.5px;">Health & Physical</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2 d-flex align-items-center"><i class="bx bx-calendar text-primary me-2"></i>
                                    <strong class="me-2">DOB:</strong> <span id="modalPatientDob" class="text-muted"></span>
                                </li>
                                <li class="mb-2 d-flex align-items-center"><i
                                        class="bx bx-male-female text-primary me-2"></i> <strong
                                        class="me-2">Gender:</strong> <span id="modalPatientGender"
                                        class="text-muted"></span></li>
                                <li class="mb-2 d-flex align-items-center"><i class="bx bx-droplet text-danger me-2"></i>
                                    <strong class="me-2">Blood Group:</strong> <span id="modalPatientBloodGroup"
                                        class="fw-bold text-dark"></span>
                                </li>
                                <li class="mb-2 d-flex align-items-center"><i class="bx bx-ruler text-primary me-2"></i>
                                    <strong class="me-2">Height:</strong> <span id="modalPatientHeight"
                                        class="text-muted"></span>
                                </li>
                                <li class="mb-0 d-flex align-items-center"><i
                                        class="bx bx-bar-chart-alt-2 text-primary me-2"></i> <strong
                                        class="me-2">Weight:</strong> <span id="modalPatientWeight"
                                        class="text-muted"></span></li>
                            </ul>
                        </div>

                        <!-- ID & Documentation -->
                        <div class="col-12 mt-4 pt-3 border-top">
                            <h6 class="fw-bold text-secondary text-uppercase mb-3"
                                style="font-size: 0.85rem; letter-spacing: 0.5px;">Identification & Cards</h6>
                            <div class="row bg-light rounded-4 p-3 border">
                                <div class="col-md-4 mb-3 mb-md-0 border-end border-md-0">
                                    <small class="text-muted d-block mb-1">Aadhar Card</small>
                                    <strong id="modalPatientAadhar" class="text-dark"></strong>
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0 border-end border-md-0">
                                    <small class="text-muted d-block mb-1">Health Card No.</small>
                                    <strong id="modalPatientHealthCard" class="text-primary"></strong>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted d-block mb-1">Verification Status</small>
                                    <span id="modalPatientVerifyStatus"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light rounded-pill shadow-sm px-4"
                        data-bs-dismiss="modal">Close</button>
                    <a href="#" id="modalEditButton" class="btn btn-default rounded-pill shadow-sm px-4"><i
                            class="bx bx-edit me-1"></i> Edit User</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.view-patient-btn').on('click', function () {
                var user = $(this).data('user');

                // Name and Photo
                $('#modalPatientName').text((user.first_name || '') + ' ' + (user.last_name || ''));
                var photoPath = user.photo ? '/public/assets/images/profiles/' + user.photo : '/public/assets/images/profiles/default.png'; // Fallback mapping
                $('#modalPatientPhoto').attr('src', photoPath);

                // Location
                var locationStr = [];
                if (user.city) locationStr.push(user.city);
                if (user.state) locationStr.push(user.state);
                if (user.country) locationStr.push(user.country);
                $('#modalPatientLocation span').text(locationStr.join(', ') || 'Location Not Provided');

                // Status Badge
                var statusBadge = $('#modalPatientStatus');
                if (user.status == '1') {
                    statusBadge.text('Active').removeClass('bg-danger').addClass('bg-success');
                } else {
                    statusBadge.text('Deactive').removeClass('bg-success').addClass('bg-danger');
                }

                // Contact Info
                $('#modalPatientEmail').text(user.email || '--');
                $('#modalPatientMobile').text(user.mobile || '--');
                $('#modalPatientAltMobile').text(user.altr_mobile || '--');
                $('#modalPatientAddress').text(user.address || '--');

                // Health Info
                $('#modalPatientDob').text(user.dob || '--');

                var genderMap = { '1': 'Male', '2': 'Female', '3': 'Other' };
                $('#modalPatientGender').text(genderMap[user.gender] || '--');

                $('#modalPatientBloodGroup').text(user.blood_group || '--');
                var heightVal = user.height ? user.height + ' Inch' : '--';
                $('#modalPatientHeight').text(heightVal);
                var weightVal = user.weight ? user.weight + ' Kg' : '--';
                $('#modalPatientWeight').text(weightVal);

                // IDs
                $('#modalPatientAadhar').text(user.adhar || '--');
                $('#modalPatientHealthCard').text(user.health_card || 'Not Issued');

                // Health Card Verification Status
                var isVerified = false;
                var isExpired = false;

                if (user.hc_verified_at && user.hc_expairy_date) {
                    var expiryDate = new Date(user.hc_expairy_date);
                    if (expiryDate > new Date()) {
                        isVerified = true;
                    } else {
                        isExpired = true;
                    }
                }

                var verifyBadgeHtml = '';
                if (isVerified) {
                    verifyBadgeHtml = '<span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-2"><i class="bx bx-check-shield me-1"></i>Verified</span>';
                } else if (isExpired) {
                    verifyBadgeHtml = '<span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-2"><i class="bx bx-error me-1"></i>Expired</span>';
                } else {
                    verifyBadgeHtml = '<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-2"><i class="bx bx-time me-1"></i>Not Verified</span>';
                }
                $('#modalPatientVerifyStatus').html(verifyBadgeHtml);

                // Set Edit Action Link dynamically based on global $type if exists, else generic fallback mapping
                var editType = "{{ $type ?? 'patient-directory' }}";
                $('#modalEditButton').attr('href', '/admin/manage-user/' + editType + '/' + user.id);

                // Show Modal
                $('#viewPatientModal').modal('show');
            });
        });
    </script>
@endpush