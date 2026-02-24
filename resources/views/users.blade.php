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

    @push('styles')
        <style>
            /* Modal Enhancements */
            .modal-content {
                border-radius: 24px;
                border: none;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                overflow: hidden;
            }

            .modal-header {
                border-bottom: none;
                padding: 15px 30px;
                position: relative;
            }

            .modal-profile-header {
                display: flex;
                align-items: center;
                gap: 24px;
                width: 100%;
            }

            .modal-profile-img {
                width: 100px;
                height: 100px;
                border-radius: 24px;
                object-fit: cover;
                border: 4px solid #f1f1f1;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            .modal-profile-info h3 {
                font-size: 1.5rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 8px;
            }

            .modal-profile-badges {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }

            .p-badge {
                padding: 4px 12px;
                border-radius: 8px;
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .p-badge-gender {
                background: #e3f2fd;
                color: #0d47a1;
            }

            .p-badge-blood {
                background: #ffebee;
                color: #c62828;
            }

            .p-badge-age {
                background: #e8f5e9;
                color: #2e7d32;
            }

            .nav-tabs-custom {
                background: #f9f9f9 !important;
                padding: 0 30px;
                border-bottom: 1px solid #e2e8f0;
                gap: 32px;
            }

            .nav-tabs-custom .nav-link {
                border: none;
                padding: 20px 0;
                color: #64748b;
                font-weight: 700;
                font-size: 0.9rem;
                position: relative;
                transition: all 0.3s;
            }

            .nav-tabs-custom .nav-link:hover {
                color: #0d6efd;
            }

            .nav-tabs-custom .nav-link.active {
                color: #0d6efd;
                background: none;
            }

            .nav-tabs-custom .nav-link.active::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 3px;
                background: #0d6efd;
                border-radius: 3px 3px 0 0;
            }

            .modal-body {
                padding: 30px;
                background: #fff;
            }

            /* Info Cards in Overview */
            .info-card {
                background: #f8fafc;
                border: 1px solid #f1f5f9;
                border-radius: 16px;
                padding: 16px;
                height: 100%;
                transition: all 0.2s;
                display: flex;
                justify-content: start;
                gap: 15px;
                align-items: center;
            }

            .info-card:hover {
                background: #fff;
                border-color: #3498db;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            .info-card-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
            }

            .icon-blue {
                background: #e0f2fe;
                color: #0369a1;
            }

            .icon-green {
                background: #dcfce7;
                color: #166534;
            }

            .icon-purple {
                background: #f3e8ff;
                color: #6b21a8;
            }

            .icon-orange {
                background: #ffedd5;
                color: #9a3412;
            }

            .info-card-label {
                font-size: 0.75rem;
                font-weight: 700;
                color: #64748b;
                text-transform: uppercase;
                margin-bottom: 4px;
            }

            .info-card-value {
                font-size: 0.95rem;
                font-weight: 600;
                color: #1e293b;
                word-break: break-all;
            }

            /* History List Enhancement */
            .history-item {
                padding: 20px;
                border-radius: 16px;
                background: #fff;
                border: 1px solid #f1f5f9;
                margin-bottom: 16px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                animation: slideInUp 0.4s ease-out forwards;
            }

            .history-item:hover {
                transform: translateX(8px);
                border-color: #cbd5e1;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            }

            .history-info {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .history-icon {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
            }

            .history-content h6 {
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 4px;
                font-size: 1rem;
            }

            .history-date {
                font-size: 0.85rem;
                color: #64748b;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            @keyframes slideInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush
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

    <!-- Patient Details Modal -->
    <div class="modal fade" id="patientDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-profile-header">
                        <img id="modalPatientImg" src="" class="modal-profile-img" alt="Patient">
                        <div class="modal-profile-info">
                            <h3 id="modalPatientName">-</h3>
                            <div class="modal-profile-badges">
                                <span id="hdr-gender" class="p-badge p-badge-gender">-</span>
                                <span id="hdr-blood" class="p-badge p-badge-blood">-</span>
                                <span id="hdr-age" class="p-badge p-badge-age">-</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-overview">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-prescriptions"
                            onclick="loadPatientPrescriptions()">Prescriptions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-history" onclick="loadPatientHistory()">Appt
                            History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-payments"
                            onclick="loadPatientPayments()">Payments</a>
                    </li>
                </ul>

                <div class="tab-content overflow-auto" style="max-height: 60vh;">
                    <!-- Overview -->
                    <div class="tab-pane fade show active modal-body" id="tab-overview">
                        <div class="row g-4">
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <div class="info-card-icon icon-blue"><i class="fas fa-phone-alt"></i></div>
                                    <div>
                                        <div class="info-card-label">Mobile Number</div>
                                        <div id="ov-mobile" class="info-card-value">-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <div class="info-card-icon icon-purple"><i class="fas fa-envelope"></i></div>
                                    <div>
                                        <div class="info-card-label">Email Address</div>
                                        <div id="ov-email" class="info-card-value">-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <div class="info-card-icon icon-green"><i class="fas fa-birthday-cake"></i></div>
                                    <div>
                                        <div class="info-card-label">Date of Birth</div>
                                        <div id="ov-dob" class="info-card-value">-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <div class="info-card-icon icon-orange"><i class="fas fa-map-marker-alt"></i></div>
                                    <div>
                                        <div class="info-card-label">Location / City</div>
                                        <div id="ov-city" class="info-card-value">-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="info-card">
                                    <div class="info-card-icon icon-blue"><i class="fas fa-home"></i></div>
                                    <div>
                                        <div class="info-card-label">Full Address</div>
                                        <div id="ov-address" class="info-card-value">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prescriptions -->
                    <div class="tab-pane fade modal-body" id="tab-prescriptions">
                        <div id="prescriptions-list">
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment History -->
                    <div class="tab-pane fade modal-body" id="tab-history">
                        <div id="history-list">
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Payments -->
                    <div class="tab-pane fade modal-body" id="tab-payments">
                        <div id="payments-list">
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
            let currentAdminPatientUid = null;
            let currentPatientName = '';

            $(document).ready(function () {
                $('.view-patient-btn').on('click', function () {
                    var user = $(this).data('user');
                    currentAdminPatientUid = user.id; // from users table

                    var firstName = user.first_name || '';
                    var lastName = user.last_name || '';
                    currentPatientName = (firstName + ' ' + lastName).trim() || 'Unknown';

                    // Name and Photo
                    $('#modalPatientName').text(currentPatientName);
                    var photoPath = user.photo ? '/public/assets/images/profiles/' + user.photo : `https://ui-avatars.com/api/?name=${encodeURIComponent(currentPatientName)}&background=0D8ABC&color=fff`;
                    $('#modalPatientImg').attr('src', photoPath);

                    // Header Badges
                    var genderMap = { '1': 'Male', '2': 'Female', '3': 'Others' };
                    $('#hdr-gender').text(genderMap[user.gender] || '--');
                    $('#hdr-blood').text(user.blood_group || '--');

                    // Age Calculation
                    var ageText = '-- YEARS OLD';
                    if (user.dob) {
                        var dob = new Date(user.dob);
                        var diff_ms = Date.now() - dob.getTime();
                        var age_dt = new Date(diff_ms);
                        var age = Math.abs(age_dt.getUTCFullYear() - 1970);
                        ageText = age + ' Years Old';
                    }
                    $('#hdr-age').text(ageText);

                    // Overview Tab Info Cards
                    $('#ov-mobile').text(user.mobile || '--');
                    $('#ov-email').text(user.email || '--');
                    $('#ov-dob').text(user.dob ? new Date(user.dob).toLocaleDateString() : '--');

                    var locationStr = [];
                    if (user.city) locationStr.push(user.city);
                    if (user.country) locationStr.push(user.country);
                    $('#ov-city').text(locationStr.join(' - ') || '--');

                    var addressArr = [user.address, user.city, user.state, user.country, user.pincode].filter(Boolean);
                    $('#ov-address').text(addressArr.join(', ') || '--');

                    // Reset tabs to Overview
                    const tabEl = document.querySelector('a[href="#tab-overview"]');
                    const tab = new bootstrap.Tab(tabEl);
                    tab.show();

                    // Show Modal
                    var modalEl = document.getElementById('patientDetailsModal');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (!modal) modal = new bootstrap.Modal(modalEl);
                    modal.show();
                });
            });

            async function fetchHistory() {
                if (!currentAdminPatientUid) return { appointments: [], prescriptions: [] };
                const response = await fetch(`/admin/get-patient-details/${currentAdminPatientUid}`);
                return await response.json();
            }

            async function loadPatientPrescriptions() {
                const list = document.getElementById('prescriptions-list');
                list.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';

                const data = await fetchHistory();
                if (!data.prescriptions || data.prescriptions.length === 0) {
                    list.innerHTML = '<p class="text-center text-muted py-4">No prescriptions found globally.</p>';
                    return;
                }

                list.innerHTML = data.prescriptions.map((p, idx) => `
                    <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden" style="animation: slideInUp 0.3s ease-out forwards; animation-delay: ${idx * 0.1}s">
                        <div class="card-header bg-light border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-uppercase fw-bold text-muted small" style="letter-spacing: 1px;">Prescription #${p.id}</span>
                                <div class="text-dark fw-bold small">
                                    <i class="far fa-calendar-alt me-1 text-primary"></i> ${new Date(p.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}
                                </div>
                            </div>
                            <a href="/download-prescription/${p.id}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">
                                <i class="fas fa-download me-1"></i> PDF
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                ${(p.medicines || []).map(m => `
                                    <div class="list-group-item border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-pills"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">${m.medicine_name}</div>
                                                <div class="text-muted small">${m.dosage} • ${m.frequency} • ${m.duration}</div>
                                            </div>
                                        </div>
                                    </div>
                                `).join('')}
                                ${(p.medicines || []).length === 0 ? '<div class="p-4 text-center text-muted small">No medicines added yet</div>' : ''}
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            async function loadPatientHistory() {
                const list = document.getElementById('history-list');
                list.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';

                const data = await fetchHistory();
                if (!data.appointments || data.appointments.length === 0) {
                    list.innerHTML = '<p class="text-center text-muted py-4">No appointment history found.</p>';
                    return;
                }

                list.innerHTML = data.appointments.map((a, idx) => `
                    <div class="history-item" style="animation-delay: ${idx * 0.1}s">
                        <div class="history-info">
                            <div class="history-icon icon-blue"><i class="fas fa-stethoscope"></i></div>
                            <div class="history-content">
                                <div class="text-primary fw-bold small mb-1">${currentPatientName}</div>
                                <h6>${a.note ? (a.note.length > 40 ? a.note.substring(0, 40) + '...' : a.note) : 'General Consultation'}</h6>
                                <div class="history-date">
                                    <i class="far fa-calendar-check mt-1"></i> ${new Date(a.date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })} at ${a.time}
                                </div>
                            </div>
                        </div>
                        <span class="badge rounded-pill px-3 py-2 text-white ${a.status == '3' ? 'bg-success' : 'bg-info'}">
                            ${a.status == '3' ? 'Completed' : (a.status == '2' ? 'Cancelled' : (a.status == '1' ? 'Confirmed' : 'Pending'))}
                        </span>
                    </div>
                `).join('');
            }

            async function loadPatientPayments() {
                const list = document.getElementById('payments-list');
                list.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';

                const data = await fetchHistory();
                const paid = (data.appointments || []).filter(a => a.payment_status === 'paid' || a.payment_status === 'health_card');

                if (paid.length === 0) {
                    list.innerHTML = '<p class="text-center text-muted py-4">No payment records found.</p>';
                    return;
                }

                list.innerHTML = paid.map((a, idx) => `
                    <div class="history-item" style="animation-delay: ${idx * 0.1}s">
                        <div class="history-info">
                            <div class="history-icon icon-green"><i class="fas fa-receipt"></i></div>
                            <div class="history-content">
                                <div class="text-primary fw-bold small mb-1">${currentPatientName}</div>
                                <h6>Amount: $${a.fees || '0'}</h6>
                                <div class="history-date">
                                    <i class="fas fa-wallet mt-1"></i> ${a.payment_mode || 'Online'} Payment on ${new Date(a.date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}
                                </div>
                            </div>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-1 text-uppercase border-opacity-25">
                            ${a.payment_status.replace('_', ' ')}
                        </span>
                    </div>
                `).join('');
            }
        </script>
@endpush