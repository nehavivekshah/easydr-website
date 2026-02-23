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
                                    <h4 class="mb-0 fw-bold text-dark" style="letter-spacing: -0.5px;">Transaction History</h4>
                                    <div class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                        <i class="fas fa-wallet me-1"></i> Balance: {{ $currency_symbol }}0.00
                                    </div>
                                </div>
    
                                @if(count($billings) > 0)
                                    <style>
                                        .transaction-card {
                                            transition: all 0.2s ease-in-out;
                                            border-left-width: 5px !important;
                                        }
                                        .transaction-card:hover {
                                            transform: translateY(-3px);
                                            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.08) !important;
                                        }
                                    </style>
                                    <div class="row g-4">
                                        @foreach($billings as $bill)
                                            <div class="col-12">
                                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden transaction-card {{ $bill->payment_status == 'paid' ? 'border-start border-success' : 'border-start border-warning' }}" style="background: #fff;">
                                                    <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                                        
                                                        <div class="d-flex align-items-start gap-3 w-100 w-md-auto">
                                                            <div class="{{ $bill->payment_status == 'paid' ? 'bg-success-subtle border-success-subtle' : 'bg-warning-subtle border-warning-subtle' }} rounded-circle d-flex align-items-center justify-content-center border" style="width: 56px; height: 56px; flex-shrink: 0;">
                                                                @if($bill->payment_status == 'paid')
                                                                    <i class="fas fa-check-circle text-success fs-3"></i>
                                                                @else
                                                                    <i class="fas fa-hourglass-half text-warning fs-4"></i>
                                                                @endif
                                                            </div>
                                                            <div class="mt-1">
                                                                <h5 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.3px;">Consultation Fee</h5>
                                                                <div class="d-flex align-items-center mb-2 mt-1">
                                                                    @php
                                                                        $avatar = "https://ui-avatars.com/api/?name=" . urlencode('Dr. ' . $bill->doctor_first_name) . "&background=0D8ABC&color=fff";
                                                                        $photo = $bill->doctor_photo ? asset('public/assets/images/profiles/' . $bill->doctor_photo) : $avatar;
                                                                    @endphp
                                                                    <img src="{{ $photo }}" class="rounded-circle me-2 border border-2 border-white shadow-sm" width="28" height="28" style="object-fit: cover;">
                                                                    <span class="text-secondary fw-semibold">Dr. {{ $bill->doctor_first_name }} {{ $bill->doctor_last_name }}</span>
                                                                    <span class="text-muted ms-2 small d-none d-sm-inline">&bull; {{ $bill->specialist }}</span>
                                                                </div>
                                                                <div class="text-secondary small mt-2">
                                                                    <span class="bg-light px-2 py-1 rounded me-2 border">
                                                                        <i class="far fa-calendar-alt text-primary me-1"></i><span class="fw-medium">{{ \Carbon\Carbon::parse($bill->date)->format('d M, Y') }}</span>
                                                                    </span>
                                                                    <span class="bg-light px-2 py-1 rounded border">
                                                                        <i class="far fa-clock text-primary me-1"></i><span class="fw-medium">{{ \Carbon\Carbon::parse($bill->date)->format('h:i A') }}</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <div class="d-flex flex-row flex-md-column align-items-center align-items-md-end justify-content-between w-100 w-md-auto ms-auto border-top border-md-0 pt-3 pt-md-0 mt-3 mt-md-0">
                                                            <div class="text-end mb-md-3">
                                                                <h3 class="fw-bold mb-0 {{ $bill->payment_status == 'paid' ? 'text-success' : 'text-dark' }}" style="letter-spacing: -0.5px;">
                                                                    {{ $currency_symbol }}{{ number_format($bill->fees, 2) }}
                                                                </h3>
                                                                <small class="text-uppercase text-muted" style="font-size: 0.70rem; font-weight: 700; letter-spacing: 0.5px;">Amount</small>
                                                            </div>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                @if($bill->payment_status == 'paid')
                                                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 fw-bold text-uppercase d-flex align-items-center" style="font-size: 0.75rem;">
                                                                        <i class="fas fa-check me-1"></i> Paid
                                                                    </span>
                                                                    <button class="btn btn-sm btn-light rounded-pill px-3 py-2 border shadow-sm" disabled title="Receipt unavailable">
                                                                        <i class="fas fa-download text-muted"></i>
                                                                    </button>
                                                                @else
                                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2 fw-bold text-uppercase d-flex align-items-center" style="font-size: 0.75rem;">
                                                                        <i class="fas fa-hourglass-half me-1"></i> Pending
                                                                    </span>
                                                                    <a href="{{ route('payment') }}" class="btn btn-sm btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-flex align-items-center gap-1" style="transition: all 0.2s;">
                                                                        Pay Now <i class="fas fa-arrow-right small"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
    
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="mt-4 d-flex justify-content-center">
                                        {{ $billings->links('pagination::bootstrap-4') }}
                                    </div>
                                @else
                                    <div style="background: #fff; padding: 40px 25px; border-radius: 16px; box-shadow: var(--shadow-sm); min-height: 400px; border: 1px dashed #ced4da;"
                                        class="d-flex flex-column align-items-center justify-content-center text-center">
                                        <div class="mb-4 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                            <i class="fas fa-file-invoice-dollar text-muted opacity-50" style="font-size: 3rem;"></i>
                                        </div>
                                        <h4 class="text-dark fw-bold mb-2">No Transactions Yet</h4>
                                        <p class="text-secondary mb-4" style="max-width: 400px;">
                                            Your payment history for appointments and consultations will appear here once you book a service.
                                        </p>
                                        <a href="/my-doctors" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                                            Book an Appointment
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