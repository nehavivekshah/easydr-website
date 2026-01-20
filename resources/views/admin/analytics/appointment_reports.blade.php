@extends('layout')

@section('title', 'Appointment Reports')

@section('content')
    <section class="task__section">
        <div class="container-fluid p-4">
            <h3 class="mb-4">Appointment Reports</h3>

            <!-- Summary Row -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total</h5>
                            <p class="card-text display-6">{{ $totalAppointments }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Pending</h5>
                            <p class="card-text display-6">{{ $pending }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Confirmed</h5>
                            <p class="card-text display-6">{{ $confirmed }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Cancelled</h5>
                            <p class="card-text display-6">{{ $cancelled }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Appointments by Specialist</h5>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px; position: relative;">
                                <canvas id="specialistChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('specialistChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($bySpecialist->pluck('specialist')) !!},
                    datasets: [{
                        data: {!! json_encode($bySpecialist->pluck('total')) !!},
                        backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0', '#9966ff'],
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