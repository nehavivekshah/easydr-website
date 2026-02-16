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

        /* Modal Enhancements */
        .modal-content {
            border-radius: 24px;
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .modal-header {
            /* background: linear-gradient(135deg, #f8f9fa 0%, #eef2f6 100%); */
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
            background: #e0f2fe;
            color: #0369a1;
        }

        .p-badge-blood {
            background: #fee2e2;
            color: #b91c1c;
        }

        .p-badge-age {
            background: #f0fdf4;
            color: #15803d;
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
            /* margin-bottom: 12px; */
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

        .medicine-search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            z-index: 1050;
            max-height: 300px;
            overflow-y: auto;
            margin-top: 5px;
            display: none;
        }

        .medicine-search-item {
            padding: 12px 16px;
            cursor: pointer;
            transition: all 0.2s;
            border-bottom: 1px solid #f1f5f9;
        }

        .medicine-search-item:last-child {
            border-bottom: none;
        }

        .medicine-search-item:hover {
            background: #f8fafc;
        }

        .medicine-search-item .med-name {
            font-weight: 600;
            color: #1e293b;
            display: block;
        }

        .medicine-search-item .med-meta {
            font-size: 0.75rem;
            color: #64748b;
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
                                        <div class="col-lg-6 col-md-12 mb-4">
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
                                                    onclick="openPatientDetails({{ $patient->id }}, '{{ addslashes($patient->first_name . " " . $patient->last_name) }}', {{ $patient->patient_table_id }})">
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
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-refer">Refer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-add-prescription"
                            onclick="preparePrescriptionForm()">Add Prescription</a>
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
                        <div class="mt-4 pt-2">
                            <a href="/messages" id="btn-chat" class="btn btn-primary w-100 py-3 rounded-4 shadow-sm">
                                <i class="fas fa-comment-dots me-2"></i> Start Consultation via Chat
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

                    <!-- Add Prescription -->
                    <div class="tab-pane fade modal-body" id="tab-add-prescription">
                        <form id="prescriptionForm" class="row g-3">
                            <input type="hidden" id="presc-patient-id">
                            <input type="hidden" id="presc-id">
                            <input type="hidden" id="presc-medicine-id">
                            <div class="col-12 position-relative">
                                <label class="form-label fw-bold small text-uppercase">Medicine Name</label>
                                <input type="text" class="form-control rounded-3 p-3" id="presc-medicine" autocomplete="off"
                                    required placeholder="Search for medicine (e.g. Paracetamol)...">
                                <div id="medicine-search-results" class="medicine-search-results"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Dosage</label>
                                <select class="form-select rounded-3 p-3" id="presc-dosage" required>
                                    <option value="">Select Dosage</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Frequency</label>
                                <select class="form-select rounded-3 p-3" id="presc-frequency" required>
                                    <option value="">Select Frequency</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Duration</label>
                                <select class="form-select rounded-3 p-3" id="presc-duration" required>
                                    <option value="">Select Duration</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Route</label>
                                <select class="form-select rounded-3 p-3" id="presc-route">
                                    <option value="">Select Route</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-uppercase">Food Intake (Meal)</label>
                                <select class="form-select rounded-3 p-3" id="presc-meal">
                                    <option value="">Select Timing</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-uppercase">Instructions / Notes</label>
                                <textarea class="form-control rounded-3 p-3" id="presc-notes" rows="3"
                                    placeholder="Additional instructions for the patient..."></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" id="presc-submit-btn"
                                    class="btn btn-primary w-100 py-3 rounded-4 shadow-sm fw-bold">
                                    <i class="fas fa-plus-circle me-1"></i> Save Prescription
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentPatientId = null;
            let currentPatientTableId = null;
            let patientData = @json($patients);

            function openPatientDetails(userId, name, patientTableId) {
                currentPatientId = userId;
                currentPatientTableId = patientTableId;
                // Use loose equality == in case of string/number mismatch
                const patient = patientData.find(p => p.id == userId);

                const avatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=0D8ABC&color=fff`;
                const photo = patient.photo ? `{{ asset('public/assets/images/profiles') }}/${patient.photo}` : avatar;

                document.getElementById('modalPatientImg').src = photo;
                document.getElementById('modalPatientName').innerText = name;

                // Badges
                const gender = patient.gender == '1' ? 'Male' : (patient.gender == '2' ? 'Female' : 'Others');
                document.getElementById('hdr-gender').innerText = gender;
                document.getElementById('hdr-blood').innerText = patient.blood_group || 'Unknown';

                // Simple age calculation if DOB exists
                let ageStr = 'Age: N/A';
                if (patient.dob) {
                    const birthYear = new Date(patient.dob).getFullYear();
                    const currentYear = new Date().getFullYear();
                    ageStr = `${currentYear - birthYear} Years Old`;
                }
                document.getElementById('hdr-age').innerText = ageStr;

                // Info Cards
                document.getElementById('ov-mobile').innerText = patient.mobile || 'Not provided';
                document.getElementById('ov-email').innerText = patient.email || 'Not provided';
                document.getElementById('ov-dob').innerText = patient.dob ? new Date(patient.dob).toLocaleDateString() : 'Not provided';
                document.getElementById('ov-city').innerText = patient.city || 'Not specifies';
                document.getElementById('ov-address').innerText = [patient.address, patient.city, patient.state].filter(Boolean).join(', ') || 'No address data';

                document.getElementById('btn-chat').href = `/messages?user_id=${userId}`;

                // Reset tabs to first tab (Overview)
                const tabEl = document.querySelector('a[href="#tab-overview"]');
                const tab = new bootstrap.Tab(tabEl);
                tab.show();

                // Get or create modal instance
                const modalEl = document.getElementById('patientDetailsModal');
                let modal = bootstrap.Modal.getInstance(modalEl);
                if (!modal) {
                    modal = new bootstrap.Modal(modalEl);
                }
                modal.show();
            }

            async function fetchHistory() {
                const response = await fetch(`/get-patient-details/${currentPatientTableId}`);
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

                list.innerHTML = data.prescriptions.map((p, idx) => `
                                                <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden" style="animation: slideIn 0.3s ease-out forwards; animation-delay: ${idx * 0.1}s">
                                                    <div class="card-header bg-light border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span class="text-uppercase fw-bold text-muted small letter-spacing-1">Prescription #${p.id}</span>
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
                                                                        <div class="medicine-icon me-3 bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                            <i class="fas fa-pills"></i>
                                                                        </div>
                                                                        <div>
                                                                            <div class="fw-bold text-dark">${m.medicine_name}</div>
                                                                            <div class="text-muted small">${m.dosage} • ${m.frequency} • ${m.duration}</div>
                                                                        </div>
                                                                    </div>
                                                                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick='editMedicine(${JSON.stringify(m)}, ${p.id})'>
                                                                        <i class="fas fa-edit me-1"></i> Edit
                                                                    </button>
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
                if (data.appointments.length === 0) {
                    list.innerHTML = '<p class="text-center text-muted py-4">No appointment history found.</p>';
                    return;
                }

                list.innerHTML = data.appointments.map((a, idx) => `
                                                                                                                                                                                        <div class="history-item" style="animation-delay: ${idx * 0.1}s">
                                                                                                                                                                                            <div class="history-info">
                                                                                                                                                                                                <div class="history-icon icon-blue"><i class="fas fa-stethoscope"></i></div>
                                                                                                                                                                                                <div class="history-content">
                                                                                                                                                                                                    <h6>${a.note ? (a.note.length > 40 ? a.note.substring(0, 40) + '...' : a.note) : 'General Consultation'}</h6>
                                                                                                                                                                                                    <div class="history-date">
                                                                                                                                                                                                        <i class="far fa-calendar-check"></i> ${new Date(a.date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })} at ${a.time}
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
                const paid = data.appointments.filter(a => a.payment_status === 'paid' || a.payment_status === 'health_card');

                if (paid.length === 0) {
                    list.innerHTML = '<p class="text-center text-muted py-4">No payment records found.</p>';
                    return;
                }

                list.innerHTML = paid.map((a, idx) => `
                                                                                                                                                                                        <div class="history-item" style="animation-delay: ${idx * 0.1}s">
                                                                                                                                                                                            <div class="history-info">
                                                                                                                                                                                                <div class="history-icon icon-green"><i class="fas fa-receipt"></i></div>
                                                                                                                                                                                                <div class="history-content">
                                                                                                                                                                                                    <h6>Amount: ₹${a.fees || '0'}</h6>
                                                                                                                                                                                                    <div class="history-date">
                                                                                                                                                                                                        <i class="fas fa-wallet"></i> ${a.payment_mode || 'Online'} Payment on ${new Date(a.date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                                                                                                                                                                                ${a.payment_status.replace('_', ' ').toUpperCase()}
                                                                                                                                                                                            </span>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    `).join('');
            }

            document.getElementById('referralForm').onsubmit = function (e) {
                e.preventDefault();
                alert('Referral request sent successfully!');
                bootstrap.Modal.getInstance(document.getElementById('patientDetailsModal')).hide();
            }

            // Prescription Creation Logic
            let metaDataLoaded = false;
            async function preparePrescriptionForm() {
                document.getElementById('prescriptionForm').reset();
                if (document.getElementById('medicine-search-results')) document.getElementById('medicine-search-results').style.display = 'none';
                document.getElementById('presc-patient-id').value = currentPatientTableId;
                document.getElementById('presc-id').value = '';
                document.getElementById('presc-medicine-id').value = '';

                const btn = document.getElementById('presc-submit-btn');
                btn.innerHTML = '<i class="fas fa-plus-circle me-1"></i> Save Prescription';
                btn.className = "btn btn-primary w-100 py-3 rounded-4 shadow-sm fw-bold";

                if (!metaDataLoaded) {
                    try {
                        const response = await fetch('/get-prescription-meta');
                        const data = await response.json();

                        populateSelect('presc-dosage', data.dosages, 'dosage');
                        populateSelect('presc-frequency', data.frequencies, 'frequency');
                        populateSelect('presc-duration', data.durations, 'duration');
                        populateSelect('presc-route', data.routes, 'route');
                        populateSelect('presc-meal', data.meals, 'meal');

                        metaDataLoaded = true;
                    } catch (e) {
                        console.error("Failed to load prescription metadata", e);
                    }
                }
            }

            function editMedicine(m, prescriptionId) {
                // Populate form
                document.getElementById('presc-id').value = prescriptionId;
                document.getElementById('presc-medicine-id').value = m.id;
                document.getElementById('presc-medicine').value = m.medicine_name;
                document.getElementById('presc-dosage').value = m.dosage;
                document.getElementById('presc-frequency').value = m.frequency;
                document.getElementById('presc-duration').value = m.duration;
                document.getElementById('presc-route').value = m.route || '';
                document.getElementById('presc-meal').value = m.meal || '';
                document.getElementById('presc-notes').value = m.notes || '';

                // Change button style
                const btn = document.getElementById('presc-submit-btn');
                btn.innerHTML = '<i class="fas fa-save me-1"></i> Update Medicine';
                btn.className = "btn btn-info w-100 py-3 rounded-4 shadow-sm fw-bold text-white";

                // Switch tab
                const addTab = document.querySelector('a[href="#tab-add-prescription"]');
                const tabInstance = bootstrap.Tab.getOrCreateInstance(addTab);
                tabInstance.show();
            }

            function populateSelect(id, items, field) {
                const select = document.getElementById(id);
                // Clear existing options except first
                while (select.options.length > 1) select.remove(1);
                items.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item[field];
                    opt.innerText = item[field];
                    select.appendChild(opt);
                });
            }

            // Medicine Search logic
            const medInput = document.getElementById('presc-medicine');
            const medResults = document.getElementById('medicine-search-results');
            let searchTimeout = null;

            medInput.addEventListener('input', (e) => {
                const query = e.target.value;
                clearTimeout(searchTimeout);

                if (query.length < 2) {
                    medResults.style.display = 'none';
                    return;
                }

                searchTimeout = setTimeout(async () => {
                    try {
                        const response = await fetch(`/search-medicines?q=${encodeURIComponent(query)}`);
                        const data = await response.json();

                        if (data.length > 0) {
                            medResults.innerHTML = data.map(m => `
                                        <div class="medicine-search-item" onclick="selectMedicine('${m.name.replace(/'/g, "\\'")}')">
                                            <span class="med-name">${m.name}</span>
                                            <span class="med-meta">${m.medicine_category || 'General'}</span>
                                        </div>
                                    `).join('');
                            medResults.style.display = 'block';
                        } else {
                            medResults.style.display = 'none';
                        }
                    } catch (e) {
                        console.error("Search failed", e);
                    }
                }, 300);
            });

            function selectMedicine(name) {
                medInput.value = name;
                medResults.style.display = 'none';
            }

            // Close results on click outside
            document.addEventListener('click', (e) => {
                const medInput = document.getElementById('presc-medicine');
                const medResults = document.getElementById('medicine-search-results');
                if (medInput && !medInput.contains(e.target) && !medResults.contains(e.target)) {
                    medResults.style.display = 'none';
                }
            });

            document.getElementById('prescriptionForm').onsubmit = async function (e) {
                e.preventDefault();
                const btn = document.getElementById('presc-submit-btn');
                const originalHtml = btn.innerHTML;

                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';

                const medicineId = document.getElementById('presc-medicine-id').value;
                const isUpdate = !!medicineId;

                const formData = {
                    doctor_id: {{ Auth::id() }},
                    patient_id: document.getElementById('presc-patient-id').value,
                    prescribed_id: document.getElementById('presc-id').value,
                    prescribed_date: new Date().toISOString().split('T')[0],
                    medicine_name: document.getElementById('presc-medicine').value,
                    dosage: document.getElementById('presc-dosage').value,
                    frequency: document.getElementById('presc-frequency').value,
                    duration: document.getElementById('presc-duration').value,
                    route: document.getElementById('presc-route').value,
                    meal: document.getElementById('presc-meal').value,
                    notes: document.getElementById('presc-notes').value,
                    _token: '{{ csrf_token() }}'
                };

                const url = isUpdate ? `/update-prescription-medicine/${medicineId}` : '/create-prescription';
                const method = isUpdate ? 'PUT' : 'POST';

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    });

                    const result = await response.json();

                    if (response.ok) {
                        alert('Prescription saved successfully!');
                        document.getElementById('prescriptionForm').reset();

                        // Switch to prescriptions tab to see the result
                        const prescTab = document.querySelector('a[href="#tab-prescriptions"]');
                        bootstrap.Tab.getInstance(prescTab).show();
                        loadPatientPrescriptions();
                    } else {
                        alert('Failed to save prescription: ' + (result.message || 'Unknown error'));
                    }
                } catch (error) {
                    console.error("Prescription error:", error);
                    alert('An error occurred while saving the prescription.');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                }
            };
        </script>
    @endpush
@endsection