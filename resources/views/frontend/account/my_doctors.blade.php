@extends('frontend.layout')

@section('content')
    <style>
        /* Card Container */
        .doctor-card {
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

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .doctor-profile {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 20px;
        }

        .doctor-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #eef2f6;
        }

        .doctor-info h5 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .doctor-meta {
            font-size: 0.85rem;
            color: #6c757d;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .doctor-meta i {
            width: 16px;
            color: #3498db;
        }

        .doctor-stats {
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
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-view-details:hover {
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .specialty-badge {
            background-color: #e3f2fd;
            color: #0d47a1;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 8px;
        }
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

        .icon-blue { background: #e0f2fe; color: #0369a1; }
        .icon-green { background: #dcfce7; color: #166534; }
        .icon-purple { background: #f3e8ff; color: #6b21a8; }
        .icon-orange { background: #ffedd5; color: #9a3412; }

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
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
                                <h4 class="fw-bold">My Doctors</h4>
                                <div class="badge rounded-pill px-3 py-2 bg-primary text-white">{{ count($doctors) }} Total Doctors</div>
                            </div>

                            <div class="row">
                                @if(isset($doctors) && count($doctors) > 0)
                                    @foreach($doctors as $doctor)
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="doctor-card">
                                                <div>
                                                    <div class="doctor-profile">
                                                        <img src="{{ !empty($doctor->photo) ? asset('public/assets/images/profiles/' . $doctor->photo) : 'https://ui-avatars.com/api/?name=Dr.+' . $doctor->first_name . '+' . $doctor->last_name . '&background=0D8ABC&color=fff' }}"
                                                            class="doctor-img">
                                                        <div class="doctor-info w-100">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <h5 class="mb-1">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h5>
                                                                <div class="text-warning small pt-1">
                                                                    <i class="fas fa-star"></i> {{ number_format($doctor->avg_rating, 1) }}
                                                                </div>
                                                            </div>
                                                            <div class="specialty-badge">
                                                                {{ $doctor->specialist ?? 'General' }} 
                                                                @if($doctor->education)
                                                                    <span class="text-muted fw-normal"> | {{ $doctor->education }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="doctor-meta">
                                                                <span><i class="fas fa-map-marker-alt"></i> 
                                                                    {{ implode(', ', array_filter([$doctor->city, $doctor->state])) ?: 'Location not specified' }}
                                                                </span>
                                                                @if($doctor->mobile)
                                                                <span class="mt-1"><i class="fas fa-phone-alt"></i> 
                                                                    <a href="tel:{{ $doctor->mobile }}" class="text-decoration-none text-secondary">{{ $doctor->mobile }}</a>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($doctor->about)
                                                    <div class="mb-3 text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                                        "{{ strip_tags($doctor->about) }}"
                                                    </div>
                                                    @endif

                                                    <div class="doctor-stats">
                                                        <div class="stat-item">
                                                            <span class="stat-value">{{ $doctor->total_appointments }}</span>
                                                            <span class="stat-label">Total Sessions</span>
                                                        </div>
                                                        <div class="stat-item">
                                                            <span class="stat-value">{{ $doctor->last_visit ? \Carbon\Carbon::parse($doctor->last_visit)->format('M d, y') : 'N/A' }}</span>
                                                            <span class="stat-label">Last Session</span>
                                                        </div>
                                                        <div class="stat-item">
                                                            <span class="stat-value">{{ $doctor->experience ? $doctor->experience . ' Yrs' : 'N/A' }}</span>
                                                            <span class="stat-label">Experience</span>
                                                        </div>
                                                        <div class="stat-item">
                                                            <span class="stat-value">{{ $doctor->fees ? '₹' . $doctor->fees : 'Free' }}</span>
                                                            <span class="stat-label">Consult Fee</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="d-flex gap-2 mt-3">
                                                    <a href="/doctor/{{ $doctor->doctor_table_id }}/{{ Str::slug($doctor->first_name . '-' . $doctor->last_name) }}?book=true" class="btn btn-primary flex-fill fw-bold" style="border-radius: 12px; padding: 10px;border-radius: 12px; padding: 10px; display: flex; justify-content: center; align-items: center; gap: 10px;">
                                                        <i class="fas fa-calendar-plus me-1"></i> Book Again
                                                    </a>
                                                    <button onclick="openDoctorDetails({{ $doctor->user_id }})" class="btn-view-details flex-fill" style="padding: 10px; width: auto; background: #eef2f6; color: #0d6efd;">
                                                        View Details
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                                            <p class="text-muted text-lg font-weight-bold">No connected doctors yet.</p>
                                            <p class="text-muted small">You haven't completed any appointments with a doctor yet. After your first visit, your doctor will appear here.</p>
                                            <a href="/doctors" class="btn btn-primary mt-3 rounded-pill px-4 py-2 shadow-sm font-weight-bold">Browse Doctors</a>
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
    <!-- Doctor Details Modal -->
    <div class="modal fade" id="doctorDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-profile-header">
                        <img id="modalDoctorImg" src="" class="modal-profile-img" alt="Doctor">
                        <div class="modal-profile-info">
                            <h3 id="modalDoctorName">-</h3>
                            <div class="modal-profile-badges">
                                <span id="hdr-specialty" class="p-badge p-badge-gender">-</span>
                                <span id="hdr-experience" class="p-badge p-badge-age">-</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-overview">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-history" onclick="loadDoctorHistory()">Appt History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-prescriptions" onclick="loadDoctorPrescriptions()">Prescriptions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-payments" onclick="loadDoctorPayments()">Payments</a>
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
                                    <div class="info-card-icon icon-green"><i class="fas fa-graduation-cap"></i></div>
                                    <div>
                                        <div class="info-card-label">Education</div>
                                        <div id="ov-education" class="info-card-value">-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <div class="info-card-icon icon-orange"><i class="fas fa-rupee-sign"></i></div>
                                    <div>
                                        <div class="info-card-label">Consultation Fee</div>
                                        <div id="ov-fees" class="info-card-value">-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="info-card">
                                    <div class="info-card-icon icon-blue"><i class="fas fa-map-marker-alt"></i></div>
                                    <div>
                                        <div class="info-card-label">Location</div>
                                        <div id="ov-location" class="info-card-value">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-2 d-flex gap-3">
                            <a href="javascript:void(0)" id="btn-book" class="btn btn-primary flex-fill py-3 rounded-4 shadow-sm fw-bold">
                                <i class="fas fa-calendar-plus me-2"></i> Book Appointment
                            </a>
                            <a href="javascript:void(0)" id="btn-profile" class="btn btn-outline-primary flex-fill py-3 rounded-4 shadow-sm fw-bold">
                                <i class="fas fa-user-md me-2"></i> Full Profile
                            </a>
                        </div>
                    </div>

                    <!-- Appt History -->
                    <div class="tab-pane fade modal-body" id="tab-history">
                        <div id="history-list">
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status"></div>
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
        let currentDoctorId = null;
        let currentDoctorTableId = null;
        let currentDoctorName = '';
        let doctorData = @json($doctors);

        function openDoctorDetails(userId) {
            const doctor = doctorData.find(d => d.user_id == userId);
            if (!doctor) return;

            const name = 'Dr. ' + doctor.first_name + ' ' + (doctor.last_name || '');
            const doctorTableId = doctor.doctor_table_id;

            currentDoctorId = userId;
            currentDoctorTableId = doctorTableId;
            currentDoctorName = name;

            const avatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=0D8ABC&color=fff`;
            const photo = doctor.photo ? `{{ asset('public/assets/images/profiles') }}/${doctor.photo}` : avatar;

            document.getElementById('modalDoctorImg').src = photo;
            document.getElementById('modalDoctorName').innerText = name;

            document.getElementById('hdr-specialty').innerText = doctor.specialist || 'General';
            document.getElementById('hdr-experience').innerText = doctor.experience ? `${doctor.experience} Yrs Exp` : 'N/A Exp';

            document.getElementById('ov-mobile').innerText = doctor.mobile || 'Not provided';
            document.getElementById('ov-email').innerText = doctor.email || 'Not provided';
            document.getElementById('ov-education').innerText = doctor.education || 'Not provided';
            document.getElementById('ov-fees').innerText = doctor.fees ? `₹${doctor.fees}` : 'Free';
            
            const location = [doctor.city, doctor.state].filter(Boolean).join(', ');
            document.getElementById('ov-location').innerText = location || 'Not specified';

            const slug = name.replace('Dr. ', '').trim().toLowerCase().replace(/ /g, '-');
            document.getElementById('btn-profile').href = `/doctor/${doctorTableId}/${slug}`;
            document.getElementById('btn-book').href = `/doctor/${doctorTableId}/${slug}?book=true`;

            // Reset tabs to first tab (Overview)
            const tabEl = document.querySelector('a[href="#tab-overview"]');
            const tab = new bootstrap.Tab(tabEl);
            tab.show();

            const modalEl = document.getElementById('doctorDetailsModal');
            let modal = bootstrap.Modal.getInstance(modalEl);
            if (!modal) {
                modal = new bootstrap.Modal(modalEl);
            }
            modal.show();
        }

        async function fetchHistory() {
            const response = await fetch(`/get-doctor-details/${currentDoctorId}`);
            return await response.json();
        }

        async function loadDoctorHistory() {
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
                            <div class="text-primary fw-bold small mb-1">${currentDoctorName}</div>
                            <h6>${a.note ? (a.note.length > 40 ? a.note.substring(0, 40) + '...' : a.note) : 'General Consultation'}</h6>
                            <div class="history-date">
                                <i class="far fa-calendar-check"></i> ${new Date(a.date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })} at ${a.time}
                            </div>
                        </div>
                    </div>
                    <span class="badge rounded-pill px-3 py-2 text-white ${a.status == '3' ? 'bg-success' : (a.status == '2' ? 'bg-danger' : 'bg-info')}">
                        ${a.status == '3' ? 'Completed' : (a.status == '2' ? 'Cancelled' : (a.status == '1' ? 'Confirmed' : 'Pending'))}
                    </span>
                </div>
            `).join('');
        }

        async function loadDoctorPrescriptions() {
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
                                </div>
                            `).join('')}
                            ${(p.medicines || []).length === 0 ? '<div class="p-4 text-center text-muted small">No medicines added yet</div>' : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        async function loadDoctorPayments() {
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
                            <div class="text-primary fw-bold small mb-1">${currentDoctorName}</div>
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
    </script>
@endpush