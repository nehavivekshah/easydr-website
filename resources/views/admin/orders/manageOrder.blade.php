@extends('layout')
@section('title', 'Manage Order - Easy Doctor')

@push('styles')
<style>
    /* ---- Wizard Stepper ---- */
    .wizard-stepper { display:flex; align-items:center; justify-content:center; background:#f8f9fa; border-radius:12px; padding:20px 30px; margin-bottom:28px; }
    .wizard-step { display:flex; flex-direction:column; align-items:center; flex:1; position:relative; cursor:pointer; }
    .wizard-step:not(:last-child)::after { content:''; position:absolute; top:18px; left:calc(50% + 22px); width:calc(100% - 44px); height:2px; background:#dee2e6; z-index:0; }
    .wizard-step.active:not(:last-child)::after, .wizard-step.done:not(:last-child)::after { background:#2563eb; }
    .step-circle { width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.9rem; border:2px solid #dee2e6; background:#fff; color:#adb5bd; z-index:1; transition:all .25s; }
    .wizard-step.active .step-circle { background:#2563eb; border-color:#2563eb; color:#fff; box-shadow:0 4px 12px rgba(37,99,235,.35); }
    .wizard-step.done .step-circle { background:#2563eb; border-color:#2563eb; color:#fff; }
    .step-label { font-size:.7rem; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#adb5bd; margin-top:8px; }
    .wizard-step.active .step-label, .wizard-step.done .step-label { color:#2563eb; }
    .wizard-panel { display:none; }
    .wizard-panel.active { display:block; }

    /* ---- Form Card ---- */
    .wizard-card { background:#fff; border-radius:16px; border:1px solid #e5e7eb; box-shadow:0 4px 24px rgba(0,0,0,.07); padding:30px 36px; }
    .wizard-page-header { display:flex; align-items:center; gap:12px; margin-bottom:24px; }
    .wizard-back-btn { width:36px; height:36px; background:#2563eb; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; font-size:1rem; flex-shrink:0; transition:background .2s; }
    .wizard-back-btn:hover { background:#1d4ed8; color:#fff; }
    .wizard-page-header h5 { margin:0; font-weight:700; font-size:1.15rem; color:#111827; }
    .form-section-title { font-size:.8rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#6c757d; margin:8px 0 18px; padding-bottom:8px; border-bottom:1px solid #e9ecef; }

    /* ---- Inputs ---- */
    .input-group-text { background:#f0f4ff; border-right:none; color:#2563eb; min-width:42px; justify-content:center; }
    .input-group .form-control, .input-group .form-select { border-left:none; background:#f8f9fb; }
    .input-group .form-control:focus, .input-group .form-select:focus { border-color:#2563eb; box-shadow:none; background:#fff; }

    /* ---- Order Items Table ---- */
    .items-table-wrapper { border-radius:12px; overflow:hidden; border:1px solid #e9ecef; }
    .items-table-wrapper table thead { background:#f0f4ff; }
    .items-table-wrapper table thead th { font-size:.78rem; font-weight:700; letter-spacing:.05em; text-transform:uppercase; color:#2563eb; border-bottom:2px solid #dbeafe; padding:12px 14px; }
    .items-table-wrapper table tbody td { vertical-align:middle; padding:10px 12px; }
    .items-table-wrapper table tfoot { background:#f8f9fb; }
    .grand-total-box { background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; color:#1d4ed8; font-weight:700; }

    /* ---- Add Item Button ---- */
    .btn-add-item { background:transparent; border:1.5px dashed #2563eb; color:#2563eb; border-radius:8px; padding:7px 18px; font-weight:600; font-size:.85rem; transition:all .2s; }
    .btn-add-item:hover { background:#eff6ff; }

    /* ---- Buttons ---- */
    .btn-wizard-next, .btn-wizard-submit { background:linear-gradient(135deg,#1d4ed8,#2563eb); color:#fff; border:none; border-radius:50px; padding:10px 32px; font-weight:600; font-size:.92rem; box-shadow:0 4px 14px rgba(37,99,235,.3); transition:all .2s; }
    .btn-wizard-next:hover, .btn-wizard-submit:hover { background:linear-gradient(135deg,#1e40af,#1d4ed8); box-shadow:0 6px 20px rgba(37,99,235,.4); transform:translateY(-1px); color:#fff; }
    .btn-wizard-back { background:#fff; color:#374151; border:1.5px solid #d1d5db; border-radius:50px; padding:10px 28px; font-weight:600; font-size:.92rem; transition:all .2s; }
    .btn-wizard-back:hover { background:#f3f4f6; border-color:#9ca3af; }

    /* Status badge select */
    .status-badge-select { font-weight:600; }
</style>
@endpush

@section('content')
    <section class="task__section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10 col-md-12 col-sm-12 offset-lg-1 my-4 p-0">

                    {{-- Page Header --}}
                    <div class="wizard-page-header">
                        <a href="{{ route('orders.index') }}" class="wizard-back-btn" title="Back">
                            <i class="bx bx-chevron-left"></i>
                        </a>
                        <h5>{{ isset($order) ? 'Edit Order #' . $order->id : 'Place New Order' }}</h5>
                    </div>

                    <div class="wizard-card">

                        {{-- Stepper --}}
                        <div class="wizard-stepper">
                            <div class="wizard-step active" data-step="1">
                                <div class="step-circle">1</div>
                                <div class="step-label">Order Details</div>
                            </div>
                            <div class="wizard-step" data-step="2">
                                <div class="step-circle">2</div>
                                <div class="step-label">Order Items</div>
                            </div>
                        </div>

                        <form action="{{ route('orders.place') }}" method="POST" id="manageOrderForm">
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id ?? '' }}">

                            {{-- ============================
                                 STEP 1: Order Details
                                 ============================ --}}
                            <div class="wizard-panel active" id="step-1">
                                <div class="form-section-title"><i class="bx bx-receipt me-2"></i>Order Information</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Store Location <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-map"></i></span>
                                            <select name="store_id" class="form-select" required>
                                                <option value="">Select Store</option>
                                                @foreach($stores as $store)
                                                    <option value="{{ $store->LocationID }}"
                                                        {{ (isset($order) && $order->store_id == $store->LocationID) ? 'selected' : '' }}>
                                                        {{ $store->LocationName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Supplier <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user-pin"></i></span>
                                            <select name="supplier_id" class="form-select" required>
                                                <option value="">Select Supplier</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ (isset($order) && $order->supplier_id == $supplier->id) ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Order Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input type="date" name="order_date" class="form-control" required
                                                value="{{ isset($order) ? \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') : date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Status</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-transfer-alt"></i></span>
                                            <select name="status" class="form-select status-badge-select">
                                                <option value="Pending" {{ (isset($order) && $order->status == 'Pending') ? 'selected' : '' }}>⏳ Pending</option>
                                                <option value="Completed" {{ (isset($order) && $order->status == 'Completed') ? 'selected' : '' }}>✅ Completed</option>
                                                <option value="Cancelled" {{ (isset($order) && $order->status == 'Cancelled') ? 'selected' : '' }}>❌ Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold">Shipping Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-home-alt"></i></span>
                                            <input type="text" name="shipping_address" class="form-control"
                                                placeholder="Enter Shipping Address"
                                                value="{{ $order->shipping_address ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn-wizard-next" onclick="goToStep(2)">
                                        Next <i class="bx bx-right-arrow-alt ms-1"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- ============================
                                 STEP 2: Order Items
                                 ============================ --}}
                            <div class="wizard-panel" id="step-2">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-section-title mb-0"><i class="bx bx-cart me-2"></i>Order Items</div>
                                    <button type="button" class="btn-add-item" id="addItemBtn">
                                        <i class="bx bx-plus me-1"></i> Add Item
                                    </button>
                                </div>

                                <div class="items-table-wrapper mb-3">
                                    <table class="table mb-0" id="itemsTable">
                                        <thead>
                                            <tr>
                                                <th style="width:40%">Medicine</th>
                                                <th style="width:15%">Quantity</th>
                                                <th style="width:20%">Unit Price</th>
                                                <th style="width:18%">Row Total</th>
                                                <th style="width:7%" class="text-center">Del</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($order) && $order->items->count() > 0)
                                                @foreach($order->items as $item)
                                                    <tr class="item-row">
                                                        <td>
                                                            <select name="items[medicine_id][]" class="form-select form-select-sm medicine-select" required>
                                                                <option value="">Select Medicine</option>
                                                                @foreach($medicines as $med)
                                                                    <option value="{{ $med->id }}" data-price="{{ $med->cost }}"
                                                                        {{ $item->medicine_id == $med->id ? 'selected' : '' }}>
                                                                        {{ $med->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="items[quantity][]" class="form-control form-control-sm qty-input" min="1" value="{{ $item->quantity }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="items[price][]" class="form-control form-control-sm price-input" step="0.01" value="{{ $item->price }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm row-total" readonly value="{{ number_format($item->quantity * $item->price, 2) }}">
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-danger btn-sm rounded-pill remove-row px-2"><i class="bx bx-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="item-row">
                                                    <td>
                                                        <select name="items[medicine_id][]" class="form-select form-select-sm medicine-select" required>
                                                            <option value="">Select Medicine</option>
                                                            @foreach($medicines as $med)
                                                                <option value="{{ $med->id }}" data-price="{{ $med->cost }}">{{ $med->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name="items[quantity][]" class="form-control form-control-sm qty-input" min="1" value="1" required></td>
                                                    <td><input type="number" name="items[price][]" class="form-control form-control-sm price-input" step="0.01" value="0.00" required></td>
                                                    <td><input type="number" class="form-control form-control-sm row-total" readonly value="0.00"></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm rounded-pill remove-row px-2"><i class="bx bx-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold text-dark pe-3">Grand Total</td>
                                                <td>
                                                    <input type="number" name="total_amount" id="grandTotal"
                                                        class="form-control form-control-sm grand-total-box fw-bold" readonly
                                                        value="{{ $order->total_amount ?? '0.00' }}">
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn-wizard-back" onclick="goToStep(1)">
                                        <i class="bx bx-left-arrow-alt me-1"></i> Back
                                    </button>
                                    <button type="submit" class="btn-wizard-submit">
                                        <i class="bx bx-save me-1"></i> {{ isset($order) ? 'Update Order' : 'Place Order' }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>{{-- /.wizard-card --}}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    /* ---- Wizard Navigation ---- */
    function goToStep(stepNum) {
        const currentPanel = document.querySelector('.wizard-panel.active');
        if (stepNum > parseInt(currentPanel.id.split('-')[1])) {
            const required = currentPanel.querySelectorAll('[required]');
            let valid = true;
            required.forEach(f => {
                if (!f.value.trim()) { f.classList.add('is-invalid'); valid = false; }
                else { f.classList.remove('is-invalid'); }
            });
            if (!valid) return;
        }
        document.querySelectorAll('.wizard-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('step-' + stepNum).classList.add('active');
        document.querySelectorAll('.wizard-step').forEach((s, i) => {
            s.classList.remove('active', 'done');
            if (i + 1 < stepNum) s.classList.add('done');
            if (i + 1 === stepNum) s.classList.add('active');
        });
        document.querySelector('.wizard-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    document.querySelectorAll('[required]').forEach(f => f.addEventListener('input', () => f.classList.remove('is-invalid')));

    /* ---- Order Items JS ---- */
    $(document).ready(function () {

        // Build medicine options string once
        let medicineOptions = `<option value="">Select Medicine</option>`;
        @foreach($medicines as $med)
            medicineOptions += `<option value="{{ $med->id }}" data-price="{{ $med->cost }}">{{ $med->name }}</option>`;
        @endforeach

        // Add new row
        $('#addItemBtn').on('click', function () {
            let row = `<tr class="item-row">
                <td>
                    <select name="items[medicine_id][]" class="form-select form-select-sm medicine-select" required>
                        ${medicineOptions}
                    </select>
                </td>
                <td><input type="number" name="items[quantity][]" class="form-control form-control-sm qty-input" min="1" value="1" required></td>
                <td><input type="number" name="items[price][]" class="form-control form-control-sm price-input" step="0.01" value="0.00" required></td>
                <td><input type="number" class="form-control form-control-sm row-total" readonly value="0.00"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm rounded-pill remove-row px-2"><i class="bx bx-trash"></i></button>
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

        // Auto-fill price on medicine selection
        $(document).on('change', '.medicine-select', function () {
            let price = $(this).find(':selected').data('price');
            let row = $(this).closest('tr');
            row.find('.price-input').val(price ? parseFloat(price).toFixed(2) : '0.00');
            calculateRowTotal(row);
        });

        // Recalculate on qty / price change
        $(document).on('input', '.qty-input, .price-input', function () {
            calculateRowTotal($(this).closest('tr'));
        });

        function calculateRowTotal(row) {
            let qty = parseFloat(row.find('.qty-input').val()) || 0;
            let price = parseFloat(row.find('.price-input').val()) || 0;
            row.find('.row-total').val((qty * price).toFixed(2));
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let total = 0;
            $('.row-total').each(function () { total += parseFloat($(this).val()) || 0; });
            $('#grandTotal').val(total.toFixed(2));
        }
    });
</script>
@endpush