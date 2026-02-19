@extends('frontend.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/css/dashboard-modern.css') }}">
    <style>
        .stat-card-modern {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stat-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(26, 75, 140, 0.08);
            border-color: #ddecff;
        }

        .stat-card-modern .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .icon-blue {
            background: #eef5ff;
            color: #1a4b8c;
        }

        .icon-green {
            background: #e6fffa;
            color: #065f46;
        }

        .icon-yellow {
            background: #fff9e6;
            color: #856404;
        }

        .icon-purple {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .stat-card-modern h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #1a4b8c !important;
        }

        .stat-card-modern p {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 0;
            font-weight: 500;
        }

        .stat-card-modern .trending {
            font-size: 12px;
            margin-top: 12px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .section-header-modern {
            font-weight: 700;
            color: #1a4b8c;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-modern-container {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }

        .calendar-modern {
            background: #fff;
            min-height: 350px;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #f0f0f0;
        }
    </style>

    <main class="dashboard-container">
        <section class="pt-100 pb-40" style="background: #f8fafc;">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    <!-- Content Area -->
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="section-header-modern mb-0">Overview</h4>
                                @if(Auth::user()->role == 4)
                                    <a href="/manage-slots" class="btn btn-pill-modern btn-primary text-white"><i
                                            class="fas fa-clock pe-1"></i> Availability</a>
                                @endif
                            </div>

                            <!-- Stat Cards Row -->
                            <div class="row mb-4">
                                @if(Auth::user()->role == 5)
                                    <!-- Patient Stats -->
                                    <div class="col-md-4 mb-4">
                                        <div class="stat-card-modern">
                                            <div class="icon-box icon-blue"><i class="fas fa-calendar-check"></i></div>
                                            <h3>{{ $appointmentsCount ?? 0 }}</h3>
                                            <p>Total Appointments</p>
                                            <div class="trending text-primary"><i class="fas fa-clock"></i>
                                                {{ $todayAppointmentsCount ?? 0 }} for Today</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="stat-card-modern">
                                            <div class="icon-box icon-green"><i class="fas fa-check-double"></i></div>
                                            <h3>{{ $completedAppointmentsCount ?? 0 }}</h3>
                                            <p>Completed Sessions</p>
                                            <div class="trending text-success"><i class="fas fa-history"></i>
                                                {{ $todayCompletedCount ?? 0 }} Finished Today</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="stat-card-modern">
                                            <div class="icon-box icon-purple"><i class="fas fa-credit-card"></i></div>
                                            <h3>{{ $billingAmount ?? 0 }}</h3>
                                            <p>Total Spent</p>
                                            <div class="trending text-purple"><i class="fas fa-receipt"></i> From
                                                {{ $appointmentsCount ?? 0 }} appointments</div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Doctor Stats -->
                                    <div class="col-md-4 mb-4">
                                        <div class="stat-card-modern">
                                            <div class="icon-box icon-blue"><i class="fas fa-user-md"></i></div>
                                            <h3>{{ $appointmentsCount ?? 0 }}</h3>
                                            <p>Total Consultations</p>
                                            <div class="trending text-primary"><i class="fas fa-users"></i>
                                                {{ $todayAppointmentsCount ?? 0 }} for Today</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="stat-card-modern">
                                            <div class="icon-box icon-green"><i class="fas fa-user-friends"></i></div>
                                            <h3>{{ $patientsCount ?? 0 }}</h3>
                                            <p>Unique Patients</p>
                                            <div class="trending text-success"><i class="fas fa-heart"></i> Growing Community
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="stat-card-modern">
                                            <div class="icon-box icon-purple"><i class="fas fa-wallet"></i></div>
                                            <h3>{{ $walletAmount ?? 0 }}</h3>
                                            <p>Wallet Balance</p>
                                            <div class="trending text-purple"><i class="fas fa-chart-line"></i> Revenue:
                                                {{ $totalRevenue ?? 0 }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row">
                                <!-- Left Column: Calendar & Content -->
                                <div class="col-lg-7">
                                    <div class="calendar-modern">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="mb-0 font-weight-bold" style="color: #1a4b8c;">Schedule</h5>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-xs btn-outline-primary rounded-circle" id="prevMonth"
                                                    style="width: 32px; height: 32px; padding: 0;"><i
                                                        class="fas fa-chevron-left"></i></button>
                                                <span id="monthYear" class="mx-2 small font-weight-bold"
                                                    style="min-width: 100px; text-align: center; border: 1px solid #eef5ff; border-radius: 20px; padding: 4px 12px; background: #eef5ff; color: #1a4b8c;"></span>
                                                <button class="btn btn-xs btn-outline-primary rounded-circle" id="nextMonth"
                                                    style="width: 32px; height: 32px; padding: 0;"><i
                                                        class="fas fa-chevron-right"></i></button>
                                            </div>
                                        </div>

                                        <div
                                            class="d-flex justify-content-between text-muted small mb-3 text-center font-weight-bold">
                                            @foreach(['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                                                <div style="width: 14%">{{ $day }}</div>
                                            @endforeach
                                        </div>
                                        <div class="calendar-grid d-flex flex-wrap" id="calendarGrid"></div>
                                    </div>

                                    @if(Auth::user()->role == 4)
                                        <!-- Revenue Chart for Doctors -->
                                        <div class="card-modern p-4 my-4">
                                            <h5 class="section-header-modern small mb-3">Revenue Analytics ({{ date('Y') }})
                                            </h5>
                                            <canvas id="revenueChart" style="width:100%; height:200px;"></canvas>
                                        </div>
                                    @endif
                                </div>

                                <!-- Right Column: Recent Activity -->
                                <div class="col-lg-5">
                                    <div class="card-modern overflow-hidden d-flex flex-column" style="height: 96.5%;">
                                        <div class="p-4 border-bottom bg-light">
                                            <h5 class="mb-0 font-weight-bold" style="color: #1a4b8c;"><i
                                                    class="fas fa-history me-2"></i> Recent Sessions</h5>
                                        </div>
                                        <div class="flex-grow-1 overflow-auto p-0" style="max-height: 531px;">
                                            @forelse($recentAppointments as $appt)
                                                <div class="p-3 border-bottom hover-bg-light transition-all">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <h6 class="mb-1 font-weight-bold small">
                                                                @if(Auth::user()->role == 4)
                                                                    {{ $appt->patient_first_name }} {{ $appt->patient_last_name }}
                                                                @else
                                                                    Dr. {{ $appt->doctor_first_name }} {{ $appt->doctor_last_name }}
                                                                @endif
                                                            </h6>
                                                            <span class="text-muted" style="font-size: 11px;"><i
                                                                    class="far fa-clock me-1"></i> {{ $appt->date }} at
                                                                {{ $appt->time }}</span>
                                                        </div>
                                                        <span
                                                            class="badge {{ $appt->status == 3 ? 'badge-soft-success' : ($appt->status == 1 ? 'badge-soft-primary' : 'badge-soft-warning') }} badge-pill-modern">
                                                            {{ $appt->status == 3 ? 'Completed' : ($appt->status == 1 ? 'Confirmed' : 'Pending') }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                                        <span
                                                            class="font-weight-bold text-primary">${{ $appt->fees }}</span>
                                                        <a href="/messages?recipient={{ Auth::user()->role == 4 ? $appt->pid : $appt->did }}"
                                                            class="btn btn-xs btn-outline-primary rounded-pill py-0 px-2"
                                                            style="font-size: 12px;    padding: 8px 28px !important;">Chat</a>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="p-5 text-center text-muted">
                                                    <i class="fas fa-calendar-times mb-2 opacity-50"
                                                        style="font-size: 2rem;"></i>
                                                    <p class="small mb-0">No recent activity found.</p>
                                                </div>
                                            @endforelse
                                        </div>
                                        <div class="p-3 bg-light text-center">
                                            <a href="/appointments"
                                                class="text-primary small font-weight-bold text-decoration-none">View All
                                                Appointments <i class="fas fa-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // --- Calendar Logic ---
                const calendarGrid = document.getElementById('calendarGrid');
                const monthYearLabel = document.getElementById('monthYear');
                let currentDate = new Date();
                const appointmentDates = @json($appointmentDates ?? []);

                function renderCalendar(date) {
                    const year = date.getFullYear();
                    const month = date.getMonth();
                    const firstDay = new Date(year, month, 1);
                    const lastDay = new Date(year, month + 1, 0);
                    const startDayIndex = firstDay.getDay();
                    const totalDays = lastDay.getDate();

                    monthYearLabel.innerText = date.toLocaleDateString('default', { month: 'short', year: 'numeric' });
                    calendarGrid.innerHTML = '';

                    for (let i = 0; i < startDayIndex; i++) {
                        const emptyDiv = document.createElement('div');
                        emptyDiv.style.width = '38px';
                        emptyDiv.style.height = '38px';
                        calendarGrid.appendChild(emptyDiv);
                    }

                    for (let i = 1; i <= totalDays; i++) {
                        const dayDiv = document.createElement('div');
                        dayDiv.style.width = '38px';
                        dayDiv.style.height = '38px';
                        dayDiv.classList.add('d-flex', 'align-items-center', 'justify-content-center', 'rounded-circle', 'mb-2', 'small', 'cursor-pointer', 'transition-all');

                        const checkDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                        dayDiv.innerText = i;
                        dayDiv.style.fontWeight = '600';

                        if (appointmentDates.includes(checkDate)) {
                            dayDiv.style.background = '#1a4b8c';
                            dayDiv.style.color = '#fff';
                            dayDiv.style.boxShadow = '0 4px 8px rgba(26, 75, 140, 0.3)';
                            dayDiv.title = 'Session Scheduled';
                        } else {
                            dayDiv.style.color = '#4a5764';
                            dayDiv.onmouseover = () => dayDiv.style.background = '#f1f5f9';
                            dayDiv.onmouseout = () => dayDiv.style.background = 'transparent';
                        }

                        // Today highlighting
                        const todayStr = new Date().toISOString().split('T')[0];
                        if (checkDate === todayStr && !appointmentDates.includes(checkDate)) {
                            dayDiv.style.border = '2px solid #1a4b8c';
                            dayDiv.style.color = '#1a4b8c';
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

                @if(Auth::user()->role == 4)
                    // --- Revenue Chart Logic for Doctors ---
                    const ctx = document.getElementById('revenueChart').getContext('2d');
                    const monthlyRevenue = @json($monthlyRevenue ?? []);

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            datasets: [{
                                label: 'Revenue ($)',
                                data: monthlyRevenue,
                                backgroundColor: 'rgba(26, 75, 140, 0.1)',
                                borderColor: '#1a4b8c',
                                borderWidth: 2,
                                borderRadius: 6,
                                hoverBackgroundColor: '#1a4b8c'
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { beginAtZero: true, grid: { display: false }, ticks: { font: { size: 10 } } },
                                x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                            }
                        }
                    });
                @endif
                    });
        </script>
    @endpush
@endsection