@extends('layout')

@section('title', 'Manage Order - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="text">
            {{ isset($order) ? 'Edit Order #' . $order->id : 'Place New Order' }}
            <div class="btn-group">
                <a href="{{ route('orders.index') }}" class="btn btn-default btn-sm">
                    <i class="bx bx-arrow-back"></i> <span>Back</span>
                </a>
            </div>
        </div>
        <div class="container-fluid">
            <form action="{{ route('orders.place') }}" method="POST" id="manageOrderForm">
                @csrf
                <input type="hidden" name="id" value="{{ $order->id ?? '' }}">

                <div class="card shadow border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 fw-bold text-primary">Order Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Store Location <span class="text-danger">*</span></label>
                                <select name="store_id" class="form-select" required>
                                    <option value="">Select Store</option>
                                    @foreach($stores as $store)
                                        <option value="{{ $store->LocationID }}" {{ (isset($order) && $order->store_id == $store->LocationID) ? 'selected' : '' }}>
                                            {{ $store->LocationName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Supplier <span class="text-danger">*</span></label>
                                <select name="supplier_id" class="form-select" required>
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ (isset($order) && $order->supplier_id == $supplier->id) ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Order Date</label>
                                <input type="date" name="order_date" class="form-control"
                                    value="{{ isset($order) ? \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') : date('Y-m-d') }}"
                                    required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Shipping Address</label>
                                <input type="text" name="shipping_address" class="form-control"
                                    value="{{ $order->shipping_address ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="Pending" {{ (isset($order) && $order->status == 'Pending') ? 'selected' : '' }}>Pending</option>
                                    <option value="Completed" {{ (isset($order) && $order->status == 'Completed') ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ (isset($order) && $order->status == 'Cancelled') ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold text-primary">Order Items</h6>
                        <button type="button" class="btn btn-sm btn-success" id="addItemBtn"><i class="bx bx-plus"></i> Add
                            Item</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="itemsTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="40%">Medicine</th>
                                        <th width="15%">Quantity</th>
                                        <th width="20%">Price</th>
                                        <th width="20%">Total</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($order) && $order->items->count() > 0)
                                        @foreach($order->items as $item)
                                            <tr>
                                                <td>
                                                    <select name="items[medicine_id][]" class="form-select medicine-select"
                                                        required>
                                                        <option value="">Select Medicine</option>
                                                        @foreach($medicines as $med)
                                                            <option value="{{ $med->id }}" data-price="{{ $med->cost }}" {{ $item->medicine_id == $med->id ? 'selected' : '' }}>
                                                                {{ $med->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="items[quantity][]" class="form-control qty-input"
                                                        min="1" value="{{ $item->quantity }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="items[price][]" class="form-control price-input"
                                                        step="0.01" value="{{ $item->price }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control row-total" readonly
                                                        value="{{ number_format($item->quantity * $item->price, 2) }}">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm remove-row"><i
                                                            class="bx bx-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <!-- Default Empty Row -->
                                        <tr class="item-row">
                                            <td>
                                                <select name="items[medicine_id][]" class="form-select medicine-select"
                                                    required>
                                                    <option value="">Select Medicine</option>
                                                    @foreach($medicines as $med)
                                                        <option value="{{ $med->id }}" data-price="{{ $med->cost }}">
                                                            {{ $med->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="items[quantity][]" class="form-control qty-input"
                                                    min="1" value="1" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[price][]" class="form-control price-input"
                                                    step="0.01" value="0.00" required>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control row-total" readonly value="0.00">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm remove-row"><i
                                                        class="bx bx-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                                        <td>
                                            <input type="number" name="total_amount" id="grandTotal"
                                                class="form-control fw-bold" readonly
                                                value="{{ $order->total_amount ?? '0.00' }}">
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4"><i class="bx bx-save"></i> Save Order</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            // Add new row
            $('#addItemBtn').click(function () {
                let row = `<tr>
                        <td>
                            <select name="items[medicine_id][]" class="form-select medicine-select" required>
                                <option value="">Select Medicine</option>
                                @foreach($medicines as $med)
                                    <option value="{{ $med->id }}" data-price="{{ $med->cost }}">{{ $med->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="items[quantity][]" class="form-control qty-input" min="1" value="1" required>
                        </td>
                        <td>
                            <input type="number" name="items[price][]" class="form-control price-input" step="0.01" value="0.00" required>
                        </td>
                        <td>
                            <input type="number" class="form-control row-total" readonly value="0.00">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm remove-row"><i class="bx bx-trash"></i></button>
                        </td>
                    </tr>`;
                $('#itemsTable tbody').append(row);
            });

            // Remove row
            $(document).on('click', '.remove-row', function () {
                if ($('#itemsTable tbody tr').length > 1) {
                    $(this).closest('tr').remove();
                    calculateGrandTotal();
                } else {
                    alert("At least one item is required.");
                }
            });

            // Handle Medicine Selection (Auto-fill price)
            $(document).on('change', '.medicine-select', function () {
                let price = $(this).find(':selected').data('price');
                let row = $(this).closest('tr');
                row.find('.price-input').val(price ? parseFloat(price).toFixed(2) : '0.00');
                calculateRowTotal(row);
            });

            // Handle Quantity or Price Change
            $(document).on('input', '.qty-input, .price-input', function () {
                let row = $(this).closest('tr');
                calculateRowTotal(row);
            });

            function calculateRowTotal(row) {
                let qty = parseFloat(row.find('.qty-input').val()) || 0;
                let price = parseFloat(row.find('.price-input').val()) || 0;
                let total = qty * price;
                row.find('.row-total').val(total.toFixed(2));
                calculateGrandTotal();
            }

            function calculateGrandTotal() {
                let grandTotal = 0;
                $('.row-total').each(function () {
                    grandTotal += parseFloat($(this).val()) || 0;
                });
                $('#grandTotal').val(grandTotal.toFixed(2));
            }

        });
    </script>
@endpush