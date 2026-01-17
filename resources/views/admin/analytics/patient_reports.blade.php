@extends('layout')

@section('title', 'Patient Reports')

@section('content')
    <div class="container-fluid p-4">
        <h3 class="mb-4">Patient Reports</h3>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Patients</h5>
                        <h2 class="display-4">{{ $totalPatients }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">Verified Health Cards</h5>
                        <h2 class="display-4">{{ $verifiedHealthCards }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Blood Group Distribution -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Blood Group Distribution</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($bloodGroups as $group)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $group->blood_group }}
                                    <span class="badge bg-primary rounded-pill">{{ $group->total }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Patients -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recently Registered Patients</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPatients as $patient)
                                    <tr>
                                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                        <td>{{ $patient->mobile }}</td>
                                        <td>{{ $patient->email }}</td>
                                        <td>{{ $patient->created_at->format('d M, Y') }}</td>
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