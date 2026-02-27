@extends('layout')
@section('title', 'Suppliers - Easy Doctor')

@push('styles')
    <style>
        .page-header-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        /* ---- Card Table ---- */
        .card-table-wrap {
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .card-table-wrap .table {
            margin: 0;
        }

        .card-table-wrap .table thead th {
            background: #f8f9fb;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #2563eb;
            border-bottom: 2px solid #dbeafe;
            padding: 14px 16px;
            white-space: nowrap;
        }

        .card-table-wrap .table tbody td {
            padding: 13px 16px;
            vertical-align: middle;
            font-size: .88rem;
            color: #374151;
        }

        .card-table-wrap .table tbody tr:hover {
            background: #f8f9fb;
        }

        .card-table-wrap .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ---- Supplier name ---- */
        .supplier-chip {
            display: inline-flex;
            align-items: center;
            gap: 9px;
        }

        .supplier-icon {
            width: 34px;
            height: 34px;
            background: #fff7ed;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ea580c;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .supplier-name {
            font-weight: 700;
            font-size: .9rem;
            color: #1e293b;
        }

        /* ---- Contact ---- */
        .contact-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .82rem;
            color: #374151;
        }

        /* ---- Address ---- */
        .addr-text {
            font-size: .8rem;
            color: #64748b;
            max-width: 200px;
        }

        /* ---- Buttons ---- */
        .btn-add {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 9px 22px;
            font-weight: 600;
            font-size: .88rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, .3);
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .btn-add:hover {
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            box-shadow: 0 6px 18px rgba(37, 99, 235, .4);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-tbl-edit {
            background: #eff6ff;
            color: #2563eb;
            border: 1.5px solid #bfdbfe;
            border-radius: 50px;
            padding: 5px 13px;
            font-size: .8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all .18s;
            cursor: pointer;
        }

        .btn-tbl-edit:hover {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-tbl-del {
            background: #fff1f2;
            color: #dc2626;
            border: 1.5px solid #fecaca;
            border-radius: 50px;
            padding: 5px 13px;
            font-size: .8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all .18s;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-tbl-del:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* ---- Modal styling ---- */
        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .15);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            border-bottom: none;
            padding: 18px 24px;
        }

        .modal-header .modal-title {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
        }

        .modal-header .btn-close {
            filter: invert(1);
            opacity: .8;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 16px 24px;
        }

        .modal-footer .btn-secondary {
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
        }

        .modal-footer .btn-primary {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            border: none;
            border-radius: 50px;
            padding: 8px 24px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(37, 99, 235, .3);
        }

        .modal-footer .btn-primary:hover {
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
        }

        .modal-body .input-group-text {
            background: #f0f4ff;
            border-right: none;
            color: #2563eb;
            min-width: 42px;
            justify-content: center;
        }

        .modal-body .form-control {
            border-left: none;
            background: #f8f9fb;
        }

        .modal-body .form-control:focus {
            border-color: #2563eb;
            box-shadow: none;
            background: #fff;
        }

        .modal-body .form-label {
            font-size: .82rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
    </style>
@endpush

@section('content')
    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">Suppliers</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/pharmacy"
                                    class="text-decoration-none text-muted">Pharmacy</a></li>
                            <li class="breadcrumb-item active text-muted">Suppliers</li>
                        </ol>
                    </nav>
                </div>
                <button type="button" class="btn-add" onclick="openAddModal()">
                    <i class="bx bx-plus"></i> Add Supplier
                </button>
            </div>

            {{-- Table Card --}}
            <div class="card-table-wrap">
                <table id="lists" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th style="width:25%">Supplier Name</th>
                            <th style="width:15%">Contact</th>
                            <th style="width:20%">Email</th>
                            <th style="width:25%">Address</th>
                            <th style="width:10%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $k => $supplier)
                            <tr>
                                <td class="fw-semibold text-muted">{{ $k + 1 }}</td>
                                <td>
                                    <div class="supplier-chip">
                                        <div class="supplier-icon"><i class="bx bx-package"></i></div>
                                        <span class="supplier-name">{{ $supplier->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="contact-pill">
                                        <i class="bx bx-phone text-muted"></i>
                                        {{ $supplier->contact }}
                                    </span>
                                </td>
                                <td style="font-size:.82rem;">
                                    <i class="bx bx-envelope text-muted me-1"></i>{{ $supplier->email }}
                                </td>
                                <td>
                                    <div class="addr-text">
                                        <i class="bx bx-map-pin text-muted me-1" style="font-size:.82rem;"></i>
                                        {{ $supplier->address }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <button class="btn-tbl-edit" onclick="editSupplier({{ $supplier->id }})" title="Edit">
                                            <i class="bx bx-edit-alt"></i>
                                        </button>
                                        <a href="{{ route('suppliers.delete', $supplier->id) }}" class="btn-tbl-del"
                                            onclick="return confirm('Are you sure? This action cannot be undone.')"
                                            title="Delete">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bx bx-package" style="font-size:2.5rem;color:#bfdbfe;"></i>
                                    <p class="mt-2 mb-0 fw-semibold">No suppliers added yet.</p>
                                    <button type="button" class="btn-add mt-3" onclick="openAddModal()">
                                        <i class="bx bx-plus"></i> Add First Supplier
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </section>

    {{-- Add / Edit Supplier Modal --}}
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('suppliers.add') }}" method="POST" id="supplierForm">
                @csrf
                <input type="hidden" name="id" id="supplierId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-package"></i></span>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter supplier name" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                <input type="text" name="contact" id="contact" class="form-control"
                                    placeholder="Enter contact number" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Enter email address" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-map"></i></span>
                                <textarea name="address" id="address" class="form-control" rows="3"
                                    placeholder="Enter address" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">
                            <i class="bx bx-save me-1"></i> Add Supplier
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openAddModal() {
            $('#supplierForm')[0].reset();
            $('#supplierId').val('');
            $('#addSupplierModalLabel').text('Add Supplier');
            $('#saveBtn').html('<i class="bx bx-save me-1"></i> Add Supplier');
            $('#addSupplierModal').modal('show');
        }

        function editSupplier(id) {
            $.get('/admin/suppliers/edit/' + id, function (data) {
                $('#addSupplierModalLabel').text('Edit Supplier');
                $('#saveBtn').html('<i class="bx bx-save me-1"></i> Update Supplier');
                $('#addSupplierModal').modal('show');
                $('#supplierId').val(data.id);
                $('#name').val(data.name);
                $('#contact').val(data.contact);
                $('#email').val(data.email);
                $('#address').val(data.address);
            });
        }
    </script>
@endpush