@extends('layout')
@section('title', 'Inventory Management - Easy Doctor')

@push('styles')
<style>
    .page-header-title { font-size:1.35rem; font-weight:700; color:#111827; margin:0; }

    /* ---- Card Table ---- */
    .card-table-wrap { border-radius:14px; border:1px solid #e5e7eb; box-shadow:0 4px 20px rgba(0,0,0,.06); overflow:hidden; }
    .card-table-wrap .table { margin:0; }
    .card-table-wrap .table thead th {
        background:#f8f9fb; font-size:.74rem; font-weight:700; letter-spacing:.06em;
        text-transform:uppercase; color:#2563eb; border-bottom:2px solid #dbeafe;
        padding:13px 14px; white-space:nowrap;
    }
    .card-table-wrap .table tbody td  { padding:12px 14px; vertical-align:middle; font-size:.87rem; color:#374151; }
    .card-table-wrap .table tbody tr:hover { background:#f8f9fb; }
    .card-table-wrap .table tbody tr:last-child td { border-bottom:none; }

    /* ---- Medicine avatar ---- */
    .med-avatar { width:40px; height:40px; border-radius:10px; object-fit:cover; border:1.5px solid #dbeafe; background:#f0f4ff; }
    .med-avatar-placeholder { width:40px; height:40px; border-radius:10px; background:#f0f4ff; display:flex; align-items:center; justify-content:center; color:#2563eb; font-size:1.1rem; }
    .med-name { font-weight:700; font-size:.88rem; color:#1e293b; }
    .med-type { font-size:.76rem; color:#64748b; margin-top:2px; }

    /* ---- Stock badges ---- */
    .qty-badge { display:inline-flex; align-items:center; gap:4px; font-weight:700; border-radius:7px; padding:4px 12px; font-size:.82rem; }
    .qty-low { background:#fff1f2; border:1px solid #fecaca; color:#dc2626; }
    .qty-good { background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; }
    .qty-zero { background:#f3f4f6; border:1px solid #d1d5db; color:#4b5563; }

    /* ---- Buttons ---- */
    .btn-add { background:linear-gradient(135deg,#1d4ed8,#2563eb); color:#fff; border:none; border-radius:50px; padding:9px 22px; font-weight:600; font-size:.88rem; box-shadow:0 4px 12px rgba(37,99,235,.3); transition:all .2s; display:inline-flex; align-items:center; gap:6px; text-decoration:none; cursor:pointer;}
    .btn-add:hover { background:linear-gradient(135deg,#1e40af,#1d4ed8); box-shadow:0 6px 18px rgba(37,99,235,.4); transform:translateY(-1px); color:#fff; }
    .btn-export { background:#fff; color:#374151; border:1.5px solid #d1d5db; border-radius:50px; padding:9px 20px; font-weight:600; font-size:.88rem; transition:all .2s; display:inline-flex; align-items:center; gap:6px; }
    .btn-export:hover { background:#f3f4f6; }

    .btn-tbl-edit { background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; border-radius:50px; padding:5px 11px; font-size:.8rem; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:4px; transition:all .18s; cursor:pointer;}
    .btn-tbl-edit:hover { background:#dbeafe; color:#1d4ed8; }
    .btn-tbl-del  { background:#fff1f2; color:#dc2626; border:1.5px solid #fecaca; border-radius:50px; padding:5px 11px; font-size:.8rem; font-weight:600; display:inline-flex; align-items:center; gap:4px; cursor:pointer; transition:all .18s; }
    .btn-tbl-del:hover  { background:#fee2e2; color:#b91c1c; }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">{{ $store->LocationName ?? 'Store' }} Inventory</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard" class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/store-locations" class="text-decoration-none text-muted">Stores</a></li>
                            <li class="breadcrumb-item active text-muted">Inventory Master</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn-add" onclick="openAddModal()">
                        <i class="bx bx-plus"></i> Update Stock
                    </button>
                    <button class="btn-export" title="Export to CSV">
                        <i class="bx bx-download"></i> Export
                    </button>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="card-table-wrap">
                <div class="table-responsive">
                    <table id="lists" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:6%">Photo</th>
                                <th style="width:30%">Medicine & Type</th>
                                <th style="width:15%">Stock Level</th>
                                <th style="width:25%">Last Updated</th>
                                <th style="width:15%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inventory as $item)
                                @php
                                    $qtyClass = 'qty-good';
                                    if ($item->quantity == 0) $qtyClass = 'qty-zero';
                                    elseif ($item->quantity < 20) $qtyClass = 'qty-low';
                                @endphp
                                <tr>
                                    <td class="fw-semibold text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        @if(!empty($item->img))
                                            <img src="/public/{{ $item->img }}" class="med-avatar"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                                            <div class="med-avatar-placeholder" style="display:none;"><i class="bx bx-capsule"></i></div>
                                        @else
                                            <div class="med-avatar-placeholder"><i class="bx bx-capsule"></i></div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="med-name">{{ $item->medicine_name }}</div>
                                        <div class="med-type"><i class="bx bx-category me-1"></i>{{ $item->type_name ?? 'Medicine' }}</div>
                                    </td>
                                    <td>
                                        <span class="qty-badge {{ $qtyClass }}">
                                            @if($item->quantity == 0)
                                                <i class="bx bx-x-circle"></i> Out of Stock
                                            @else
                                                <i class="bx bx-package"></i> {{ $item->quantity }} Units
                                            @endif
                                        </span>
                                    </td>
                                    <td style="font-size: .8rem; color: #64748b;">
                                        <i class="bx bx-time-five me-1"></i>{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y, h:i A') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <button class="btn-tbl-edit" onclick="editInventory({{ $item->id }})" title="Edit Stock">
                                                <i class="bx bx-edit-alt"></i>
                                            </button>
                                            <a href="{{ route('inventory.delete', $item->id) }}" class="btn-tbl-del"
                                                onclick="return confirm('Are you sure? This action will remove this item from the store inventory map.')" title="Remove form Store">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bx bx-layer" style="font-size:3rem;color:#bfdbfe;"></i>
                                        <p class="mt-3 mb-0 fw-semibold text-dark">No inventory records found.</p>
                                        <p class="small">Click "Update Stock" to map medicines to this store's inventory.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <!-- Update Stock Modal -->
    <div class="modal fade" id="updateInventoryModal" tabindex="-1" aria-labelledby="updateInventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form action="{{ route('inventory.update') }}" method="POST" id="inventoryForm">
                    @csrf
                    <input type="hidden" name="id" id="inventoryId">
                    <input type="hidden" name="store_id" value="{{ $store_id ?? '' }}">
                    
                    <div class="modal-header bg-light border-0 py-3 px-4" style="border-radius: 1rem 1rem 0 0;">
                        <h5 class="modal-title fw-bold text-dark" id="updateInventoryModalLabel">Update Inventory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body p-4 bg-white">
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted small text-uppercase">Select Medicine</label>
                            <select name="medicine_id" id="medicine_id" class="form-control select2" required style="width: 100%;">
                                <option value="" disabled selected>Search for medicine...</option>
                                @foreach($medicines as $med)
                                    <option value="{{ $med->id }}">{{ $med->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small text-uppercase">Stock Quantity</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class='bx bx-pie-chart-alt-2'></i></span>
                                <input type="number" name="quantity" id="quantity" class="form-control border-start-0 ps-0" placeholder="Enter total units available" min="0" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-0 bg-light py-3 px-4" style="border-radius: 0 0 1rem 1rem;">
                        <button type="button" class="btn text-muted fw-semibold" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm" id="saveBtn">Save Stock Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                dropdownParent: $('#updateInventoryModal'),
                placeholder: "Search for a medicine..."
            });
        });

        function openAddModal() {
            $('#inventoryForm')[0].reset();
            $('#inventoryId').val('');
            $('#medicine_id').val('').trigger('change');
            $('#updateInventoryModalLabel').text('Add New Stock');
            $('#saveBtn').text('Add Stock');
            $('#updateInventoryModal').modal('show');
        }

        function editInventory(id) {
            $.get('/admin/inventory/edit/' + id, function (data) {
                $('#updateInventoryModalLabel').text('Update Existing Quantity');
                $('#saveBtn').text('Save Changes');
                
                $('#inventoryId').val(data.id);
                $('#medicine_id').val(data.medicine_id).trigger('change');
                $('#quantity').val(data.quantity);
                
                $('#updateInventoryModal').modal('show');
            });
        }
    </script>
@endpush