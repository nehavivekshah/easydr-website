@extends('frontend.layout')

@section('content')
    <style>
        /* ========================================================
       CART PAGE — SELF-CONTAINED STYLES
       ======================================================== */

        /* ----- Page Header ----- */
        .cart-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
        }

        .cart-section-header h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.4rem;
            color: #1a1a2e;
        }

        /* ----- Items Card ----- */
        .cart-items-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(30, 11, 155, 0.07);
            overflow: hidden;
        }

        /* ----- Table Header Row ----- */
        .cart-header-row {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            background: linear-gradient(90deg, #f0f4ff, #e8f8fd);
            border-bottom: 1px solid #e4e8f5;
            font-size: 0.78rem;
            font-weight: 700;
            color: #6c7a99;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .cart-header-row .col-info {
            flex: 2;
            padding-right: 12px;
        }

        .cart-header-row .col-qty {
            flex: 0 0 150px;
            text-align: center;
        }

        .cart-header-row .col-price {
            flex: 0 0 150px;
            text-align: right;
            padding-right: 8px;
        }

        .cart-header-row .col-total {
            flex: 0 0 120px;
            text-align: right;
            padding-right: 8px;
        }

        .cart-header-row .col-del {
            flex: 0 0 35px;
        }

        /* ----- Single Cart Row ----- */
        .cart-med-row {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 18px 20px;
            border-bottom: 1px solid #f0f2f7;
            transition: background 0.15s;
        }

        .cart-med-row:last-child {
            border-bottom: none;
        }

        .cart-med-row:hover {
            background: #f9fbff;
        }

        /* --- Product info column --- */
        .med-info-area {
            flex: 2;
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
            padding-right: 12px;
        }

        .cart-med-icon {
            flex-shrink: 0;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #eef1ff, #e0f7fd);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .cart-med-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        .cart-med-details h5 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0 0 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .tag-rx {
            display: inline-block;
            font-size: 0.68rem;
            font-weight: 600;
            background: #eef1ff;
            color: #1E0B9B;
            border-radius: 30px;
            padding: 2px 8px;
            text-transform: capitalize;
        }

        .tag-poi {
            display: inline-block;
            font-size: 0.68rem;
            font-weight: 600;
            background: #fff3cd;
            color: #856404;
            border-radius: 30px;
            padding: 2px 8px;
        }

        /* --- Quantity column --- */
        .col-qty-cell {
            flex: 0 0 150px;
            display: flex;
            flex-direction: column;
            align-items: end;
            gap: 5px;
        }

        .qty-group {
            display: flex;
            align-items: center;
            border: 1.5px solid #d0d5e8;
            border-radius: 10px;
            overflow: hidden;
            height: 34px;
        }

        .qty-btn {
            width: 32px;
            height: 34px;
            background: #f4f6fb;
            border: none;
            cursor: pointer;
            font-size: 0.75rem;
            color: #1E0B9B;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s;
            flex-shrink: 0;
        }

        .qty-btn:hover {
            background: #e0e7ff;
        }

        .qty-num {
            width: 38px;
            height: 34px;
            border: none;
            text-align: center;
            font-size: 0.88rem;
            font-weight: 700;
            color: #1a1a2e;
            background: #fff;
            outline: none;
            -moz-appearance: textfield;
        }

        .qty-num::-webkit-inner-spin-button,
        .qty-num::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }

        .btn-update-qty {
            font-size: 0.68rem;
            color: #1E0B9B;
            background: none;
            border: 1px solid #c7d0ef;
            border-radius: 6px;
            padding: 2px 8px;
            cursor: pointer;
            transition: all 0.15s;
            font-weight: 600;
        }

        .btn-update-qty:hover {
            background: #eef1ff;
            border-color: #1E0B9B;
        }

        /* --- Price column --- */
        .col-price-cell {
            flex: 0 0 150px;
            text-align: right;
            padding-right: 8px;
            /* prevent badge+strikethrough from overflowing */
            overflow: visible;
        }
        /* Ensure the discount line wraps cleanly */
        .price-discount-line {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 4px;
            line-height: 1.3;
        }

        .price-val {
            font-size: 0.92rem;
            font-weight: 700;
            color: #1E0B9B;
        }

        .disc-badge {
            display: inline-block;
            background: linear-gradient(90deg, #1E0B9B, #07CCEC);
            color: #fff;
            font-size: 0.62rem;
            font-weight: 700;
            border-radius: 30px;
            padding: 1px 5px;
            vertical-align: middle;
            letter-spacing: 0.02em;
        }

        .na-text {
            color: #b0b8cc;
            font-size: 0.85rem;
        }

        /* --- Total column --- */
        .col-total-cell {
            flex: 0 0 120px;
            text-align: right;
            padding-right: 8px;
        }

        .total-val {
            font-size: 1rem;
            font-weight: 800;
            color: #0a0a1a;
        }

        /* --- Remove button --- */
        .col-del-cell {
            flex: 0 0 35px;
            display: flex;
            justify-content: center;
        }

        .btn-remove {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            color: #dc3545;
            background: #fff1f2;
            border: 1px solid #ffd0d5;
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.15s;
        }

        .btn-remove:hover {
            background: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }

        /* ----- Order Summary ----- */
        .cart-summary-box {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(30, 11, 155, 0.07);
            overflow: hidden;
            position: sticky;
            top: 100px;
        }

        .cart-summary-header {
            background: linear-gradient(90deg, #1E0B9B, #07CCEC);
            padding: 16px 22px;
        }

        .cart-summary-header h5 {
            color: #fff;
            font-weight: 700;
            margin: 0;
            font-size: 1rem;
        }

        .cart-summary-body {
            padding: 20px 22px;
        }

        .sum-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 0.88rem;
            color: #444;
        }

        .sum-val {
            font-weight: 600;
            color: #1a1a2e;
        }

        .text-free {
            color: #22c55e;
            font-weight: 700;
        }

        .divider {
            border-top: 2px dashed #e4e8f5;
            margin: 10px 0;
        }

        .sum-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0 14px;
            font-size: 0.95rem;
            font-weight: 700;
            color: #1a1a2e;
        }

        .sum-total-val {
            font-size: 1.2rem;
            font-weight: 800;
            background: linear-gradient(90deg, #1E0B9B, #07CCEC);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .checkout-btn {
            display: block;
            width: 100%;
            padding: 13px;
            background: linear-gradient(90deg, #1E0B9B, #07CCEC);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            letter-spacing: 0.03em;
            margin-bottom: 16px;
        }

        .checkout-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Trust badges */
        .trust-badges {
            display: flex;
            justify-content: space-between;
            gap: 6px;
            flex-wrap: wrap;
        }

        .trust-item {
            font-size: 0.75rem;
            color: #555;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ----- Empty State ----- */
        .cart-empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .cart-empty-state .empty-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 24px;
            background: linear-gradient(135deg, #eef1ff, #e0f7fd);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.4rem;
            color: #1E0B9B;
        }

        /* ----- Mobile ----- */
        @media (max-width: 767px) {
            .cart-header-row {
                display: none;
            }

            .cart-med-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                padding: 16px;
            }

            .med-info-area {
                width: 100%;
            }

            .cart-med-details h5 {
                max-width: 100%;
                white-space: normal;
            }

            .col-qty-cell,
            .col-price-cell,
            .col-total-cell {
                flex: none;
                text-align: left;
            }

            .col-price-cell {
                text-align: left;
            }

            .col-total-cell {
                text-align: left;
            }

            .mobile-row {
                display: flex;
                width: 100%;
                justify-content: space-between;
                align-items: center;
            }
        }
    </style>

    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    {{-- ===== Main Content ===== --}}
                    <div class="col-lg-12">
                        <div class="dashboard_content p-4">

                            {{-- Page Header --}}
                            <div class="cart-section-header">
                                <h4>
                                    My Cart
                                    @if(count($cartItems) > 0)
                                        <span class="badge rounded-pill ms-2"
                                            style="background:linear-gradient(90deg,#1E0B9B,#07CCEC);font-size:0.7rem;vertical-align:middle;color:#000;">
                                            {{ count($cartItems) }} Items
                                        </span>
                                    @endif
                                </h4>
                                <a href="/patient-prescriptions"
                                    class="btn btn-outline-primary btn-sm rounded-pill px-4 py-2 fw-bold">
                                    <i class="fas fa-plus me-1"></i> Add More Medicines
                                </a>
                            </div>

                            {{-- Alerts --}}
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm border-0 bg-success-subtle text-success"
                                    role="alert">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm border-0 bg-danger-subtle text-danger"
                                    role="alert">
                                    <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                            @if(session('warning'))
                                <div class="alert alert-warning alert-dismissible fade show rounded-3 mb-4 shadow-sm border-0"
                                    role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if(count($cartItems) > 0)
                                <div class="row g-4">

                                    {{-- ===== Cart Items List ===== --}}
                                    <div class="col-lg-8">
                                        <div class="cart-items-card">

                                            {{-- Desktop Table Headers --}}
                                            <div class="cart-header-row d-none d-md-flex">
                                                <div class="col-info">Product Details</div>
                                                <div class="col-qty">Quantity</div>
                                                <div class="col-price">Unit Price</div>
                                                <div class="col-total">Total</div>
                                                <div class="col-del"></div>
                                            </div>

                                            @foreach($cartItems as $item)
                                                @php
                                                    $originalCost = (float) ($item->medicine->cost ?? 0);
                                                    $discountCost = (float) ($item->medicine->discount_cost ?? 0);
                                                    $hasDiscount = ($discountCost > 0 && $discountCost < $originalCost);
                                                    $price = $hasDiscount ? $discountCost : ($originalCost > 0 ? $originalCost : $discountCost);
                                                    $hasPrice = $price > 0;
                                                    $itemTotal = $hasPrice ? ($price * $item->quantity) : 0;
                                                    $img = $item->medicine->img ?? null;
                                                    $medName = $item->medicine->name ?? 'Unknown Product';
                                                    $typeName = $item->medicine->medicine_category ?? $item->medicine->type_name ?? 'Rx Medicine';
                                                @endphp

                                                <div class="cart-med-row">

                                                    {{-- Col 1: Image + Name --}}
                                                    <div class="med-info-area">
                                                        <div class="cart-med-icon">
                                                            @if($img)
                                                                <img src="{{ asset('public/assets/images/medicines/' . $img) }}"
                                                                    alt="{{ $medName }}"
                                                                    onerror="this.onerror=null;this.parentElement.innerHTML='<i class=\'fas fa-capsules fa-2x\' style=\'color:#1E0B9B;\'></i>';">
                                                            @else
                                                                <i class="fas fa-capsules fa-2x" style="color:#1E0B9B;"></i>
                                                            @endif
                                                        </div>
                                                        <div class="cart-med-details">
                                                            <h5 title="{{ $medName }}">{{ $medName }}</h5>
                                                            <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                                                                <span class="tag-rx">{{ $typeName }}</span>
                                                                @if(!$hasPrice)
                                                                    <span class="tag-poi">
                                                                        <i class="fas fa-info-circle"></i> Price on inquiry
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Col 2: Quantity --}}
                                                    <div class="col-qty-cell">
                                                        <form action="{{ route('cart.update') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                                            <div class="qty-group">
                                                                <button type="button" class="qty-btn qty-minus">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                                <input type="number" name="quantity" class="qty-num"
                                                                    value="{{ $item->quantity }}" min="1" max="99" readonly>
                                                                <button type="button" class="qty-btn qty-plus">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                            <button type="submit" class="btn-update-qty mt-1">Update</button>
                                                        </form>
                                                    </div>

                                                    {{-- Col 3: Unit Price --}}
                                                    <div class="col-price-cell">
                                                        @if($hasPrice)
                                                            <div class="d-flex justify-content-end
                                                            items-align-center">
                                                                <div class="price-val">₹{{ number_format($price, 2) }}</div>
                                                                <small class="text-muted" style="font-size:0.65rem;">/ unit</small>
                                                            </div>
                                                            
                                                            @if($hasDiscount)
                                                                <div class="price-discount-line">
                                                                    <span style="text-decoration:line-through;color:#aaa;font-size:0.78rem;white-space:nowrap;">
                                                                        ₹{{ number_format($originalCost, 2) }}
                                                                    </span>
                                                                    <!-- <span class="disc-badge">
                                                                        {{ round((($originalCost - $discountCost) / $originalCost) * 100) }}% off
                                                                    </span> -->
                                                                </div>
                                                            @endif
                                                        @else
                                                            <span class="na-text">—</span>
                                                        @endif
                                                    </div>

                                                    {{-- Col 4: Total --}}
                                                    <div class="col-total-cell">
                                                        @if($hasPrice)
                                                            <div class="total-val">₹{{ number_format($itemTotal, 2) }}</div>
                                                        @else
                                                            <span class="na-text">TBD</span>
                                                        @endif
                                                    </div>

                                                    {{-- Col 5: Remove --}}
                                                    <div class="col-del-cell">
                                                        <a href="{{ route('cart.remove', $item->id) }}" class="btn-remove"
                                                            onclick="return confirm('Remove {{ addslashes($medName) }} from cart?');"
                                                            title="Remove">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>
                                                    </div>

                                                </div>{{-- /cart-med-row --}}
                                            @endforeach

                                        </div>{{-- /cart-items-card --}}

                                        {{-- Info hint --}}
                                        <div
                                            class="d-flex align-items-start gap-2 mt-3 p-3 rounded-3 bg-info-subtle text-info-emphasis">
                                            <i class="fas fa-info-circle mt-1"></i>
                                            <small>Items marked as <strong>"Price on inquiry"</strong> need verification from
                                                our pharmacists. The final bill will be communicated to you before order
                                                confirmation.</small>
                                        </div>
                                    </div>{{-- /col-lg-8 --}}

                                    {{-- ===== Order Summary ===== --}}
                                    <div class="col-lg-4">
                                        <div class="cart-summary-box">
                                            <div class="cart-summary-header">
                                                <h5><i class="fas fa-receipt mr-2"></i>Order Summary</h5>
                                            </div>
                                            <div class="cart-summary-body">
                                                <div class="sum-row">
                                                    <span>Subtotal</span>
                                                    <span class="sum-val">
                                                        @if($subtotal > 0)
                                                            ₹{{ number_format($subtotal, 2) }}
                                                        @else
                                                            <span class="text-muted fw-normal">To be calculated</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="sum-row">
                                                    <span>Delivery Charges</span>
                                                    <span class="sum-val text-free">FREE</span>
                                                </div>
                                                <div class="sum-row">
                                                    <span>Estimated Tax</span>
                                                    <span class="sum-val">Inclusive</span>
                                                </div>

                                                <div class="divider"></div>

                                                <div class="sum-total">
                                                    <span>Total Amount</span>
                                                    <span class="sum-total-val">
                                                        @if($subtotal > 0)
                                                            ₹{{ number_format($subtotal, 2) }}
                                                        @else
                                                            —
                                                        @endif
                                                    </span>
                                                </div>

                                                <form action="{{ route('cart.checkout') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="checkout-btn">
                                                        Proceed to Checkout &nbsp;<i class="fas fa-arrow-right"></i>
                                                    </button>
                                                </form>

                                                <div class="trust-badges">
                                                    <span class="trust-item"><i class="fas fa-shield-alt text-success"></i>
                                                        Secure</span>
                                                    <span class="trust-item"><i class="fas fa-check-circle text-primary"></i>
                                                        Verified</span>
                                                    <span class="trust-item"><i class="fas fa-truck text-info"></i> Fast
                                                        Delivery</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>{{-- /col-lg-4 --}}

                                </div>{{-- /row --}}
                            @else
                                {{-- ===== Empty State ===== --}}
                                <div class="cart-empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-2">Your Cart is Empty</h3>
                                    <p class="text-secondary mb-4">
                                        Looks like you haven't added any medicines yet.<br>
                                        Browse your prescriptions to add prescribed items.
                                    </p>
                                    <a href="/patient-prescriptions"
                                        class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow">
                                        View My Prescriptions
                                    </a>
                                </div>
                            @endif

                        </div>{{-- /dashboard_content --}}
                    </div>{{-- /col-lg-9 --}}
                </div>{{-- /row --}}
            </div>{{-- /container --}}
        </section>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                // Hide "Update" buttons — updates are now automatic
                document.querySelectorAll('.btn-update-qty').forEach(function (btn) {
                    btn.style.display = 'none';
                });

                document.querySelectorAll('.cart-med-row').forEach(function (row) {
                    const minus  = row.querySelector('.qty-minus');
                    const plus   = row.querySelector('.qty-plus');
                    const input  = row.querySelector('.qty-num');
                    const form   = row.querySelector('form');
                    if (!minus || !plus || !input || !form) return;

                    let debounceTimer = null;

                    // ── Submit helper ──────────────────────────────────────
                    function submitQty() {
                        clearTimeout(debounceTimer);
                        let v = parseInt(input.value) || 1;
                        if (v < 1)  v = 1;
                        if (v > 99) v = 99;
                        input.value = v;

                        // Visual feedback: dim the row while saving
                        row.style.opacity = '0.55';
                        row.style.pointerEvents = 'none';
                        form.submit();
                    }

                    // ── Debounced version for typing ───────────────────────
                    function debouncedSubmit() {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(submitQty, 600);
                    }

                    // ── + / - buttons ──────────────────────────────────────
                    minus.addEventListener('click', function () {
                        let v = parseInt(input.value) || 1;
                        if (v > 1) {
                            input.value = v - 1;
                            submitQty();
                        }
                    });

                    plus.addEventListener('click', function () {
                        let v = parseInt(input.value) || 1;
                        if (v < 99) {
                            input.value = v + 1;
                            submitQty();
                        }
                    });

                    // ── Direct keyboard input ──────────────────────────────
                    input.removeAttribute('readonly');   // allow direct typing
                    input.addEventListener('keyup', function (e) {
                        if (e.key === 'Enter') {
                            clearTimeout(debounceTimer);
                            submitQty();
                        } else {
                            debouncedSubmit();
                        }
                    });

                    // ── Blur / change (e.g. mobile spinner) ───────────────
                    input.addEventListener('change', function () {
                        clearTimeout(debounceTimer);
                        submitQty();
                    });
                });
            });
        </script>
    @endpush
@endsection