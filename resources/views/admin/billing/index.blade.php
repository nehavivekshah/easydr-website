@extends('layout')

@section('title', 'Billing - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="text">
            Billing
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm" data-bs-toggle="modal"
                    data-bs-target="#processPaymentModal"><i class="bx bx-plus"></i> <span>Process Payment</span></button>
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
                <form action="{{ route('billing.process') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="processPaymentModalLabel">Process Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Store ID</label>
                            <input type="number" name="store_id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order ID</label>
                            <input type="number" name="order_id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Amount</label>
                            <input type="number" step="0.01" name="total_amount" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select" required>
                                <option value="Paid">Paid</option>
                                <option value="Pending">Pending</option>
                                <option value="Failed">Failed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Process</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection