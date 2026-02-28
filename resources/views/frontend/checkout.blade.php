@extends('frontend.layout')

@section('content')
    <div class="breadcrumb-bar" style="background-color: #f7f9fa; padding: 15px 0; border-bottom: 1px solid #e4e8f5;">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb mb-0" style="font-size: 0.9rem;">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: #6c757d; text-decoration: none;">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('cart.view') }}" style="color: #6c757d; text-decoration: none;">Cart</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="color: #1E0B9B; font-weight: 500;">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="content" style="background-color: #f0f3f8; padding: 40px 0;">
        <div class="container-fluid">
            <h3 class="mb-4" style="color: #1E0B9B; font-weight: 700;">Complete Your Order</h3>

            <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                @csrf
                <div class="row">

                    {{-- Left Column: Shipping & Payment Options --}}
                    <div class="col-lg-8">
                        {{-- Shipping Address Card --}}
                        <div class="card mb-4" style="border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                            <div class="card-header bg-white" style="border-bottom: 1px solid #f0f0f0; padding: 20px;">
                                <h5 class="mb-0" style="font-weight: 600; color: #333;"><i class="fas fa-shipping-fast text-primary me-2"></i> Shipping Information</h5>
                            </div>
                            <div class="card-body" style="padding: 25px;">
                                
                                {{-- Store Selection (Hidden but submitting) --}}
                                @if(isset($cartStoreId) && $cartStoreId)
                                    <input type="hidden" name="store_id" value="{{ $cartStoreId }}">
                                @else
                                    <input type="hidden" name="store_id" value="0">
                                @endif

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="fullName" value="{{ old('fullName', Auth::user()->name ?? '') }}" required placeholder="John Doe">
                                        @error('fullName')<div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" required placeholder="+1 234 567 8900">
                                        @error('phone')<div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size: 0.85rem;">Street Address / Apartment <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="street" value="{{ old('street') }}" required placeholder="123 Main St, Apt 4B">
                                    @error('street')<div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div>@enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">City <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="city" value="{{ old('city') }}" required placeholder="New York">
                                        @error('city')<div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">State/Province <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="state" value="{{ old('state') }}" required placeholder="NY">
                                        @error('state')<div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">ZIP Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="zip" value="{{ old('zip') }}" required placeholder="10001">
                                        @error('zip')<div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Method Card --}}
                        <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                            <div class="card-header bg-white" style="border-bottom: 1px solid #f0f0f0; padding: 20px;">
                                <h5 class="mb-0" style="font-weight: 600; color: #333;"><i class="fas fa-wallet text-success me-2"></i> Payment Method</h5>
                            </div>
                            <div class="card-body" style="padding: 25px;">
                                {{-- Cash on Delivery --}}
                                <div class="form-check custom-radio mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="pay_cod" value="cod" checked onchange="toggleGateways()">
                                    <label class="form-check-label d-flex align-items-center gap-2" for="pay_cod" style="cursor: pointer; font-size: 0.95rem; font-weight: 600;">
                                        <i class="fas fa-hand-holding-usd text-success"></i> Cash on Delivery (COD)
                                    </label>
                                </div>

                                {{-- Online Payment --}}
                                <div class="form-check custom-radio mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="pay_online" value="online" onchange="toggleGateways()">
                                    <label class="form-check-label d-flex align-items-center gap-2" for="pay_online" style="cursor: pointer; font-size: 0.95rem; font-weight: 600;">
                                        <i class="fas fa-credit-card text-primary"></i> Online Payment
                                    </label>
                                </div>

                                {{-- Gateways Wrapper (Hidden by default) --}}
                                <div id="gateways_wrapper" class="mt-3 p-3 bg-light rounded-3" style="display: none; border: 1px solid #e4e8f5;">
                                    @if(isset($paymentGateways) && count($paymentGateways) > 0)
                                        <p class="text-muted mb-3" style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Select Payment Gateway</p>
                                        @foreach($paymentGateways as $index => $gateway)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="payment_gateway_id" id="gw_{{ $gateway->id }}" value="{{ $gateway->id }}" {{ $index === 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gw_{{ $gateway->id }}" style="font-size: 0.9rem; cursor: pointer;">
                                                    {{ $gateway->gateway_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-warning py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> No active payment gateways available. Please use COD.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>{{-- /Col-8 --}}

                    {{-- Right Column: Order Summary --}}
                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); position: sticky; top: 20px;">
                            <div class="card-header bg-white" style="border-bottom: 1px solid #f0f0f0; padding: 20px;">
                                <h5 class="mb-0" style="font-weight: 600; color: #333;"><i class="fas fa-receipt text-info me-2"></i> Order Summary</h5>
                            </div>
                            <div class="card-body" style="padding: 25px;">
                                
                                {{-- Item mini-list --}}
                                <div class="mb-4" style="max-height: 250px; overflow-y: auto;">
                                    @foreach($cartItems as $item)
                                        @php
                                            $medName = $item->medicine->name ?? 'Unknown Medicine';
                                            $price = $item->medicine->discount_cost ?? $item->medicine->cost ?? 0;
                                            $itemTotal = $price * $item->quantity;
                                        @endphp
                                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2" style="border-bottom: 1px dashed #eee;">
                                            <div>
                                                <span style="font-size: 0.85rem; font-weight: 500;">{{ Str::limit($medName, 30) }}</span><br>
                                                <span class="text-muted" style="font-size: 0.75rem;">Qty: {{ $item->quantity }} x ₹{{ number_format($price, 2) }}</span>
                                            </div>
                                            <span style="font-weight: 600; font-size: 0.9rem;">₹{{ number_format($itemTotal, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #666;">Subtotal</span>
                                    <span style="font-weight: 600;">₹{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #666;">Delivery</span>
                                    <span class="text-success fw-bold">FREE</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span style="color: #666;">Tax</span>
                                    <span style="font-weight: 600;">Inclusive</span>
                                </div>
                                
                                <hr style="border-color: #eee;">
                                
                                <div class="d-flex justify-content-between mb-4 mt-3">
                                    <span style="font-size: 1.1rem; font-weight: 700; color: #1E0B9B;">Total to Pay</span>
                                    <span style="font-size: 1.25rem; font-weight: 800; color: #1E0B9B;">₹{{ number_format($subtotal, 2) }}</span>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3" style="border-radius: 8px; font-weight: 600; letter-spacing: 0.5px; box-shadow: 0 4px 10px rgba(30, 11, 155, 0.2);">
                                    PLACE ORDER <i class="fas fa-lock ms-2"></i>
                                </button>
                                
                                <div class="text-center mt-3 text-muted" style="font-size: 0.75rem;">
                                    <i class="fas fa-shield-alt text-success me-1"></i> Secure and encrypted checkout
                                </div>
                            </div>
                        </div>
                    </div>{{-- /Col-4 --}}

                </div>{{-- /Row --}}
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle payment gateways UI
            window.toggleGateways = function() {
                const onlineRadio = document.getElementById('pay_online');
                const wrapper = document.getElementById('gateways_wrapper');
                if (wrapper) {
                    if (onlineRadio && onlineRadio.checked) {
                        wrapper.style.display = 'block';
                    } else {
                        wrapper.style.display = 'none';
                    }
                }
            };
            
            // Initialize on load
            toggleGateways();
        </script>
    @endpush
@endsection
