@extends('layout')

@section('title', 'Billing - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="text">
            Billing
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm" onclick="openAddModal()">
                    <i class="bx bx-plus"></i> <span>Process Payment</span>
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
                                <th>Store ID</th>
                                <th>Order ID</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($billings as $k => $billing)
                                <tr>
                                    <td class="text-center">{{ $k + 1 }}</td>
                                    <td>{{ $billing->store_id }}</td>
                                    <td>{{ $billing->order_id }}</td>
                                    <td>{{ $billing->total_amount }}</td>
                                    <td>{{ $billing->payment_status }}</td>
                                    <td>{{ $billing->created_at }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info text-white"
                                            onclick="editBilling({{ $billing->id }})">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <a href="{{ route('billing.delete', $billing->id) }}" class="btn btn-sm btn-danger"
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
    <div class="modal fade" id="processPaymentModal" tabindex="-1" aria-labelledby="processPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('billing.process') }}" method="POST" id="billingForm">
                    @csrf
                    <input type="hidden" name="id" id="billingId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="processPaymentModalLabel">Process Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Store ID</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-store'></i></span>
                                <input type="number" name="store_id" id="store_id" class="form-control"
                                    placeholder="Enter store ID" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order ID</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-receipt'></i></span>
                                <input type="number" name="order_id" id="order_id" class="form-control"
                                    placeholder="Enter order ID" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Amount</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-dollar'></i></span>
                                <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control"
                                    placeholder="Enter amount" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Status</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-check-circle'></i></span>
                                <select name="payment_status" id="payment_status" class="form-select" required>
                                    <option value="Paid">Paid</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Failed">Failed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Process</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openAddModal() {
            $('#billingForm')[0].reset();
            $('#billingId').val('');
            $('#processPaymentModalLabel').text('Process Payment');
            $('#saveBtn').text('Process');
            $('#processPaymentModal').modal('show');
        }

        function editBilling(id) {
            $.get('/admin/billing/edit/' + id, function (data) {
                $('#processPaymentModalLabel').text('Edit Payment Details');
                $('#saveBtn').text('Update Payment');
                $('#processPaymentModal').modal('show');

                $('#billingId').val(data.id);
                $('#store_id').val(data.store_id);
                $('#order_id').val(data.order_id);
                $('#total_amount').val(data.total_amount);
                $('#payment_status').val(data.payment_status).change();
            });
        }
    </script>
@endpush