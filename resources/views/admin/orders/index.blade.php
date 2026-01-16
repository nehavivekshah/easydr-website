@extends('layout')

@section('title', 'Orders - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="text">
            Orders
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm" onclick="openAddModal()">
                    <i class="bx bx-plus"></i> <span>Place Order</span>
                </button>
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
                                <th>Total Amount</th>
                                <th>Created At</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $k => $order)
                                <tr>
                                    <td class="text-center">{{ $k + 1 }}</td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->store_id }}</td>
                                    <td>{{ $order->supplier_id }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info text-white" onclick="editOrder({{ $order->id }})">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <a href="{{ route('orders.delete', $order->id) }}" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">
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

    <!-- Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('orders.place') }}" method="POST" id="orderForm">
                    @csrf
                    <input type="hidden" name="id" id="orderId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addOrderModalLabel">Place Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Store ID</label>
                            <input type="number" name="store_id" id="store_id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Supplier ID</label>
                            <input type="number" name="supplier_id" id="supplier_id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Amount</label>
                            <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openAddModal() {
            $('#orderForm')[0].reset();
            $('#orderId').val('');
            $('#addOrderModalLabel').text('Place Order');
            $('#saveBtn').text('Place Order');
            $('#addOrderModal').modal('show');
        }

        function editOrder(id) {
            $.get('/admin/orders/edit/' + id, function (data) {
                $('#addOrderModalLabel').text('Edit Order');
                $('#saveBtn').text('Update Order');
                $('#addOrderModal').modal('show');

                $('#orderId').val(data.id);
                $('#store_id').val(data.store_id);
                $('#supplier_id').val(data.supplier_id);
                $('#total_amount').val(data.total_amount);
            });
        }
    </script>
@endpush