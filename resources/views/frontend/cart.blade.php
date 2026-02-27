@extends('frontend.layout')

@section('content')
    <main>
        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex align-items-center"
            style="background-image:url({{ asset('public/assets/frontend/img/testimonial/test-bg.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                        <div class="breadcrumb-wrap text-center">
                            <div class="breadcrumb-title mb-30">
                                <h2>Your Cart</h2>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">View Cart</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <section class="cart-area pt-100 pb-100">
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-check-circle me-2"></i>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-exclamation-circle me-2"></i>Notice:</strong> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-times-circle me-2"></i>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                            <div class="card-header bg-white border-bottom px-4 py-3">
                                <h5 class="mb-0 fw-bold text-dark">Cart Items ({{ count($cartItems) }})</h5>
                            </div>

                            <div class="card-body p-0">
                                @if(count($cartItems) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-4">Product</th>
                                                    <th>Price</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-end">Total</th>
                                                    <th class="text-center pe-4">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cartItems as $item)
                                                    @php
                                                        $price = $item->medicine->price ?? $item->medicine->mrp ?? 0;
                                                        $itemTotal = $price * $item->quantity;
                                                    @endphp
                                                    <tr>
                                                        <td class="ps-4 py-3">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="bg-light rounded p-2 d-flex align-items-center justify-content-center"
                                                                    style="width: 60px; height: 60px;">
                                                                    <img src="{{ $item->medicine->img ?? asset('public/assets/frontend/img/shop/product_placeholder.png') }}"
                                                                        alt="{{ $item->medicine->name ?? 'Medicine' }}"
                                                                        class="img-fluid"
                                                                        style="max-height: 100%; object-fit: contain;">
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-1 text-dark fw-bold">
                                                                        {{ $item->medicine->name ?? 'Unknown Product' }}</h6>
                                                                    <small
                                                                        class="text-muted d-block">{{ $item->medicine->type_name ?? 'Medicine' }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>${{ number_format($price, 2) }}</td>
                                                        <td style="width: 150px;">
                                                            <form action="{{ route('cart.update') }}" method="POST"
                                                                class="d-flex align-items-center justify-content-center gap-2">
                                                                @csrf
                                                                <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                                                <input type="number" name="quantity"
                                                                    class="form-control form-control-sm text-center"
                                                                    value="{{ $item->quantity }}" min="1" style="width: 70px;">
                                                                <button type="submit" class="btn btn-sm btn-outline-primary"
                                                                    title="Update Quantity">
                                                                    <i class="fas fa-sync-alt"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <td class="text-end fw-bold text-dark">${{ number_format($itemTotal, 2) }}
                                                        </td>
                                                        <td class="text-center pe-4">
                                                            <a href="{{ route('cart.remove', $item->id) }}"
                                                                class="btn btn-sm btn-outline-danger rounded-circle"
                                                                title="Remove Item"
                                                                onclick="return confirm('Are you sure you want to remove this item?');">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="p-5 text-center">
                                        <div class="mb-4 text-muted">
                                            <i class="fas fa-shopping-basket" style="font-size: 4rem; opacity: 0.2;"></i>
                                        </div>
                                        <h4 class="text-dark fw-bold mb-3">Your cart is currently empty</h4>
                                        <p class="text-secondary mb-4">Looks like you haven't added any medicines to your cart
                                            yet.</p>
                                        <a href="/patient-prescriptions"
                                            class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                                            <i class="fas fa-prescription me-2"></i> View My Prescriptions
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 overlay-hidden sticky-top" style="top: 100px;">
                            <div class="card-header bg-white border-bottom px-4 py-3">
                                <h5 class="mb-0 fw-bold text-dark">Order Summary</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="text-dark fw-bold">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                                    <span class="text-muted">Estimated Tax</span>
                                    <span class="text-dark fw-bold">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-4">
                                    <span class="text-dark fw-bold fs-5">Total</span>
                                    <span class="text-primary fw-bold fs-5">${{ number_format($subtotal, 2) }}</span>
                                </div>

                                @if(count($cartItems) > 0)
                                    <form action="{{ route('cart.checkout') }}" method="POST" class="d-grid gap-2">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold">
                                            Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </form>
                                @endif

                                <div class="mt-4 text-center">
                                    <img src="{{ asset('public/assets/frontend/img/banner/payment-methods.png') }}"
                                        alt="Secure Payment" class="img-fluid opacity-50" style="max-height: 30px;">
                                    <p class="text-muted small mt-2 mb-0"><i
                                            class="fas fa-shield-alt text-success me-1"></i> 100% Secure Checkout</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection