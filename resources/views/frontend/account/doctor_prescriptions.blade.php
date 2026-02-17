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
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h5 class="mb-0">Issued Prescriptions</h5>
                                <a href="{{ url('/my-patients') }}" class="btn btn-primary btn-pill-modern px-4 shadow-sm">
                                    <i class="fas fa-plus mr-1"></i> New Prescription
                                </a>
                            </div>

                            <!-- Filters -->
                            <div class="filters-container mb-4">
                                <form action="{{ url('/doctor-prescriptions') }}" method="GET" class="row no-gutters align-items-center justify-content-between">
                                    <div class="col-md-5 mr-md-3 mb-3 mb-md-0">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-0 py-0"><i class="fas fa-search text-muted"></i></span>
                                            </div>
                                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by Patient Name or ID...">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mr-md-3 mb-3 mb-md-0">
                                        <input type="date" name="date" value="{{ request('date') }}" class="form-control rounded-lg border">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-block btn-pill-modern shadow-sm" style="padding: 10px 25px;">Filter</button>
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
                                                @forelse($prescriptions as $p)
                                                    <tr>
                                                        <td class="font-weight-bold text-primary">#{{ $p->id }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-initials mr-3">
                                                                    {{ substr($p->patient_first_name, 0, 1) }}{{ substr($p->patient_last_name, 0, 1) }}
                                                                </div>
                                                                <div>
                                                                    <span class="d-block font-weight-bold text-dark">{{ $p->patient_first_name }} {{ $p->patient_last_name }}</span>
                                                                    <small class="text-muted">PID: #{{ $p->patient_id }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-dark font-weight-bold">{{ date('d M, Y', strtotime($p->prescribed_date)) }}</span>
                                                            <small class="d-block text-muted">{{ date('h:i A', strtotime($p->created_at)) }}</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-pill badge-soft-primary badge-pill-modern">
                                                                <i class="fas fa-pills mr-1"></i> {{ $p->medicine_count }} {{ $p->medicine_count == 1 ? 'Item' : 'Items' }}
                                                            </span>
                                                        </td>
                                                        <td class="text-right">
                                                            <div class="btn-group shadow-sm border rounded overflow-hidden">
                                                                <button type="button" class="btn btn-white btn-sm text-primary py-2 px-3 border-right" 
                                                                        onclick="viewMedicines({{ json_encode($p->medicines) }}, '{{ $p->patient_first_name }} {{ $p->patient_last_name }}', {{ $p->id }})"
                                                                        title="View Summary">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <a href="{{ route('downloadPrescription', $p->id) }}" class="btn btn-white btn-sm text-info py-2 px-3"
                                                                   title="Download PDF">
                                                                    <i class="fas fa-download"></i>
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
            <div class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius: 20px;">
                <div class="modal-header bg-primary text-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-white rounded-circle p-2 mr-3 shadow-sm">
                            <i class="fas fa-prescription text-primary"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0 text-white" id="modalPatientName">Medicine Details</h5>
                            <small class="text-white-50">Issued Prescription Items</small>
                        </div>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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

        function viewMedicines(medicines, patientName, prescriptionId) {
            currentPrescriptionId = prescriptionId;
            $('#modalPatientName').text('Prescription for ' + patientName);
            const tbody = $('#medicineTableBody');
            tbody.empty();

            if (medicines && medicines.length > 0) {
                medicines.forEach(med => {
                    const mealClass = med.meal === 'Before Food' ? 'badge-soft-warning' : 'badge-soft-success';
                    
                    tbody.append(`
                        <tr>
                            <td>
                                <div class="font-weight-bold text-dark">${med.medicine_name}</div>
                                <small class="text-muted"><i class="fas fa-pills mr-1"></i>${med.medicine_type || 'Medicine'} &bull; ${med.route || 'Oral'}</small>
                            </td>
                            <td>${med.dosage || '-'}</td>
                            <td class="font-weight-bold text-dark">${med.frequency || '-'}</td>
                            <td>${med.duration || '-'}</td>
                            <td>
                                <span class="badge badge-pill badge-pill-modern ${mealClass}">
                                    ${med.meal || 'As directed'}
                                </span>
                                ${med.notes ? `<small class="d-block text-muted mt-1 italic">"${med.notes}"</small>` : ''}
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
