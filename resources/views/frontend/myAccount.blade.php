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
                            <h5>overview</h5>

                            <div class="row">

                                @if(Auth::user()->role == 5)
                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview">
                                            <div class="icon"><i class="fas fa-handshake" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>Total Appointment</p>
                                                <h3>{{ $appointmentsCount ?? 0 }}</h3>
                                                <p>{{ $todayAppointmentsCount ?? 0 }} Today</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview bg-success">
                                            <div class="icon"><i class="far fa-check-circle" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>Done Appointment</p>
                                                <h3>{{ $completedAppointmentsCount ?? 0 }}</h3>
                                                <p>{{ $todayCompletedCount ?? 0 }} Today</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview bg-warning">
                                            <div class="icon"><i class="far fa-file-alt" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>Pending Appointment</p>
                                                <h3>{{ $pendingAppointmentsCount ?? 0 }}</h3>
                                                <p>{{ $todayPendingCount ?? 0 }} Today</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview bg-purple">
                                            <div class="icon"><i class="fas fa-hand-holding-usd" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>Total Payment</p>
                                                <h3>{{ $billingAmount ?? 0 }}</h3>
                                                <p>{{ $todayPaymentCount ?? 0 }} Today</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                        <div class="dashboard_overview bg-info">
                                            <div class="icon"><i class="fal fa-stars" aria-hidden="true"></i></div>
                                            <div class="text">
                                                <p>Total Review</p>
                                                <h3>{{ $favoritesCount ?? 0 }}</h3>
                                                <p>0 Today</p>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>

                                @else

                                        <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                            <div class="dashboard_overview">
                                                <div class="icon"><i class="fas fa-handshake" aria-hidden="true"></i></div>
                                                <div class="text">
                                                    <p>Total Appointment</p>
                                                    <h3>{{ $appointmentsCount ?? 0 }}</h3>
                                                    <p>{{ $todayAppointmentsCount ?? 0 }} Today</p>
                                                </div>
                                                <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                            <div class="dashboard_overview bg-success">
                                                <div class="icon"><i class="fas fa-users" aria-hidden="true"></i></div>
                                                <div class="text">
                                                    <p>My Patients</p>
                                                    <h3>{{ $patientsCount ?? 0 }}</h3>
                                                    <p>Unique Patients</p>
                                                </div>
                                                <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                            <div class="dashboard_overview bg-purple">
                                                <div class="icon"><i class="fas fa-wallet" aria-hidden="true"></i></div>
                                                <div class="text">
                                                    <p>Wallet Balance</p>
                                                    <h3>{{ $walletAmount ?? 0 }}</h3>
                                                    <p>Total Revenue: {{ $totalRevenue ?? 0 }}</p>
                                                </div>
                                                <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                            </div>
                                            <div class="bg-icon"><i class="fas fa-heartbeat"></i></div>
                                        </div>
                                    </div>

                                    <!-- New Section: Calendar & Revenue Graph -->
                                    <div class="row mt-4">
                                        <!-- Calendar Section -->
                                        <div class="col-lg-12 mb-4">
                                            <div class="card shadow-sm border-0">
                                                <div class="card-header bg-white">
                                                    <h5 class="mb-0">Upcoming Appointments</h5>
                                                </div>
                                                <div class="card-body">
                                                    <!-- Simple Custom Calendar UI -->
                                                    <div class="custom-calendar">
                                                        <div
                                                            class="calendar-header d-flex justify-content-between align-items-center mb-3">
                                                            <button class="btn btn-sm btn-outline-primary" id="prevMonth"
                                                                style="padding: 8px 15px 8px 13px;"><i
                                                                    class="fas fa-chevron-left"></i></button>
                                                            <h6 class="mb-0" id="monthYear"></h6>
                                                            <button class="btn btn-sm btn-outline-primary" id="nextMonth"
                                                                style="padding: 8px 13px 8px 15px;"><i
                                                                    class="fas fa-chevron-right"></i></button>
                                                        </div>
                                                        <div
                                                            class="calendar-days d-flex justify-content-between text-muted small mb-2 text-center font-weight-bold">
                                                            <div style="width: 14%">Sun</div>
                                                            <div style="width: 14%">Mon</div>
                                                            <div style="width: 14%">Tue</div>
                                                            <div style="width: 14%">Wed</div>
                                                            <div style="width: 14%">Thu</div>
                                                            <div style="width: 14%">Fri</div>
                                                            <div style="width: 14%">Sat</div>
                                                        </div>
                                                        <div class="calendar-grid d-flex flex-wrap" id="calendarGrid">
                                                            <!-- Days generated by JS -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Revenue Graph Section -->
                                        <div class="col-lg-12 mb-4">
                                            <div class="card shadow-sm border-0 h-100">
                                                <div class="card-header bg-white">
                                                    <h5 class="mb-0">Monthly Revenue ({{ date('Y') }})</h5>
                                                </div>
                                                <div class="card-body">
                                                    <canvas id="revenueChart" style="width:100%; height:300px;"></canvas>
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
                                                            label: 'Revenue ($)',
                                                            data: monthlyRevenue,
                                                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                                            borderColor: 'rgba(54, 162, 235, 1)',
                                                            borderWidth: 1
                                                        }]
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true
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