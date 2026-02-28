@extends('frontend.layout')

@push('styles')
    <style>
        /* ==============================
           Cart Specific Styles
           ============================== */
        
        :root {
            --primary-grad: linear-gradient(90deg, #1E0B9B 0%, #07CCEC 100%);
            --bg-light: #f4f7fc;
            --text-dark: #1a1a2e;
            --text-muted: #6c757d;
        }

        .dashboard_content {
            background: #fff;
            border-radius: 16px;
            /* Ensure content fits well */
        }

        /* ---- Header ---- */
        .cart-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .cart-section-header h4 {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ---- Cart Items Card ---- */
        .cart-items-card {
            border: 1px solid #f0f2f8;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            background: #fff;
        }

        .cart-header-row {
            background: #f8fafc;
            padding: 12px 20px;
            border-bottom: 1px solid #eef2f6;
            font-size: 0.8rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Medicine Row */
        .cart-med-row {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #f2f4f8;
            transition: background 0.2s ease;
            flex-wrap: wrap; /* Allows stacking on mobile */
        }

        .cart-med-row:last-child {
            border-bottom: none;
        }

        .cart-med-row:hover {
            background: #fafbff;
        }

        /* Product Info Area */
        .med-info-area {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 2; /* Takes more space */
            min-width: 280px;
        }

        .cart-med-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #e2e8f0;
            padding: 4px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .cart-med-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
        }

        .cart-med-details h5 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .tag-rx {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #eef2ff;
            color: #4f46e5;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .tag-poi {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #fffbeb;
            color: #b45309;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* Controls Area (Qty, Price, Total) */
        .med-controls-area {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex: 3;
            gap: 15px;
        }

        /* Quantity */
        .qty-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .qty-group {
            display: flex;
            align-items: center;
            background: #f1f5f9;
            border-radius: 50rem;
            padding: 2px;
            width: fit-content;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            background: #fff;
            color: #1a1a2e;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.2s;
        }
        .qty-btn:hover { background: #4f46e5; color: #fff; }

        .qty-num {
            width: 36px;
            text-align: center;
            background: transparent;
            border: none;
            font-weight: 700;
            font-size: 0.9rem;
            color: #334155;
            -moz-appearance: textfield;
        }
        .qty-num::-webkit-outer-spin-button, .qty-num::-webkit-inner-spin-button { -webkit-appearance: none; }

        .btn-update-qty {
            border: none;
            background: none;
            color: #0ea5e9;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 4px;
            text-decoration: underline;
            transition: color 0.2s;
        }
        .btn-update-qty:hover { color: #0284c7; }

        /* Price Columns */
        .col-price, .col-total {
            text-align: right;
            min-width: 80px;
        }

        .price-val {
            font-weight: 600;
            color: #64748b;
            font-size: 0.9rem;
        }

        .total-val {
            font-weight: 800;
            color: var(--text-dark);
            font-size: 1rem;
        }

        .na-text {
            color: #cbd5e1;
            font-style: italic;
            font-size: 0.85rem;
        }

        /* Remove Button */
        .btn-remove {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
            background: #fef2f2;
            border-radius: 8px;
            transition: all 0.2s;
            margin-left: 10px;
        }
        .btn-remove:hover {
            background: #ef4444;
            color: white;
            transform: scale(1.05);
        }

        /* ---- Summary Box ---- */
        .cart-summary-box {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #eef2f6;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 100px; /* Sticky on scroll */
        }

        .cart-summary-header {
            background: var(--primary-grad);
            padding: 18px 24px;
            border-radius: 16px 16px 0 0;
            color: #fff;
        }
        .cart-summary-header h5 { margin: 0; font-weight: 700; font-size: 1.1rem; }

        .cart-summary-body { padding: 24px; }

        .sum-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.9rem;
            color: #64748b;
        }
        .sum-val { font-weight: 700; color: var(--text-dark); }
        .text-free { color: #10b981; }

        .divider { border-top: 1px dashed #e2e8f0; margin: 15px 0; }

        .sum-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-dark);
        }
        .sum-total-val { color: #4f46e5; font-size: 1.25rem; }

        .checkout-btn {
            width: 100%;
            padding: 14px;
            background: var(--primary-grad);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 11, 155, 0.3);
        }

        .trust-badges {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            font-size: 0.75rem;
            color: #94a3b8;
        }
        .trust-item { display: flex; align-items: center; gap: 4px; }

        /* Empty State */
        .cart-empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-icon {
            width: 100px;
            height: 100px;
            background: #f1f5f9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 3rem;
            color: #cbd5e1;
        }

        /* Responsive Tweaks */
        @media (max-width: 768px) {
            .cart-med-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .med-info-area { width: 100%; }
            .med-controls-area {
                width: 100%;
                justify-content: space-between;
                border-top: 1px dashed #f1f5f9;
                padding-top: 15px;
            }
            .cart-header-row { display: none; } /* Hide table headers on mobile */
            .col-price { display: none; } /* Hide unit price on mobile to save space */
            .col-total { text-align: right; }
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
                        <div class="dashboard_content p-4">

                            <!-- Page Header -->
                            <div class="cart-section-header">
                                <h4>
                                    My Cart
                                    @if(count($cartItems) > 0)
                                        <span class="badge rounded-pill ms-2"
                                              style="background: linear-gradient(90deg, #1E0B9B, #07CCEC); font-size: 0.7rem; vertical-align: middle;">
                                            {{ count($cartItems) }} Items
                                        </span>
                                    @endif
                                </h4>
                                <a href="/patient-prescriptions"
                                   class="btn btn-outline-primary btn-sm rounded-pill px-4 py-2 fw-bold">
                                    <i class="fas fa-plus me-1"></i> Add More Medicines
                                </a>
                            </div>

                            <!-- Alerts -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm border-0 bg-success-subtle text-success" role="alert">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm border-0 bg-danger-subtle text-danger" role="alert">
                                    <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif


                            @if(count($cartItems) > 0)
                                <div class="row g-4">
                                    <!-- ===== Cart Items List ===== -->
                                    <div class="col-lg-8">
                                        <div class="cart-items-card">
                                            <!-- Desktop Headers -->
                                            <div class="cart-header-row d-none d-md-flex">
                                                <div style="flex: 2;">Product Details</div>
                                                <div style="flex: 3; display: flex; justify-content: space-between; padding-right: 40px;">
                                                    <span class="text-center" style="width: 80px;">Quantity</span>
                                                    <span class="text-end" style="width: 80px;">Price</span>
                                                    <span class="text-end" style="width: 80px;">Total</span>
                                                </div>
                                            </div>

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
                                                    
                                                    <!-- Section 1: Image & Name -->
                                                    <div class="med-info-area">
                                                        <div class="cart-med-icon">
                                                            @if($img)
                                                                <img src="{{ asset('public/assets/images/medicines/' . $img) }}"
                                                                     alt="{{ $medName }}"
                                                                     onerror="this.onerror=null;this.parentElement.innerHTML='<i class=\'fas fa-capsules fa-lg text-primary\'></i>';">
                                                            @else
                                                                <i class="fas fa-capsules fa-lg text-primary"></i>
                                                            @endif
                                                        </div>
                                                        <div class="cart-med-details">
                                                            <h5>{{ $medName }}</h5>
                                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                                <span class="tag-rx">{{ $typeName }}</span>
                                                                @if(!$hasPrice)
                                                                    <span class="tag-poi" title="Pharmacy will update price">
                                                                        <i class="fas fa-info-circle"></i> Price on inquiry
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Section 2: Controls & Price -->
                                                    <div class="med-controls-area">
                                                        
                                                        <!-- Quantity -->
                                                        <form action="{{ route('cart.update') }}" method="POST" class="qty-wrapper">
                                                            @csrf
                                                            <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                                            
                                                            <div class="qty-group">
                                                                <button type="button" class="qty-btn qty-minus"><i class="fas fa-minus"></i></button>
                                                                <input type="number" name="quantity" class="qty-num" value="{{ $item->quantity }}" min="1" max="99" readonly>
                                                                <button type="button" class="qty-btn qty-plus"><i class="fas fa-plus"></i></button>
                                                            </div>
                                                            <!-- Subtle update button that users click after changing qty -->
                                                            <button type="submit" class="btn-update-qty" title="Save Quantity">
                                                                Update
                                                            </button>
                                                        </form>

                                                        <!-- Unit Price (Hidden on mobile) -->
                                                        <div class="col-price d-none d-md-block">
                                                            @if($hasPrice)
                                                                <div class="price-val">₹{{ number_format($price, 2) }}</div>
                                                                <small class="text-muted" style="font-size:0.65rem;">/ unit</small>
                                                            @else
                                                                <span class="na-text">—</span>
                                                            @endif
                                                        </div>

                                                        <!-- Total Price -->
                                                        <div class="col-total">
                                                            @if($hasPrice)
                                                                <div class="total-val">₹{{ number_format($itemTotal, 2) }}</div>
                                                            @else
                                                                <span class="na-text">TBD</span>
                                                            @endif
                                                        </div>

                                                        <!-- Remove Action -->
                                                        <a href="{{ route('cart.remove', $item->id) }}" 
                                                           class="btn-remove" 
                                                           onclick="return confirm('Are you sure you want to remove {{ $medName }}?');" 
                                                           title="Remove Item">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <!-- Info Hint -->
                                        <div class="d-flex align-items-start gap-2 mt-3 p-3 rounded-3 bg-info-subtle text-info-emphasis">
                                            <i class="fas fa-info-circle mt-1"></i>
                                            <small>Items marked as <strong>"Price on inquiry"</strong> need verification from our pharmacists. The final bill amount will be communicated to you before order confirmation.</small>
                                        </div>
                                    </div>

                                    <!-- ===== Order Summary ===== -->
                                    <div class="col-lg-4">
                                        <div class="cart-summary-box">
                                            <div class="cart-summary-header">
                                                <h5>Order Summary</h5>
                                            </div>
                                            <div class="cart-summary-body">
                                                <div class="sum-row">
                                                    <span>Subtotal</span>
                                                    <span class="sum-val">
                                                        @if($subtotal > 0) ₹{{ number_format($subtotal, 2) }}
                                                        @else <span class="text-muted" style="font-weight:400;">To be calculated</span>
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
                                                        @if($subtotal > 0) ₹{{ number_format($subtotal, 2) }}
                                                        @else —
                                                        @endif
                                                    </span>
                                                </div>

                                                <form action="{{ route('cart.checkout') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="checkout-btn">
                                                        Proceed to Checkout <i class="fas fa-arrow-right"></i>
                                                    </button>
                                                </form>

                                                <div class="trust-badges">
                                                    <span class="trust-item"><i class="fas fa-shield-alt text-success"></i> Secure</span>
                                                    <span class="trust-item"><i class="fas fa-check-circle text-primary"></i> Verified</span>
                                                    <span class="trust-item"><i class="fas fa-truck text-info"></i> Fast</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- ===== Empty State ===== -->
                                <div class="cart-empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <h3 class="fw-bold text-dark">Your Cart is Empty</h3>
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

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle Quantity Buttons
                document.querySelectorAll('.cart-med-row').forEach(function (row) {
                    const minusBtn = row.querySelector('.qty-minus');
                    const plusBtn = row.querySelector('.qty-plus');
                    const input = row.querySelector('.qty-num');

                    if (!minusBtn || !plusBtn || !input) return;

                    minusBtn.addEventListener('click', function () {
                        let v = parseInt(input.value) || 1;
                        if (v > 1) {
                            input.value = v - 1;
                            // Optional: Automatically highlight update button or trigger form submit
                        }
                    });

                    plusBtn.addEventListener('click', function () {
                        let v = parseInt(input.value) || 1;
                        if (v < 99) {
                            input.value = v + 1;
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection