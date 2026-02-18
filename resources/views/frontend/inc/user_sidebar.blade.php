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

    @if(Auth::user()->role == 4)
        <!-- Global Appointment Alert -->
        <div id="global-appointment-alert" class="d-none mt-4 p-3 shadow-sm border-0"
            style="border-radius: 12px; background: #fff3cd; border-left: 4px solid #ffc107 !important;">
            <div class="d-flex align-items-center mb-2">
                <i class="fas fa-exclamation-circle text-warning me-2"></i>
                <span class="font-weight-bold small text-dark">Session Finished</span>
            </div>
            <p class="small text-muted mb-2">Your session with <strong id="global-patient-name">Patient</strong> has ended.
            </p>
            <button onclick="completeGlobalAppointment()"
                class="btn btn-xs btn-warning w-100 rounded-pill small font-weight-bold shadow-sm">Complete Now</button>
        </div>

        @push('scripts')
            <script>
                let globalAppointmentId = null;
                let globalStatusInterval = null;

                function checkGlobalOverdue() {
                    // Don't check if we're on the messages page (it has its own specific check)
                    if (window.location.pathname.includes('/messages')) return;

                    $.get('/chat/check-any-overdue', function (response) {
                        if (response.appointment) {
                            globalAppointmentId = response.appointment.id;
                            $('#global-patient-name').text(response.appointment.patient_name);
                            $('#global-appointment-alert').removeClass('d-none');
                        } else {
                            $('#global-appointment-alert').addClass('d-none');
                        }
                    });
                }

                function completeGlobalAppointment() {
                    if (!globalAppointmentId) return;

                    const btn = $('#global-appointment-alert button');
                    const originalText = btn.text();
                    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

                    $.post(`/chat/appointment-complete/${globalAppointmentId}`, {
                        _token: '{{ csrf_token() }}'
                    }, function (response) {
                        if (response.success) {
                            $('#global-appointment-alert').fadeOut(function () {
                                $(this).addClass('d-none').show();
                            });
                        } else {
                            alert(response.error || 'Failed to complete appointment.');
                            btn.prop('disabled', false).text(originalText);
                        }
                    });
                }

                // Start polling
                $(document).ready(function () {
                    checkGlobalOverdue();
                    if (globalStatusInterval) clearInterval(globalStatusInterval);
                    globalStatusInterval = setInterval(checkGlobalOverdue, 30000);
                });
            </script>
        @endpush
    @endif
@endif