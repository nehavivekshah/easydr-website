@extends('layout')
@section('title', 'Role Settings - Easy Doctor')

@push('styles')
    <style>
        .page-header-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .card-table {
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .card-table .table {
            margin: 0;
        }

        .card-table .table thead th {
            background: #f8f9fb;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #2563eb;
            border-bottom: 2px solid #dbeafe;
            padding: 14px 16px;
        }

        .card-table .table tbody td {
            padding: 13px 16px;
            vertical-align: middle;
            font-size: .9rem;
            color: #374151;
        }

        .card-table .table tbody tr:hover {
            background: #f8f9fb;
        }

        .card-table .table tbody tr:last-child td {
            border-bottom: none;
        }

        .features-pill {
            display: inline-block;
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            border-radius: 50px;
            padding: 3px 12px;
            font-size: .78rem;
            font-weight: 600;
            max-width: 380px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .features-all {
            background: #f0fdf4;
            color: #16a34a;
            border-color: #bbf7d0;
        }

        .badge-active {
            background: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            border-radius: 50px;
            padding: 4px 12px;
            font-size: .78rem;
            font-weight: 700;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 50px;
            padding: 4px 12px;
            font-size: .78rem;
            font-weight: 700;
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
            box-shadow: 0 6px 18px rgba(37, 99, 235, .4);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-edit {
            background: #eff6ff;
            color: #2563eb;
            border: 1.5px solid #bfdbfe;
            border-radius: 50px;
            padding: 5px 14px;
            font-size: .8rem;
            font-weight: 600;
            transition: all .18s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }

        .btn-edit:hover {
            background: #dbeafe;
            border-color: #93c5fd;
            color: #1d4ed8;
        }

        .btn-edit.disabled {
            opacity: .45;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
@endpush

@section('content')
    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">Role Settings</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active text-muted">Role Settings</li>
                        </ol>
                    </nav>
                </div>
                <a href="/admin/manage-role-setting" class="btn-add">
                    <i class="bx bx-plus"></i> Add New Role
                </a>
            </div>

            {{-- Table Card --}}
            <div class="card-table">
                <table id="lists" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th style="width:18%">Role</th>
                            <th style="width:18%">Designation</th>
                            <th>Features / Permissions</th>
                            <th style="width:10%">Status</th>
                            <th style="width:10%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $k => $role)
                            @php $features = ucwords(str_replace(',', ', ', ($role->features ?? ''))); @endphp
                            <tr>
                                <td class="text-muted fw-semibold">{{ $k + 1 }}</td>
                                <td class="fw-semibold">{{ $role->title ?? '--' }}</td>
                                <td class="text-muted">{{ $role->subtitle ?? '--' }}</td>
                                <td>
                                    <span class="features-pill {{ $features == 'All' ? 'features-all' : '' }}"
                                        title="{{ $features }}">
                                        {{ $features ?: '--' }}
                                    </span>
                                </td>
                                <td>
                                    @if($role->status == '1')
                                        <span class="badge-active">Active</span>
                                    @else
                                        <span class="badge-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ $features == 'All' ? 'javascript:void(0)' : '/admin/manage-role-setting?id=' . $role->id }}"
                                        class="btn-edit {{ $features == 'All' ? 'disabled' : '' }}"
                                        title="{{ $features == 'All' ? 'Super Admin role cannot be edited' : 'Edit Role' }}">
                                        <i class="bx bx-edit-alt"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>
@endsection