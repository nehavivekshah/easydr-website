@if(Auth::check())
    <div class="user_profile">
        <div class="user_profile_img">
            @if(Auth::user()->photo)
                <img src="{{ asset('assets/images/profiles/' . Auth::user()->photo) }}" alt="user" class="img-fluid w-100">
            @else
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->first_name }}+{{ Auth::user()->last_name }}&background=0D8ABC&color=fff"
                    alt="user" class="img-fluid w-100">
            @endif
            <label for="profile_photo"><i class="fas fa-camera" aria-hidden="true"></i></label>
            <input id="profile_photo" type="file" hidden="">
        </div>
        <h4>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
        <p>Patient Id : {{ Auth::user()->id }}</p>
    </div>

    <ul class="dashboard_menu">
        @if(Auth::user()->role == 3) {{-- Patient --}}
            <li><a class="{{ Request::is('my-account') || Request::is('my-profile') ? 'active' : '' }}" href="/my-account">My
                    Profile</a></li>
            <li><a class="{{ Request::is('appointments*') && !request('filter') ? 'active' : '' }}"
                    href="/appointments">Appointment</a></li>
            <li><a class="{{ Request::is('billing*') ? 'active' : '' }}" href="/billing">Transaction History</a></li>
            <li><a class="{{ Request::is('appointments*') && request('filter') == 'past' ? 'active' : '' }}"
                    href="/appointments?filter=past">Meeting History</a></li>
            <li><a class="{{ Request::is('appointments*') && request('filter') == 'upcoming' ? 'active' : '' }}"
                    href="/appointments?filter=upcoming">Upcoming Meeting</a></li>
            <li><a class="{{ Request::is('messages*') ? 'active' : '' }}" href="/messages">Message</a></li>
        @elseif(Auth::user()->role == 2) {{-- Doctor --}}
            <li><a class="{{ Request::is('my-account') ? 'active' : '' }}" href="/my-account">Dashboard</a></li>
            <li><a class="{{ Request::is('appointments*') ? 'active' : '' }}" href="/appointments">Appointments</a></li>
            <li><a class="{{ Request::is('my-patients*') ? 'active' : '' }}" href="/my-patients">My Patients</a></li>
            <li><a class="{{ Request::is('doctor-billing*') ? 'active' : '' }}" href="/doctor-billing">Billing</a></li>
            <li><a class="{{ Request::is('change-password*') ? 'active' : '' }}" href="/change-password">Change Password</a>
            </li>
        @endif

        <form action="/logout" method="POST" class="d-none" id="logout-form">
            @csrf
        </form>
        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn-logout">Logout <i class="fas fa-chevron-right"></i></a></li>
    </ul>
@endif