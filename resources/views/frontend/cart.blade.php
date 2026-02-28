@extends('frontend.layout')

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
