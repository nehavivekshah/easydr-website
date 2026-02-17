@extends('frontend.layout')

@section('content')
    <main>
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
                                <a href="{{ url('/my-patients') }}" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                                    <i class="fas fa-plus mr-1"></i> New Prescription
                                </a>
                            </div>

                            <!-- Filters -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-3">
                                    <form action="{{ url('/doctor-prescriptions') }}" method="GET" class="row no-gutters align-items-center">
                                        <div class="col-md-5 mr-md-3 mb-3 mb-md-0">
                                            <div class="input-group shadow-sm border rounded">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span>
                                                </div>
                                                <input type="text" name="q" value="{{ request('q') }}" class="form-control border-0 shadow-none" placeholder="Search by Patient Name or ID...">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mr-md-3 mb-3 mb-md-0">
                                            <input type="date" name="date" value="{{ request('date') }}" class="form-control shadow-sm border rounded">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-block rounded shadow-sm">Filter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Prescriptions Table -->
                            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="border-0 px-4 py-3">#ID</th>
                                                    <th class="border-0 py-3">Patient Name</th>
                                                    <th class="border-0 py-3">Prescribed On</th>
                                                    <th class="border-0 py-3">Medicines</th>
                                                    <th class="border-0 px-4 py-3 text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($prescriptions as $p)
                                                    <tr>
                                                        <td class="px-4 align-middle font-weight-bold text-primary">#{{ $p->id }}</td>
                                                        <td class="align-middle">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm mr-3 text-primary text-center rounded-circle font-weight-bold" 
                                                                     style="width: 36px; height: 36px; line-height: 36px; background: #eef5ff; border: 1px solid #ddecff;">
                                                                    {{ substr($p->patient_first_name, 0, 1) }}{{ substr($p->patient_last_name, 0, 1) }}
                                                                </div>
                                                                <div>
                                                                    <span class="d-block font-weight-bold text-dark">{{ $p->patient_first_name }} {{ $p->patient_last_name }}</span>
                                                                    <small class="text-muted">ID: #{{ $p->patient_id }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">
                                                            <span class="text-dark font-weight-600">{{ date('d M, Y', strtotime($p->prescribed_date)) }}</span>
                                                            <small class="d-block text-muted">{{ date('h:i A', strtotime($p->created_at)) }}</small>
                                                        </td>
                                                        <td class="align-middle">
                                                            <span class="badge badge-pill p-2" style="background: #e3f2fd; color: #0d47a1; font-weight: 600;">
                                                                <i class="fas fa-pills mr-1"></i> {{ $p->medicine_count }} {{ $p->medicine_count == 1 ? 'Item' : 'Items' }}
                                                            </span>
                                                        </td>
                                                        <td class="px-4 align-middle text-right">
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
                                                            <a href="{{ url('/my-patients') }}" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">Issue New Prescription</a>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    @if($prescriptions->hasPages())
                                        <div class="p-4 border-top bg-light-soft">
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
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header bg-primary text-white border-0 py-4" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <div class="d-flex align-items-center">
                        <div class="bg-white rounded-circle p-2 mr-3 shadow-sm">
                            <i class="fas fa-prescription text-primary"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="modalPatientName">Medicine Details</h5>
                            <small class="text-white-50">Issued Prescription Items</small>
                        </div>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 pl-4 py-3">Medicine</th>
                                    <th class="border-0 py-3">Dosage</th>
                                    <th class="border-0 py-3">Frequency</th>
                                    <th class="border-0 py-3">Duration</th>
                                    <th class="border-0 pr-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody id="medicineTableBody">
                                <!-- JS Populated -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-light px-4 rounded-pill border" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary px-4 rounded-pill shadow-sm" id="btnDownloadFromModal">
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
                    const mealIcon = med.meal === 'Before Food' ? 'fa-clock' : 'fa-check-circle';
                    const mealClass = med.meal === 'Before Food' ? 'text-warning' : 'text-success';
                    
                    tbody.append(`
                        <tr>
                            <td class="pl-4 py-3">
                                <div class="font-weight-bold text-dark">${med.medicine_name}</div>
                                <small class="text-muted"><i class="fas fa-pills mr-1"></i>${med.medicine_type || 'Medicine'} &bull; ${med.route || 'Oral'}</small>
                            </td>
                            <td class="py-3 text-dark">${med.dosage || '-'}</td>
                            <td class="py-3 text-dark font-weight-bold">${med.frequency || '-'}</td>
                            <td class="py-3 text-dark">${med.duration || '-'}</td>
                            <td class="pr-4 py-3">
                                <span class="badge badge-pill px-3 py-2 ${med.meal === 'Before Food' ? 'badge-soft-warning' : 'badge-soft-success'}" 
                                      style="font-size: 11px;">
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
        .dashboard_content h5 { font-weight: 800; color: #1a4b8c; letter-spacing: -0.5px; }
        .table thead th { font-size: 10px; font-weight: 700; text-transform: uppercase; color: #6c757d; border-bottom: none; }
        .table td { border-top: 1px solid #f8f9fa; }
        .font-weight-600 { font-weight: 600; }
        .badge-soft-info { background-color: #e1f5fe; color: #0288d1; border-radius: 4px; border: 1px solid #b3e5fc; }
        .badge-soft-warning { background-color: #fff9e6; color: #856404; border: 1px solid #ffeeba; }
        .badge-soft-success { background-color: #e6fffa; color: #065f46; border: 1px solid #b2f5ea; }
        .avatar-sm { display: inline-flex; justify-content: center; align-items: center; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .badge-pill { letter-spacing: 0.3px; }
        .pagination { justify-content: flex-end; margin-bottom: 0; }
        .page-item.active .page-link { background-color: #1a4b8c; border-color: #1a4b8c; }
        .page-link { color: #1a4b8c; border-radius: 6px !important; margin: 0 3px; }
        
        /* Modal Customization */
        .modal-header .close { opacity: 0.8; }
        .modal-header .close:hover { opacity: 1; }
    </style>
@endsection