@extends('frontend.layout')

@section('content')
    <style>
        /* Card Container */
        .patient-card {
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .patient-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .patient-profile {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 20px;
        }

        .patient-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #eef2f6;
        }

        .patient-info h5 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .patient-meta {
            font-size: 0.85rem;
            color: #6c757d;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .patient-meta i {
            width: 16px;
            color: #3498db;
        }

        .patient-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            display: block;
            font-weight: 700;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-view-details {
            width: 100%;
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-view-details:hover {
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            color: white;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 20px;
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid #f0f0f0;
            padding: 24px;
        }

        .nav-tabs-custom {
            border-bottom: 2px solid #f0f0f0;
            gap: 20px;
            padding: 0 24px;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            padding: 15px 0;
            color: #6c757d;
            font-weight: 600;
            position: relative;
        }

        .nav-tabs-custom .nav-link.active {
            color: #0d6efd;
            background: none;
        }

        .nav-tabs-custom .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #0d6efd;
        }

        .modal-body {
            padding: 24px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .history-item {
            padding: 15px;
            border-radius: 12px;
            background: #f8f9fa;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .history-info h6 {
            font-weight: 700;
            margin-bottom: 2px;
        }

        .history-date {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .btn-action-sm {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>

    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    <!-- Content Area -->
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold">My Patients</h4>
                                <div class="badge bg-primary rounded-pill px-3 py-2">{{ count($patients) }} Total Patients
                                </div>
                            </div>

                            <div class="row">
                                @if(isset($patients) && count($patients) > 0)
                                    @foreach($patients as $patient)
                                        <div class="col-lg-6 col-md-12 mb-4 wow fadeInUp">
                                            <div class="patient-card">
                                                <div>
                                                    <div class="patient-profile">
                                                        <img src="{{ !empty($patient->photo) ? asset('public/assets/images/profiles/' . $patient->photo) : 'https://ui-avatars.com/api/?name=' . $patient->first_name . '+' . $patient->last_name . '&background=0D8ABC&color=fff' }}"
                                                            class="patient-img">
                                                        <div class="patient-info">
                                                            <h5>{{ $patient->first_name }} {{ $patient->last_name }}</h5>
                                                            <div class="patient-meta">
                                                                <span><i class="fas fa-phone-alt"></i> {{ $patient->mobile }}</span>
                                                                <span><i class="fas fa-envelope"></i> {{ $patient->email }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="patient-stats">
                                                        <div class="stat-item">
                                                            <span class="stat-value">{{ $patient->total_appointments }}</span>
                                                            <span class="stat-label">Total Visits</span>
                                                        </div>
                                                        <div class="stat-item">
                                                            <span
                                                                class="stat-value">{{ $patient->last_visit ? \Carbon\Carbon::parse($patient->last_visit)->format('d M') : 'N/A' }}</span>
                                                            <span class="stat-label">Last Visit</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button class="btn-view-details"
                                                    onclick="openPatientDetails({{ $patient->id }}, '{{ $patient->first_name }} {{ $patient->last_name }}')">
                                                    View Patient Details
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No patient records found.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Patient Details Modal -->
    <div class="modal fade" id="patientDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalPatientName">Patient Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-refer">Refer</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Overview -->
                    <div class="tab-pane fade show active modal-body" id="tab-overview">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small text-uppercase fw-bold">Contact Number</label>
                                <p id="ov-mobile" class="fw-bold">-</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small text-uppercase fw-bold">Email Address</label>
                                <p id="ov-email" class="fw-bold">-</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="text-muted small text-uppercase fw-bold">Date of Birth</label>
                                <p id="ov-dob" class="fw-bold">-</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="text-muted small text-uppercase fw-bold">Gender</label>
                                <p id="ov-gender" class="fw-bold">-</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="text-muted small text-uppercase fw-bold">Blood Group</label>
                                <p id="ov-blood" class="fw-bold">-</p>
                            </div>
                            <div class="col-12">
                                <label class="text-muted small text-uppercase fw-bold">Address</label>
                                <p id="ov-address" class="fw-bold">-</p>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex gap-2">
                            <a href="/messages" id="btn-chat" class="btn btn-outline-primary flex-grow-1 py-2 rounded-3">
                                <i class="fas fa-comment-dots me-2"></i> Open Chat
                            </a>
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

                    <!-- Referral -->
                    <div class="tab-pane fade modal-body" id="tab-refer">
                        <form id="referralForm">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Select Specialist</label>
                                <select class="form-select rounded-3 p-3" id="refer-specialist">
                                    <option value="">Choose Specialty...</option>
                                    @foreach($specialists as $spec)
                                        <option value="{{ $spec->id }}">{{ $spec->specialist }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Select Doctor</label>
                                <select class="form-select rounded-3 p-3" id="refer-doctor">
                                    <option value="">Choose Doctor...</option>
                                    @foreach($doctors as $doc)
                                        <option value="{{ $doc->id }}">{{ $doc->first_name }} {{ $doc->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Reason for Referral</label>
                                <textarea class="form-control rounded-3" rows="3" placeholder="Enter reason..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold">Send Referral
                                Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentPatientId = null;
            let patientData = @json($patients);

            function openPatientDetails(id, name) {
                currentPatientId = id;
                const patient = patientData.find(p => p.id === id);

                document.getElementById('modalPatientName').innerText = name;
                document.getElementById('ov-mobile').innerText = patient.mobile || '-';
                document.getElementById('ov-email').innerText = patient.email || '-';
                document.getElementById('ov-dob').innerText = patient.dob || 'Unspecified';
                document.getElementById('ov-gender').innerText = patient.gender == '1' ? 'Male' : (patient.gender == '2' ? 'Female' : 'Others');
                document.getElementById('ov-blood').innerText = patient.blood_group || 'Unknown';
                document.getElementById('ov-address').innerText = [patient.address, patient.city, patient.state].filter(Boolean).join(', ') || '-';

                document.getElementById('btn-chat').href = `/messages?user_id=${id}`;

                // Reset tabs
                const tabEl = document.querySelector('a[href="#tab-overview"]');
                const tab = new bootstrap.Tab(tabEl);
                tab.show();

                const modal = new bootstrap.Modal(document.getElementById('patientDetailsModal'));
                modal.show();
            }

            async function fetchHistory() {
                const response = await fetch(`/get-patient-details/${currentPatientId}`);
                return await response.json();
            }

            async function loadPatientPrescriptions() {
                const list = document.getElementById('prescriptions-list');
                list.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';

                const data = await fetchHistory();
                if (data.prescriptions.length === 0) {
                    list.innerHTML = '<p class="text-center text-muted py-4">No prescriptions found.</p>';
                    return;
                }

                list.innerHTML = data.prescriptions.map(p => `
                        <div class="history-item">
                            <div class="history-info">
                                <h6>Prescription #${p.id}</h6>
                                <span class="history-date">${new Date(p.created_at).toLocaleDateString()}</span>
                            </div>
                            <a href="/download-prescription/${p.id}" class="btn btn-sm btn-outline-primary btn-action-sm">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    `).join('');
            }

            async function loadPatientHistory() {
                const list = document.getElementById('history-list');
                list.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';

                const data = await fetchHistory();
                if (data.appointments.length === 0) {
                    list.innerHTML = '<p class="text-center text-muted py-4">No appointment history found.</p>';
                    return;
                }

                list.innerHTML = data.appointments.map(a => `
                        <div class="history-item">
                            <div class="history-info">
                                <h6>${a.note ? (a.note.length > 30 ? a.note.substring(0, 30) + '...' : a.note) : 'Consultation'}</h6>
                                <span class="history-date">${new Date(a.date).toLocaleDateString()} at ${a.time}</span>
                            </div>
                            <span class="badge ${a.status == '3' ? 'bg-success' : 'bg-info'}">${a.status == '3' ? 'Completed' : (a.status == '2' ? 'Cancelled' : (a.status == '1' ? 'Confirmed' : 'Pending'))}</span>
                        </div>
                    `).join('');
            }

            async function loadPatientPayments() {
                const list = document.getElementById('payments-list');
                list.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';

                const data = await fetchHistory();
                const paid = data.appointments.filter(a => a.payment_status === 'paid' || a.payment_status === 'health_card');

                if (paid.length === 0) {
                    list.innerHTML = '<p class="text-center text-muted py-4">No payment records found.</p>';
                    return;
                }

                list.innerHTML = paid.map(a => `
                        <div class="history-item">
                            <div class="history-info">
                                <h6>Amount: ₹${a.fees || '0'}</h6>
                                <span class="history-date">${new Date(a.date).toLocaleDateString()} via ${a.payment_mode || 'Online'}</span>
                            </div>
                            <span class="badge bg-success">${a.payment_status.replace('_', ' ').toUpperCase()}</span>
                        </div>
                    `).join('');
            }

            document.getElementById('referralForm').onsubmit = function (e) {
                e.preventDefault();
                alert('Referral request sent successfully!');
                bootstrap.Modal.getInstance(document.getElementById('patientDetailsModal')).hide();
            }
        </script>
    @endpush
@endsection