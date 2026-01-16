@extends('layout')

@section('title', 'Reports - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="text">
            Reports
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addReportModal"><i class="bx bx-plus"></i> <span>Generate Report</span></button>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50px">Sr. No.</th>
                                <th>Report Type</th>
                                <th>Store ID</th>
                                <th>Details</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $k => $report)
                                <tr>
                                    <td class="text-center">{{ $k + 1 }}</td>
                                    <td>{{ $report->report_type }}</td>
                                    <td>{{ $report->store_id }}</td>
                                    <td>{{ $report->details }}</td>
                                    <td>{{ $report->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('reports.generate') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addReportModalLabel">Generate Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Store ID</label>
                            <input type="number" name="store_id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Report Type</label>
                            <select name="report_type" class="form-select" required>
                                <option value="Sales">Sales</option>
                                <option value="Inventory">Inventory</option>
                                <option value="Orders">Orders</option>
                                <option value="Revenue">Revenue</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Details</label>
                            <textarea name="details" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection