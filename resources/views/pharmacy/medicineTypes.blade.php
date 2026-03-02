@extends('layout')
@section('title', 'Medicine Types - Easy Doctor')

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

        /* ---- Type chip ---- */
        .type-name-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .type-icon-box {
            width: 36px;
            height: 36px;
            background: #ede9fe;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6d28d9;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .type-name-text {
            font-weight: 700;
            font-size: .9rem;
            color: #1e293b;
        }

        /* ---- Icon display ---- */
        .icon-preview {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #f0f4ff;
            border: 1px solid #c7d2fe;
            border-radius: 8px;
            padding: 4px 12px;
            font-size: .82rem;
            font-weight: 600;
            color: #4338ca;
        }

        .icon-preview i {
            font-size: 1.05rem;
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
        $canAdd = in_array('medicine_add', $roleArray) || in_array('All', $roleArray);
        $canEdit = in_array('medicine_edit', $roleArray) || in_array('All', $roleArray);
        $canDelete = in_array('medicine_delete', $roleArray) || in_array('All', $roleArray);
    @endphp

    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">Medicine Types</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/pharmacy"
                                    class="text-decoration-none text-muted">Pharmacy</a></li>
                            <li class="breadcrumb-item active text-muted">Medicine Types</li>
                        </ol>
                    </nav>
                </div>
                @if($canAdd)
                    <a href="/admin/manage-medicine-type" class="btn-add">
                        <i class="bx bx-plus"></i> Add Type
                    </a>
                @endif
            </div>

            {{-- Table Card --}}
            <div class="card-table-wrap">
                <table id="lists" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:6%">#</th>
                            <th style="width:50%">Type Name</th>
                            <th style="width:30%">Icon</th>
                            <th style="width:14%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($types as $k => $type)
                            <tr>
                                <td class="fw-semibold text-muted">{{ $k + 1 }}</td>
                                <td>
                                    <div class="type-name-chip">
                                        <div class="type-icon-box">
                                            @if(!empty($type->icon))
                                                <i class="bx {{ $type->icon }}"></i>
                                            @else
                                                <i class="bx bx-category"></i>
                                            @endif
                                        </div>
                                        <span class="type-name-text">{{ $type->name ?? '--' }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if(!empty($type->icon))
                                        <span class="icon-preview">
                                            <i class="bx {{ $type->icon }}"></i>
                                            {{ $type->icon }}
                                        </span>
                                    @else
                                        <span class="text-muted">--</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        @if($canEdit)
                                            <a href="/admin/manage-medicine-type?id={{ $type->id }}" class="btn-tbl-edit"
                                                title="Edit">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                        @endif
                                        @if($canDelete)
                                            <form action="{{ route('medicineType.destroy', $type->id) }}" method="POST"
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
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bx bx-category" style="font-size:2.5rem;color:#bfdbfe;"></i>
                                    <p class="mt-2 mb-0 fw-semibold">No medicine types found.</p>
                                    @if($canAdd)
                                        <a href="/admin/manage-medicine-type" class="btn-add mt-3 d-inline-flex mx-auto">
                                            <i class="bx bx-plus"></i> Add First Type
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </section>
@endsection