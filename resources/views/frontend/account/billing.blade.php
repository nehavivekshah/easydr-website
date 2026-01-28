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
                        <div class="card shadow-sm mb-4 border-0 rounded-3">
                            <div class="card-header bg-white border-bottom p-3">
                                <h4 class="mb-0">Billing & Payments</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="border-0">Date</th>
                                                <th class="border-0">Description</th>
                                                <th class="border-0">Doctor</th>
                                                <th class="border-0">Amount</th>
                                                <th class="border-0">Status</th>
                                                <th class="border-0">Receipt</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($billings as $bill)
                                                <tr>
                                                    <td class="align-middle">{{ \Carbon\Carbon::parse($bill->date)->format('d M, Y') }}</td>
                                                    <td class="align-middle">Consultation Fee</td>
                                                    <td class="align-middle">Dr. {{ $bill->doctor_first_name }} {{ $bill->doctor_last_name }}<br><small class="text-muted">{{ $bill->specialist }}</small></td>
                                                    <td class="align-middle fw-bold">₹{{ number_format($bill->fees, 2) }}</td>
                                                    <td class="align-middle">
                                                        @if($bill->payment_status == 'paid')
                                                            <span class="badge bg-success rounded-pill px-3">Paid</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark rounded-pill px-3">Unpaid</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        @if($bill->payment_status == 'paid')
                                                            <button class="btn btn-sm btn-outline-secondary" disabled><i class="bx bx-download"></i> Receipt</button>
                                                        @else
                                                             <a href="{{ route('payment') }}" class="btn btn-sm btn-primary">Pay Now</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-5">
                                                        <div class="text-muted">
                                                            <i class="bx bx-receipt fs-1 d-block mb-3"></i>
                                                            No billing records found.
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-3">
                                    {{ $billings->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection