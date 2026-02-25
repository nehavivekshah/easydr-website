@extends('layout')

@section('title', 'Orders - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-0 text-dark fw-bold" style="font-size: 1.5rem;">Orders Management</h2>
                <div class="text-muted small mt-1">Home / Pharmacy / Orders</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('orders.manage') }}" class="btn btn-default rounded-pill shadow-sm px-4">
                    <i class="bx bx-plus me-1 border-0 bg-transparent text-white p-0"></i> <span>Create New Order</span>
                </a>
                <button class="btn btn-outline-secondary rounded-pill shadow-sm px-4" title="Export to CSV">
                    <i class="bx bx-download me-1"></i> Export
                </button>
            </div>
        </div>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-12 pb-3">
                    <div class="card border-0 shadow-sm rounded-4 w-100">
                        <div class="card-body p-3 table-responsive">
                            <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="50px" class="text-center">Sr. No.</th>
                                        <th>Order ID</th>
                                        <th>Store ID</th>
                                        <th>Supplier ID</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Items</th>
                                        <th>Total Amount</th>
                                        <th>Order Date</th>
                                        <th class="wpx-100 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $k => $order)
                                        <tr>
                                            <td class="text-center">{{ $k + 1 }}</td>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->store_id }}</td>
                                            <td>{{ $order->supplier_id }}</td>
                                            <td class="text-center">
                                                @if($order->status == 'Completed')
                                                    <span class="font-weight-bold badge bg-success">Completed</span>
                                                @elseif($order->status == 'Cancelled')
                                                    <span class="font-weight-bold badge bg-danger">Cancelled</span>
                                                @else
                                                    <span class="font-weight-bold badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $order->items->count() }}</td>
                                            <td>Rs. {{ number_format($order->total_amount, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('orders.manage', ['id' => $order->id]) }}"
                                                    class="btn btn-info btn-sm rounded-pill shadow-sm mb-1 px-3 d-inline-flex align-items-center"
                                                    title="Edit">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="{{ route('orders.delete', $order->id) }}"
                                                    class="btn btn-danger btn-sm rounded-pill shadow-sm mb-1 px-3 d-inline-flex align-items-center"
                                                    onclick="return confirm('Are you sure you want to delete this order? This action cannot be undone.')"
                                                    title="Delete">
                                                    <i class="bx bx-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center mt-3">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
            </div>
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