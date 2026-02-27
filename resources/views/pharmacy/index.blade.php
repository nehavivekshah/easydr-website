@extends('layout')
@section('title', 'Pharmacy Directory - Easy Doctor')

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

        /* ---- Pharmacy name ---- */
        .pharmacy-name {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .pharmacy-icon {
            width: 34px;
            height: 34px;
            background: #eff6ff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 1.05rem;
            flex-shrink: 0;
        }

        .pharmacy-name-text {
            font-weight: 700;
            font-size: .9rem;
            color: #1e293b;
        }

        /* ---- Contact person ---- */
        .contact-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 7px;
            padding: 3px 10px;
            font-size: .8rem;
            font-weight: 600;
            color: #166534;
        }

        /* ---- Address ---- */
        .addr-text {
            font-size: .82rem;
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
            text-decoration: none;
        }

        .btn-add:hover {
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            box-shadow: 0 6px 18px rgba(37, 99, 235, .4);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-export {
            background: #fff;
            color: #374151;
            border: 1.5px solid #d1d5db;
            border-radius: 50px;
            padding: 9px 20px;
            font-weight: 600;
            font-size: .88rem;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-export:hover {
            background: #f3f4f6;
        }

        .btn-tbl-view {
            background: #f0f9ff;
            color: #0ea5e9;
            border: 1.5px solid #bae6fd;
            border-radius: 50px;
            padding: 5px 11px;
            font-size: .8rem;
            font-weight: 600;
            transition: all .18s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
        }

        .btn-tbl-view:hover {
            background: #e0f2fe;
            color: #0284c7;
        }

        .btn-tbl-edit {
            background: #eff6ff;
            color: #2563eb;
            border: 1.5px solid #bfdbfe;
            border-radius: 50px;
            padding: 5px 11px;
            font-size: .8rem;
            font-weight: 600;
            transition: all .18s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
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
            padding: 5px 11px;
            font-size: .8rem;
            font-weight: 600;
            transition: all .18s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
        }

        .btn-tbl-del:hover {
            background: #fee2e2;
            color: #b91c1c;
        }
    </style>
@endpush

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
        $canAdd = in_array('stores_add', $roleArray) || in_array('All', $roleArray);
    @endphp

    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">Pharmacy Directory</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active text-muted">Pharmacy</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if($canAdd)
                        <a href="/admin/manage-pharmacy" class="btn-add">
                            <i class="bx bx-plus"></i> Add Pharmacy
                        </a>
                    @endif
                    <button class="btn-export" title="Export to CSV">
                        <i class="bx bx-download"></i> Export
                    </button>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="card-table-wrap">
                <table id="lists" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th style="width:22%">Pharmacy Name</th>
                            <th style="width:25%">Head Office Address</th>
                            <th style="width:16%">Contact Person</th>
                            <th style="width:14%" class="m-none">Email</th>
                            <th style="width:10%" class="m-none">Phone</th>
                            <th style="width:8%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pharmacyMaster as $pharmacy)
                            <tr>
                                <td class="fw-semibold text-muted">{{ $pharmacy->PharmacyID }}</td>
                                <td>
                                    <div class="pharmacy-name">
                                        <div class="pharmacy-icon"><i class="bx bx-capsule"></i></div>
                                        <span class="pharmacy-name-text">{{ $pharmacy->PharmacyName }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="addr-text">
                                        <i class="bx bx-map-pin text-muted me-1" style="font-size:.85rem;"></i>
                                        {{ $pharmacy->Address }}, {{ $pharmacy->City }},
                                        {{ $pharmacy->State }} - {{ $pharmacy->ZipCode }}
                                    </div>
                                </td>
                                <td>
                                    <span class="contact-chip">
                                        <i class="bx bx-user"></i>
                                        {{ $pharmacy->PrimaryContactName }}
                                    </span>
                                </td>
                                <td class="m-none" style="font-size:.82rem;">{{ $pharmacy->EmailAddress ?? '--' }}</td>
                                <td class="m-none" style="font-size:.82rem;">{{ $pharmacy->PhoneNumber ?? '--' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <button type="button" class="btn-tbl-view rounded-pill px-3 shadow-sm"
                                            style="background:var(--color-primary); color:#fff; border:none;"
                                            data-bs-toggle="modal" data-bs-target="#createLoginModal"
                                            data-id="{{ $pharmacy->PharmacyID }}" data-name="{{ $pharmacy->PharmacyName }}"
                                            data-email="{{ $pharmacy->EmailAddress }}">
                                            <i class="bx bx-key"></i> Login
                                        </button>
                                        <a href="/admin/medicine-listings?PharmacyID={{ $pharmacy->PharmacyID ?? '' }}"
                                            class="btn-tbl-view" title="View Medicines">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="/admin/manage-pharmacy?id={{ $pharmacy->PharmacyID ?? '' }}"
                                            class="btn-tbl-edit" title="Edit">
                                            <i class="bx bx-edit-alt"></i>
                                        </a>
                                        <form action="{{ route('pharmacy.destroy', $pharmacy->PharmacyID) }}" method="POST"
                                            onsubmit="return confirm('Are you sure? This action cannot be undone.')"
                                            class="d-inline m-0 p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-tbl-del" title="Delete">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bx bx-capsule" style="font-size:2.5rem;color:#bfdbfe;"></i>
                                    <p class="mt-2 mb-0 fw-semibold">No pharmacies found.</p>
                                    @if($canAdd)
                                        <a href="/admin/manage-pharmacy" class="btn-add mt-3 d-inline-flex mx-auto">
                                            <i class="bx bx-plus"></i> Add First Pharmacy
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($pharmacyMaster->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $pharmacyMaster->links('pagination::bootstrap-4') }}
                </div>
            @endif

        </div>
    </section>

    <!-- Create Login Modal -->
    <div class="modal fade" id="createLoginModal" tabindex="-1" aria-labelledby="createLoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="createLoginModalLabel">Create Pharmacy Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('createPharmacyLogin') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pharmacy_id" id="modal_pharmacy_id">
                    <div class="modal-body">
                        <p class="text-muted small mb-4">Create a dedicated login account for <strong id="display_pharmacy_name"></strong>. This will allow them to access the pharmacy portal independently.</p>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold small text-muted">Primary Contact Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="modal_pharmacy_name" required placeholder="John Doe">
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-muted">Login Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="modal_pharmacy_email" required placeholder="pharmacy@example.com">
                        </div>
                        
                        <div class="mb-3">
                            <label for="mobile" class="form-label fw-semibold small text-muted">Mobile Number</label>
                            <input type="text" class="form-control" name="mobile" id="modal_pharmacy_mobile" placeholder="Leave blank if none">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small text-muted">Set Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" required minlength="6" placeholder="Minimum 6 characters">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background:var(--color-primary); border:none;">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var createLoginModal = document.getElementById('createLoginModal');
        createLoginModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var email = button.getAttribute('data-email');
            
            // For the visual display
            document.getElementById('display_pharmacy_name').textContent = name;
            
            // For the form inputs
            document.getElementById('modal_pharmacy_id').value = id;
            document.getElementById('modal_pharmacy_name').value = name;
            
            // Only set email if it's a valid string and not "--"
            if(email && email.trim() !== '' && email.trim() !== '--') {
                document.getElementById('modal_pharmacy_email').value = email;
            } else {
                document.getElementById('modal_pharmacy_email').value = '';
            }
        });
    });
</script>
@endpush