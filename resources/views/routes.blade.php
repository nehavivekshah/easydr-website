@extends('layout')
@section('title', 'Medicine Routes - Easy Doctor')

@push('styles')
    <style>
        .page-header-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

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
            padding: 14px 18px;
            white-space: nowrap;
        }

        .card-table-wrap .table tbody td {
            padding: 13px 18px;
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

        .route-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 5px 12px;
            font-size: .85rem;
            font-weight: 700;
            color: #0369a1;
        }

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
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-tbl-edit {
            background: #eff6ff;
            color: #2563eb;
            border: 1.5px solid #bfdbfe;
            border-radius: 50px;
            padding: 5px 13px;
            font-size: .8rem;
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
            padding: 5px 13px;
            font-size: .8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all .18s;
            text-decoration: none;
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
        $canAdd = in_array('listing_add', $roleArray) || in_array('All', $roleArray);
        $canEdit = in_array('listing_edit', $roleArray) || in_array('All', $roleArray);
        $canDelete = in_array('listing_delete', $roleArray) || in_array('All', $roleArray);
    @endphp

    <section class="task__section">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">Medicine Routes</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active text-muted">Medicine Routes</li>
                        </ol>
                    </nav>
                </div>
                @if($canAdd)
                    <a href="/admin/manage-route" class="btn-add"><i class="bx bx-plus"></i> Add Route</a>
                @endif
            </div>

            <div class="card-table-wrap">
                <table id="lists" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:6%">#</th>
                            <th>Route Name</th>
                            <th style="width:12%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($routes as $k => $route)
                            <tr>
                                <td class="fw-semibold text-muted">{{ $k + 1 }}</td>
                                <td><span class="route-chip"><i class="bx bx-transfer-alt"></i>{{ $route->name ?? '--' }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @if($canEdit)
                                            <a href="/admin/manage-route?id={{ $route->id }}" class="btn-tbl-edit" title="Edit"><i
                                                    class="bx bx-edit-alt"></i></a>
                                        @endif
                                        @if($canDelete)
                                            <a class="btn-tbl-del delete" data-id="{{ $route->id }}" data-page="route"
                                                title="Delete"><i class="bx bx-trash"></i></a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bx bx-transfer-alt" style="font-size:2.5rem;color:#bfdbfe;"></i>
                                    <p class="mt-2 mb-0 fw-semibold">No medicine routes found.</p>
                                    @if($canAdd)<a href="/admin/manage-route" class="btn-add mt-3 d-inline-flex mx-auto"><i
                                    class="bx bx-plus"></i> Add First Route</a>@endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection