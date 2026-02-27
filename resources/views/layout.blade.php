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

<body class="easy-doctor-backend">
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

                    <!-- Global Search Bar -->
                    <div class="global-search d-none d-md-flex align-items-center ms-4">
                        <i class="bx bx-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Search Patients, Appointments...">
                    </div>
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
                    <!-- Profile Dropdown -->
                    <li class="profile-dropdown dropdown ms-3">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-circle">
                                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                            </div>
                            <div class="profile-info d-none d-md-block ms-2 text-start">
                                <span class="d-block fw-bold profile-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                                <span
                                    class="d-block text-muted profile-role small">{{ Auth::user()->roles->role ?? 'Administrator' }}</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 profile-menu"
                            aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="/admin/my-profile/user/{{ Auth::User()->id ?? '' }}"><i
                                        class="bx bx-user me-2"></i> My Profile</a></li>
                            <!--<li><a class="dropdown-item" href="/admin/settings"><i class="bx bx-cog me-2"></i> Settings</a></li>-->
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="/admin/logout"><i class="bx bx-log-out me-2"></i>
                                    Sign Out</a></li>
                        </ul>
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

    {{-- =====================================================
    Global Export Utility (CSV / PDF for all pages)
    Works on any table with id="lists" or nearest <table>
        ===================================================== --}}
        <script>
            (function () {
                /* ---------- helpers ---------- */

                /** Sanitise a cell value for CSV */
                function csvCell(val) {
                    val = val.replace(/"/g, '""').replace(/\s+/g, ' ').trim();
                    return '"' + val + '"';
                }

                /** Return visible text of a cell, skipping img / action icons */
                function cellText(td) {
                    // Clone so we don't mutate the DOM
                    var clone = td.cloneNode(true);
                    // Remove action-button links (edit/delete icons)
                    clone.querySelectorAll('a[class*="btn-tbl"], button, .badge').forEach(function (el) { el.remove(); });
                    return clone.innerText || clone.textContent || '';
                }

                /** Build CSV string from a <table> — uses DT API when available */
                function buildCSV(table) {
                    var rows = [];
                    var ths = table.querySelectorAll('thead tr th');

                    // Determine columns to skip
                    var skipCols = [];
                    ths.forEach(function (th, i) {
                        var h = (th.innerText || th.textContent || '').trim().toLowerCase();
                        if (h === 'action' || h === '' || h === '#' || h === 'photo' || h === 'sr. no.' || h === 'sr.no.') skipCols.push(i);
                    });

                    // Header row
                    var headerCols = [];
                    ths.forEach(function (th, i) {
                        if (!skipCols.includes(i)) headerCols.push(csvCell(th.innerText || th.textContent || ''));
                    });
                    rows.push(headerCols.join(','));

                    // Use DataTables API for search-filtered rows (all pages)
                    var tableId = table.id;
                    var dtActive = (window.$ && $.fn && $.fn.DataTable && tableId && $.fn.DataTable.isDataTable('#' + tableId));
                    var trElements = [];
                    if (dtActive) {
                        $('#' + tableId).DataTable().rows({ search: 'applied' }).nodes().each(function (tr) { trElements.push(tr); });
                    } else {
                        table.querySelectorAll('tbody tr').forEach(function (tr) { trElements.push(tr); });
                    }

                    trElements.forEach(function (tr) {
                        if (tr.querySelector('td[colspan]')) return;
                        var tds = tr.querySelectorAll('td');
                        var cells = [];
                        tds.forEach(function (td, i) {
                            if (!skipCols.includes(i)) cells.push(csvCell(cellText(td)));
                        });
                        if (cells.length) rows.push(cells.join(','));
                    });
                    return rows.join('\n');
                }


                /** Trigger a CSV file download */
                function downloadCSV(csv, filename) {
                    var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                    var url = URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = filename + '.csv';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                }

                /** Open a print-preview window as a simple PDF substitute */
                function printAsPDF(table, title) {
                    var ths = table.querySelectorAll('thead tr th');
                    var skipCols = [];
                    ths.forEach(function (th, i) {
                        var h = (th.innerText || th.textContent || '').trim().toLowerCase();
                        if (h === 'action' || h === '' || h === 'photo') skipCols.push(i);
                    });
                    var headerHtml = '<tr>';
                    ths.forEach(function (th, i) {
                        if (!skipCols.includes(i)) headerHtml += '<th style="background:#2563eb;color:#fff;padding:8px 12px;text-align:left;">' + (th.innerText || th.textContent || '') + '</th>';
                    });
                    headerHtml += '</tr>';

                    var bodyHtml = '';
                    var trs = table.querySelectorAll('tbody tr');
                    var odd = true;
                    trs.forEach(function (tr) {
                        if (tr.querySelector('td[colspan]') || tr.style.display === 'none') return;
                        var tds = tr.querySelectorAll('td');
                        var bg = odd ? '#f8faff' : '#fff'; odd = !odd;
                        bodyHtml += '<tr style="background:' + bg + '">';
                        tds.forEach(function (td, i) {
                            if (!skipCols.includes(i)) bodyHtml += '<td style="padding:7px 12px;border-bottom:1px solid #e5e7eb;">' + cellText(td) + '</td>';
                        });
                        bodyHtml += '</tr>';
                    });

                    var w = window.open('', '_blank');
                    w.document.write(
                        '<!DOCTYPE html><html><head><meta charset="utf-8"><title>' + title + '</title>' +
                        '<style>body{font-family:Arial,sans-serif;font-size:13px;margin:24px}table{width:100%;border-collapse:collapse}h2{color:#1d4ed8}</style>' +
                        '</head><body><h2>' + title + '</h2><table>' + headerHtml + bodyHtml + '</table></body></html>'
                    );
                    w.document.close();
                    w.focus();
                    setTimeout(function () { w.print(); }, 400);
                }

                /* ---------- wire up ---------- */
                document.addEventListener('click', function (e) {
                    var btn = e.target.closest('.btn-export');
                    if (!btn) return;

                    var isPDF = (btn.title || btn.getAttribute('data-export') || '').toLowerCase().includes('pdf');
                    var table = document.getElementById('lists') || document.querySelector('table');
                    if (!table) { alert('No table found to export.'); return; }

                    var title = document.title.replace(/\s*[-|].*$/, '').trim() || 'export';

                    // Show brief loading state on button
                    var origHtml = btn.innerHTML;
                    btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Exporting…';
                    btn.disabled = true;

                    setTimeout(function () {
                        try {
                            if (isPDF) {
                                printAsPDF(table, title);
                            } else {
                                downloadCSV(buildCSV(table), title.replace(/\s+/g, '_'));
                            }
                        } catch (ex) {
                            console.error('Export error:', ex);
                            alert('Export failed. Please try again.');
                        }
                        btn.innerHTML = origHtml;
                        btn.disabled = false;
                    }, 150);
                });
            })();
        </script>

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