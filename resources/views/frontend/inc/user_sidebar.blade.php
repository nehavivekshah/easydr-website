{{-- Sidebar Profile Card --}}
<div class="sidebar-profile-card">
    <div class="position-relative d-inline-block">
        @if(Auth::user()->photo)
            <img src="{{ asset('assets/images/profiles/' . Auth::user()->photo) }}" alt="Profile"
                class="sidebar-profile-img">
        @else
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->first_name }}+{{ Auth::user()->last_name }}&background=0D8ABC&color=fff"
                alt="Profile" class="sidebar-profile-img">
        @endif
    </div>

    <h3 class="sidebar-profile-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
    <p class="sidebar-patient-id">Patient Id : {{ Auth::user()->id }}</p>
</div>

{{-- Sidebar Navigation --}}
<div class="nav flex-column nav-pills-custom">
    @if(Auth::user()->role == 3) {{-- Patient --}}

        <a href="/my-account" class="nav-link {{ Request::is('my-account') ? 'active' : '' }}">
            <span>My Profile</span>
            <i class="bx bxs-chevron-right"></i>
        </a>

        <a href="/appointments" class="nav-link {{ Request::is('appointments*') ? 'active' : '' }}">
            <span>Appointment</span>
            <i class="bx bxs-chevron-right"></i>
        </a>

        <a href="/billing" class="nav-link {{ Request::is('billing*') ? 'active' : '' }}">
            <span>Transaction History</span>
            <i class="bx bxs-chevron-right"></i>
        </a>

        {{-- Meeting History -> Past Appointments --}}
        <a href="/appointments?filter=past"
            class="nav-link {{ Request::is('appointments*') && request('filter') == 'past' ? 'active' : '' }}">
            <span>Meeting History</span>
            <i class="bx bxs-chevron-right"></i>
        </a>

        {{-- Upcoming Meeting -> Upcoming Appointments --}}
        <a href="/appointments?filter=upcoming"
            class="nav-link {{ Request::is('appointments*') && request('filter') == 'upcoming' ? 'active' : '' }}">
            <span>Upcoming Meeting</span>
            <i class="bx bxs-chevron-right"></i>
        </a>

        <a href="/messages" class="nav-link {{ Request::is('messages*') ? 'active' : '' }}">
            <span>Message</span>
            <i class="bx bxs-chevron-right"></i>
        </a>

    @elseif(Auth::user()->role == 2) {{-- Doctor (Kept standard for now as request was likely for Patient UI) --}}

        <a href="/my-account" class="nav-link {{ Request::is('my-account') ? 'active' : '' }}">
            <span>Dashboard</span>
            <i class="bx bxs-chevron-right"></i>
        </a>

        <a href="/appointments" class="nav-link {{ Request::is('appointments*') ? 'active' : '' }}">
            <span>Appointments</span>
            <i class="bx bxs-chevron-right"></i>
        </a>
        <a href="/my-patients" class="nav-link {{ Request::is('my-patients*') ? 'active' : '' }}">
            <span>My Patients</span>
            <i class="bx bxs-chevron-right"></i>
        </a>
        <a href="/doctor-billing" class="nav-link {{ Request::is('doctor-billing*') ? 'active' : '' }}">
            <span>Billing</span>
            <i class="bx bxs-chevron-right"></i>
        </a>
        <a href="/change-password" class="nav-link {{ Request::is('change-password*') ? 'active' : '' }}">
            <span>Change Password</span>
            <i class="bx bxs-chevron-right"></i>
        </a>

    @endif

    <form action="/logout" method="POST" class="d-none" id="logout-form">
        @csrf
    </form>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        class="nav-link btn-logout">
        <span>Logout</span>
        <i class="bx bxs-chevron-right"></i>
    </a>
</div>
{{-- Common Links --}}
<a href="/my-account"
    class="list-group-item list-group-item-action p-3 {{ Request::is('my-account') ? 'active-menu' : '' }}">
    <i class="bx bxs-grid-alt me-2 text-primary"></i> Dashboard
</a>

{{-- Doctor Role (2) --}}
@if(Auth::check() && Auth::user()->role == 2)
    <a href="/appointments"
        class="list-group-item list-group-item-action p-3 {{ Request::is('appointments*') ? 'active-menu' : '' }}">
        <i class="bx bxs-calendar me-2 text-primary"></i> Appointments
    </a>
    <a href="/my-patients"
        class="list-group-item list-group-item-action p-3 {{ Request::is('my-patients*') ? 'active-menu' : '' }}">
        <i class="bx bxs-user-detail me-2 text-primary"></i> My Patients
    </a>
    <a href="/manage-slots"
        class="list-group-item list-group-item-action p-3 {{ Request::is('manage-slots*') ? 'active-menu' : '' }}">
        <i class="bx bxs-time me-2 text-primary"></i> Manage Slots
    </a>
    <a href="/doctor-prescriptions"
        class="list-group-item list-group-item-action p-3 {{ Request::is('doctor-prescriptions*') ? 'active-menu' : '' }}">
        <i class="bx bxs-file-plus me-2 text-primary"></i> Prescriptions
    </a>
    <a href="/doctor-billing"
        class="list-group-item list-group-item-action p-3 {{ Request::is('doctor-billing*') ? 'active-menu' : '' }}">
        <i class="bx bxs-wallet me-2 text-primary"></i> Billing & Payments
    </a>
@endif

{{-- Patient Role (3) --}}
@if(Auth::check() && Auth::user()->role == 3)
    <a href="/my-doctors"
        class="list-group-item list-group-item-action p-3 {{ Request::is('my-doctors*') ? 'active-menu' : '' }}">
        <i class="bx bxs-user-badge me-2 text-primary"></i> My Doctors
    </a>
    <a href="/appointments"
        class="list-group-item list-group-item-action p-3 {{ Request::is('appointments*') ? 'active-menu' : '' }}">
        <i class="bx bxs-calendar-check me-2 text-primary"></i> Appointments
    </a>
    <a href="/medical-reports"
        class="list-group-item list-group-item-action p-3 {{ Request::is('medical-reports*') ? 'active-menu' : '' }}">
        <i class="bx bxs-report me-2 text-primary"></i> Medical Reports
    </a>
    <a href="/patient-prescriptions"
        class="list-group-item list-group-item-action p-3 {{ Request::is('patient-prescriptions*') ? 'active-menu' : '' }}">
        <i class="bx bxs-capsule me-2 text-primary"></i> Prescriptions
    </a>
    <a href="/billing"
        class="list-group-item list-group-item-action p-3 {{ Request::is('billing*') ? 'active-menu' : '' }}">
        <i class="bx bxs-receipt me-2 text-primary"></i> Billing
    </a>
@endif

{{-- Common Bottom Links --}}
<a href="/my-profile"
    class="list-group-item list-group-item-action p-3 {{ Request::is('my-profile*') ? 'active-menu' : '' }}">
    <i class="bx bxs-user me-2 text-primary"></i> My Profile
</a>
<a href="/change-password"
    class="list-group-item list-group-item-action p-3 {{ Request::is('change-password*') ? 'active-menu' : '' }}">
    <i class="bx bxs-lock-alt me-2 text-primary"></i> Change Password
</a>

<form action="/logout" method="POST" class="d-none" id="logout-form">
    @csrf
</form>
<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
    class="list-group-item list-group-item-action p-3 text-danger">
    <i class="bx bxs-log-out me-2"></i> Logout
</a>
</div>
</div>

<style>
    .active-menu {
        background-color: var(--color-primary-light, #eef2ff);
        color: var(--color-primary) !important;
        font-weight: 600;
        border-right: 3px solid var(--color-primary);
    }

    .list-group-item {
        border: none;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        padding-left: 1.5rem !important;
        /* Slide effect */
    }
</style>
<div class="list-group-item bg-primary text-white">
    <h5 class="mb-0">Menu</h5>
</div>

{{-- Common Links --}}
<a href="/my-account" class="list-group-item list-group-item-action {{ Request::is('my-account') ? 'active' : '' }}">
    <i class="fas fa-th-large mr-2"></i> Dashboard
</a>

{{-- Doctor Role (2) --}}
@if(Auth::check() && Auth::user()->role == 2)
    <a href="/appointments"
        class="list-group-item list-group-item-action {{ Request::is('appointments*') ? 'active' : '' }}">
        <i class="fas fa-calendar-alt mr-2"></i> Appointments
    </a>
    <a href="/my-patients" class="list-group-item list-group-item-action {{ Request::is('my-patients*') ? 'active' : '' }}">
        <i class="fas fa-user-injured mr-2"></i> My Patients
    </a>
    <a href="/manage-slots"
        class="list-group-item list-group-item-action {{ Request::is('manage-slots*') ? 'active' : '' }}">
        <i class="fas fa-clock mr-2"></i> Manage Slots
    </a>
    <a href="/doctor-prescriptions"
        class="list-group-item list-group-item-action {{ Request::is('doctor-prescriptions*') ? 'active' : '' }}">
        <i class="fas fa-file-prescription mr-2"></i> Prescriptions
    </a>
    <a href="/doctor-billing"
        class="list-group-item list-group-item-action {{ Request::is('doctor-billing*') ? 'active' : '' }}">
        <i class="fas fa-file-invoice-dollar mr-2"></i> Billing & Payments
    </a>
@endif

{{-- Patient Role (3) --}}
@if(Auth::check() && Auth::user()->role == 3)
    <a href="/my-doctors" class="list-group-item list-group-item-action {{ Request::is('my-doctors*') ? 'active' : '' }}">
        <i class="fas fa-user-md mr-2"></i> My Doctors
    </a>
    <a href="/appointments"
        class="list-group-item list-group-item-action {{ Request::is('appointments*') ? 'active' : '' }}">
        <i class="fas fa-calendar-check mr-2"></i> Appointments
    </a>
    <a href="/medical-reports"
        class="list-group-item list-group-item-action {{ Request::is('medical-reports*') ? 'active' : '' }}">
        <i class="fas fa-file-medical mr-2"></i> Medical Reports
    </a>
    <a href="/patient-prescriptions"
        class="list-group-item list-group-item-action {{ Request::is('patient-prescriptions*') ? 'active' : '' }}">
        <i class="fas fa-pills mr-2"></i> Prescriptions
    </a>
    <a href="/billing" class="list-group-item list-group-item-action {{ Request::is('billing*') ? 'active' : '' }}">
        <i class="fas fa-receipt mr-2"></i> Billing
    </a>
@endif

{{-- Common Bottom Links --}}
<a href="/my-profile" class="list-group-item list-group-item-action {{ Request::is('my-profile*') ? 'active' : '' }}">
    <i class="fas fa-user mr-2"></i> My Profile
</a>
<a href="/change-password"
    class="list-group-item list-group-item-action {{ Request::is('change-password*') ? 'active' : '' }}">
    <i class="fas fa-lock mr-2"></i> Change Password
</a>
<form action="/logout" method="POST" class="d-none" id="logout-form">
    @csrf
</form>
<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
    class="list-group-item list-group-item-action text-danger">
    <i class="fas fa-sign-out-alt mr-2"></i> Logout
</a>
</div>