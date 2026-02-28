@extends('frontend.layout')

@push('styles')
    <style>
        /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
       CART PAGE — Full Premium Redesign
       Matches site's dashboard_content pattern
    ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */

    /* Header */
    .cart-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
    }
    .cart-header-row h4 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1a1a2e;
        letter-spacing: -0.5px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .cart-count-badge {
        background: linear-gradient(90deg, #1E0B9B, #07CCEC);
        color: #fff;
        font-size: 0.72rem;
        font-weight: 700;
        border-radius: 20px;
        padding: 2px 10px;
    }

    /* Alerts consistent with site style */
    .cart-alert {
        border-left: 4px solid transparent;
        border-radius: 12px;
        font-size: 0.88rem;
        padding: 12px 16px;
    }
    .cart-alert.success { border-color: #198754; background: #d1e7dd; color: #0f5132; }
    .cart-alert.warning { border-color: #ffc107; background: #fff3cd; color: #664d03; }
    .cart-alert.danger  { border-color: #dc3545; background: #f8d7da; color: #842029; }

    /* ─── Medicine Card ─── */
    .med-card {
        background: #fff;
        border: 1px solid #f0f2f8;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 12px;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .med-card:hover {
        box-shadow: 0 4px 18px rgba(30, 11, 155, 0.08);
        transform: translateY(-1px);
    }
    .med-card:last-of-type { margin-bottom: 0; }

    /* Top row: icon + info + remove btn */
    .med-top-row {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }
    .med-icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: linear-gradient(135deg, #eef2ff, #e0f7ff);
        border: 1px solid #dde6ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
        overflow: hidden;
    }
    .med-icon-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .med-info { flex: 1; min-width: 0; }
    .med-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #1a1a2e;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 5px;
    }
    .med-tags { display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }
    .tag-rx {
        background: #eef2ff; color: #1E0B9B;
        border-radius: 5px; padding: 2px 8px;
        font-size: 0.7rem; font-weight: 600;
        display: inline-flex; align-items: center; gap: 3px;
    }
    .tag-poi {
        background: #fefce8; color: #a16207;
        border-radius: 5px; padding: 2px 8px;
        font-size: 0.7rem; font-weight: 600;
        display: inline-flex; align-items: center; gap: 3px;
    }
    .tag-price {
        background: #f0fdf4; color: #15803d;
        border-radius: 5px; padding: 2px 8px;
        font-size: 0.7rem; font-weight: 700;
    }

    /* Bottom row: qty controls + total */
    .med-bottom-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px dashed #f0f2f8;
        flex-wrap: wrap;
    }
    .qty-stepper {
        display: flex;
        align-items: center;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        height: 34px;
    }
    .qty-step-btn {
        width: 32px; height: 34px;
        background: #f8fafc; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: #1E0B9B; font-size: 0.75rem;
        transition: background 0.15s; flex-shrink: 0;
    }
    .qty-step-btn:hover { background: #e8ecff; }
    .qty-step-input {
        width: 40px; text-align: center;
        font-weight: 700; font-size: 0.88rem; color: #1a1a2e;
        border: none; outline: none; background: #fff; height: 100%;
    }
    .qty-update-btn {
        background: linear-gradient(90deg, #1E0B9B, #07CCEC);
        color: #fff; border: none; border-radius: 8px;
        padding: 6px 14px; font-size: 0.75rem; font-weight: 600;
        cursor: pointer; display: inline-flex; align-items: center; gap: 5px;
        transition: opacity .2s; white-space: nowrap; height: 34px;
    }
    .qty-update-btn:hover { opacity: 0.88; }
    .med-line-total {
        margin-left: auto;
        font-weight: 800; font-size: 0.95rem;
        color: #1E0B9B;
    }
    .med-line-na { color: #ccc; font-size: 0.83rem; font-style: italic; }
    .remove-btn {
        width: 34px; height: 34px;
        background: #fff5f5; color: #dc3545;
        border: 1.5px solid #ffd6d6; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        text-decoration: none; flex-shrink: 0; font-size: 0.78rem;
        transition: all .2s;
    }
    .remove-btn:hover { background: #dc3545; color: #fff; border-color: #dc3545; }

    /* Cart items wrapper */
    .cart-items-wrap {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 14px rgba(0,0,0,0.05);
        border: 1px solid #f0f2f8;
        padding: 18px;
    }
    .cart-items-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0f2f8;
    }
    .cart-items-header span { font-weight: 700; font-size: 0.88rem; color: #1a1a2e; }
    .cart-items-header small { color: #aaa; font-size: 0.78rem; }
    .cart-hint {
        margin-top: 14px;
        padding: 10px 14px;
        background: #f7f9ff;
        border-radius: 8px;
        font-size: 0.77rem;
        color: #888;
        display: flex;
        align-items: flex-start;
        gap: 7px;
    }
    .cart-hint i { color: #1E0B9B; margin-top: 1px; flex-shrink: 0; }

    /* ─── Order Summary ─── */
    .summary-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 14px rgba(0,0,0,0.05);
        border: 1px solid #f0f2f8;
        overflow: hidden;
        position: sticky;
        top: 90px;
    }
    .summary-head {
        background: linear-gradient(90deg, #1E0B9B 0%, #07CCEC 100%);
        padding: 16px 20px;
    }
    .summary-head h6 { color: #fff; font-weight: 700; font-size: 0.95rem; margin: 0; }
    .summary-body { padding: 18px 20px; }
    .sum-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.86rem;
        padding: 8px 0;
        border-bottom: 1px dashed #f0f2f8;
    }
    .sum-line:last-of-type, .sum-line.total-line { border-bottom: none; }
    .sum-line .lbl { color: #888; }
    .sum-line .val { font-weight: 700; color: #1a1a2e; }
    .sum-line.total-line .lbl { font-weight: 700; color: #1a1a2e; font-size: 0.95rem; }
    .sum-line.total-line .val { font-weight: 800; color: #1E0B9B; font-size: 1.1rem; }
    .checkout-btn {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; padding: 13px 16px; margin-top: 14px;
        background: linear-gradient(90deg, #1E0B9B 0%, #07CCEC 100%);
        color: #fff; border: none; border-radius: 12px;
        font-weight: 700; font-size: 0.92rem; cursor: pointer;
        box-shadow: 0 4px 16px rgba(30,11,155,0.22);
        transition: opacity .2s, transform .2s; letter-spacing: 0.2px;
    }
    .checkout-btn:hover { opacity: .9; transform: translateY(-1px); }

    .trust-strip {
        display: flex; justify-content: space-between; gap: 4px;
        margin-top: 12px; padding-top: 12px;
        border-top: 1px dashed #f0f2f8;
    }
    .trust-item { display: flex; align-items: center; gap: 4px; font-size: 0.7rem; color: #aaa; }
    .trust-item i { color: #28a745; font-size: 0.65rem; }
    .help-box {
        display: flex; align-items: center; gap: 10px;
        background: #f7f9fc; border-radius: 10px;
        padding: 10px 12px; margin-top: 12px;
    }
    .help-box i { color: #1E0B9B; font-size: 1rem; flex-shrink: 0; }
    .help-box .ht { font-size: 0.78rem; font-weight: 700; color: #1a1a2e; }
    .help-box .hs { font-size: 0.71rem; color: #aaa; }

    /* Empty State */
    .empty-state {
        text-align: center; padding: 50px 20px;
    }
    .empty-icon-wrap {
        width: 90px; height: 90px; border-radius: 50%;
        background: #f0f4ff; margin: 0 auto 18px;
        display: flex; align-items: center; justify-content: center;
    }
    </style>
@endpush

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">

                    {{-- ===== LEFT SIDEBAR ===== --}}
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    {{-- ===== MAIN CONTENT ===== --}}
                    <div class="col-lg-9">
                        <div class="dashboard_content">

                            {{-- Header --}}
                            <div class="cart-header-row">
                                <h4>
                                    <i class="fas fa-shopping-basket" style="color:#07CCEC;"></i>
                                    My Cart
                                    <span class="cart-count-badge">{{ count($cartItems) }}</span>
                                </h4>
                                <a href="/patient-prescriptions"
                                    class="btn btn-sm rounded-pill px-3 fw-semibold"
                                    style="border:1.5px solid #1E0B9B;color:#1E0B9B;font-size:0.8rem;">
                                    <i class="fas fa-prescription me-1"></i> My Prescriptions
                                </a>
                            </div>

                            {{-- Alerts --}}
                            @if(session('success'))
                                <div class="cart-alert success alert-dismissible fade show d-flex align-items-center gap-2 mb-3">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                            @if(session('warning'))
                                <div class="cart-alert warning alert-dismissible fade show d-flex align-items-center gap-2 mb-3">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>{{ session('warning') }}</span>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="cart-alert danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3">
                                    <i class="fas fa-times-circle"></i>
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="row g-4 align-items-start">

                                {{-- ===== CART ITEMS COL ===== --}}
                                <div class="col-lg-8">
                                    <div class="cart-items-wrap">
                                        <div class="cart-items-header">
                                            <span><i class="fas fa-pills me-2" style="color:#07CCEC;"></i>Items in Cart</span>
                                            <small>{{ count($cartItems) }} product{{ count($cartItems) != 1 ? 's' : '' }}</small>
                                        </div>

                                        @if(count($cartItems) > 0)
                                            @foreach($cartItems as $item)
                                                @php
                                                    $price = $item->medicine->price ?? $item->medicine->mrp ?? 0;
                                                    $hasPrice = $price > 0;
                                                    $total = $hasPrice ? ($price * $item->quantity) : 0;
                                                    $img = $item->medicine->img ?? null;
                                                    $name = $item->medicine->name ?? 'Unknown Product';
                                                    $type = $item->medicine->type_name ?? $item->medicine->category ?? 'Rx Medicine';
                                                @endphp

                                                <div class="med-card">
                                                    {{-- TOP ROW: icon + info + remove --}}
                                                    <div class="med-top-row">
                                                        <div class="med-icon-wrap">
                                                            @if($img)
                                                                <img src="{{ asset('public/assets/images/medicines/' . $img) }}"
                                                                    alt="{{ $name }}"
                                                                    onerror="this.style.display='none';this.parentElement.innerHTML='💊';">
                                                            @else
                                                                💊
                                                            @endif
                                                        </div>

                                                        <div class="med-info">
                                                            <div class="med-name">{{ $name }}</div>
                                                            <div class="med-tags">
                                                                <span class="tag-rx">
                                                                    <i class="fas fa-tag" style="font-size:0.58rem;"></i>
                                                                    {{ $type }}
                                                                </span>
                                                                @if($hasPrice)
                                                                    <span class="tag-price">₹{{ number_format($price, 2) }} / unit</span>
                                                                @else
                                                                    <span class="tag-poi">
                                                                        <i class="fas fa-info-circle" style="font-size:0.65rem;"></i>
                                                                        Price on inquiry
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <a href="{{ route('cart.remove', $item->id) }}"
                                                            class="remove-btn"
                                                            onclick="return confirm('Remove {{ addslashes($name) }}?');"
                                                            title="Remove item">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>

                                                    {{-- BOTTOM ROW: qty + total --}}
                                                    <div class="med-bottom-row">
                                                        <form action="{{ route('cart.update') }}" method="POST"
                                                            class="d-flex align-items-center gap-2">
                                                            @csrf
                                                            <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                                            <div class="qty-stepper">
                                                                <button type="button" class="qty-step-btn qty-minus">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                                <input type="number" name="quantity"
                                                                    class="qty-step-input"
                                                                    value="{{ $item->quantity }}" min="1" max="99">
                                                                <button type="button" class="qty-step-btn qty-plus">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                            <button type="submit" class="qty-update-btn">
                                                                <i class="fas fa-sync-alt"></i> Update
                                                            </button>
                                                        </form>

                                                        <div class="med-line-total ms-auto">
                                                            @if($hasPrice)
                                                                ₹{{ number_format($total, 2) }}
                                                            @else
                                                                <span class="med-line-na">—</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="cart-hint">
                                                <i class="fas fa-info-circle"></i>
                                                Items marked <strong>"Price on inquiry"</strong> will be reviewed
                                                and priced by our pharmacy team before dispatch.
                                            </div>

                                        @else
                                            <div class="empty-state">
                                                <div class="empty-icon-wrap">
                                                    <i class="fas fa-shopping-basket"
                                                        style="font-size:2.5rem;color:#1E0B9B;opacity:0.22;"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark mb-2">Your cart is empty</h5>
                                                <p class="text-muted mb-4" style="font-size:0.87rem;max-width:300px;margin:auto;">
                                                    Open a prescription and click <strong>"Buy Available Medicines"</strong>
                                                    to add items directly from your doctor's prescription.
                                                </p>
                                                <a href="/patient-prescriptions"
                                                    class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                                                    <i class="fas fa-prescription me-2"></i> View My Prescriptions
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- ===== ORDER SUMMARY COL ===== --}}
                                <div class="col-lg-4">
                                    <div class="summary-card">
                                        <div class="summary-head">
                                            <h6><i class="fas fa-receipt me-2"></i>Order Summary</h6>
                                        </div>
                                        <div class="summary-body">
                                            <div class="sum-line">
                                                <span class="lbl">Subtotal</span>
                                                <span class="val">
                                                    @if($subtotal > 0)
                                                        ₹{{ number_format($subtotal, 2) }}
                                                    @else
                                                        <em style="color:#bbb;font-weight:500;font-size:0.83rem;">To be confirmed</em>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="sum-line">
                                                <span class="lbl">Delivery</span>
                                                <span class="val text-success">Free</span>
                                            </div>
                                            <div class="sum-line">
                                                <span class="lbl">Tax</span>
                                                <span class="val">Inclusive</span>
                                            </div>
                                            <div class="sum-line total-line mt-1" style="padding-top:12px;border-top:2px solid #eef2ff;">
                                                <span class="lbl">Total</span>
                                                <span class="val">
                                                    @if($subtotal > 0)
                                                        ₹{{ number_format($subtotal, 2) }}
                                                    @else
                                                        <em style="color:#bbb;font-weight:500;font-size:0.83rem;">—</em>
                                                    @endif
                                                </span>
                                            </div>

                                            @if(count($cartItems) > 0)
                                                <form action="{{ route('cart.checkout') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="checkout-btn">
                                                        <i class="fas fa-lock" style="font-size:0.83rem;"></i>
                                                        Place Order
                                                        <i class="fas fa-chevron-right" style="font-size:0.78rem;"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <div class="trust-strip">
                                                <span class="trust-item"><i class="fas fa-shield-alt"></i> Secure</span>
                                                <span class="trust-item"><i class="fas fa-check-circle"></i> Verified</span>
                                                <span class="trust-item"><i class="fas fa-undo"></i> Returns</span>
                                            </div>

                                            <div class="help-box">
                                                <i class="fas fa-headset"></i>
                                                <div>
                                                    <div class="ht">Need help?</div>
                                                    <div class="hs">Our pharmacy team is ready to assist.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>{{-- /row --}}
                        </div>{{-- /dashboard_content --}}
                    </div>{{-- /col-lg-9 --}}
                </div>{{-- /row --}}
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
        document.querySelectorAll('.med-card').forEach(function(card) {
            var minus = card.querySelector('.qty-minus');
            var plus  = card.querySelector('.qty-plus');
            var inp   = card.querySelector('.qty-step-input');
            if (!minus || !plus || !inp) return;
            minus.addEventListener('click', function() {
                var v = parseInt(inp.value) || 1;
                if (v > 1) inp.value = v - 1;
            });
            plus.addEventListener('click', function() {
                var v = parseInt(inp.value) || 1;
                if (v < 99) inp.value = v + 1;
            });
        });
        </script>
    @endpush
@endsection