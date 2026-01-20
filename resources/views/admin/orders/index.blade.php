@extends('layout')

@section('title', 'Orders - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="text">
            Orders Management
            <div class="btn-group">
                <a href="{{ route('orders.manage') }}" class="btn btn-default btn-sm">
                    <i class="bx bx-plus"></i> <span>Create New Order</span>
                </a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50px">Sr. No.</th>
                                <th>Order ID</th>
                                <th>Store ID</th>
                                <th>Supplier ID</th>
                                <th>Status</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Order Date</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $k => $order)
                                <tr>
                                    <td class="text-center">{{ $k + 1 }}</td>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->store_id }}</td>
                                    <td>{{ $order->supplier_id }}</td>
                                    <td>
                                        @if($order->status == 'Completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($order->status == 'Cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $order->items->count() }}</td>
                                    <td class="text-end">${{ number_format($order->total_amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('orders.manage', ['id' => $order->id]) }}"
                                            class="btn btn-sm btn-info text-white">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="{{ route('orders.delete', $order->id) }}" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this order?')">
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
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Additional script if needed
        });
    </script>
@endpush