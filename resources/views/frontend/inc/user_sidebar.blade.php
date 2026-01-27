<div class="list-group shadow-sm">
    <div class="list-group-item bg-primary text-white">
        <h5 class="mb-0">Menu</h5>
    </div>

    {{-- Common Links --}}
    <a href="/my-account"
        class="list-group-item list-group-item-action {{ Request::is('my-account') ? 'active' : '' }}">
        <i class="fas fa-th-large mr-2"></i> Dashboard
    </a>

    {{-- Doctor Role (2) --}}
    @if(Auth::check() && Auth::user()->role == 2)
        <a href="/appointments"
            class="list-group-item list-group-item-action {{ Request::is('appointments*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt mr-2"></i> Appointments
        </a>
        <a href="/my-patients"
            class="list-group-item list-group-item-action {{ Request::is('my-patients*') ? 'active' : '' }}">
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
        <a href="/my-doctors"
            class="list-group-item list-group-item-action {{ Request::is('my-doctors*') ? 'active' : '' }}">
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
    <a href="/my-profile"
        class="list-group-item list-group-item-action {{ Request::is('my-profile*') ? 'active' : '' }}">
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