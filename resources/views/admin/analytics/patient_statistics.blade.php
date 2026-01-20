@extends('layout')

@section('title', 'Patient Statistics')

@section('content')
    <section class="task__section">
        <div class="container-fluid p-4">
            <h3 class="mb-4">Patient Statistics</h3>

            <div class="row">
                <!-- Gender Distribution -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0 text-white">Gender Distribution</h5>
                        </div>
                        <div class="card-body">
                            @if($genderDist->count() > 0)
                                <div style="height: 250px; position: relative;">
                                    <canvas id="genderChart"></canvas>
                                </div>
                            @else
                                <p class="text-muted">No data available.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Monthly Registrations -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0 text-white">Registrations this Year</h5>
                        </div>
                        <div class="card-body">
                            @if($registrations->count() > 0)
                                <div style="height: 250px; position: relative;">
                                    <canvas id="regChart"></canvas>
                                </div>
                            @else
                                <p class="text-muted">No data available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gender Chart
        const genderCtx = document.getElementById('genderChart');
        if (genderCtx) {
            new Chart(genderCtx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($genderDist->pluck('gender')) !!},
                    datasets: [{
                        data: {!! json_encode($genderDist->pluck('total')) !!},
                        backgroundColor: ['#36a2eb', '#ff6384', '#ffcd56'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        }

        // Registration Chart
        const regCtx = document.getElementById('regChart');
        if (regCtx) {
            new Chart(regCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($registrations->pluck('month')->map(fn($m) => date("F", mktime(0, 0, 0, $m, 10)))) !!},
                    datasets: [{
                        label: 'New Patients',
                        data: {!! json_encode($registrations->pluck('count')) !!},
                        backgroundColor: '#4bc0c0'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        }
    </script>
@endsection