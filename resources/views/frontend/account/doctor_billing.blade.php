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
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-primary btn-sm mr-3" data-bs-toggle="modal"
                                        data-bs-target="#requestPaymentModal">
                                        <i class="fas fa-paper-plane mr-1"></i> Request Withdrawal
                                    </button>
                                    <div class="badge badge-pill badge-pill-modern badge-soft-success">
                                        <i class="fas fa-check-circle mr-1"></i> Account Verified
                                    </div>
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

    <!-- Request Withdrawal Modal -->
    <div class="modal fade" id="requestPaymentModal" tabindex="-1" aria-labelledby="requestPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="requestPaymentModalLabel">Request Withdrawal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('doctorPaymentRequest') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="alert alert-info small mb-4">
                            <i class="fas fa-info-circle mr-1"></i> Available Balance:
                            <strong>₹{{ number_format($availableBalance, 2) }}</strong>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Withdrawal Amount (₹)</label>
                            <input type="number" name="amount" class="form-control" placeholder="Enter amount" min="1"
                                max="{{ $availableBalance }}" required>
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3">Bank Details</h6>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control"
                                value="{{ $bankDetails['bank_name'] ?? '' }}" placeholder="e.g. HDFC Bank" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Account Number</label>
                            <input type="text" name="account_number" class="form-control"
                                value="{{ $bankDetails['account_number'] ?? '' }}" placeholder="Enter account number"
                                required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold small">IFSC Code</label>
                                    <input type="text" name="ifsc_code" class="form-control"
                                        value="{{ $bankDetails['ifsc_code'] ?? '' }}" placeholder="e.g. HDFC0001234"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold small">Account Holder Name</label>
                                    <input type="text" name="account_name" class="form-control"
                                        value="{{ $bankDetails['account_name'] ?? '' }}" placeholder="Enter name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
    </style>
@endsection