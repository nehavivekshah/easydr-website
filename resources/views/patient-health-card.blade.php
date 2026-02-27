@extends('layout')
@section('title', 'Patient Health Cards - Easy Doctor')

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
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #2563eb;
            border-bottom: 2px solid #dbeafe;
            padding: 13px 16px;
            white-space: nowrap;
        }

        .card-table-wrap .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            font-size: .87rem;
            color: #374151;
        }

        .card-table-wrap .table tbody tr:hover {
            background: #f8f9fb;
        }

        .card-table-wrap .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ---- Patient name ---- */
        .patient-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .patient-icon {
            width: 34px;
            height: 34px;
            background: #eff6ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: .95rem;
            flex-shrink: 0;
        }

        .patient-name {
            font-weight: 700;
            font-size: .9rem;
            color: #1e293b;
        }

        /* ---- Health card no ---- */
        .card-no {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f0f4ff;
            border: 1px solid #c7d2fe;
            border-radius: 7px;
            padding: 3px 10px;
            font-size: .8rem;
            font-weight: 700;
            color: #4338ca;
            font-family: monospace;
            letter-spacing: .05em;
        }

        /* ---- Date ---- */
        .date-text {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .82rem;
            color: #475569;
        }

        .date-expired {
            color: #dc2626;
            font-weight: 700;
        }

        /* ---- Expired inline badge ---- */
        .badge-expired-inline {
            background: #fff1f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 50px;
            padding: 2px 8px;
            font-size: .72rem;
            font-weight: 700;
            margin-left: 4px;
        }

        /* ---- Card file ---- */
        .btn-view-file {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f0f9ff;
            color: #0ea5e9;
            border: 1.5px solid #bae6fd;
            border-radius: 50px;
            padding: 4px 12px;
            font-size: .79rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .18s;
        }

        .btn-view-file:hover {
            background: #e0f2fe;
            color: #0284c7;
        }

        /* ---- Verification status ---- */
        .badge-verified {
            background: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            border-radius: 50px;
            padding: 4px 12px;
            font-size: .76rem;
            font-weight: 700;
        }

        .badge-unverified {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde68a;
            border-radius: 50px;
            padding: 4px 12px;
            font-size: .76rem;
            font-weight: 700;
        }

        /* ---- Action buttons ---- */
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

        .btn-tbl-edit {
            background: #eff6ff;
            color: #2563eb;
            border: 1.5px solid #bfdbfe;
            border-radius: 50px;
            padding: 5px 11px;
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

        .btn-verify {
            background: #dcfce7;
            color: #16a34a;
            border: 1.5px solid #bbf7d0;
            border-radius: 50px;
            padding: 5px 13px;
            font-size: .79rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            transition: all .18s;
        }

        .btn-verify:hover:not(:disabled) {
            background: #bbf7d0;
        }

        .btn-verify:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .btn-unverify {
            background: #fef9c3;
            color: #854d0e;
            border: 1.5px solid #fde68a;
            border-radius: 50px;
            padding: 5px 13px;
            font-size: .79rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            transition: all .18s;
        }

        .btn-unverify:hover {
            background: #fde68a;
        }
    </style>
@endpush

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
        $canEdit = in_array('permission_edit', $roleArray) || in_array('All', $roleArray);
    @endphp

    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">Patient Health Cards</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/users/patient-directory"
                                    class="text-decoration-none text-muted">Patients</a></li>
                            <li class="breadcrumb-item active text-muted">Health Cards</li>
                        </ol>
                    </nav>
                </div>
                <button class="btn-export" title="Export to CSV">
                    <i class="bx bx-download"></i> Export
                </button>
            </div>

            {{-- Table Card --}}
            <div class="card-table-wrap">
                <div class="table-responsive">
                    <table id="lists" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:4%">#</th>
                                <th style="width:20%">Patient Name</th>
                                <th style="width:14%">Health Card No.</th>
                                <th style="width:13%">Issue Date</th>
                                <th style="width:13%">Expiry Date</th>
                                <th style="width:10%">Card File</th>
                                <th style="width:10%" class="text-center">Status</th>
                                <th style="width:16%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patients as $k => $patient)
                                @php
                                    $expired = $patient->hc_expairy_date &&
                                        \Carbon\Carbon::parse($patient->hc_expairy_date)->isPast();
                                @endphp
                                <tr>
                                    <td class="fw-semibold text-muted">{{ $k + 1 }}</td>
                                    <td>
                                        <div class="patient-chip">
                                            <div class="patient-icon"><i class="bx bx-user"></i></div>
                                            <span
                                                class="patient-name">{{ trim($patient->first_name . ' ' . $patient->last_name) ?: '--' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($patient->health_card)
                                            <span class="card-no">
                                                <i class="bx bx-id-card"></i>
                                                {{ $patient->health_card }}
                                            </span>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($patient->hc_issue_date)
                                            <div class="date-text">
                                                <i class="bx bx-calendar"></i>
                                                {{ \Carbon\Carbon::parse($patient->hc_issue_date)->format('d M Y') }}
                                            </div>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($patient->hc_expairy_date)
                                            <div class="date-text {{ $expired ? 'date-expired' : '' }}">
                                                <i class="bx bx-calendar{{ $expired ? '-x' : '-check' }}"></i>
                                                {{ \Carbon\Carbon::parse($patient->hc_expairy_date)->format('d M Y') }}
                                                @if($expired)
                                                    <span class="badge-expired-inline">Expired</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($patient->health_card_file)
                                            <a href="{{ asset('public/assets/images/healthCards/' . $patient->health_card_file) }}"
                                                target="_blank" class="btn-view-file">
                                                <i class="bx bx-file"></i> View
                                            </a>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($patient->hc_verified_at)
                                            <span class="badge-verified">✓ Verified</span>
                                        @else
                                            <span class="badge-unverified">⏳ Not Verified</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($canEdit)
                                            <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                                <a href="{{ route('admin.patient.healthcard.edit', $patient->id) }}"
                                                    class="btn-tbl-edit" title="Edit Health Card">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>

                                                <form action="/admin/patient-health-card" method="POST" class="d-inline m-0 p-0">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $patient->id }}">

                                                    @if($patient->hc_verified_at)
                                                        <button class="btn-unverify"
                                                            onclick="return confirm('Are you sure you want to un-verify this health card?')">
                                                            <i class="bx bx-x-circle"></i> Unverify
                                                        </button>
                                                    @else
                                                        @php
                                                            $missingInfo = [];
                                                            if (empty($patient->health_card))
                                                                $missingInfo[] = 'Card No';
                                                            if (empty($patient->health_card_file))
                                                                $missingInfo[] = 'Card File';
                                                            if (empty($patient->hc_expairy_date))
                                                                $missingInfo[] = 'Expiry Date';
                                                            $canVerify = empty($missingInfo) && !$expired;
                                                            $title = '';
                                                            if (!$canVerify) {
                                                                $title = $expired
                                                                    ? 'Cannot Verify: Card is expired'
                                                                    : 'Cannot Verify: Missing ' . implode(', ', $missingInfo);
                                                            }
                                                        @endphp
                                                        <button class="btn-verify" {{ !$canVerify ? 'disabled' : '' }}
                                                            title="{{ $title }}"
                                                            onclick="return confirm('Do you want to verify this health card?')">
                                                            <i class="bx bx-check-shield"></i> Verify
                                                        </button>
                                                    @endif
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bx bx-id-card" style="font-size:2.5rem;color:#bfdbfe;"></i>
                                        <p class="mt-2 mb-0 fw-semibold">No patient health cards found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection