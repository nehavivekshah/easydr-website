@php
    $company = session('companies');
    $roles = session('roles');
    $roleArray = explode(',', ($roles->features ?? ''));
@endphp
<div class="sidebar @if(isset($_COOKIE['sidebarOpen']) && $_COOKIE['sidebarOpen'] == 'open') open @endif">
    <ul class="nav-list" id="accordion">
        <li>
            <a href="/admin/home">
                <i class="bx bx-grid-alt"></i>
                <span class="link_name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>

        <!--Appointments Management-->
        @if(in_array('appointments', $roleArray) || in_array('All', $roleArray))
            <li>
                <!-- Appointments Main Menu -->
                <a href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#appointments">
                    <i class="bx bx-calendar-check"></i> <!-- Updated icon for better clarity -->
                    <span class="link_name">Appointments</span>
                    <span class="tooltip">Manage Appointments</span> <!-- Improved tooltip -->
                </a>

                <!-- Appointments Submenu -->
                <div id="appointments" class="collapse 
                        @if(
                            in_array(Request::segment(2), [
                                'upcoming-appointments',
                                'appointment-history',
                                'appointment-calendar',
                                'manage-appointment'
                            ])
                        ) show @endif" data-bs-parent="#accordion">

                    <ul class="sb_submenu">

                        <li class="submenu-title divider">Manage Appointment Tabs</li>

                        <!-- Manage Appointments -->
                        <li>
                            <a href="/admin/manage-appointment">
                                <i class="bx bx-plus"></i>
                                New Appointment
                            </a>
                        </li>

                        <!-- Upcoming Appointments -->
                        <li>
                            <a href="/admin/upcoming-appointments">
                                <i class="bx bx-time"></i> <!-- Icon for upcoming appointments -->
                                Upcoming Appointments<!-- Clearer label -->
                            </a>
                        </li>

                        <!-- Appointment Calendar -->
                        <li>
                            <a href="/admin/appointment-calendar">
                                <i class="bx bx-calendar"></i> <!-- Icon for calendar -->
                                Appointment Calendar <!-- Clearer label -->
                            </a>
                        </li>

                        <!-- Appointment History -->
                        <li>
                            <a href="/admin/appointment-history">
                                <i class="bx bx-history"></i> <!-- Icon for history -->
                                Appointment History <!-- Clearer label -->
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if(in_array('patients', $roleArray) || in_array('All', $roleArray))
            <li>
                <!-- Patient Management Main Menu -->
                <a href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#patientManagement">
                    <i class="bx bx-user-circle"></i> <!-- Updated icon for better clarity -->
                    <span class="link_name">Patient Management</span>
                    <span class="tooltip">Manage Patients and Records</span> <!-- Improved tooltip -->
                </a>

                <!-- Patient Management Submenu -->
                <div id="patientManagement" class="collapse 
                        @if(
                            in_array(Request::segment(2), [
                                'patient-directory',
                                'patient-history',
                                'medical-records',
                                'patient-health-card',
                                'patient-appointment-history',
                                'patient-reports',
                                'patient-statistics'
                            ]) || Request::segment(3) == 'patient-directory'
                        ) show @endif" data-bs-parent="#accordion">

                    <ul class="sb_submenu">

                        <li class="submenu-title divider">Manage Patient Tabs</li>

                        <!-- Patient Directory -->
                        <li>
                            <a href="/admin/users/patient-directory">
                                <i class="bx bx-group"></i> <!-- Icon for patient directory -->
                                Patient Profiles <!-- Clearer label -->
                            </a>
                        </li>

                        <!-- Patient Health Card -->
                        <li>
                            <a href="/admin/patient-health-card">
                                <i class="bx bx-id-card"></i>
                                Health Card
                            </a>
                        </li>

                        <!-- Appointment History -->
                        <li>
                            <a href="/admin/patient-appointment-history">
                                <i class="bx bx-calendar"></i> <!-- Icon for appointment history -->
                                App. History <!-- Clearer label -->
                            </a>
                        </li>

                        <!-- Reports Section -->
                        @if(in_array('reports', $roleArray) || in_array('All', $roleArray))
                            <li class="submenu-title divider">Reports & Analytics</li> <!-- Improved section title -->
                            <li>
                                <a href="/admin/patient-reports">
                                    <i class="bx bx-bar-chart"></i> <!-- Icon for reports -->
                                    Patient Reports <!-- Clearer label -->
                                </a>
                            </li>
                            <li>
                                <a href="/admin/patient-statistics">
                                    <i class="bx bx-line-chart"></i> <!-- Icon for statistics -->
                                    Patient Statistics <!-- Clearer label -->
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif

        @if(in_array('doctors', $roleArray) || in_array('All', $roleArray))
            <li>
                <!-- Doctor Management Main Menu -->
                <a href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#doctorManagement">
                    <i class="bx bx-heart-circle"></i> <!-- More appropriate doctor icon -->
                    <span class="link_name">Doctors</span>
                    <span class="tooltip">Manage Medical Staff</span> <!-- More descriptive tooltip -->
                </a>

                <!-- Doctor Management Submenu -->
                <div id="doctorManagement" class="collapse 
                        @if(
                            in_array(Request::segment(2), [
                                'doctor-availability',
                                'doctor-reviews',
                                'assigned-doctors',
                                'manage-slot',
                                'doctor-appointment-history',
                                'appointment-reports',
                                'revenue-reports',
                                'patient-statistics'
                            ]) || Request::segment(3) == 'doctor-directory'
                        ) show @endif" data-bs-parent="#accordion">

                    <ul class="sb_submenu">
                        <!-- Core Doctor Functions -->
                        <li class="submenu-title divider">Doctor Directory</li>
                        <li>
                            <a href="/admin/users/doctor-directory">
                                <i class="bx bx-id-card"></i>
                                Doctor Profiles
                            </a>
                        </li>

                        <li class="submenu-title divider">Scheduling</li>
                        <li>
                            <a href="/admin/manage-slot">
                                <i class="bx bx-plus"></i>
                                Add New Time Slot
                            </a>
                        </li>
                        <li>
                            <a href="/admin/doctor-availability">
                                <i class="bx bx-calendar"></i>
                                Availability Schedule
                            </a>
                        </li>

                        <li class="submenu-title divider">Assignments</li>
                        <li>
                            <a href="/admin/assigned-doctors">
                                <i class="bx bx-link"></i>
                                Assign F. Doctors
                            </a>
                        </li>

                        <!-- Historical Data -->
                        <li class="submenu-title divider">History</li>
                        <li>
                            <a href="/admin/doctor-appointment-history">
                                <i class="bx bx-history"></i>
                                Appointment History
                            </a>
                        </li>

                        <!-- Reports Section -->
                        @if(in_array('reports', $roleArray) || in_array('All', $roleArray))
                            <li class="submenu-title divider">Analytics & Reports</li>
                            <li>
                                <a href="/admin/appointment-reports">
                                    <i class="bx bx-file"></i>
                                    Appointment Reports
                                </a>
                            </li>
                            <li>
                                <a href="/admin/revenue-reports">
                                    <i class="bx bx-dollar"></i>
                                    Revenue Analysis
                                </a>
                            </li>
                            <li>
                                <a href="/admin/patient-statistics">
                                    <i class="bx bx-bar-chart-alt"></i>
                                    Patient Demographics
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif
        <!--Pharmacy Management-->
        @if(in_array('stores', $roleArray) || in_array('All', $roleArray))
            <li>
                <a href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#pharmacyMaster">
                    <i class="bx bx-capsule"></i> <!-- Any suitable icon for Pharmacy Master -->
                    <span class="link_name">Pharmacy Master</span>
                    <span class="tooltip">Pharmacy Master</span>
                </a>
                <div id="pharmacyMaster" class="collapse 
                            @if(
                                (Request::segment(2) == 'pharmacy') ||
                                (Request::segment(2) == 'manage-pharmacy') ||
                                (Request::segment(2) == 'store-locations') ||
                                (Request::segment(2) == 'manage-store') ||
                                (Request::segment(2) == 'medicine-listings') ||
                                (Request::segment(2) == 'manage-medicine') ||
                                (Request::segment(2) == 'medicine-type') ||
                                (Request::segment(2) == 'manage-medicine-type') ||
                                (Request::segment(2) == 'inventory') ||
                                (Request::segment(2) == 'suppliers') ||
                                (Request::segment(2) == 'orders') ||
                                (Request::segment(2) == 'billing') ||
                                (Request::segment(2) == 'reports')
                            ) show @endif" data-bs-parent="#accordion">

                    <ul class="sb_submenu">
                        <!-- Pharmacy Management -->
                        <li class="submenu-title divider">Pharmacy Management</li>
                        <li><a href="/admin/pharmacy"><i class="bx bx-store"></i> Pharmacy</a></li>
                        {{-- Add "manage-store" link here if needed --}}

                        <!-- Store Locations -->
                        <li class="submenu-title divider">Store Locations</li>
                        <li><a href="/admin/store-locations"><i class="bx bx-map"></i> Store Locations</a></li>

                        <!-- Product Management -->
                        <li class="submenu-title divider">Product Management</li>
                        <li><a href="/admin/medicine-listings"><i class="bx bx-box"></i> Medicine Listings</a></li>
                        <li><a href="/admin/medicine-type"><i class="bx bx-category-alt"></i> Medicine Type</a></li>
                        <!--<li><a href="/admin/inventory"><i class="bx bx-layer"></i> Inventory</a></li>-->

                        <!-- Supplier & Order Management -->
                        <li class="submenu-title divider">Supplier & Order Management</li>
                        <li><a href="/admin/suppliers"><i class="bx bx-store-alt"></i> Suppliers</a></li>
                        <li><a href="/admin/orders"><i class="bx bx-cart"></i> Orders</a></li>

                        <!-- Billing & Reports -->
                        <!--<li class="submenu-title divider">Billing & Reports</li>-->
                        <!--<li><a href="/admin/billing"><i class="bx bx-receipt"></i> Billing</a></li>-->
                        <!--<li><a href="/admin/reports"><i class="bx bx-bar-chart-alt"></i> Reports</a></li>-->
                    </ul>
                </div>
            </li>
        @endif
        <!--Bills & Payments Management-->
        <!--@if(in_array('payments',$roleArray) || in_array('All',$roleArray))-->
        <!--<li>-->
        <!--    <a href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#bill">-->
        <!--        <i class="bx bx-money"></i>-->
        <!--        <span class="link_name">Billing & Payments</span>-->
        <!--    </a>-->
        <!--    <span class="tooltip">Billing & Payments</span>-->
        <!--    <div id="bill" class="collapse @if((Request::segment(2) == 'invoices') || (Request::segment(2) == 'payments')) show @endif" data-bs-parent="#accordion">-->
        <!--        <ul class="sb_submenu">-->
        <!--            <li><a href="/admin/invoices"><i class="bx bx-right-arrow-alt"></i> Invoices</a></li>-->
        <!--            <li><a href="/admin/payments"><i class="bx bx-right-arrow-alt"></i> Payments</a></li>-->
        <!--        </ul>-->
        <!--    </div>-->
        <!--</li>-->
        <!--@endif-->

        <!--@if(in_array('communication',$roleArray) || in_array('All',$roleArray))-->
        <!--<li>-->
        <!--    <a href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#communication">-->
        <!--        <i class="bx bx-message-dots"></i>-->
        <!--        <span class="link_name">Communication</span>-->
        <!--    </a>-->
        <!--    <span class="tooltip">Communication</span>-->
        <!--    <div id="communication" class="collapse @if((Request::segment(2) == 'sms-email-reminders')) show @endif" data-bs-parent="#accordion">-->
        <!--        <ul class="sb_submenu">-->
        <!--            <li><a href="/admin/sms-email-reminders"><i class="bx bx-right-arrow-alt"></i> SMS/Email Reminders</a></li>-->
        <!--        </ul>-->
        <!--    </div>-->
        <!--</li>-->
        <!--@endif-->

        @if(in_array('users', $roleArray) || in_array('All', $roleArray))
            <li>
                <!-- User Management Main Menu -->
                <a href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#userManagement">
                    <i class="bx bx-user-pin"></i> <!-- Updated icon for better clarity -->
                    <span class="link_name">User Management</span>
                    <span class="tooltip">Manage System Users</span> <!-- Improved tooltip -->
                </a>

                <!-- User Management Submenu -->
                <div id="userManagement" class="collapse 
                        @if(
                            in_array(Request::segment(3), [
                                'users',
                                'admin-accounts',
                                'staff-accounts'
                            ])
                        ) show @endif" data-bs-parent="#accordion">

                    <ul class="sb_submenu">

                        <li class="submenu-title divider">Manage Users Tabs</li>

                        <!-- Admin Users -->
                        <li>
                            <a href="/admin/users/admin-accounts">
                                <i class="bx bx-shield"></i> <!-- Icon for admin users -->
                                <span>Admin Accounts</span> <!-- Clearer label -->
                            </a>
                        </li>

                        <!-- Staff Accounts -->
                        <li>
                            <a href="/admin/users/staff-accounts">
                                <i class="bx bx-user-voice"></i> <!-- Icon for staff accounts -->
                                <span>Staff Accounts</span> <!-- Clearer label -->
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if(in_array('settings', $roleArray) || in_array('All', $roleArray))
            <li>
                <a href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#rolesettings">
                    <i class="bx bx-cog"></i>
                    <span class="link_name">Settings</span>
                    <span class="tooltip">Settings</span>
                </a>
                <div id="rolesettings"
                    class="collapse @if((Request::segment(2) == 'my-profile') || (Request::segment(2) == 'reset-password') || (Request::segment(2) == 'notification-settings') || (Request::segment(2) == 'role-settings') || (Request::segment(2) == 'manage-role-setting') || (Request::segment(2) == 'payment-gateway-configs') || (Request::segment(2) == 'manage-payment-gateway-config') || (Request::segment(2) == 'video-call-gateway-configs') || (Request::segment(2) == 'manage-video-call-gateway-config')) show @endif"
                    data-bs-parent="#accordion">
                    <ul class="sb_submenu">
                        <li>
                            <a href="/admin/my-profile/user/{{ Auth::user()->id ?? '' }}">
                                <!-- bx-user for Profile -->
                                <i class="bx bx-user"></i>
                                Profile Settings
                            </a>
                        </li>
                        <li>
                            <a href="/admin/reset-password">
                                <!-- bx-key for Reset Password -->
                                <i class="bx bx-key"></i>
                                Reset Password
                            </a>
                        </li>
                        <li>
                            <a href="/admin/role-settings">
                                <!-- bx-shield for Access Controls -->
                                <i class="bx bx-shield"></i>
                                Access Controls
                            </a>
                        </li>
                        <li>
                            <a href="/admin/payment-gateway-configs">
                                <i class="bx bxs-credit-card"></i>
                                Payment Gateway
                            </a>
                        </li>
                        <li>
                            <a href="/admin/video-call-gateway-configs">
                                <i class="bx bxs-video"></i>
                                Video Call Gateway
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if(in_array('other', $roleArray) || in_array('All', $roleArray))
            <li>
                <a href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#other">
                    <i class="bx bx-tag"></i>
                    <span class="link_name">Tags Listing</span>
                    <span class="tooltip">Tags Listing</span>
                </a>
                <div id="other"
                    class="collapse @if((Request::segment(2) == 'pharmacy-types') || (Request::segment(2) == 'manage-pharmacy-type') || (Request::segment(2) == 'specialists') || (Request::segment(2) == 'manage-specialist') || (Request::segment(2) == 'cities') || (Request::segment(2) == 'manage-city') || (Request::segment(2) == 'states') || (Request::segment(2) == 'manage-state') || (Request::segment(2) == 'countries') || (Request::segment(2) == 'manage-country') || (Request::segment(2) == 'dosages') || (Request::segment(2) == 'manage-dosage') || (Request::segment(2) == 'frequencies') || (Request::segment(2) == 'manage-frequency') || (Request::segment(2) == 'durations') || (Request::segment(2) == 'manage-duration') || (Request::segment(2) == 'routes') || (Request::segment(2) == 'manage-route') || (Request::segment(2) == 'meals') || (Request::segment(2) == 'manage-meal')) show @endif"
                    data-bs-parent="#accordion">
                    <ul class="sb_submenu">
                        <li>
                            <a href="/admin/dosages">
                                <i class="bx bxs-injection"></i>
                                Dosages
                            </a>
                        </li>
                        <li>
                            <a href="/admin/frequencies">
                                <i class="bx bxs-time"></i>
                                Frequencies
                            </a>
                        </li>
                        <li>
                            <a href="/admin/durations">
                                <i class="bx bxs-hourglass"></i>
                                Durations
                            </a>
                        </li>
                        <li>
                            <a href="/admin/routes">
                                <i class="bx bxs-directions"></i>
                                Routes
                            </a>
                        </li>
                        <li>
                            <a href="/admin/meals">
                                <i class="bx bxs-food-menu"></i>
                                Meals
                            </a>
                        </li>
                        <li>
                            <a href="/admin/pharmacy-types">
                                <i class="bx bxs-capsule"></i>
                                Pharmacy Types
                            </a>
                        </li>
                        <li>
                            <a href="/admin/specialists">
                                <i class="bx bx-user-voice"></i>
                                Specialists
                            </a>
                        </li>
                        <li>
                            <a href="/admin/cities">
                                <i class="bx bx-buildings"></i>
                                Cities
                            </a>
                        </li>
                        <li>
                            <a href="/admin/states">
                                <i class="bx bx-map"></i>
                                States
                            </a>
                        </li>
                        <li>
                            <a href="/admin/countries">
                                <i class="bx bx-globe"></i>
                                Countries
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        <li class="profile">
            <div class="profile_details">
                <img src="{{ asset('public/assets/images/profiles/' . (Auth::user()->photo ?? "")) }}"
                    alt="profile image">
                <div class="profile_content">
                    <div class="name">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? '' }}</div>
                    <div class="designation">{{ $roles->title ?? '' }}</div>
                </div>
            </div>
        </li>
    </ul>
</div>