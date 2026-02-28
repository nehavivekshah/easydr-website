@extends('frontend.layout')

@push('styles')
    <style>
        :root {
            --cart-primary: #1E0B9B;
            --cart-accent: #07CCEC;
            --cart-gradient: linear-gradient(135deg, #1E0B9B 0%, #07CCEC 100%);
        }

        /* Page Hero */
        .cart-hero {
            background: var(--cart-gradient);
            padding: 60px 0 40px;
        }

        .cart-hero h1 {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff;
        }

        .cart-hero .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .cart-hero .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.6);
        }

        .cart-hero .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Alert Banners */
        .cart-alert {
            border: none;
            border-left: 4px solid transparent;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 0.92rem;
        }

        .cart-alert.alert-success {
            border-color: #198754;
            background: #d1e7dd;
        }

        .cart-alert.alert-warning {
            border-color: #ffc107;
            background: #fff3cd;
        }

        .cart-alert.alert-danger {
            border-color: #dc3545;
            background: #f8d7da;
        }

        /* Cart Card */
        .cart-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        .cart-card .card-header {
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            padding: 20px 24px;
        }

        .cart-card .card-header h5 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--cart-primary);
        }

        .cart-card .card-header small {
            color: #aaa;
            font-size: 0.8rem;
        }

        /* Medicine Rows */
        .medicine-row {
            padding: 16px 24px;
            border-bottom: 1px solid #f8f8f8;
            transition: background 0.2s;
        }

        .medicine-row:last-child {
            border-bottom: none;
        }

        .medicine-row:hover {
            background: #fafbff;
        }

        /* Medicine Avatar */
        .med-avatar {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            background: linear-gradient(135deg, #eef2ff 0%, #e0f7ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid #e8ecff;
            overflow: hidden;
        }

        .med-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .med-avatar .fallback-icon {
            font-size: 1.6rem;
            color: var(--cart-primary);
            opacity: 0.7;
        }

        .med-name {
            font-weight: 700;
            font-size: 0.95rem;
            color: #1a1a2e;
            margin-bottom: 3px;
        }

        .med-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #eef2ff;
            color: var(--cart-primary);
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 0.73rem;
            font-weight: 600;
        }

        /* Price Badge */
        .price-badge {
            font-weight: 700;
            font-size: 0.95rem;
            color: #1a1a2e;
        }

        .price-na {
            font-size: 0.8rem;
            color: #aaa;
            font-style: italic;
        }

        /* Qty Controls */
        .qty-wrapper {
            display: flex;
            align-items: center;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            width: fit-content;
        }

        .qty-btn {
            background: #f8fafc;
            border: none;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.9rem;
            color: var(--cart-primary);
            transition: background 0.2s;
        }

        .qty-btn:hover {
            background: #e8ecff;
        }

        .qty-input {
            border: none;
            width: 44px;
            text-align: center;
            font-weight: 700;
            font-size: 0.95rem;
            color: #1a1a2e;
            background: #fff;
            outline: none;
        }

        .qty-update-btn {
            background: var(--cart-gradient);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: opacity 0.2s;
            margin-left: 8px;
            white-space: nowrap;
        }

        .qty-update-btn:hover {
            opacity: 0.85;
        }

        /* Remove Button */
        .remove-btn {
            background: #fff5f5;
            color: #dc3545;
            border: 1px solid #ffd6d6;
            border-radius: 8px;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            flex-shrink: 0;
        }

        .remove-btn:hover {
            background: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }

        /* Row Total */
        .row-total {
            font-weight: 800;
            font-size: 1rem;
            color: var(--cart-primary);
            min-width: 60px;
            text-align: right;
        }

        /* Order Summary Card */
        .summary-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.07);
            position: sticky;
            top: 90px;
        }

        .summary-card .card-header {
            background: var(--cart-gradient);
            border-radius: 20px 20px 0 0 !important;
            padding: 18px 22px;
        }

        .summary-card .card-header h5 {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            margin: 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px dashed #f0f0f0;
        }

        .summary-row:last-of-type {
            border-bottom: none;
        }

        .summary-label {
            color: #888;
            font-size: 0.88rem;
        }

        .summary-value {
            font-weight: 700;
            color: #1a1a2e;
            font-size: 0.9rem;
        }

        .summary-total-label {
            color: #1a1a2e;
            font-weight: 700;
            font-size: 1rem;
        }

        .summary-total-value {
            color: var(--cart-primary);
            font-weight: 800;
            font-size: 1.2rem;
        }

        /* Checkout Button */
        .checkout-btn {
            background: var(--cart-gradient);
            color: #fff;
            border: none;
            border-radius: 14px;
            padding: 14px 24px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 6px 20px rgba(30, 11, 155, 0.3);
            letter-spacing: 0.2px;
        }

        .checkout-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Empty State */
        .empty-cart {
            padding: 60px 30px;
            text-align: center;
        }

        .empty-cart .icon-wrap {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #f0f4ff;
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Trust Badge */
        .trust-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .trust-badge {
            font-size: 0.75rem;
            color: #888;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .trust-badge i {
            color: #28a745;
        }

        /* Price on inquiry label */
        .poi-label {
            background: #fef3c7;
            color: #92400e;
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 0.73rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .medicine-row {
                padding: 14px 16px;
            }

            .med-avatar {
                width: 48px;
                height: 48px;
                border-radius: 10px;
            }

            .cart-card .card-header {
                padding: 14px 16px;
            }
        }
    </style>
@endpush

@section('content')
    <main>
        <!-- Hero -->
        <section class="cart-hero">
            <div class="container">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                        style="width:44px;height:44px;background:rgba(255,255,255,0.15);">
                        <i class="fas fa-shopping-basket text-white"></i>
                    </div>
                    <div>
                        <h1 class="mb-0">My Cart</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0" style="font-size:0.82rem;">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item"><a href="/patient-prescriptions">Prescriptions</a></li>
                                <li class="breadcrumb-item active">Cart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5" style="background:#f7f9fc;min-height:70vh;">
            <div class="container">

                <!-- Alerts -->
                @if(session('success'))
                    <div class="cart-alert alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2 text-success"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('warning'))
                    <div class="cart-alert alert alert-warning alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-2 text-warning"></i> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="cart-alert alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-times-circle me-2 text-danger"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row g-4 align-items-start">

                    <!-- LEFT: Cart Items -->
                    <div class="col-lg-8">
                        <div class="cart-card card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0">
                                        <i class="fas fa-pills me-2" style="color:var(--cart-accent);"></i>
                                        Cart Items
                                        <span class="badge rounded-pill ms-1"
                                            style="background:var(--cart-gradient);font-size:0.75rem;">
                                            {{ count($cartItems) }}
                                        </span>
                                    </h5>
                                </div>
                                @if(count($cartItems) > 0)
                                    <a href="/patient-prescriptions" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                        style="font-size:0.8rem;">
                                        <i class="fas fa-plus me-1"></i> Add More
                                    </a>
                                @endif
                            </div>

                            <div>
                                @if(count($cartItems) > 0)
                                    @foreach($cartItems as $item)
                                        @php
                                            $price = $item->medicine->price ?? $item->medicine->mrp ?? 0;
                                            $hasPrice = $price > 0;
                                            $itemTotal = $hasPrice ? ($price * $item->quantity) : 0;
                                            $img = $item->medicine->img ?? null;
                                            $medName = $item->medicine->name ?? 'Unknown Product';
                                            $typeName = $item->medicine->type_name ?? $item->medicine->category ?? 'Prescription Medicine';
                                        @endphp
                                        <div class="medicine-row d-flex align-items-center gap-3 flex-wrap">

                                            <!-- Avatar -->
                                            <div class="med-avatar">
                                                @if($img && file_exists(public_path('public/assets/images/medicines/' . $img)))
                                                    <img src="{{ asset('public/assets/images/medicines/' . $img) }}"
                                                        alt="{{ $medName }}">
                                                @else
                                                    <span class="fallback-icon">💊</span>
                                                @endif
                                            </div>

                                            <!-- Medicine Info -->
                                            <div class="flex-grow-1">
                                                <div class="med-name">{{ $medName }}</div>
                                                <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                                                    <span class="med-tag">
                                                        <i class="fas fa-tag" style="font-size:0.65rem;"></i>
                                                        {{ $typeName }}
                                                    </span>
                                                    @if(!$hasPrice)
                                                        <span class="poi-label">
                                                            <i class="fas fa-info-circle"></i>
                                                            Price on inquiry
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Price -->
                                            <div class="text-center d-none d-md-block" style="min-width:70px;">
                                                @if($hasPrice)
                                                    <div class="price-badge">₹{{ number_format($price, 2) }}</div>
                                                    <div style="font-size:0.72rem;color:#aaa;">per unit</div>
                                                @else
                                                    <div class="price-na">—</div>
                                                @endif
                                            </div>

                                            <!-- Qty Controls -->
                                            <form action="{{ route('cart.update') }}" method="POST"
                                                class="d-flex align-items-center">
                                                @csrf
                                                <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                                <div class="qty-wrapper">
                                                    <button type="button" class="qty-btn qty-minus"><i class="fas fa-minus"
                                                            style="font-size:0.7rem;"></i></button>
                                                    <input type="number" name="quantity" class="qty-input"
                                                        value="{{ $item->quantity }}" min="1" max="99">
                                                    <button type="button" class="qty-btn qty-plus"><i class="fas fa-plus"
                                                            style="font-size:0.7rem;"></i></button>
                                                </div>
                                                <button type="submit" class="qty-update-btn" title="Update Quantity">
                                                    <i class="fas fa-sync-alt"></i> Update
                                                </button>
                                            </form>

                                            <!-- Row Total -->
                                            <div class="row-total">
                                                @if($hasPrice)
                                                    ₹{{ number_format($itemTotal, 2) }}
                                                @else
                                                    <span class="price-na">—</span>
                                                @endif
                                            </div>

                                            <!-- Remove -->
                                            <a href="{{ route('cart.remove', $item->id) }}" class="remove-btn" title="Remove"
                                                onclick="return confirm('Remove {{ $medName }} from cart?');">
                                                <i class="fas fa-trash-alt" style="font-size:0.8rem;"></i>
                                            </a>
                                        </div>
                                    @endforeach

                                    <!-- Bottom Note -->
                                    <div class="px-4 py-3" style="background:#fafbff;border-top:1px solid #f0f0f0;">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1 text-primary"></i>
                                            Items showing <strong>"Price on inquiry"</strong> will be confirmed
                                            by the pharmacy team during order review.
                                        </small>
                                    </div>

                                @else
                                    <!-- Empty State -->
                                    <div class="empty-cart">
                                        <div class="icon-wrap">
                                            <i class="fas fa-shopping-basket"
                                                style="font-size:2.8rem;color:var(--cart-primary);opacity:0.3;"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-2">Your cart is empty</h5>
                                        <p class="text-secondary mb-4" style="max-width:340px;margin:auto;">
                                            Go to your prescriptions to add medicines directly from your doctor's prescriptions.
                                        </p>
                                        <a href="/patient-prescriptions"
                                            class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                                            <i class="fas fa-prescription me-2"></i> View My Prescriptions
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Order Summary -->
                    <div class="col-lg-4">
                        <div class="summary-card card">
                            <div class="card-header">
                                <h5><i class="fas fa-receipt me-2"></i> Order Summary</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="summary-row">
                                    <span class="summary-label">Subtotal</span>
                                    <span class="summary-value">
                                        @if($subtotal > 0)
                                            ₹{{ number_format($subtotal, 2) }}
                                        @else
                                            <span class="price-na">To be confirmed</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-label">Delivery</span>
                                    <span class="summary-value text-success">Free</span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-label">Tax</span>
                                    <span class="summary-value">Inclusive</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center my-3 pt-2 border-top">
                                    <span class="summary-total-label">Estimated Total</span>
                                    <span class="summary-total-value">
                                        @if($subtotal > 0)
                                            ₹{{ number_format($subtotal, 2) }}
                                        @else
                                            —
                                        @endif
                                    </span>
                                </div>

                                @if(count($cartItems) > 0)
                                    <form action="{{ route('cart.checkout') }}" method="POST" class="mb-3">
                                        @csrf
                                        <button type="submit" class="checkout-btn">
                                            <i class="fas fa-lock"></i>
                                            Place Order
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </form>
                                @endif

                                <!-- Trust Badges -->
                                <div class="trust-badges mt-3">
                                    <span class="trust-badge"><i class="fas fa-shield-alt"></i> Secure Checkout</span>
                                    <span class="trust-badge"><i class="fas fa-check-circle"></i> Verified Pharmacy</span>
                                    <span class="trust-badge"><i class="fas fa-undo"></i> Easy Returns</span>
                                </div>

                                <!-- Support -->
                                <div class="mt-4 p-3 rounded-3" style="background:#f7f9fc;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-headset" style="color:var(--cart-primary);"></i>
                                        <div>
                                            <div style="font-size:0.78rem;font-weight:700;color:#1a1a2e;">Need Help?</div>
                                            <div style="font-size:0.72rem;color:#aaa;">
                                                Our pharmacy team is here to assist you.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <script>
        // Inline Quantity +/- Buttons
        document.querySelectorAll('.medicine-row').forEach(row => {
            const minus = row.querySelector('.qty-minus');
            const plus = row.querySelector('.qty-plus');
            const input = row.querySelector('.qty-input');
            if (!minus || !plus || !input) return;

            minus.addEventListener('click', () => {
                let val = parseInt(input.value) || 1;
                if (val > 1) input.value = val - 1;
            });
            plus.addEventListener('click', () => {
                let val = parseInt(input.value) || 1;
                if (val < 99) input.value = val + 1;
            });
        });
    </script>
@endsection