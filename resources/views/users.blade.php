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
                <div class="modal-body p-4 bg-light">
                    <!-- Header Block in Modal Body -->
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-light">
                        <div class="me-3">
                            <img id="modalPatientPhoto" src="" alt="Profile Photo" class="rounded shadow-sm bg-white p-1"
                                style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #dee2e6;">
                        </div>
                        <div>
                            <h3 id="modalPatientName" class="mb-2 fw-bold text-dark" style="letter-spacing: -0.5px;"></h3>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 rounded text-uppercase"
                                    id="modalPatientGender"><i class="bx bx-male-female me-1"></i>--</span>
                                <span class="badge bg-danger bg-opacity-10 text-danger py-2 px-3 rounded text-uppercase"
                                    id="modalPatientBloodGroup"><i class="bx bx-droplet me-1"></i>--</span>
                                <span class="badge bg-success bg-opacity-10 text-success py-2 px-3 rounded text-uppercase"
                                    id="modalPatientAge"><i class="bx bx-calendar me-1"></i>-- YEARS OLD</span>
                            </div>
                        </div>
                        <div class="ms-auto text-end align-self-start">
                            <span id="modalPatientStatus" class="badge rounded-pill px-3 py-2 fs-6 shadow-sm"></span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Mobile Number -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-3 d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded pt-1 d-flex justify-content-center align-items-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bx bx-phone fs-4"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted fw-bold mb-1 d-block text-uppercase"
                                            style="font-size: 0.75rem; letter-spacing: 0.5px;">Mobile Number</small>
                                        <h6 class="mb-0 fw-bold text-dark fs-6" id="modalPatientMobile"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-3 d-flex align-items-center gap-3">
                                    <div class="bg-info bg-opacity-10 text-info rounded pt-1 d-flex justify-content-center align-items-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bx bx-envelope fs-4"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <small class="text-muted fw-bold mb-1 d-block text-uppercase"
                                            style="font-size: 0.75rem; letter-spacing: 0.5px;">Email Address</small>
                                        <h6 class="mb-0 fw-bold text-dark text-truncate fs-6" id="modalPatientEmail"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-3 d-flex align-items-center gap-3">
                                    <div class="bg-success bg-opacity-10 text-success rounded pt-1 d-flex justify-content-center align-items-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bx bxs-cake fs-4"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted fw-bold mb-1 d-block text-uppercase"
                                            style="font-size: 0.75rem; letter-spacing: 0.5px;">Date of Birth</small>
                                        <h6 class="mb-0 fw-bold text-dark fs-6" id="modalPatientDob"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location / City -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-3 d-flex align-items-center gap-3">
                                    <div class="bg-warning bg-opacity-10 text-warning rounded pt-1 d-flex justify-content-center align-items-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bx bxs-map fs-4"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <small class="text-muted fw-bold mb-1 d-block text-uppercase"
                                            style="font-size: 0.75rem; letter-spacing: 0.5px;">Location / City</small>
                                        <h6 class="mb-0 fw-bold text-dark text-truncate fs-6" id="modalPatientLocation">
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Full Address -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body p-3 d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded pt-1 d-flex justify-content-center align-items-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bx bx-home fs-4"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted fw-bold mb-1 d-block text-uppercase"
                                            style="font-size: 0.75rem; letter-spacing: 0.5px;">Full Address</small>
                                        <h6 class="mb-0 fw-bold text-dark fs-6" id="modalPatientAddress"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Identification & Card -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4 mt-2">
                                <div class="card-header bg-white border-bottom p-3">
                                    <h6 class="mb-0 fw-bold text-dark fs-6"><i
                                            class="bx bx-id-card text-primary me-2"></i>Identification Details</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <small class="text-muted fw-bold mb-1 d-block text-uppercase"
                                                style="font-size: 0.75rem; letter-spacing: 0.5px;">Aadhar Card</small>
                                            <h6 class="mb-0 fw-bold text-dark fs-6" id="modalPatientAadhar"></h6>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted fw-bold mb-1 d-block text-uppercase"
                                                style="font-size: 0.75rem; letter-spacing: 0.5px;">Health Card</small>
                                            <h6 class="mb-0 fw-bold text-dark fs-6" id="modalPatientHealthCard"></h6>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted fw-bold mb-1 d-block text-uppercase"
                                                style="font-size: 0.75rem; letter-spacing: 0.5px;">Verification</small>
                                            <div id="modalPatientVerifyStatus"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 pb-4 pe-4 bg-light rounded-bottom-4">
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
                $('#modalPatientLocation').text(locationStr.join(', ') || 'Location Not Provided');

                // Header Badges
                var genderMap = { '1': 'MALE', '2': 'FEMALE', '3': 'OTHER' };
                $('#modalPatientGender').html('<i class="bx bx-male-female me-1"></i>' + (genderMap[user.gender] || '--'));

                $('#modalPatientBloodGroup').html('<i class="bx bx-droplet me-1"></i>' + (user.blood_group || '--'));

                // Age Calculation
                var ageText = '-- YEARS OLD';
                if (user.dob) {
                    var dob = new Date(user.dob);
                    var diff_ms = Date.now() - dob.getTime();
                    var age_dt = new Date(diff_ms);
                    var age = Math.abs(age_dt.getUTCFullYear() - 1970);
                    ageText = age + ' YEARS OLD';
                }
                $('#modalPatientAge').html('<i class="bx bx-calendar me-1"></i>' + ageText);

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