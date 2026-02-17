@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    <!-- Content Area -->
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <div class="section-title mb-4">
                                <h3 class="fw-bold mb-0">Dashboard Overview</h3>
                                <p class="text-muted small mb-0">Welcome back, Dr. {{ Auth::user()->first_name }}</p>
                            </div>

                            <div class="row">
                                @if(Auth::user()->role == 5)
                                    <!-- Patient Overview (Legacy Role 5 handling - skip for now as I'm focusing on Doctor Role 4) -->
                                @else
                                    <!-- Doctor Role 4 Overview -->
                                    <div class="col-xl-4 col-md-6 mb-4 animate-fade-in-up">
                                        <div class="card-modern p-4 h-100 border-left-primary">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-primary-subtle text-primary rounded-circle p-3 mr-3">
                                                    <i class="fas fa-calendar-check fa-lg"></i>
                                                </div>
                                                <div>
                                                    <p class="text-muted small mb-0 font-weight-bold text-uppercase">Total Appointments</p>
                                                    <h3 class="mb-0 fw-bold">{{ $appointmentsCount ?? 0 }}</h3>
                                                </div>
                                            </div>
                                            <div class="border-top pt-2">
                                                <span class="badge badge-soft-primary">{{ $todayAppointmentsCount ?? 0 }} Scheduled Today</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-md-6 mb-4 animate-fade-in-up delay-1">
                                        <div class="card-modern p-4 h-100 border-left-success">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-success-subtle text-success rounded-circle p-3 mr-3">
                                                    <i class="fas fa-user-injured fa-lg"></i>
                                                </div>
                                                <div>
                                                    <p class="text-muted small mb-0 font-weight-bold text-uppercase">My Patients</p>
                                                    <h3 class="mb-0 fw-bold">{{ $patientsCount ?? 0 }}</h3>
                                                </div>
                                            </div>
                                            <div class="border-top pt-2">
                                                <span class="text-muted small">Unique patient records</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-md-6 mb-4 animate-fade-in-up delay-2">
                                        <div class="card-modern p-4 h-100 border-left-purple">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-purple-subtle text-purple rounded-circle p-3 mr-3">
                                                    <i class="fas fa-wallet fa-lg"></i>
                                                </div>
                                                <div>
                                                    <p class="text-muted small mb-0 font-weight-bold text-uppercase">Wallet Balance</p>
                                                    <h3 class="mb-0 fw-bold">₹{{ number_format($walletAmount ?? 0, 2) }}</h3>
                                                </div>
                                            </div>
                                            <div class="border-top pt-2 d-flex justify-content-between">
                                                <span class="text-muted small">Revenue: ₹{{ number_format($totalRevenue ?? 0, 2) }}</span>
                                                <a href="/doctor-billing" class="small fw-bold">View Billing <i class="fas fa-arrow-right ml-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                                    <!-- New Section: Calendar & Revenue Graph -->
                                    <div class="row mt-4">
                                        <!-- Calendar Section -->
                                        <div class="col-lg-6 mb-4 animate-fade-in-up delay-3">
                                            <div class="card-modern h-100">
                                                <div class="card-header bg-white border-bottom py-3">
                                                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-calendar-alt mr-2"></i>Upcoming Appointments</h5>
                                                </div>
                                                <div class="card-body p-4">
                                                    <!-- Simple Custom Calendar UI -->
                                                    <div class="custom-calendar">
                                                        <div class="calendar-header d-flex justify-content-between align-items-center mb-4">
                                                            <button class="btn btn-sm btn-light border rounded-pill px-3 shadow-sm" id="prevMonth"
                                                                style="width: 40px; height: 40px;"><i class="fas fa-chevron-left"></i></button>
                                                            <h6 class="mb-0 fw-bold" id="monthYear"></h6>
                                                            <button class="btn btn-sm btn-light border rounded-pill px-3 shadow-sm" id="nextMonth"
                                                                style="width: 40px; height: 40px;"><i class="fas fa-chevron-right"></i></button>
                                                        </div>
                                                        <div class="calendar-days d-flex justify-content-between text-muted small mb-3 text-center fw-bold opacity-75">
                                                            <div style="width: 14%">S</div>
                                                            <div style="width: 14%">M</div>
                                                            <div style="width: 14%">T</div>
                                                            <div style="width: 14%">W</div>
                                                            <div style="width: 14%">T</div>
                                                            <div style="width: 14%">F</div>
                                                            <div style="width: 14%">S</div>
                                                        </div>
                                                        <div class="calendar-grid d-flex flex-wrap" id="calendarGrid">
                                                            <!-- Days generated by JS -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Revenue Graph Section -->
                                        <div class="col-lg-6 mb-4 animate-fade-in-up delay-4">
                                            <div class="card-modern h-100">
                                                <div class="card-header bg-white border-bottom py-3">
                                                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-chart-line mr-2"></i>Monthly Revenue ({{ date('Y') }})</h5>
                                                </div>
                                                <div class="card-body p-4">
                                                    <div style="height: 300px;">
                                                        <canvas id="revenueChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @push('scripts')
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                // --- Calendar Logic ---
                                                const calendarGrid = document.getElementById('calendarGrid');
                                                const monthYearLabel = document.getElementById('monthYear');

                                                let currentDate = new Date();
                                                // appointmentDates passed from controller
                                                const appointmentDates = @json($appointmentDates ?? []);

                                                function renderCalendar(date) {
                                                    const year = date.getFullYear();
                                                    const month = date.getMonth();

                                                    // First day of split month
                                                    const firstDay = new Date(year, month, 1);
                                                    // Last day of month
                                                    const lastDay = new Date(year, month + 1, 0);

                                                    // Start day index (0=Sun, 1=Mon...)
                                                    const startDayIndex = firstDay.getDay();
                                                    const totalDays = lastDay.getDate();

                                                    monthYearLabel.innerText = date.toLocaleDateString('default', { month: 'long', year: 'numeric' });
                                                    calendarGrid.innerHTML = '';

                                                    // Empty slots for previous month
                                                    for (let i = 0; i < startDayIndex; i++) {
                                                        const emptyDiv = document.createElement('div');
                                                        emptyDiv.style.width = '14.28%';
                                                        emptyDiv.style.height = '40px';
                                                        calendarGrid.appendChild(emptyDiv);
                                                    }

                                                    // Days
                                                    for (let i = 1; i <= totalDays; i++) {
                                                        const dayDiv = document.createElement('div');
                                                        dayDiv.style.width = '14.28%';
                                                        dayDiv.style.height = '40px';
                                                        dayDiv.classList.add('d-flex', 'align-items-center', 'justify-content-center', 'rounded-circle', 'mb-1');

                                                        // Format date YYYY-MM-DD for comparison
                                                        // Note: month is 0-indexed, so +1. PadStart for leading zero.
                                                        const checkDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

                                                        dayDiv.innerText = i;

                                                        if (appointmentDates.includes(checkDate)) {
                                                            dayDiv.classList.add('bg-primary', 'text-white');
                                                            dayDiv.title = 'Appointment Scheduled';
                                                            dayDiv.style.cursor = 'pointer';
                                                        } else {
                                                            dayDiv.classList.add('text-dark');
                                                        }

                                                        calendarGrid.appendChild(dayDiv);
                                                    }
                                                }

                                                renderCalendar(currentDate);

                                                document.getElementById('prevMonth').addEventListener('click', () => {
                                                    currentDate.setMonth(currentDate.getMonth() - 1);
                                                    renderCalendar(currentDate);
                                                });

                                                document.getElementById('nextMonth').addEventListener('click', () => {
                                                    currentDate.setMonth(currentDate.getMonth() + 1);
                                                    renderCalendar(currentDate);
                                                });

                                                // --- Revenue Chart Logic ---
                                                const ctx = document.getElementById('revenueChart').getContext('2d');
                                                const monthlyRevenue = @json($monthlyRevenue ?? []);

                                                new Chart(ctx, {
                                                    type: 'bar', // or 'line'
                                                    data: {
                                                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                                        datasets: [{
                                                            label: 'Revenue (₹)',
                                                            data: monthlyRevenue,
                                                            backgroundColor: 'rgba(26, 75, 140, 0.7)',
                                                            borderColor: '#1a4b8c',
                                                            borderWidth: 0,
                                                            borderRadius: 5,
                                                            hoverBackgroundColor: '#0d6efd'
                                                        }]
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        plugins: {
                                                            legend: {
                                                                display: false
                                                            }
                                                        },
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true,
                                                                grid: {
                                                                    display: true,
                                                                    drawBorder: false,
                                                                    color: '#f0f0f0'
                                                                },
                                                                ticks: {
                                                                    color: '#6c757d',
                                                                    font: { family: 'Poppins' }
                                                                }
                                                            },
                                                            x: {
                                                                grid: {
                                                                    display: false
                                                                },
                                                                ticks: {
                                                                    color: '#6c757d',
                                                                    font: { family: 'Poppins' }
                                                                }
                                                            }
                                                        }
                                                    }
                                                });
                                            });
                                        </script>
                                    @endpush
                                @endif

                        </div>


                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
@endsection