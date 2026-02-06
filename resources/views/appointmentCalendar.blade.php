@extends('layout')
@section('title', "Appointment Calendar - Easy Doctor")

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
        // Prepare calendar events
        $calendarEvents = $appointments->map(function ($appointment) {
            return [
                'title' => $appointment->title ?? 'Appointment',
                'start' => $appointment->date, // Assuming appointment has a 'date' field
                'url' => "/admin/manage-appointment?id=" . $appointment->id,
            ];
        });
    @endphp
    <style>
        /* Fix for calendar "today" highlight - ensure it's a perfect circle */
        .fc .fc-daygrid-day.fc-day-today {
            background-color: transparent !important;
        }

        .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
            background-color: #0d6efd;
            /* Bootstrap primary or specific blue from screenshot */
            color: #fff !important;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 4px auto 0 auto;
            /* Center horizontally */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            text-decoration: none;
        }

        /* Ensure non-today numbers are also positioned correctly to align */
        .fc .fc-daygrid-day-number {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 4px auto 0 auto;
            text-decoration: none;
            color: #333;
        }

        /* Remove default underline */
        .fc-daygrid-day-number:hover {
            text-decoration: none;
            background-color: #f0f0f0;
            border-radius: 50%;
        }
    </style>
    <section class="task__section">
        <div class="text">
            Appointment Calendar

            @if(in_array('permission_add', $roleArray) || in_array('All', $roleArray))
                <div class="btn-group">
                    <a href="/admin/manage-appointment" class="btn btn-default btn-sm">
                        <i class="bx bx-plus"></i> <span>Add New</span>
                    </a>
                </div>
            @endif
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="bg-white rounded p-3" id="calendar"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Appointment Creation/Editing -->
    <!--<div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Schedule Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="appointmentForm" action="/admin/manage-appointment" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="appointmentTitle">Event Name</label>
                            <input type="text" class="form-control" id="appointmentTitle" name="title" placeholder="Enter appointment title">
                        </div>
                        <div class="form-group">
                            <label for="appointmentDate">Date</label>
                            <input type="date" class="form-control" id="appointmentDate" name="date">
                        </div>
                        <div class="form-group">
                            <label for="appointmentTime">Time</label>
                            <input type="time" class="form-control" id="appointmentTime" name="time">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Enter appointment details"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>-->

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

    <!-- Add FullCalendar and Bootstrap Modal dependencies -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>

@endsection