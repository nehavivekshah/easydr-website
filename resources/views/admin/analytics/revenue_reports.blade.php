@extends('layout')

@section('title', 'Revenue Analysis')

@section('content')
    <div class="container-fluid p-4">
        <h3 class="mb-4">Revenue Analysis</h3>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Revenue Collected</h5>
                        <h2 class="display-5">${{ number_format($totalRevenue, 2) }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Revenue by Doctor -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Top Earning Doctors</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th class="text-end">Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($revenueByDoctor as $doc)
                                    <tr>
                                        <td>Dr. {{ $doc->first_name }} {{ $doc->last_name }}</td>
                                        <td class="text-end">${{ number_format($doc->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recent Transactions</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Doctor</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTransactions as $trans)
                                    <tr>
                                        <td>#{{ $trans->id }}</td>
                                        <td>{{ $trans->first_name }}</td>
                                        <td>${{ number_format($trans->amount, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($trans->created_at)->format('d M') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection