@extends('layout')
@section('title', 'Orders Management - Easy Doctor')

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

        /* ---- Order ID chip ---- */
        .order-id-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 4px 10px;
            font-size: .82rem;
            font-weight: 700;
            color: #1d4ed8;
            font-family: monospace;
        }

        /* ---- Ref chips ---- */
        .ref-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 7px;
            padding: 3px 9px;
            font-size: .78rem;
            font-weight: 600;
            color: #475569;
        }

        /* ---- Items badge ---- */
        .items-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background: #ede9fe;
            border-radius: 50%;
            font-size: .8rem;
            font-weight: 700;
            color: #6d28d9;
        }

        /* ---- Amount ---- */
        .amount-text {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 7px;
            padding: 3px 10px;
            font-size: .82rem;
            font-weight: 700;
            color: #15803d;
        }

        /* ---- Date ---- */
        .date-text {
            font-size: .82rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* ---- Status badges ---- */
        .badge-completed {
            background: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            border-radius: 50px;
            padding: 4px 12px;
            font-size: .76rem;
            font-weight: 700;
        }

        .badge-cancelled {
            background: #fff1f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 50px;
            padding: 4px 12px;
            font-size: .76rem;
            font-weight: 700;
        }

        .badge-pending {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde68a;
            border-radius: 50px;
            padding: 4px 12px;
            font-size: .76rem;
            font-weight: 700;
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

        .btn-tbl-del {
            background: #fff1f2;
            color: #dc2626;
            border: 1.5px solid #fecaca;
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

        .btn-tbl-del:hover {
            background: #fee2e2;
            color: #b91c1c;
        }
    </style>
@endpush

@section('content')
    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">Orders Management</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/pharmacy"
                                    class="text-decoration-none text-muted">Pharmacy</a></li>
                            <li class="breadcrumb-item active text-muted">Orders</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('orders.manage') }}" class="btn-add">
                        <i class="bx bx-plus"></i> Create Order
                    </a>
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
                                <th style="width:10%">Order ID</th>
                                <th style="width:10%">Store</th>
                                <th style="width:10%">Supplier</th>
                                <th style="width:11%" class="text-center">Status</th>
                                <th style="width:7%" class="text-center">Items</th>
                                <th style="width:13%">Total Amount</th>
                                <th style="width:13%">Order Date</th>
                                <th style="width:8%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $k => $order)
                                <tr>
                                    <td class="fw-semibold text-muted">{{ $k + 1 }}</td>
                                    <td>
                                        <span class="order-id-chip">
                                            <i class="bx bx-receipt"></i>#{{ $order->id }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="ref-chip">
                                            <i class="bx bx-store-alt"></i>
                                            {{ $order->store->LocationName ?? 'Unknown Store' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="ref-chip">
                                            <i class="bx bx-package"></i>
                                            {{ $order->supplier->name ?? 'Unknown Supplier' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($order->status == 'Completed')
                                            <span class="badge-completed">✓ Completed</span>
                                        @elseif($order->status == 'Cancelled')
                                            <span class="badge-cancelled">✕ Cancelled</span>
                                        @else
                                            <span class="badge-pending">⏳ Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="items-badge">{{ $order->items->count() }}</span>
                                    </td>
                                    <td>
                                        <span class="amount-text">
                                            <i class="bx bx-rupee"></i>
                                            {{ number_format($order->total_amount, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="date-text">
                                            <i class="bx bx-calendar"></i>
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <a href="{{ route('orders.manage', ['id' => $order->id]) }}" class="btn-tbl-edit"
                                                title="Edit">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                            <a href="{{ route('orders.delete', $order->id) }}" class="btn-tbl-del"
                                                onclick="return confirm('Are you sure? This action cannot be undone.')"
                                                title="Delete">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        <i class="bx bx-receipt" style="font-size:2.5rem;color:#bfdbfe;"></i>
                                        <p class="mt-2 mb-0 fw-semibold">No orders found.</p>
                                        <a href="{{ route('orders.manage') }}" class="btn-add mt-3 d-inline-flex mx-auto">
                                            <i class="bx bx-plus"></i> Create First Order
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if($orders->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
            @endif

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Additional script if needed
        });
    </script>
@endpush