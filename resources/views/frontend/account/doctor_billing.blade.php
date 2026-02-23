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
                                        <h3 class="mb-1 text-primary">
                                            {{ $currency_symbol }}{{ number_format($totalEarnings, 2) }}
                                        </h3>
                                        <p class="text-muted small mb-0">Total Earnings</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-modern shadow-soft text-center p-4 h-100">
                                        <div class="avatar-initials bg-light-success text-success mb-3 mx-auto"
                                            style="width: 60px; height: 60px; font-size: 24px;">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </div>
                                        <h3 class="mb-1 text-success">
                                            {{ $currency_symbol }}{{ number_format($availableBalance, 2) }}
                                        </h3>
                                        <p class="text-muted small mb-0">Available Balance</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-modern shadow-soft text-center p-4 h-100">
                                        <div class="avatar-initials bg-light-warning text-warning mb-3 mx-auto"
                                            style="width: 60px; height: 60px; font-size: 24px;">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <h3 class="mb-1 text-warning">
                                            {{ $currency_symbol }}{{ number_format($pendingPayments, 2) }}
                                        </h3>
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
                                                            {{ $currency_symbol }}{{ number_format($t->amount, 2) }}
                                                        </td>
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

    <!-- Premium Request Withdrawal Modal -->
    <div class="modal fade" id="requestPaymentModal" tabindex="-1" aria-labelledby="requestPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-premium border-0">
            <div class="modal-content border-0 shadow-xl" style="border-radius: 20px; overflow: hidden;">

                {{-- Modern Header --}}
                <div class="modal-header border-0 pb-0 pt-4 px-4 px-md-5">
                    <h4 class="modal-title font-weight-bold display-7" id="requestPaymentModalLabel">
                        <i class="fas fa-university text-primary mr-2"></i> Request Withdrawal
                    </h4>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"
                        style="filter: none; opacity: 0.5;"></button>
                </div>

                <form action="{{ route('doctorPaymentRequest') }}" method="POST">
                    @csrf
                    <div class="modal-body px-4 px-md-5 py-4">

                        {{-- Feature: Beautiful Interactive Balance Card --}}
                        <div class="balance-elegant-card mb-4 position-relative overflow-hidden">
                            <div class="d-flex justify-content-between align-items-center position-relative z-index-1">
                                <div>
                                    <p class="mb-1 text-uppercase font-weight-bold"
                                        style="letter-spacing: 1px; color: #10b981; font-size: 11px;">Available For
                                        Withdrawal</p>
                                    <h2 class="mb-0 font-weight-bold text-dark display-5">
                                        <span
                                            class="text-muted mr-1 ml-n1 font-weight-light">{{ $currency_symbol }}</span>{{ number_format($availableBalance, 2) }}
                                    </h2>
                                </div>
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                    style="width: 48px; height: 48px;">
                                    <i class="fas fa-arrow-down text-success" style="font-size: 20px;"></i>
                                </div>
                            </div>
                            <!-- Subtle Background Design -->
                            <div class="position-absolute"
                                style="top: -20px; right: 20px; opacity: 0.05; transform: scale(2);">
                                <i class="fas fa-wallet fa-5x"></i>
                            </div>
                        </div>

                        {{-- Elegant Amount Input --}}
                        <div class="form-group mb-4 position-relative modern-input-group">
                            <label class="font-weight-bold small text-muted mb-2 text-uppercase"
                                style="letter-spacing: 0.5px;">Amount to Withdraw</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-right-0"
                                    style="border-top-left-radius: 12px; border-bottom-left-radius: 12px; border-color: #e2e8f0; color: #64748b;">
                                    {{ $currency_symbol }}
                                </span>
                                <input type="number" name="amount" class="form-control premium-input border-left-0 pl-0"
                                    placeholder="0.00" min="1" max="{{ $availableBalance }}" step="0.01" required
                                    style="font-size: 1.25rem; font-weight: 600;">
                            </div>
                        </div>

                        <div class="d-flex align-items-center my-4">
                            <div class="flex-grow-1" style="height: 1px; background-color: #e2e8f0;"></div>
                            <span class="px-3 text-muted small font-weight-bold text-uppercase"
                                style="letter-spacing: 1px; background-color: #fff; border-radius: 20px; border: 1px solid #e2e8f0;">Destination
                                Bank</span>
                            <div class="flex-grow-1" style="height: 1px; background-color: #e2e8f0;"></div>
                        </div>

                        {{-- Bank Details Section with Icons --}}
                        <div class="form-group mb-3 modern-input-group">
                            <label class="font-weight-bold small text-muted mb-1">Bank Name</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-building input-icon text-primary"></i>
                                <input type="text" name="bank_name" class="form-control premium-input has-icon"
                                    value="{{ $bankDetails['bank_name'] ?? '' }}" placeholder="e.g. HDFC Bank" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 modern-input-group">
                            <label class="font-weight-bold small text-muted mb-1">Account Number</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-hashtag input-icon text-primary"></i>
                                <input type="text" name="account_number" class="form-control premium-input has-icon"
                                    value="{{ $bankDetails['account_number'] ?? '' }}" placeholder="Enter account number"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0 pb-3 modern-input-group">
                                    <label class="font-weight-bold small text-muted mb-1">IFSC Code</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-barcode input-icon text-primary"></i>
                                        <input type="text" name="ifsc_code"
                                            class="form-control premium-input has-icon text-uppercase"
                                            value="{{ $bankDetails['ifsc_code'] ?? '' }}" placeholder="e.g. HDFC0001234"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0 pb-3 modern-input-group">
                                    <label class="font-weight-bold small text-muted mb-1">Account Holder</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-user-circle input-icon text-primary"></i>
                                        <input type="text" name="account_name" class="form-control premium-input has-icon"
                                            value="{{ $bankDetails['account_name'] ?? '' }}" placeholder="Enter name"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Premium Footer Action --}}
                    <div class="modal-footer border-0 px-4 px-md-5 pb-4 pt-0">
                        <button type="button" class="btn btn-light elegant-btn-light px-4"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary elegant-btn-primary px-5 shadow-sm">
                            Submit Request <i class="fas fa-paper-plane ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Existing Dashboard Styles */
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

        /* Premium Modal Overrides */
        .shadow-xl {
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15) !important;
        }

        .balance-elegant-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            border: 1px solid #d1fae5;
            border-radius: 16px;
            padding: 24px;
            box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.7);
        }

        .modern-input-group .premium-input {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            color: #334155;
            transition: all 0.2s ease;
        }

        .modern-input-group .premium-input.has-icon {
            padding-left: 44px;
        }

        .modern-input-group .input-icon-wrapper {
            position: relative;
        }

        .modern-input-group .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.5;
            transition: all 0.2s ease;
        }

        .modern-input-group .premium-input:focus {
            background-color: #fff;
            border-color: var(--primary-color, #0f4a86);
            box-shadow: 0 0 0 4px rgba(15, 74, 134, 0.1);
        }

        .modern-input-group .premium-input:focus+.input-icon,
        .modern-input-group .input-icon-wrapper:focus-within .input-icon {
            opacity: 1;
        }

        .elegant-btn-primary {
            border-radius: 30px;
            padding: 12px 24px;
            font-weight: 600;
            background: linear-gradient(to right, var(--primary-color, #0f4a86), #145da3);
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .elegant-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(15, 74, 134, 0.2) !important;
        }

        .elegant-btn-light {
            border-radius: 30px;
            background-color: #f1f5f9;
            color: #475569;
            border: none;
            font-weight: 600;
        }

        .elegant-btn-light:hover {
            background-color: #e2e8f0;
            color: #1e293b;
        }

        /* Custom styling for amount input group integration */
        .modern-input-group .input-group-text {
            background-color: #f8fafc;
        }

        .modern-input-group .input-group:focus-within .input-group-text {
            border-color: var(--primary-color, #0f4a86);
            background-color: #fff;
        }

        .modern-input-group .input-group:focus-within .premium-input {
            box-shadow: none;
            /* remove inner shadow since we have outer border */
            border-right: 1px solid var(--primary-color, #0f4a86);
            border-top: 1px solid var(--primary-color, #0f4a86);
            border-bottom: 1px solid var(--primary-color, #0f4a86);
        }
    </style>
@endsection