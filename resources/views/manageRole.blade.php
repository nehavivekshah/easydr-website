@extends('layout')
@section('title', 'Manage Role - Easy Doctor')

@push('styles')
    <style>
        /* ---- Card ---- */
        .page-header-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .wizard-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
            overflow: hidden;
        }

        .wizard-banner {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            padding: 22px 32px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .wizard-banner-icon {
            width: 46px;
            height: 46px;
            background: rgba(255, 255, 255, .18);
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .wizard-banner-title {
            color: #fff;
            font-size: 1.05rem;
            font-weight: 700;
            margin: 0;
        }

        .wizard-banner-sub {
            color: rgba(255, 255, 255, .8);
            font-size: .78rem;
            margin: 2px 0 0;
        }

        .wizard-back-btn {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, .18);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            flex-shrink: 0;
            transition: background .2s;
            margin-right: 4px;
        }

        .wizard-back-btn:hover {
            background: rgba(255, 255, 255, .3);
            color: #fff;
        }

        .wizard-card-body {
            padding: 28px 32px 32px;
        }

        .form-section-title {
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #6c757d;
            margin: 8px 0 18px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e9ecef;
        }

        /* ---- Inputs ---- */
        .input-group-text {
            background: #f0f4ff;
            border-right: none;
            color: #2563eb;
            min-width: 42px;
            justify-content: center;
        }

        .input-group .form-control,
        .input-group .form-select {
            border-left: none;
            background: #f8f9fb;
        }

        .input-group .form-control:focus,
        .input-group .form-select:focus {
            border-color: #2563eb;
            box-shadow: none;
            background: #fff;
        }

        /* ---- Permissions Grid ---- */
        .permissions-table {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            width: 100%;
        }

        .permissions-table thead {
            background: #f0f4ff;
        }

        .permissions-table thead th {
            padding: 12px 16px;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #2563eb;
            border-bottom: 2px solid #dbeafe;
            text-align: center;
        }

        .permissions-table thead th:first-child {
            text-align: left;
        }

        .permissions-table tbody tr:hover {
            background: #f8f9fb;
        }

        .permissions-table tbody td {
            padding: 13px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .permissions-table tbody tr:last-child td {
            border-bottom: none;
        }

        .permissions-table tbody td:first-child {
            font-weight: 600;
            font-size: .9rem;
            color: #374151;
        }

        .permissions-table td.perm-cell {
            text-align: center;
        }

        /* ---- Custom toggle checkbox ---- */
        .perm-toggle {
            display: none;
        }

        .perm-toggle+label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1.5px solid #d1d5db;
            background: #f9fafb;
            cursor: pointer;
            transition: all .2s;
            font-size: 1rem;
            color: transparent;
        }

        .perm-toggle:checked+label {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
        }

        .perm-toggle+label::after {
            content: '✓';
            font-weight: 700;
            font-size: .85rem;
        }

        .perm-toggle:checked+label::after {
            color: #fff;
        }

        .perm-toggle+label:hover {
            border-color: #2563eb;
            background: #eff6ff;
        }

        /* ---- Row toggle header cell ---- */
        .feature-name {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-row-toggle {
            font-size: .7rem;
            padding: 2px 10px;
            border-radius: 50px;
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            color: #2563eb;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
            white-space: nowrap;
        }

        .btn-row-toggle:hover {
            background: #dbeafe;
        }

        /* ---- Select/Clear all ---- */
        .perm-header-actions {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
        }

        .btn-all,
        .btn-none {
            font-size: .78rem;
            padding: 5px 14px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid;
            transition: all .15s;
        }

        .btn-all {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .btn-all:hover {
            background: #dbeafe;
        }

        .btn-none {
            background: #fff;
            color: #6b7280;
            border-color: #d1d5db;
        }

        .btn-none:hover {
            background: #f3f4f6;
        }

        /* ---- Buttons ---- */
        .btn-wizard-submit {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 10px 36px;
            font-weight: 600;
            font-size: .92rem;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .3);
            transition: all .2s;
        }

        .btn-wizard-submit:hover {
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            box-shadow: 0 6px 20px rgba(37, 99, 235, .4);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-wizard-reset {
            background: #fff;
            color: #374151;
            border: 1.5px solid #d1d5db;
            border-radius: 50px;
            padding: 10px 24px;
            font-weight: 600;
            font-size: .92rem;
            transition: all .2s;
        }

        .btn-wizard-reset:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }
    </style>
@endpush

@section('content')
    @php
        $features = explode(',', ($roles->features ?? ''));
        $permissions = explode(',', ($roles->permissions ?? ''));
        $isEdit = !empty(request()->get('id'));

        $modules = [
            'appointments' => ['icon' => 'bx-calendar', 'label' => 'Appointments Management'],
            'doctors' => ['icon' => 'bx-user-check', 'label' => 'Doctors Management'],
            'doctor_slots' => ['icon' => 'bx-time-five', 'label' => 'Doctor Availability Slots'],
            'patients' => ['icon' => 'bx-user-heart', 'label' => 'Patients Management'],
            'pharmacy' => ['icon' => 'bx-plus-medical', 'label' => 'Pharmacy Management'],
            'stores' => ['icon' => 'bx-store', 'label' => 'Stores Management'],
            'inventory' => ['icon' => 'bx-package', 'label' => 'Inventory Management'],
            'suppliers' => ['icon' => 'bx-truck', 'label' => 'Suppliers Management'],
            'orders' => ['icon' => 'bx-cart', 'label' => 'Orders Management'],
            'billing' => ['icon' => 'bx-receipt', 'label' => 'Billing & Payments'],
            'reports' => ['icon' => 'bx-chart', 'label' => 'Reports & Analytics'],
            'users' => ['icon' => 'bx-group', 'label' => 'Users & Staff Management'],
            'setting' => ['icon' => 'bx-cog', 'label' => 'General Settings'],
            'listing' => ['icon' => 'bx-list-ul', 'label' => 'Data Listing (Cities, Categories)'],
        ];
    @endphp

    <section class="task__section">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">{{ $isEdit ? 'Edit Role' : 'Add New Role' }}</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/role-settings"
                                    class="text-decoration-none text-muted">Role Settings</a></li>
                            <li class="breadcrumb-item active text-muted">{{ $isEdit ? 'Edit Role' : 'Add Role' }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="wizard-card">
                <div class="wizard-banner">
                    <a href="/admin/role-settings" class="wizard-back-btn" title="Back"><i class="bx bx-arrow-back"></i></a>
                    <div class="wizard-banner-icon"><i class="bx bx-shield-alt-2"></i></div>
                    <div>
                        <p class="wizard-banner-title">{{ $isEdit ? 'Edit Role' : 'Add New Role' }}</p>
                        <p class="wizard-banner-sub">Define role name, designation, and feature access permissions</p>
                    </div>
                </div>
                <div class="wizard-card-body">
                    <form action="manage-role-setting" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ request()->get('id') ?? '' }}">

                        {{-- Section: Role Info --}}
                        <div class="form-section-title"><i class="bx bx-shield-alt-2 me-2"></i>Role Information</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Role Name <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" class="form-control" name="role" placeholder="e.g. Receptionist"
                                        value="{{ $roles->title ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Designation</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                    <input type="text" class="form-control" name="subrole"
                                        placeholder="e.g. Front Desk Staff" value="{{ $roles->subtitle ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Status <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-check-circle"></i></span>
                                    <select class="form-select" name="status" required>
                                        <option value="1" @if(($roles->status ?? '1') == '1') selected @endif>Active
                                        </option>
                                        <option value="2" @if(($roles->status ?? '') == '2') selected @endif>Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Permissions --}}
                        <div class="form-section-title"><i class="bx bx-key me-2"></i>Features &amp; Access Permissions
                        </div>

                        <div class="perm-header-actions">
                            <button type="button" class="btn-all" onclick="toggleAll(true)">
                                <i class="bx bx-check-double me-1"></i> Select All
                            </button>
                            <button type="button" class="btn-none" onclick="toggleAll(false)">
                                <i class="bx bx-x me-1"></i> Clear All
                            </button>
                        </div>

                        <table class="permissions-table mb-4">
                            <thead>
                                <tr>
                                    <th style="width:40%">Module</th>
                                    <th style="width:20%">➕ Add</th>
                                    <th style="width:20%">✏️ Edit</th>
                                    <th style="width:20%">🗑️ Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modules as $key => $module)
                                    <tr>
                                        <td>
                                            <div class="feature-name">
                                                <i class="bx {{ $module['icon'] }} text-primary" style="font-size:1.1rem;"></i>
                                                <span>{{ $module['label'] }}</span>
                                                <button type="button" class="btn-row-toggle"
                                                    onclick="toggleRow('{{ $key }}')">Toggle Row</button>
                                            </div>
                                        </td>
                                        @foreach(['add', 'edit', 'delete'] as $action)
                                            <td class="perm-cell">
                                                <input type="checkbox" class="perm-toggle perm-{{ $key }}"
                                                    id="perm_{{ $key }}_{{ $action }}" name="permissions[{{ $key }}][]"
                                                    value="{{ $action }}" @if(in_array("{$key}_{$action}", $permissions)) checked
                                                    @endif>
                                                <label for="perm_{{ $key }}_{{ $action }}"></label>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-between align-items-center pt-3"
                            style="border-top:1px solid #e9ecef;">
                            <button type="reset" class="btn-wizard-reset">
                                <i class="bx bx-reset me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn-wizard-submit">
                                <i class="bx bx-save me-1"></i>
                                {{ $isEdit ? 'Update Role' : 'Create Role' }}
                            </button>
                        </div>
                    </form>
                </div>{{-- /.wizard-card-body --}}
            </div>{{-- /.wizard-card --}}
        </div>{{-- /.container-fluid --}}
    </section>
@endsection

@push('scripts')
    <script>
        function toggleAll(check) {
            document.querySelectorAll('.perm-toggle').forEach(cb => { cb.checked = check; });
        }

        function toggleRow(key) {
            const checkboxes = document.querySelectorAll('.perm-' + key);
            const anyUnchecked = [...checkboxes].some(cb => !cb.checked);
            checkboxes.forEach(cb => { cb.checked = anyUnchecked; });
        }
    </script>
@endpush