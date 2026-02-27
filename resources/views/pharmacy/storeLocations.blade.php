@extends('layout')
@section('title', 'Store Locations - Easy Doctor')

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
            font-size: .74rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #2563eb;
            border-bottom: 2px solid #dbeafe;
            padding: 13px 14px;
            white-space: nowrap;
        }

        .card-table-wrap .table tbody td {
            padding: 12px 14px;
            vertical-align: middle;
            font-size: .86rem;
            color: #374151;
        }

        .card-table-wrap .table tbody tr:hover {
            background: #f8f9fb;
        }

        .card-table-wrap .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ---- Store name chip ---- */
        .store-name-cell {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .store-icon {
            width: 34px;
            height: 34px;
            background: #eff6ff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .store-name-text {
            font-weight: 700;
            font-size: .88rem;
            color: #1e293b;
        }

        /* ---- Manager chip ---- */
        .manager-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 7px;
            padding: 3px 9px;
            font-size: .78rem;
            font-weight: 600;
            color: #166534;
        }

        /* ---- Hours badge ---- */
        .hours-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #feff9c20;
            border: 1px solid #fde68a;
            border-radius: 7px;
            padding: 3px 9px;
            font-size: .78rem;
            font-weight: 600;
            color: #92400e;
        }

        /* ---- Accessibility & sqft ---- */
        .info-pill {
            font-size: .78rem;
            color: #64748b;
            background: #f1f5f9;
            border-radius: 6px;
            padding: 2px 8px;
        }

        /* ---- Address ---- */
        .addr-text {
            font-size: .8rem;
            color: #64748b;
            max-width: 160px;
            line-height: 1.4;
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

        .btn-tbl-map {
            background: #f0fdf4;
            color: #16a34a;
            border: 1.5px solid #bbf7d0;
            border-radius: 50px;
            padding: 4px 10px;
            font-size: .78rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all .18s;
        }

        .btn-tbl-map:hover {
            background: #dcfce7;
            color: #15803d;
        }

        .btn-tbl-view {
            background: #f0f9ff;
            color: #0ea5e9;
            border: 1.5px solid #bae6fd;
            border-radius: 50px;
            padding: 4px 10px;
            font-size: .78rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all .18s;
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
            padding: 4px 10px;
            font-size: .78rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all .18s;
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
            padding: 4px 10px;
            font-size: .78rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            transition: all .18s;
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
                    <h4 class="page-header-title">Store Locations</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/pharmacy"
                                    class="text-decoration-none text-muted">Pharmacy</a></li>
                            <li class="breadcrumb-item active text-muted">Store Locations</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if($canAdd)
                        <a href="/admin/manage-store" class="btn-add">
                            <i class="bx bx-plus"></i> Add Store
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
                                <th style="width:17%">Store Name</th>
                                <th style="width:12%">Manager</th>
                                <th style="width:10%">Phone</th>
                                <th style="width:16%">Address</th>
                                <th style="width:10%">Hours</th>
                                <th style="width:5%">Map</th>
                                <th style="width:8%">Sq. Ft.</th>
                                <th style="width:10%">Accessibility</th>
                                <th style="width:8%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stores as $store)
                                @php
                                    $HoursOfOperation = $store->HoursOfOperation ?? [];
                                    $openTime = !empty($HoursOfOperation[0]) ? date_format(date_create($HoursOfOperation[0]), 'h:i A') : '--';
                                    $closeTime = !empty($HoursOfOperation[1]) ? date_format(date_create($HoursOfOperation[1]), 'h:i A') : '--';
                                @endphp
                                <tr>
                                    <td class="fw-semibold text-muted">{{ $store->LocationID }}</td>
                                    <td>
                                        <div class="store-name-cell">
                                            <div class="store-icon"><i class="bx bx-store-alt"></i></div>
                                            <span class="store-name-text">{{ $store->LocationName }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($store->ManagerName)
                                            <span class="manager-chip">
                                                <i class="bx bx-user"></i>
                                                {{ $store->ManagerName }}
                                            </span>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td style="font-size:.82rem;">
                                        <i class="bx bx-phone text-muted me-1"></i>{{ $store->PhoneNumber ?? '--' }}
                                    </td>
                                    <td>
                                        <div class="addr-text">
                                            <i class="bx bx-map-pin text-muted me-1" style="font-size:.82rem;"></i>
                                            {{ $store->Address }}<br>
                                            {{ $store->City }}, {{ $store->State }} - {{ $store->ZipCode }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="hours-badge">
                                            <i class="bx bx-time-five"></i>
                                            {{ $openTime }}–{{ $closeTime }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($store->MapLink)
                                            <a href="{{ $store->MapLink }}" class="btn-tbl-map" target="_blank" title="View on Map">
                                                <i class="bx bx-map-alt"></i> Map
                                            </a>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($store->SquareFootage)
                                            <span class="info-pill">{{ $store->SquareFootage }} sq.ft</span>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($store->AccessibilityFeatures)
                                            <span class="info-pill">{{ $store->AccessibilityFeatures }}</span>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                            <a href="/admin/medicine-listings?storeid={{ $store->LocationID ?? '' }}"
                                                class="btn-tbl-view" title="View Medicines">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a href="/admin/manage-store?id={{ $store->LocationID ?? '' }}" class="btn-tbl-edit"
                                                title="Edit">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                            <form action="{{ route('stores.destroy', $store->LocationID) }}" method="POST"
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
                                    <td colspan="10" class="text-center py-5 text-muted">
                                        <i class="bx bx-store-alt" style="font-size:2.5rem;color:#bfdbfe;"></i>
                                        <p class="mt-2 mb-0 fw-semibold">No store locations found.</p>
                                        @if($canAdd)
                                            <a href="/admin/manage-store" class="btn-add mt-3 d-inline-flex mx-auto">
                                                <i class="bx bx-plus"></i> Add First Store
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
            @if($stores->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $stores->links('pagination::bootstrap-4') }}
                </div>
            @endif

        </div>
    </section>
@endsection