@extends('admin.layout')

@section('title', 'Reports')

@section('content')
    <h2>Reports</h2>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Store ID</th>
                <th>Report Type</th>
                <th>Date</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->store_id }}</td>
                    <td>{{ ucfirst($report->report_type) }}</td>
                    <td>{{ $report->generated_date }}</td>
                    <td>{{ $report->details }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
