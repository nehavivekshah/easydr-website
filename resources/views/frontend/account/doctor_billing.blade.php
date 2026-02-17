@extends('frontend.layout')

@section('content')
    <main class="dashboard-container">
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h5 class="mb-0">Billing & Payments</h5>
                                <div class="badge badge-pill badge-pill-modern badge-soft-success">
                                    <i class="fas fa-check-circle mr-1"></i> Account Verified
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card-modern shadow-soft text-center p-4 h-100">
                                        <div class="avatar-initials bg-light-blue text-primary mb-3 mx-auto"
                                            style="width: 60px; height: 60px; font-size: 24px;">
                                            <i class="fas fa-wallet"></i>
                                        </div>
                                        <h3 class="mb-1 text-primary">₹{{ number_format($totalEarnings, 2) }}</h3>
                                        <p class="text-muted small mb-0">Total Earnings</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-modern shadow-soft text-center p-4 h-100">
                                        <div class="avatar-initials bg-light-success text-success mb-3 mx-auto"
                                            style="width: 60px; height: 60px; font-size: 24px;">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </div>
                                        <h3 class="mb-1 text-success">₹{{ number_format($availableBalance, 2) }}</h3>
                                        <p class="text-muted small mb-0">Available Balance</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-modern shadow-soft text-center p-4 h-100">
                                        <div class="avatar-initials bg-light-warning text-warning mb-3 mx-auto"
                                            style="width: 60px; height: 60px; font-size: 24px;">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <h3 class="mb-1 text-warning">₹{{ number_format($pendingPayments, 2) }}</h3>
                                        <p class="text-muted small mb-0">Pending Payments</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-modern">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-modern mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Transaction ID</th>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($transactions as $t)
                                                    <tr>
                                                        <td class="font-weight-bold">#{{ $t->id }}</td>
                                                        <td>{{ $t->created_at->format('d M, Y') }}</td>
                                                        <td>{{ $t->details }}</td>
                                                        <td class="font-weight-bold text-success">
                                                            ₹{{ number_format($t->amount, 2) }}</td>
                                                        <td>
                                                            <span
                                                                class="badge badge-pill badge-pill-modern {{ $t->status == 'credit' ? 'badge-soft-success' : 'badge-soft-warning' }}">
                                                                {{ ucfirst($t->status) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-5">
                                                            <div class="mb-3">
                                                                <i class="fas fa-file-invoice-dollar text-muted"
                                                                    style="font-size: 48px; opacity: 0.3;"></i>
                                                            </div>
                                                            <h6 class="text-muted">No transactions found.</h6>
                                                            <p class="small text-muted">Your billing and payment history will
                                                                appear here.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @if($transactions->hasPages())
                                    <div class="p-3 d-flex justify-content-center">
                                        {{ $transactions->links('pagination::bootstrap-5') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        .bg-light-blue {
            background-color: #eef5ff;
        }

        .bg-light-success {
            background-color: #e6fffa;
        }

        .bg-light-warning {
            background-color: #fff9e6;
        }

        .shadow-soft {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
        }
    </style>
@endsection