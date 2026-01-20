@php
    $company = session('companies');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/public/assets/frontend/img/fevicon.jpg" type="image/x-icon">

    <title>@yield('title', 'Dashboard - Easy Doctor')</title>

    <!--Bootstrap 5 library-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.datatables.net/1.13.0/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    @include('inc.loginHeadLink')

    <!-- Admin UI/UX Enhancements -->
    @if(Request::segment(1) == 'admin' && Request::segment(2) != 'login' && Request::segment(2) != 'register')
        <link rel="stylesheet" href="{{ asset('/public/assets/css/admin-enhancements.css') }}">
    @endif

    <!-- Js Library -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')

</head>

<body class="bg-light">
    @if(Request::segment(2) != 'login' && Request::segment(2) != 'register' && Request::segment(2) != 'forgot-password')
        <nav class="navbar navbar-white bg-white shadow-sm border-bootm-1 fixed-top">
            <div class="container-fluid">
                <div class="left-side-header">
                    @if(isset($_COOKIE['sidebarOpen']) && $_COOKIE['sidebarOpen'] == 'open')
                        <i class="bx bx-menu-alt-right" id="btn"></i>
                    @else
                        <i class="bx bx-menu" id="btn"></i>
                    @endif
                    <a class="navbar-brand" href="/admin">{{ $company->name ?? '' }}</a>
                </div>
                <ul class="header-icon d-flex align-items-center">
                    <!-- Notification Icon -->
                    <li class="position-relative">
                        <a href="javascript:void(0)" class="budge-warning" id="notifDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bx bx-bell"></i>
                            <span
                                class="badge position-absolute top-0 start-100 translate-middle badge-warning bg-danger rounded-circle p-1 d-none"
                                id="notifBadge">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-0 shadow border-0" aria-labelledby="notifDropdown"
                            style="width: 320px; max-height: 400px; overflow-y: auto;">
                            <li class="p-3 border-bottom bg-light">
                                <h6 class="m-0">Notifications</h6>
                            </li>
                            <div id="notifList">
                                <li class="p-3 text-center text-muted">Loading...</li>
                            </div>
                        </ul>
                    </li>
                    <!-- Settings Icon -->
                    <li>
                        <a href="/admin/my-profile/user/{{ Auth::User()->id ?? '' }}" class="budge-warning"
                            aria-label="My Account" data-bs-toggle="tooltip" data-bs-placement="bottom" title="My Account">
                            <i class="bx bx-user"></i>
                        </a>
                    </li>
                    <!-- Sign-out Icon -->
                    <li class="signout">
                        <a href="/admin/logout" class="budge-warning" aria-label="Sign Out" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Sign Out">
                            <i class="bx bx-log-out"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    @endif

    @if(Auth::check())

        @include('inc.sidebar')

    @endif

    @yield('content')

    @if ($errors->any())
        <div class="response-msg">
            <div class="alert alert-black shadow" role="alert">
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (Session::has('success'))
        <div class="response-msg">
            <div class="alert alert-black shadow" role="alert">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif

    @if (Session::has('error'))
        <div class="response-msg">
            <div class="alert alert-black shadow" role="alert">
                {{ Session::get('error') }}
            </div>
        </div>
    @endif

    @include('inc.script')

    <script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#lists').DataTable({
                "order": [],
            });

            $("#leadslists_filter label input").attr("placeholder", "Search..");
            $("#lists_filter label input").attr("placeholder", "Search..");
        });
        $('#leadslists').DataTable({
            "columnDefs": [
                { "orderable": false, "targets": 0 } // Disable sorting on first column
            ]
        });
    </script>

    @stack('scripts')

    <script>
        $(document).ready(function () {
            // Fetch notifications on page load
            fetchNotifications();

            // Refresh every 60 seconds
            setInterval(fetchNotifications, 60000);

            function fetchNotifications() {
                $.ajax({
                    url: '/admin/notifications/fetch',
                    method: 'GET',
                    success: function (response) {
                        // Update Badge
                        if (response.unread_count > 0) {
                            $('#notifBadge').removeClass('d-none');
                        } else {
                            $('#notifBadge').addClass('d-none');
                        }

                        // Update List
                        let html = '';
                        if (response.notifications.length > 0) {
                            response.notifications.forEach(function (notif) {
                                html += `
                                    <li>
                                        <a class="dropdown-item p-3 border-bottom d-flex align-items-start" href="#">
                                            <div class="me-3">
                                                <div class="avatar-sm bg-light rounded-circle text-center">
                                                    <i class="bx bx-info-circle fs-4 text-primary mt-2"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">${notif.title}</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">${notif.message}</p>
                                                    <p class="mb-0"><i class="bx bx-time"></i> ${new Date(notif.created_at).toLocaleTimeString()}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                `;
                            });
                        } else {
                            html = '<li class="p-3 text-center text-muted">No new notifications</li>';
                        }
                        $('#notifList').html(html);
                    }
                });
            }
        });
    </script>

</body>

</html>