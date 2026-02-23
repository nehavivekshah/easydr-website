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
                                    <div class="row g-4">
                                        @foreach($billings as $bill)
                                            <div class="col-12">
                                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #fff; transition: transform 0.2s;">
                                                    <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                                        
                                                        <div class="d-flex align-items-center gap-3 w-100 w-md-auto">
                                                            <div class="bg-light-subtle rounded-circle d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px; flex-shrink: 0;">
                                                                @if($bill->payment_status == 'paid')
                                                                    <i class="fas fa-arrow-up-right-dots text-success fs-5"></i>
                                                                @else
                                                                    <i class="fas fa-clock text-warning fs-5"></i>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-bold mb-1 text-dark">Consultation Fee</h6>
                                                                <div class="d-flex align-items-center mb-1">
                                                                    @php
                                                                        $avatar = "https://ui-avatars.com/api/?name=" . urlencode('Dr. ' . $bill->doctor_first_name) . "&background=0D8ABC&color=fff";
                                                                        $photo = $bill->doctor_photo ? asset('public/assets/images/profiles/' . $bill->doctor_photo) : $avatar;
                                                                    @endphp
                                                                    <img src="{{ $photo }}" class="rounded-circle me-2 border" width="20" height="20" style="object-fit: cover;">
                                                                    <small class="text-muted text-truncate" style="max-width: 150px;">Dr. {{ $bill->doctor_first_name }} {{ $bill->doctor_last_name }}</small>
                                                                </div>
                                                                <small class="text-secondary"><i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($bill->date)->format('d M, Y h:i A') }}</small>
                                                            </div>
                                                        </div>
    
                                                        <div class="d-flex flex-row flex-md-column align-items-center align-items-md-end justify-content-between w-100 w-md-auto ms-auto border-top border-md-0 pt-3 pt-md-0 mt-3 mt-md-0">
                                                            <div class="text-end mb-md-2">
                                                                <h5 class="fw-bold mb-0 {{ $bill->payment_status == 'paid' ? 'text-success' : 'text-dark' }}">
                                                                    {{ $currency_symbol }}{{ number_format($bill->fees, 2) }}
                                                                </h5>
                                                                <small class="text-muted">Amount</small>
                                                            </div>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                @if($bill->payment_status == 'paid')
                                                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 fw-medium">
                                                                        <i class="fas fa-check-circle me-1"></i> Paid
                                                                    </span>
                                                                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" disabled title="Receipt unavailable">
                                                                        <i class="fas fa-download"></i>
                                                                    </button>
                                                                @else
                                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2 fw-medium">
                                                                        <i class="fas fa-exclamation-circle me-1"></i> Pending
                                                                    </span>
                                                                    <a href="{{ route('payment') }}" class="btn btn-sm btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                                                        Pay Now
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