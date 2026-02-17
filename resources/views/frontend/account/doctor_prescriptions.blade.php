@extends('frontend.layout')

@section('content')
    <main class="dashboard-container">
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <div class="section-title mb-4 d-flex align-items-center justify-content-between">
                                <h3 class="fw-bold mb-0">Issued Prescriptions</h3>
                                <div class="badge badge-pill badge-soft-primary px-3 py-2">
                                    {{ $prescriptions->total() }} Total Prescriptions
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mb-4">
                                <a href="{{ url('/my-patients') }}" class="btn btn-primary btn-pill-modern px-4 shadow-sm">
                                    <i class="fas fa-plus mr-1"></i> New Prescription
                                </a>
                            </div>

                            <!-- Filters -->
                            <div class="filters-container mb-4">
                                <form action="{{ url('/doctor-prescriptions') }}" method="GET">
                                    <div class="d-flex flex-wrap align-items-center" style="gap: 15px;">
                                        <div class="flex-grow-1" style="min-width: 300px;">
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-0 py-0 px-3"><i class="fas fa-search text-muted"></i></span>
                                                </div>
                                                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by Patient Name or Prescription ID...">
                                            </div>
                                        </div>
                                        <div style="min-width: 180px;">
                                            <input type="date" name="date" value="{{ request('date') }}" class="form-control rounded-lg border px-3">
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary btn-pill-modern shadow-sm px-4">
                                                <i class="fas fa-filter mr-1"></i> Filter
                                            </button>
                                        </div>
                                        @if(request()->has('q') || request()->has('date'))
                                            <div>
                                                <a href="{{ url('/doctor-prescriptions') }}" class="btn btn-light btn-pill-modern border px-4">Clear</a>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>

                            <!-- Prescriptions Table -->
                            <div class="card-modern">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-modern mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>Patient Name</th>
                                                    <th>Prescribed On</th>
                                                    <th>Medicines</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($prescriptions as $index => $p)
                                                    <tr class="animate-fade-in-up" style="animation-delay: {{ $index * 0.05 }}s">
                                                        <td class="fw-bold text-primary">#{{ $p->id }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @if($p->patient_image && file_exists(public_path($p->patient_image)))
                                                                    <img src="{{ asset($p->patient_image) }}" class="mr-3 shadow-sm" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #fff;">
                                                                @else
                                                                    <div class="avatar-initials mr-3 shadow-sm" style="background: #f0f7ff; color: #0d6efd; border: 1px solid #c2d9ff;">
                                                                        <i class="fas fa-user small"></i>
                                                                    </div>
                                                                @endif
                                                                <div>
                                                                    <span class="d-block fw-bold text-dark">{{ $p->patient_first_name }} {{ $p->patient_last_name }}</span>
                                                                    <small class="text-muted mb-0">Record ID: <span class="text-primary-emphasis fw-medium">#{{ $p->patient_id }}</span></small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <span class="text-dark fw-bold">{{ date('d M, Y', strtotime($p->prescribed_date)) }}</span>
                                                                <small class="text-muted"><i class="far fa-clock mr-1 small"></i>{{ date('h:i A', strtotime($p->created_at)) }}</small>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-primary badge-pill-modern shadow-sm">
                                                                <i class="fas fa-pills mr-1"></i> {{ $p->medicine_count }} {{ $p->medicine_count == 1 ? 'Item' : 'Items' }}
                                                            </span>
                                                        </td>
                                                        <td class="text-right">
                                                            <div class="d-flex justify-content-end align-items-center" style="gap: 8px;">
                                                                <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold text-primary shadow-sm" 
                                                                        onclick="viewMedicines({{ json_encode($p->medicines) }}, '{{ $p->patient_first_name }} {{ $p->patient_last_name }}', {{ $p->id }}, '{{ $p->patient_image ? asset($p->patient_image) : '' }}', {{ $p->patient_id }})">
                                                                    <i class="fas fa-eye mr-1"></i> View
                                                                </button>
                                                                <a href="{{ url('/my-patients?edit_prescription=' . $p->id . '&patient_id=' . $p->patient_id) }}" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold text-info shadow-sm">
                                                                    <i class="fas fa-edit mr-1"></i> Edit
                                                                </a>
                                                                <a href="{{ route('downloadPrescription', $p->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-3 fw-bold shadow-sm">
                                                                    <i class="fas fa-download mr-1"></i> PDF
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-5">
                                                            <div class="mb-3">
                                                                <i class="fas fa-file-medical text-muted" style="font-size: 48px; opacity: 0.3;"></i>
                                                            </div>
                                                            <h6 class="text-muted">No prescriptions found.</h6>
                                                            <p class="small text-muted mb-4">Start by issuing a new prescription to a patient.</p>
                                                            <a href="{{ url('/my-patients') }}" class="btn btn-primary btn-pill-modern px-4 shadow-sm">Issue New Prescription</a>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    @if($prescriptions->hasPages())
                                        <div class="p-4 border-top bg-light">
                                            {{ $prescriptions->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Medicine Summary Modal -->
    <div class="modal fade" id="medicineModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius: 24px;">
                <div class="modal-header bg-white border-bottom py-4 px-4 align-items-center">
                    <div class="d-flex align-items-center w-100">
                        <div id="modalPatientPhotoContainer" class="mr-3">
                            <!-- JS Populated Photo -->
                            <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="modal-title fw-bold mb-0 text-primary" id="modalPatientName">Prescription Details</h4>
                            <p class="text-muted mb-0 small" id="modalSubTitle">Review Issued Medication</p>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-pill-modern border rounded-pill px-3 mr-4 d-none" id="btnEditFromModal">
                           <i class="fas fa-edit mr-1"></i> Edit
                        </button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 1.5rem; right: 1.5rem;"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Dosage</th>
                                    <th>Frequency</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="medicineTableBody">
                                <!-- JS Populated -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-light px-4 btn-pill-modern border" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary px-4 btn-pill-modern shadow-sm" id="btnDownloadFromModal">
                        <i class="fas fa-download mr-1"></i> Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentPrescriptionId = null;
        let currentPatientId = null;

        function viewMedicines(medicines, patientName, prescriptionId, patientPhoto, patientId) {
            currentPrescriptionId = prescriptionId;
            currentPatientId = patientId;
            
            $('#modalPatientName').text(patientName);
            $('#modalSubTitle').text('Reviewing Prescription #' + prescriptionId);
            
            // Set Photo
            const photoContainer = $('#modalPatientPhotoContainer');
            if (patientPhoto) {
                photoContainer.html(`<img src="${patientPhoto}" class="shadow-sm" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid #f0f7ff;">`);
            } else {
                photoContainer.html(`<div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;"><i class="fas fa-user fa-lg"></i></div>`);
            }

            // Show Edit Button in Modal
            $('#btnEditFromModal').removeClass('d-none').off('click').on('click', function() {
                window.location.href = `/my-patients?edit_prescription=${prescriptionId}&patient_id=${patientId}`;
            });

            const tbody = $('#medicineTableBody');
            tbody.empty();

            if (medicines && medicines.length > 0) {
                medicines.forEach(med => {
                    const mealClass = med.meal === 'Before Food' ? 'badge-soft-warning' : 'badge-soft-success';
                    
                    tbody.append(`
                        <tr>
                            <td class="py-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light text-primary rounded-3 p-2 mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-pills"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-1">${med.medicine_name}</div>
                                        <div class="text-muted small">
                                            <span class="badge badge-pill-modern badge-soft-info py-1 px-2 mr-1">${med.medicine_type || 'Medicine'}</span>
                                            <span>${med.route || 'Oral'}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="text-dark fw-bold">${med.dosage || '-'}</span></td>
                            <td><span class="text-dark fw-bold">${med.frequency || '-'}</span></td>
                            <td><span class="text-muted">${med.duration || '-'}</span></td>
                            <td>
                                <span class="badge badge-pill badge-pill-modern ${mealClass} mb-2">
                                    <i class="fas ${med.meal === 'Before Food' ? 'fa-clock' : 'fa-check-circle'} mr-1"></i>
                                    ${med.meal || 'As directed'}
                                </span>
                                ${med.notes ? `<div class="text-muted small font-italic" style="max-width: 150px; line-height: 1.2;">"${med.notes}"</div>` : ''}
                            </td>
                        </tr>
                    `);
                });
            } else {
                tbody.append('<tr><td colspan="5" class="text-center py-5 text-muted">No medicines found in this record.</td></tr>');
            }

            $('#medicineModal').modal('show');
        }

        $('#btnDownloadFromModal').on('click', function() {
            if (currentPrescriptionId) {
                window.location.href = `/download-prescription/${currentPrescriptionId}`;
            }
        });

        // Ensure modal closing stability for BS5
        $(document).on('click', '[data-bs-dismiss="modal"]', function() {
            var modalEl = $(this).closest('.modal');
            var modal = bootstrap.Modal.getInstance(modalEl[0]) || new bootstrap.Modal(modalEl[0]);
            modal.hide();
        });
    </script>

    <style>
        .btn-white { background: #fff; }
        .btn-white:hover { background: #f8f9fa; }
        .pagination { justify-content: flex-end; margin-bottom: 0; }
        /* Modal Customization */
        .modal-header .close { opacity: 0.8; }
        .modal-header .close:hover { opacity: 1; }
    </style>
@endsection
