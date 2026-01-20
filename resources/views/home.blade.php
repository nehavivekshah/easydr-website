@extends('layout')
@section('title', 'Dashboard - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="text">
            Welcome {{Auth::User()->first_name}}
            <div class="bradcrum">
                Dashboard
            </div>
        </div>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-overview">
                        <div class="overview-box appointments">
                            <a href="/admin/upcoming-appointments" class="overview-link"></a>
                            <i class="bx bx-calendar-check"></i>
                            <div class="overview-details">
                                <div class="overview-count">{{ $appointments ?? 0 }}</div>
                                <div class="overview-label">Appointments</div>
                            </div>
                        </div>

                        <div class="overview-box patients">
                            <a href="/admin/users/patient-directory" class="overview-link"></a>
                            <i class="bx bx-group"></i>
                            <div class="overview-details">
                                <div class="overview-count">{{ $patients ?? 0 }}</div>
                                <div class="overview-label">Patients</div>
                            </div>
                        </div>

                        <div class="overview-box doctors">
                            <a href="/admin/users/doctor-directory" class="overview-link"></a>
                            <i class="bx bx-heart-circle"></i>
                            <div class="overview-details">
                                <div class="overview-count">{{ $doctors ?? 0 }}</div>
                                <div class="overview-label">Doctors</div>
                            </div>
                        </div>

                        <div class="overview-box medicines">
                            <a href="/admin/medicine-listings" class="overview-link"></a>
                            <i class="bx bx-capsule"></i>
                            <div class="overview-details">
                                <div class="overview-count">{{ $medicines ?? 0 }}</div>
                                <div class="overview-label">Medicines</div>
                            </div>
                        </div>

                        <div class="overview-box medical-stores">
                            <a href="/admin/pharmacy" class="overview-link"></a>
                            <i class="bx bx-store"></i>
                            <div class="overview-details">
                                <div class="overview-count">{{ $medicalStores ?? 0 }}</div>
                                <div class="overview-label">Medical Stores</div>
                            </div>
                        </div>

                        <div class="overview-box medicines">
                            <a href="/admin/reports" class="overview-link"></a>
                            <i class="bx bx-spreadsheet"></i>
                            <div class="overview-details">
                                <div class="overview-count">{{ $reports ?? 0 }}</div>
                                <div class="overview-label">Reports</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-2">
                <div class="col-md-6">
                    <!-- Appointment Chart -->
                    <div class="card mb-4">
                        <div class="card-header">Appointment Chart</div>
                        <div class="card-body">
                            <canvas id="appointmentChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Patient Chart -->
                    <div class="card mb-4">
                        <div class="card-header">Patient Chart</div>
                        <div class="card-body pb-4">
                            <canvas id="patientChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Appointment Chart Data and Configuration
        const appointmentChartCanvas = document.getElementById('appointmentChart');
        if (appointmentChartCanvas) {
            const appointmentData = {
                labels: @json($appointmentChartLabels), // e.g., ['Jan', 'Feb', 'Mar']
                datasets: [{
                    label: 'Appointments',
                    data: @json($appointmentChartData),   // e.g., [10, 5, 12]
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            };

            const appointmentChartConfig = {
                type: 'bar', // or 'line', 'pie', etc.
                data: appointmentData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            const appointmentChart = new Chart(appointmentChartCanvas, appointmentChartConfig);
        }


        // Patient Chart Data and Configuration
        const patientChartCanvas = document.getElementById('patientChart');
        if (patientChartCanvas) {
            const patientData = {
                labels: @json($patientChartLabels), // e.g., ['Male', 'Female', 'Other']
                datasets: [{
                    label: 'Patients',
                    data: @json($patientChartData),   // e.g., [30, 25, 2]
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)'
                    ],
                    borderWidth: 1
                }]
            };

            const patientChartConfig = {
                type: 'pie', // or 'bar', 'line', etc.
                data: patientData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Allow the chart to take the card's size
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Patient Demographics'
                        }
                    }
                }
            };

            const patientChart = new Chart(patientChartCanvas, patientChartConfig);
        }
    </script>
@endsection