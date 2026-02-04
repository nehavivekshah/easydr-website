@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>
        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex align-items-center"
            style="background-image:url(public/assets/frontend/img/testimonial/test-bg.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                        <div class="breadcrumb-wrap text-center">
                            <div class="breadcrumb-title mb-30">
                                <h2>Pharmacy</h2>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Medicines</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <!-- Conditional Content Area -->
        <section class="pharmacy-content-area pt-80 pb-100">
            <div class="container">

                <div class="prescription-list">
                    @forelse ($prescribedMedicines as $item)
                        <div class="card prescription-item mb-4 shadow-sm">
                            <div class="row g-0">
                                <div class="col-md-2 d-flex align-items-center justify-content-center p-3">
                                    <img src="{{ $item->product->image_path ?? 'public/assets/frontend/img/shop/product_placeholder.png' }}"
                                        class="img-fluid rounded-start" alt="{{ $item->product->name ?? 'Medicine' }}"
                                        style="max-height: 100px; object-fit: contain;">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->product->name ?? 'Prescribed Medicine' }}</h5>
                                        <p class="card-text text-muted">
                                            <strong>Dosage/Instructions:</strong>
                                            {{ $item->dosage_instructions ?? 'As directed by your doctor' }} <br>
                                        </p>
                                        <p class="card-text fw-bold">Price: ${{ number_format($item->product->price ?? 0, 2) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-center justify-content-center p-3 bg-light">
                                    @if(isset($item->product) && $item->product->is_purchasable)
                                        <form action="#" method="POST" class="d-grid gap-2">
                                            <input type="hidden" name="product_id" value="{{ $item->product_id ?? '' }}">
                                            <input type="hidden" name="prescription_ref"
                                                value="{{ $item->id ?? $item->prescription_id ?? '' }}">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">Qty:</span>
                                                <input type="number" name="quantity" class="form-control form-control-sm" value="1"
                                                    min="1" aria-label="Quantity">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">Item details unavailable or not purchasable online.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            No medications have been prescribed for you by our platform doctors yet, or your prescriptions are
                            not currently active.
                            <br>
                            <a href="/doctors" class="btn btn-info mt-3"><i class="fas fa-user-md me-2"></i> Find a Doctor to
                                Get a Prescription</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
        <!-- Conditional Content Area End -->

    </main>
    <!-- main-area-end -->
@endsection

@push('styles')

    <style>
        .pharmacy-search .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .pharmacy-search .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .product-card .card-img-top {
            width: 100%;
            height: 180px;
            object-fit: contain;
            padding: 10px;
        }

        .product-card .card-title a {
            text-decoration: none;
            color: inherit;
        }

        .product-card .card-title a:hover {
            color: var(--bs-primary);
        }

        .product-card .product-description {
            min-height: 3em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .prescription-item .card-body {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .prescription-item .bg-light {
            background-color: #f8f9fa !important;
            border-left: 1px solid #dee2e6;
        }

        /* Optional style for the Find a Doctor button in the empty state */
        .alert a.btn {
            text-decoration: none;
            /* Remove underline */
        }
    </style>
@endpush

@push('scripts')

    <script>
        // Any specific JS for this page can go here
    </script>
@endpush