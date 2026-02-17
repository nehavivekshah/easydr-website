@if(Auth::check())
    <div class="user_profile shadow-sm mb-4">
        <div class="user_profile_img">
            @if(Auth::user()->photo)
                <img src="{{ asset('public/assets/images/profiles/' . Auth::user()->photo) }}" alt="user"
                    class="img-fluid w-100 shadow-sm">
            @else
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->first_name }}+{{ Auth::user()->last_name }}&background=1E0B9B&color=fff&bold=true"
                    alt="user" class="img-fluid w-100 shadow-sm">
            @endif
            <label for="profile_photo"><i class="fas fa-camera" aria-hidden="true"></i></label>
            <input id="profile_photo" type="file" hidden="">
        </div>
        <h4 class="mb-1">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
        <p class="text-muted small">
            @if(Auth::user()->role == 4)
                Doctor ID: #{{ Auth::user()->id }}
            @else
                Patient ID: #{{ Auth::user()->id }}
            @endif
        </p>
    </div>

    <ul class="dashboard_menu list-unstyled">
        @if(Auth::user()->role == 5)
            <li><a class="{{ Request::is('my-account') ? 'active' : '' }}" href="/my-account"><i
                        class="fas fa-th-large mr-2"></i> Dashboard</a></li>
            <li><a class="{{ Request::is('profile-info') || Request::is('my-profile') ? 'active' : '' }}"
                    href="/profile-info"><i class="fas fa-user mr-2"></i> My Profile</a></li>
            <li><a class="{{ Request::is('appointments*') && !request('filter') ? 'active' : '' }}" href="/appointments"><i
                        class="fas fa-calendar-alt mr-2"></i> Appointments</a></li>
            <li><a class="{{ Request::is('my-doctors*') ? 'active' : '' }}" href="/my-doctors"><i
                        class="fas fa-user-md mr-2"></i> My Doctors</a></li>
            <li><a class="{{ Request::is('medical-reports*') ? 'active' : '' }}" href="/medical-reports"><i
                        class="fas fa-file-medical-alt mr-2"></i> Medical Reports</a></li>
            <li><a class="{{ Request::is('patient-prescriptions*') ? 'active' : '' }}" href="/patient-prescriptions"><i
                        class="fas fa-prescription mr-2"></i> Prescriptions</a></li>
            <li><a class="{{ Request::is('billing*') ? 'active' : '' }}" href="/billing"><i class="fas fa-history mr-2"></i>
                    Transaction History</a></li>
            <li><a class="{{ Request::is('messages*') ? 'active' : '' }}" href="/messages"><i class="fas fa-envelope mr-2"></i>
                    Messages</a></li>
            <li><a class="{{ Request::is('change-password*') ? 'active' : '' }}" href="/change-password"><i
                        class="fas fa-key mr-2"></i> Change Password</a></li>
        @elseif(Auth::user()->role == 4)
            <li><a class="{{ Request::is('my-account') ? 'active' : '' }}" href="/my-account"><i
                        class="fas fa-th-large mr-2"></i> Dashboard</a></li>
            <li><a class="{{ Request::is('profile-info') || Request::is('my-profile') ? 'active' : '' }}"
                    href="/profile-info"><i class="fas fa-user mr-2"></i> My Profile</a></li>
            <li><a class="{{ Request::is('appointments*') ? 'active' : '' }}" href="/appointments"><i
                        class="fas fa-calendar-check mr-2"></i> Appointments</a></li>
            <li><a class="{{ Request::is('my-patients*') ? 'active' : '' }}" href="/my-patients"><i
                        class="fas fa-user-friends mr-2"></i> My Patients</a></li>
            <li><a class="{{ Request::is('doctor-prescriptions*') ? 'active' : '' }}" href="/doctor-prescriptions"><i
                        class="fas fa-file-prescription mr-2"></i> Prescriptions</a></li>
            <li><a class="{{ Request::is('doctor-billing*') ? 'active' : '' }}" href="/doctor-billing"><i
                        class="fas fa-wallet mr-2"></i> Billing & Payments</a></li>
            <li><a class="{{ Request::is('messages*') ? 'active' : '' }}" href="/messages"><i
                        class="fas fa-comment-medical mr-2"></i> Messages</a></li>
            <li><a class="{{ Request::is('change-password*') ? 'active' : '' }}" href="/change-password"><i
                        class="fas fa-unlock-alt mr-2"></i> Change Password</a></li>
        @endif

        <form action="/logout" method="POST" class="d-none" id="logout-form">
            @csrf
        </form>
        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn-logout bg-dark text-white rounded-pill mt-4 justify-content-center">Logout <i
                    class="fas fa-sign-out-alt ml-2"></i></a></li>
    </ul>
@endif