@extends('layout')
@section('title', 'Payment Gateway Configs - Easy Doctor')

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
            font-size: .88rem;
            color: #374151;
        }

        .card-table .table tbody tr:hover {
            background: #f8f9fb;
        }

        .card-table .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Gateway chip */
        .gateway-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #f0f4ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 4px 12px;
            font-weight: 700;
            font-size: .85rem;
            color: #1e40af;
        }

        .gateway-chip i {
            font-size: 1rem;
            color: #2563eb;
        }

        /* Masked value */
        .masked-val {
            font-family: monospace;
            background: #f1f5f9;
            border-radius: 6px;
            padding: 2px 8px;
            font-size: .82rem;
            color: #64748b;
            letter-spacing: .05em;
        }

        /* Environment badge */
        .env-live {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 50px;
            padding: 3px 12px;
            font-size: .76rem;
            font-weight: 700;
        }

        .env-sandbox {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde68a;
            border-radius: 50px;
            padding: 3px 12px;
            font-size: .76rem;
            font-weight: 700;
        }

        /* Status badges */
        .badge-active {
            background: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            border-radius: 50px;
            padding: 4px 12px;
            font-size: .76rem;
            font-weight: 700;
        }

        .badge-inactive {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: 4px 12px;
            font-size: .76rem;
            font-weight: 700;
        }

        /* Buttons */
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

        .btn-delete {
            background: #fff1f2;
            color: #dc2626;
            border: 1.5px solid #fecaca;
            border-radius: 50px;
            padding: 5px 12px;
            font-size: .8rem;
            font-weight: 600;
            transition: all .18s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-delete:hover {
            background: #fee2e2;
            border-color: #f87171;
            color: #b91c1c;
        }
    </style>
@endpush

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
        $canAdd = in_array('pgc_add', $roleArray) || in_array('All', $roleArray);
        $canEdit = in_array('pgc_edit', $roleArray) || in_array('All', $roleArray);
        $canDelete = in_array('pgc_delete', $roleArray) || in_array('All', $roleArray);

        $gatewayIcons = [
            'stripe' => 'bx-credit-card',
            'razorpay' => 'bxl-paypal',
            'paypal' => 'bxl-paypal',
            'paytm' => 'bx-wallet',
        ];
    @endphp

    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">Payment Gateway Configs</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active text-muted">Payment Gateways</li>
                        </ol>
                    </nav>
                </div>
                @if($canAdd)
                    <a href="/admin/manage-payment-gateway-config" class="btn-add">
                        <i class="bx bx-plus"></i> Add Gateway
                    </a>
                @endif
            </div>

            {{-- Table Card --}}
            <div class="card-table">
                <table id="lists" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:4%">#</th>
                            <th style="width:15%">Gateway</th>
                            <th style="width:16%">Merchant ID</th>
                            <th style="width:14%">API Key</th>
                            <th style="width:12%">API Secret</th>
                            <th style="width:14%">Webhook Secret</th>
                            <th style="width:10%">Environment</th>
                            <th style="width:8%" class="text-center">Status</th>
                            <th style="width:7%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pgc as $k => $pg)
                            <tr>
                                <td class="text-muted fw-semibold">{{ $k + 1 }}</td>
                                <td>
                                    <div class="gateway-chip">
                                        <i
                                            class="bx {{ $gatewayIcons[strtolower($pg->gateway_name ?? '')] ?? 'bx-globe' }}"></i>
                                        {{ $pg->gateway_name ?? '--' }}
                                    </div>
                                </td>
                                <td>
                                    @if($pg->merchant_id)
                                        <span class="masked-val">{{ $pg->merchant_id }}</span>
                                    @else
                                        <span class="text-muted">--</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pg->api_key)
                                        <span class="masked-val">{{ Str::limit($pg->api_key, 16) }}</span>
                                    @else
                                        <span class="text-muted">--</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="masked-val">{{ $pg->api_secret ? '••••••••' : '--' }}</span>
                                </td>
                                <td>
                                    <span class="masked-val">{{ $pg->webhook_secret ? '••••••••' : '--' }}</span>
                                </td>
                                <td>
                                    @php $env = strtolower($pg->environment ?? ''); @endphp
                                    <span class="{{ $env === 'live' ? 'env-live' : 'env-sandbox' }}">
                                        {{ $env === 'live' ? '🔴 Live' : '🟡 Sandbox' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($pg->is_active)
                                        <span class="badge-active">Active</span>
                                    @else
                                        <span class="badge-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @if($canEdit)
                                            <a href="/admin/manage-payment-gateway-config?id={{ $pg->id }}" class="btn-edit"
                                                title="Edit">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                        @endif
                                        @if($canDelete)
                                            <a class="btn-delete delete" data-id="{{ $pg->id }}" data-page="pgc" title="Delete">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bx bx-credit-card" style="font-size:2.5rem;color:#bfdbfe;"></i>
                                    <p class="mt-2 mb-0 fw-semibold">No payment gateways configured yet.</p>
                                    @if($canAdd)
                                        <a href="/admin/manage-payment-gateway-config" class="btn-add mt-3 mx-auto">
                                            <i class="bx bx-plus"></i> Add First Gateway
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