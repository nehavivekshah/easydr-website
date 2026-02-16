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
            background: linear-gradient(135deg, #f8f9fa 0%, #eef2f6 100%);
            border-bottom: none;
            padding: 30px;
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
            border: 4px solid #fff;
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
            background: #fff;
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
            margin-bottom: 12px;
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
                </ul>

                <div class="tab-content overflow-auto" style="max-height: 60vh;">
                    <!-- Overview -->
                    <div class="tab-pane fade show active modal-body" id="tab-overview">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-card-icon icon-blue"><i class="fas fa-phone-alt"></i></div>
                                    <div class="info-card-label">Mobile Number</div>
                                    <div id="ov-mobile" class="info-card-value">-</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-card-icon icon-purple"><i class="fas fa-envelope"></i></div>
                                    <div class="info-card-label">Email Address</div>
                                    <div id="ov-email" class="info-card-value">-</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-card-icon icon-green"><i class="fas fa-birthday-cake"></i></div>
                                    <div class="info-card-label">Date of Birth</div>
                                    <div id="ov-dob" class="info-card-value">-</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-card-icon icon-orange"><i class="fas fa-map-marker-alt"></i></div>
                                    <div class="info-card-label">Location / City</div>
                                    <div id="ov-city" class="info-card-value">-</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-card">
                                    <div class="info-card-icon icon-blue"><i class="fas fa-home"></i></div>
                                    <div class="info-card-label">Full Address</div>
                                    <div id="ov-address" class="info-card-value">-</div>
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
                        <div class="history-item" style="animation-delay: ${idx * 0.1}s">
                            <div class="history-info">
                                <div class="history-icon icon-purple"><i class="fas fa-file-prescription"></i></div>
                                <div class="history-content">
                                    <h6>Prescription #${p.id}</h6>
                                    <div class="history-date">
                                        <i class="far fa-calendar-alt"></i> ${new Date(p.created_at).toLocaleDateString('en-GB', {day: '2-digit', month: 'short', year: 'numeric'})}
                                    </div>
                                </div>
                            </div>
                            <a href="/download-prescription/${p.id}" class="btn btn-sm btn-outline-primary px-3 rounded-3 fw-bold">
                                <i class="fas fa-download me-1"></i> Download
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

                list.innerHTML = data.appointments.map((a, idx) => `
                        <div class="history-item" style="animation-delay: ${idx * 0.1}s">
                            <div class="history-info">
                                <div class="history-icon icon-blue"><i class="fas fa-stethoscope"></i></div>
                                <div class="history-content">
                                    <h6>${a.note ? (a.note.length > 40 ? a.note.substring(0, 40) + '...' : a.note) : 'General Consultation'}</h6>
                                    <div class="history-date">
                                        <i class="far fa-calendar-check"></i> ${new Date(a.date).toLocaleDateString('en-GB', {day: '2-digit', month: 'short', year: 'numeric'})} at ${a.time}
                                    </div>
                                </div>
                            </div>
                            <span class="badge rounded-pill px-3 py-2 ${a.status == '3' ? 'bg-success' : 'bg-info'}">
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
                                        <i class="fas fa-wallet"></i> ${a.payment_mode || 'Online'} Payment on ${new Date(a.date).toLocaleDateString('en-GB', {day: '2-digit', month: 'short', year: 'numeric'})}
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
        </script>
    @endpush
@endsection