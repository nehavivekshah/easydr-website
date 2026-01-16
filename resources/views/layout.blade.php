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
                        <a href="#" class="budge-warning" aria-label="Notifications" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notifications">
                            <i class="bx bx-bell"></i>
                            <!-- Notification Badge -->
                            <!--<span class="badge position-absolute top-0 start-100 translate-middle badge-warning" style="background-color: var(--color-second); color: var(--color-white); border-radius: 50%; font-size: 0.75rem; padding: 0.2rem 0.35rem;">
                                3
                            </span>-->
                        </a>
                    </li>
                    <!-- Settings Icon -->
                    <li>
                        <a href="/admin/my-profile/user/{{ Auth::User()->id ?? '' }}" class="budge-warning" aria-label="My Account" data-bs-toggle="tooltip" data-bs-placement="bottom" title="My Account">
                            <i class="bx bx-user"></i>
                        </a>
                    </li>
                    <!-- Sign-out Icon -->
                    <li class="signout">
                        <a href="/admin/logout" class="budge-warning" aria-label="Sign Out" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Sign Out">
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
            $(document).ready(function() {
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
        
    </body>

</html>