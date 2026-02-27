@extends('layout')
@section('title', 'Medicine Listings - Easy Doctor')

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

    /* ---- Medicine name ---- */
    .med-name { font-weight:700; font-size:.88rem; color:#1e293b; }
    .med-purpose { font-size:.76rem; color:#64748b; margin-top:2px; max-width:180px; }

    /* ---- Type chip ---- */
    .type-chip { display:inline-flex; align-items:center; gap:5px; background:#ede9fe; border:1px solid #c4b5fd; border-radius:7px; padding:3px 9px; font-size:.76rem; font-weight:600; color:#6d28d9; white-space:nowrap; }

    /* ---- Price ---- */
    .price-badge { display:inline-flex; align-items:center; gap:4px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:7px; padding:3px 10px; font-size:.8rem; font-weight:700; color:#15803d; }

    /* ---- Expiry ---- */
    .expiry-text { font-size:.8rem; color:#64748b; display:flex; align-items:center; gap:5px; }
    .expiry-near { color:#dc2626; font-weight:600; }

    /* ---- Stock badges ---- */
    .badge-avail   { background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0; border-radius:50px; padding:4px 12px; font-size:.76rem; font-weight:700; }
    .badge-unavail { background:#fff1f2; color:#dc2626; border:1px solid #fecaca; border-radius:50px; padding:4px 12px; font-size:.76rem; font-weight:700; }

    /* ---- Buttons ---- */
    .btn-add    { background:linear-gradient(135deg,#1d4ed8,#2563eb); color:#fff; border:none; border-radius:50px; padding:9px 22px; font-weight:600; font-size:.88rem; box-shadow:0 4px 12px rgba(37,99,235,.3); transition:all .2s; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .btn-add:hover    { background:linear-gradient(135deg,#1e40af,#1d4ed8); box-shadow:0 6px 18px rgba(37,99,235,.4); transform:translateY(-1px); color:#fff; }
    .btn-export { background:#fff; color:#374151; border:1.5px solid #d1d5db; border-radius:50px; padding:9px 20px; font-weight:600; font-size:.88rem; transition:all .2s; display:inline-flex; align-items:center; gap:6px; }
    .btn-export:hover { background:#f3f4f6; }

    .btn-tbl-edit { background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; border-radius:50px; padding:5px 11px; font-size:.8rem; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:4px; transition:all .18s; }
    .btn-tbl-edit:hover { background:#dbeafe; color:#1d4ed8; }
    .btn-tbl-del  { background:#fff1f2; color:#dc2626; border:1.5px solid #fecaca; border-radius:50px; padding:5px 11px; font-size:.8rem; font-weight:600; display:inline-flex; align-items:center; gap:4px; cursor:pointer; transition:all .18s; }
    .btn-tbl-del:hover  { background:#fee2e2; color:#b91c1c; }
</style>
@endpush

@section('content')
    @php
        $roles     = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
        $canAdd    = in_array('medicine_add',    $roleArray) || in_array('All', $roleArray);
        $canEdit   = in_array('medicine_edit',   $roleArray) || in_array('All', $roleArray);
        $canDelete = in_array('medicine_delete', $roleArray) || in_array('All', $roleArray);
    @endphp

    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">Medicine Listings</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard" class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/pharmacy" class="text-decoration-none text-muted">Pharmacy</a></li>
                            <li class="breadcrumb-item active text-muted">Medicines</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if($canAdd)
                        <a href="/admin/manage-medicine" class="btn-add">
                            <i class="bx bx-plus"></i> Add Medicine
                        </a>
                    @endif
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
                                <th style="width:4%">#</th>
                                <th style="width:5%">Photo</th>
                                <th style="width:22%">Name & Purpose</th>
                                <th style="width:13%">Type</th>
                                <th style="width:10%">Price</th>
                                <th style="width:13%">Expiry Date</th>
                                <th style="width:10%" class="text-center">Stock</th>
                                <th style="width:8%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medicines as $medicine)
                                @php
                                    $expiryDate  = date_create($medicine->expiration_date);
                                    $expiryLabel = $expiryDate ? date_format($expiryDate, 'd M, Y') : '--';
                                    $daysLeft    = $expiryDate ? now()->diffInDays($expiryDate, false) : null;
                                    $expiryClass = ($daysLeft !== null && $daysLeft <= 30) ? 'expiry-near' : '';
                                @endphp
                                <tr>
                                    <td class="fw-semibold text-muted">{{ $medicine->id }}</td>
                                    <td>
                                        @if(!empty($medicine->img))
                                            <img src="/public/{{ $medicine->img }}" class="med-avatar"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                                            <div class="med-avatar-placeholder" style="display:none;"><i class="bx bx-capsule"></i></div>
                                        @else
                                            <div class="med-avatar-placeholder"><i class="bx bx-capsule"></i></div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="med-name">{{ $medicine->name }}</div>
                                        @if($medicine->purpose)
                                            <div class="med-purpose">{{ Str::limit($medicine->purpose, 60) }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="type-chip">
                                            <i class="bx bx-category"></i>
                                            {{ $medicine->type_name ?? '--' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="price-badge">
                                            <i class="bx bx-rupee"></i>
                                            {{ number_format($medicine->cost, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="expiry-text {{ $expiryClass }}">
                                            <i class="bx bx-calendar{{ $expiryClass ? '-x' : '' }}"></i>
                                            {{ $expiryLabel }}
                                            @if($expiryClass && $daysLeft > 0)
                                                <span style="font-size:.7rem;">({{ $daysLeft }}d left)</span>
                                            @elseif($daysLeft !== null && $daysLeft <= 0)
                                                <span style="font-size:.7rem;">(Expired)</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($medicine->available == '1')
                                            <span class="badge-avail">In Stock</span>
                                        @else
                                            <span class="badge-unavail">Out of Stock</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            @if($canEdit)
                                                <a href="/admin/manage-medicine?id={{ $medicine->id }}"
                                                    class="btn-tbl-edit" title="Edit">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>
                                            @endif
                                            @if($canDelete)
                                                <form action="{{ route('medicine.destroy', $medicine->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure? This action cannot be undone.')"
                                                    class="d-inline m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-tbl-del" title="Delete">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bx bx-capsule" style="font-size:2.5rem;color:#bfdbfe;"></i>
                                        <p class="mt-2 mb-0 fw-semibold">No medicines found.</p>
                                        @if($canAdd)
                                            <a href="/admin/manage-medicine" class="btn-add mt-3 d-inline-flex mx-auto">
                                                <i class="bx bx-plus"></i> Add First Medicine
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if($medicines->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $medicines->links('pagination::bootstrap-4') }}
                </div>
            @endif

        </div>
    </section>
@endsection