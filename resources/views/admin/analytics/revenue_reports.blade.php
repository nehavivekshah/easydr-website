@extends('layout')

@section('title', 'Revenue Analysis')

@section('content')
    <section class="task__section">
        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Revenue Analysis</h3>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">{{ date('F Y') }}</span>
            </div>

            <!-- Revenue Overview Card -->
            <div class="row mb-4">
                <div class="col-md-5">
                    <div class="card text-white shadow border-0 overflow-hidden"
                        style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <div class="card-body p-4 position-relative">
                            <div class="d-flex align-items-center justify-content-between z-1"
                                style="position: relative; z-index: 2;">
                                <div>
                                    <h6 class="mb-1 text-white-50 text-uppercase fw-bold ls-1"
                                        style="letter-spacing: 1px; font-size: 0.85rem;">Total Revenue Collected</h6>
                                    <h2 class="display-4 fw-bold mb-0">${{ number_format($totalRevenue, 2) }}</h2>
                                </div>
                                <div
                                    class="p-3 bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center">
                                    <i class='bx bx-dollar text-white' style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                            <!-- Decorative background icon -->
                            <i class='bx bx-line-chart'
                                style="position: absolute; bottom: -20px; right: -20px; font-size: 10rem; opacity: 0.15; z-index: 1;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Revenue by Doctor -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-header">
                            <h5 class="mb-0 text-white"><i class='bx bx-user-voice me-2'></i>Top Earning Doctors</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-3 ps-3"><i class='bx bx-user me-2 text-muted'></i>Doctor</th>
                                        <th class="py-3 pe-3 text-end"><i class='bx bx-money me-2 text-muted'></i>Revenue
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($revenueByDoctor as $doc)
                                        <tr>
                                            <td class="ps-3 fw-medium">Dr. {{ $doc->first_name }} {{ $doc->last_name }}</td>
                                            <td class="text-end pe-3 text-success fw-bold">${{ number_format($doc->total, 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center py-4 text-muted">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-header">
                            <h5 class="mb-0 text-white"><i class='bx bx-history me-2'></i>Recent Transactions</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-3 ps-3">ID</th>
                                        <th class="py-3"><i class='bx bx-user me-1 text-muted'></i>Doctor</th>
                                        <th class="py-3"><i class='bx bx-dollar-circle me-1 text-muted'></i>Amount</th>
                                        <th class="py-3"><i class='bx bx-calendar me-1 text-muted'></i>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransactions as $trans)
                                        <tr>
                                            <td class="ps-3"><span
                                                    class="badge bg-light text-secondary border">#{{ $trans->id }}</span></td>
                                            <td>Dr. {{ $trans->first_name }}</td>
                                            <td class="fw-bold text-dark">${{ number_format($trans->amount, 2) }}</td>
                                            <td class="text-muted small">
                                                {{ \Carbon\Carbon::parse($trans->created_at)->format('d M, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">No transactions found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection