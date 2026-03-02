@extends('layout')
@section('title', 'Appointment Calendar - Easy Doctor')

@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <style>
        .page-header-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        /* ---- Calendar card ---- */
        .calendar-card {
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
            overflow: hidden;
            background: #fff;
        }

        .calendar-card .card-body {
            padding: 20px;
        }

        /* ---- FullCalendar overrides ---- */
        .fc .fc-toolbar-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1e293b;
        }

        .fc .fc-button {
            border-radius: 50px !important;
            padding: 5px 14px !important;
            font-size: .82rem !important;
            font-weight: 600 !important;
            border: none !important;
        }

        .fc .fc-button-primary {
            background: linear-gradient(135deg, #1d4ed8, #2563eb) !important;
            box-shadow: 0 3px 10px rgba(37, 99, 235, .25) !important;
        }

        .fc .fc-button-primary:hover {
            background: linear-gradient(135deg, #1e40af, #1d4ed8) !important;
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active {
            background: #1d4ed8 !important;
        }

        .fc .fc-col-header-cell-cushion {
            font-size: .78rem;
            font-weight: 700;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: .05em;
            text-decoration: none;
        }

        .fc .fc-daygrid-day-number {
            font-size: .82rem;
            font-weight: 600;
            color: #374151;
            text-decoration: none;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background: #eff6ff !important;
        }

        .fc .fc-event {
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
            border: none !important;
            border-radius: 6px !important;
            font-size: .76rem !important;
            font-weight: 600 !important;
            padding: 2px 6px !important;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(37, 99, 235, .3);
        }

        .fc .fc-event:hover {
            opacity: .88;
        }

        .fc .fc-daygrid-day-frame {
            min-height: 80px;
        }

        .fc thead {
            background: #f8f9fb;
        }

        .fc .fc-scrollgrid {
            border-radius: 10px;
            overflow: hidden;
        }

        .fc .fc-scrollgrid,
        .fc .fc-scrollgrid td,
        .fc .fc-scrollgrid th {
            border-color: #e5e7eb !important;
        }

        /* ---- Header btn ---- */
        .btn-add {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 9px 22px;
            font-weight: 600;
            font-size: .88rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, .3);
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-add:hover {
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            color: #fff;
            transform: translateY(-1px);
        }
    </style>
@endpush

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
        $canAdd = in_array('appointments_add', $roleArray) || in_array('All', $roleArray);

        // Prepare calendar events
        $calendarEvents = $appointments->map(function ($appointment) {
            return [
                'title' => $appointment->title ?? 'Appointment',
                'start' => $appointment->date,
                'url' => '/admin/manage-appointment?id=' . $appointment->id,
            ];
        });
    @endphp

    <section class="task__section">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">Appointment Calendar</h4>
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/appointment-history"
                                    class="text-decoration-none text-muted">Appointments</a></li>
                            <li class="breadcrumb-item active text-muted">Calendar</li>
                        </ol>
                    </nav>
                </div>
                @if($canAdd)
                    <a href="/admin/manage-appointment" class="btn-add">
                        <i class="bx bx-plus"></i> Add New
                    </a>
                @endif
            </div>

            {{-- Calendar Card --}}
            <div class="calendar-card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($calendarEvents),
                dateClick: function (info) {
                    // Open the modal on date click
                    //$('#appointmentModal').modal('show');
                    //document.getElementById('appointmentDate').value = info.dateStr;
                }
            });
            calendar.render();
        });
    </script>
@endpush