@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0 fw-bold text-dark" style="letter-spacing: -0.5px;">My Medicine Orders</h4>
                            </div>

                            @if(count($orders) > 0)
                                <div class="row g-4">
                                    @foreach($orders as $order)
                                        <div class="col-12">
                                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #fff;">
                                                <div class="card-header bg-transparent border-bottom px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                            <i class="fas fa-box fs-4"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="fw-bold mb-1 text-dark">Order #{{ $order->id }}</h6>
                                                            <div class="d-flex align-items-center">
                                                                <small class="text-muted"><i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="text-end">
                                                        <span class="d-block fw-bold text-dark fs-5">₹{{ number_format($order->total_amount, 2) }}</span>
                                                        @if($order->status == 0)
                                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mt-1">Pending Payment</span>
                                                        @elseif($order->status == 1)
                                                            <span class="badge bg-info px-3 py-2 rounded-pill mt-1">Paid / Processing</span>
                                                        @elseif($order->status == 2)
                                                            <span class="badge bg-primary px-3 py-2 rounded-pill mt-1">Shipped</span>
                                                        @elseif($order->status == 3)
                                                            <span class="badge bg-success px-3 py-2 rounded-pill mt-1">Delivered</span>
                                                        @elseif($order->status == 4)
                                                            <span class="badge bg-danger px-3 py-2 rounded-pill mt-1">Cancelled</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="card-body p-0">
                                                    <div class="px-4 py-3 bg-light border-bottom">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <small class="text-muted d-block fw-bold mb-1">Payment Method:</small>
                                                                <span class="text-dark small text-uppercase">
                                                                    @if($order->payment_method == 'online')
                                                                        Online Payment
                                                                    @else
                                                                        Cash on Delivery
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <small class="text-muted d-block fw-bold mb-1">Shipping Address:</small>
                                                                <span class="text-dark small d-block" style="white-space: pre-line;">{{ $order->shipping_address }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="list-group list-group-flush">
                                                        @if(count($order->items) > 0)
                                                            @foreach($order->items as $item)
                                                            <div class="list-group-item px-4 py-3 border-0 border-bottom">
                                                                <div class="d-flex align-items-start gap-3">
                                                                    <div class="text-primary mt-1">
                                                                        @if(isset($item->medicine->photo) && !empty($item->medicine->photo))
                                                                            <img src="{{ asset('public/assets/images/medicines/' . $item->medicine->photo) }}" width="40" height="40" class="rounded object-fit-cover shadow-sm">
                                                                        @else
                                                                            <div class="rounded bg-light shadow-sm d-flex align-items-center justify-content-center text-secondary" style="width: 40px; height: 40px;">
                                                                                <i class="fas fa-pills mb-0 pb-0" style="font-size: 1.2rem;"></i>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="w-100 d-flex justify-content-between">
                                                                        <div>
                                                                            <h6 class="fw-bold text-dark mb-1">{{ $item->medicine->name ?? 'Unknown Medicine' }}</h6>
                                                                            <small class="text-muted">Quantity: {{ $item->quantity }}</small>
                                                                        </div>
                                                                        <div class="text-end">
                                                                            <strong class="text-dark">₹{{ number_format($item->price, 2) }}</strong>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @else
                                                            <div class="px-4 py-4 text-center text-muted small">No items recorded for this order.</div>
                                                        @endif
                                                        
                                                        @if($order->status == 0 && $order->payment_method == 'online')
                                                        <div class="list-group-item px-4 py-3 border-0 text-end"
                                                            style="background: linear-gradient(to right, #fff7f7, #ffeefe);">
                                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                                <small class="text-danger">
                                                                    <i class="fas fa-exclamation-circle me-1"></i>
                                                                    This order is awaiting payment closure.
                                                                </small>
                                                                <!-- We could add a "Pay Now" logic redirecting them to checkout again, 
                                                                    but for now we just show its pending explicitly -->
                                                                <a href="{{ route('cart.view') }}" class="btn fw-bold shadow-sm px-4 py-2 rounded-pill"
                                                                    style="background: linear-gradient(90deg, #1E0B9B 0%, #07CCEC 100%); color: #fff; border: none; font-size: 0.88rem;">
                                                                    <i class="fas fa-credit-card me-2"></i> Go to Cart to Retry Payment
                                                                </a>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $orders->links() }}
                                </div>
                            @else
                                <div style="background: #fff; padding: 40px 25px; border-radius: 16px; box-shadow: var(--shadow-sm); min-height: 400px; border: 1px dashed #ced4da;"
                                    class="d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="mb-4 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                        <i class="fas fa-shopping-bag text-muted opacity-50" style="font-size: 3rem;"></i>
                                    </div>
                                    <h4 class="text-dark fw-bold mb-2">No Medicine Orders yet</h4>
                                    <p class="text-secondary mb-4" style="max-width: 400px;">
                                        Looks like you haven't placed any medicines orders yet. Visit our pharmacy to purchase your prescribed medicines.
                                    </p>
                                    <a href="/pharmacy" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                                        Visit Pharmacy
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
