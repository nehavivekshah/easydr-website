@extends('frontend.layout')

@push('styles')
    <style>
        /* ---- Cart UI: matches existing dashboard_content card style ---- */
        .cart-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .cart-section-header h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a1a2e;
            letter-spacing: -0.5px;
            margin: 0;
        }

        /* Medicine Row */
        .cart-med-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 20px;
            border-bottom: 1px solid #f2f4f8;
            transition: background 0.15s;
        }

        .cart-med-row:last-of-type {
            border-bottom: none;
        }

        .cart-med-row:hover {
            background: #fafbff;
        }

        .cart-med-icon {
            width: 54px;
            height: 54px;
            border-radius: 12px;
            background: linear-gradient(135deg, #eef2ff, #e0f7ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            flex-shrink: 0;
            border: 1px solid #e0e8ff;
            overflow: hidden;
        }

        .cart-med-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-med-name {
            font-weight: 700;
            font-size: 0.92rem;
            color: #1a1a2e;
            margin-bottom: 3px;
        }

        .cart-med-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #eef2ff;
            color: #1E0B9B;
            border-radius: 5px;
            padding: 1px 7px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .cart-price-na {
            font-size: 0.75rem;
            color: #bbb;
            font-style: italic;
        }

        .cart-poi {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            background: #fef3c7;
            color: #92400e;
            border-radius: 5px;
            padding: 1px 7px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* Qty inline controls */
        .qty-group {
            display: flex;
            align-items: center;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            width: fit-content;
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            background: #f8fafc;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            color: #1E0B9B;
            transition: background 0.15s;
        }

        .qty-btn:hover {
            background: #e8ecff;
        }

        .qty-num {
            width: 38px;
            text-align: center;
            font-weight: 700;
            font-size: 0.88rem;
            color: #1a1a2e;
            border: none;
            outline: none;
            background: #fff;
        }

        .qty-save-btn {
            background: linear-gradient(90deg, #1E0B9B, #07CCEC);
            color: #fff;
            border: none;
            border-radius: 7px;
            padding: 5px 10px;
            font-size: 0.73rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: opacity .2s;
            margin-left: 7px;
            white-space: nowrap;
        }

        .qty-save-btn:hover {
            opacity: .85;
        }

        .cart-row-total {
            font-weight: 800;
            font-size: 0.95rem;
            color: #1E0B9B;
            min-width: 58px;
            text-align: right;
        }

        .cart-remove-btn {
            width: 32px;
            height: 32px;
            background: #fff5f5;
            color: #dc3545;
            border: 1px solid #ffd6d6;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            flex-shrink: 0;
            transition: all .2s;
        }

        .cart-remove-btn:hover {
            background: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }

        .cart-remove-btn i {
            font-size: 0.75rem;
        }

        /* Summary Card inside dashboard_content */
        .cart-summary-box {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .cart-summary-header {
            background: linear-gradient(90deg, #1E0B9B 0%, #07CCEC 100%);
            padding: 16px 20px;
        }

        .cart-summary-header h6 {
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            margin: 0;
        }

        .cart-summary-body {
            padding: 20px;
        }

        .sum-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px dashed #f0f2f8;
            font-size: 0.87rem;
        }

        .sum-row:last-of-type {
            border-bottom: none;
        }

        .sum-label {
            color: #888;
        }

        .sum-val {
            font-weight: 700;
            color: #1a1a2e;
        }

        .sum-total-label {
            color: #1a1a2e;
            font-weight: 700;
            font-size: 0.97rem;
        }

        .sum-total-val {
            color: #1E0B9B;
            font-weight: 800;
            font-size: 1.1rem;
        }

        .checkout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px;
            background: linear-gradient(90deg, #1E0B9B 0%, #07CCEC 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(30, 11, 155, 0.25);
            transition: opacity .2s, transform .2s;
        }

        .checkout-btn:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        .trust-row {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 14px;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.72rem;
            color: #aaa;
        }

        .trust-item i {
            color: #28a745;
            font-size: 0.65rem;
        }

        /* Empty State */
        .cart-empty {
            text-align: center;
            padding: 50px 20px;
        }

        .cart-empty .e-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #f0f4ff;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Info hint */
        .cart-hint {
            background: #f7f9ff;
            border-radius: 0 0 16px 16px;
            padding: 12px 20px;
            font-size: 0.78rem;
            color: #888;
            border-top: 1px solid #f0f2f8;
        }
    </style>
@endpush

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">

                    <!-- ===== Sidebar ===== -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    <!-- ===== Main Content ===== -->
                    <div class="col-lg-9">
                        <div class="dashboard_content">

                            <!-- Page Header -->
                            <div class="cart-section-header">
                                <h4>
                                    <i class="fas fa-shopping-basket me-2" style="color:#07CCEC;"></i>
                                    My Cart
                                    <span class="badge rounded-pill ms-1"
                                        style="background:linear-gradient(90deg,#1E0B9B,#07CCEC);font-size:0.72rem;vertical-align:middle;">
                                        {{ count($cartItems) }}
                                    </span>
                                </h4>
                                <a href="/patient-prescriptions"
                                    class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold"
                                    style="font-size:0.8rem;">
                                    <i class="fas fa-prescription me-1"></i> Back to Prescriptions
                                </a>
                            </div>

                            <!-- Alerts -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                            @if(session('warning'))
                                <div class="alert alert-warning alert-dismissible fade show rounded-3 mb-4" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                                    <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="row g-4 align-items-start">

                                <!-- ===== Cart Items ===== -->
                                <div class="col-lg-8">
                                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                        <div
                                            class="card-header bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-bold text-dark">
                                                Items in Cart
                                            </h6>
                                            @if(count($cartItems) > 0)
                                                <small class="text-muted">{{ count($cartItems) }} product(s)</small>
                                            @endif
                                        </div>

                                        @if(count($cartItems) > 0)
                                            @foreach($cartItems as $item)
                                                @php
                                                    $price = $item->medicine->price ?? $item->medicine->mrp ?? 0;
                                                    $hasPrice = $price > 0;
                                                    $itemTotal = $hasPrice ? ($price * $item->quantity) : 0;
                                                    $img = $item->medicine->img ?? null;
                                                    $medName = $item->medicine->name ?? 'Unknown Product';
                                                    $typeName = $item->medicine->type_name ?? $item->medicine->category ?? 'Rx Medicine';
                                                @endphp
                                                <div class="cart-med-row">
                                                    <!-- Icon -->
                                                    <div class="cart-med-icon">
                                                        @if($img)
                                                            <img src="{{ asset('public/assets/images/medicines/' . $img) }}"
                                                                alt="{{ $medName }}"
                                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                            <span class="fallback"
                                                                style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:1.5rem;">💊</span>
                                                        @else
                                                            💊
                                                        @endif
                                                    </div>

                                                    <!-- Info -->
                                                    <div class="flex-grow-1">
                                                        <div class="cart-med-name">{{ $medName }}</div>
                                                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                                            <span class="cart-med-tag">
                                                                <i class="fas fa-tag" style="font-size:0.6rem;"></i>
                                                                {{ $typeName }}
                                                            </span>
                                                            @if(!$hasPrice)
                                                                <span class="cart-poi">
                                                                    <i class="fas fa-info-circle"></i> Price on inquiry
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Per unit price (md+) -->
                                                    <div class="text-center d-none d-md-block" style="min-width:65px;">
                                                        @if($hasPrice)
                                                            <div style="font-weight:700;font-size:0.88rem;color:#1a1a2e;">
                                                                ₹{{ number_format($price, 2) }}</div>
                                                            <div style="font-size:0.68rem;color:#bbb;">per unit</div>
                                                        @else
                                                            <span class="cart-price-na">—</span>
                                                        @endif
                                                    </div>

                                                    <!-- Qty Controls -->
                                                    <form action="{{ route('cart.update') }}" method="POST"
                                                        class="d-flex align-items-center">
                                                        @csrf
                                                        <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                                        <div class="qty-group">
                                                            <button type="button" class="qty-btn qty-minus"><i
                                                                    class="fas fa-minus"></i></button>
                                                            <input type="number" name="quantity" class="qty-num"
                                                                value="{{ $item->quantity }}" min="1" max="99">
                                                            <button type="button" class="qty-btn qty-plus"><i
                                                                    class="fas fa-plus"></i></button>
                                                        </div>
                                                        <button type="submit" class="qty-save-btn" title="Update">
                                                            <i class="fas fa-sync-alt"></i> Update
                                                        </button>
                                                    </form>

                                                    <!-- Row Total -->
                                                    <div class="cart-row-total">
                                                        @if($hasPrice)
                                                            ₹{{ number_format($itemTotal, 2) }}
                                                        @else
                                                            <span class="cart-price-na">—</span>
                                                        @endif
                                                    </div>

                                                    <!-- Remove -->
                                                    <a href="{{ route('cart.remove', $item->id) }}" class="cart-remove-btn"
                                                        onclick="return confirm('Remove {{ $medName }}?');" title="Remove">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            @endforeach

                                            <div class="cart-hint">
                                                <i class="fas fa-info-circle text-primary me-1"></i>
                                                Items with <strong>"Price on inquiry"</strong> will be confirmed by our pharmacy
                                                team before dispatch.
                                            </div>

                                        @else
                                            <div class="cart-empty">
                                                <div class="e-icon">
                                                    <i class="fas fa-shopping-basket"
                                                        style="font-size:2.4rem;color:#1E0B9B;opacity:0.25;"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark mb-2">Your cart is empty</h5>
                                                <p class="text-secondary mb-4"
                                                    style="max-width:320px;margin:auto;font-size:0.88rem;">
                                                    Go to your prescriptions and click "Buy Available Medicines" to add items
                                                    here.
                                                </p>
                                                <a href="/patient-prescriptions"
                                                    class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                                                    <i class="fas fa-prescription me-2"></i> View My Prescriptions
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- ===== Order Summary ===== -->
                                <div class="col-lg-4">
                                    <div class="cart-summary-box" style="position:sticky;top:90px;">
                                        <div class="cart-summary-header">
                                            <h6><i class="fas fa-receipt me-2"></i>Order Summary</h6>
                                        </div>
                                        <div class="cart-summary-body">
                                            <div class="sum-row">
                                                <span class="sum-label">Subtotal</span>
                                                <span class="sum-val">
                                                    @if($subtotal > 0) ₹{{ number_format($subtotal, 2) }}
                                                    @else <span class="cart-price-na">To be confirmed</span>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="sum-row">
                                                <span class="sum-label">Delivery</span>
                                                <span class="sum-val text-success fw-bold">Free</span>
                                            </div>
                                            <div class="sum-row">
                                                <span class="sum-label">Tax</span>
                                                <span class="sum-val">Inclusive</span>
                                            </div>
                                            <div class="sum-row mt-1 pt-2"
                                                style="border-top:2px solid #eef2ff;border-bottom:none;">
                                                <span class="sum-total-label">Total</span>
                                                <span class="sum-total-val">
                                                    @if($subtotal > 0) ₹{{ number_format($subtotal, 2) }}
                                                    @else —
                                                    @endif
                                                </span>
                                            </div>

                                            @if(count($cartItems) > 0)
                                                <form action="{{ route('cart.checkout') }}" method="POST" class="mt-3">
                                                    @csrf
                                                    <button type="submit" class="checkout-btn">
                                                        <i class="fas fa-lock" style="font-size:0.85rem;"></i>
                                                        Place Order
                                                        <i class="fas fa-chevron-right" style="font-size:0.8rem;"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Trust -->
                                            <div class="trust-row">
                                                <span class="trust-item"><i class="fas fa-shield-alt"></i> Secure</span>
                                                <span class="trust-item"><i class="fas fa-check-circle"></i> Verified</span>
                                                <span class="trust-item"><i class="fas fa-undo"></i> Easy Returns</span>
                                            </div>

                                            <!-- Help -->
                                            <div class="mt-3 p-3 rounded-3 d-flex align-items-center gap-2"
                                                style="background:#f7f9fc;">
                                                <i class="fas fa-headset" style="color:#1E0B9B;font-size:1.1rem;"></i>
                                                <div>
                                                    <div style="font-size:0.78rem;font-weight:700;color:#1a1a2e;">Need help?
                                                    </div>
                                                    <div style="font-size:0.72rem;color:#aaa;">Our pharmacy team is ready to
                                                        assist.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end row --}}

                        </div>
                        {{-- end dashboard_content --}}
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
            document.querySelectorAll('.cart-med-row').forEach(function (row) {
                var minus = row.querySelector('.qty-minus');
                var plus = row.querySelector('.qty-plus');
                var inp = row.querySelector('.qty-num');
                if (!minus || !plus || !inp) return;
                minus.addEventListener('click', function () {
                    var v = parseInt(inp.value) || 1;
                    if (v > 1) inp.value = v - 1;
                });
                plus.addEventListener('click', function () {
                    var v = parseInt(inp.value) || 1;
                    if (v < 99) inp.value = v + 1;
                });
            });
        </script>
    @endpush
@endsection