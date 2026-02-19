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

    @if(Auth::user()->role == 4 || Auth::user()->role == 5)
        <!-- Global Appointment Alert -->
        <div id="global-appointment-alert" class="d-none mt-4 p-3 shadow-sm border-0"
            style="border-radius: 12px; background: #fff3cd; border-left: 4px solid #ffc107 !important;">
            <div class="d-flex align-items-center mb-2">
                <i class="fas fa-exclamation-circle text-warning me-2"></i>
                <span class="font-weight-bold small text-dark">Session Finished</span>
            </div>
            <p class="small text-muted mb-2">Your session with <strong id="global-other-name">User</strong> has ended.</p>

            <div class="completion-status small mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span>Doctor:</span>
                    <span id="status-doctor"><i class="fas fa-clock text-muted"></i> Pending</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Patient:</span>
                    <span id="status-patient"><i class="fas fa-clock text-muted"></i> Pending</span>
                </div>
            </div>

            <button id="btn-complete-session" onclick="completeGlobalAppointment()"
                class="btn btn-xs btn-warning w-100 rounded-pill small font-weight-bold shadow-sm">Complete Now</button>
        </div>

        @push('scripts')
            <script>
                let globalAppointmentId = null;
                let globalStatusInterval = null;

                function checkGlobalOverdue() {
                    $.get('/chat/check-any-overdue', function (response) {
                        if (response.appointment) {
                            globalAppointmentId = response.appointment.id;

                            // Coordination logic: Hide sidebar alert if we're on the chat page 
                            // AND that specific other user is already the active chat recipient.
                            let isChattingWithThisUser = false;
                            if (window.location.pathname.includes('/messages') && typeof currentRecipientId !== 'undefined') {
                                if (currentRecipientId == response.appointment.other_user_id) {
                                    isChattingWithThisUser = true;
                                }
                            }

                            if (isChattingWithThisUser) {
                                $('#global-appointment-alert').addClass('d-none');
                            } else {
                                $('#global-other-name').text(response.appointment.other_user_name);

                                // Update completion statuses
                                const statuses = response.appointment.is_completed.split(',');
                                const doctorDone = statuses[0] === '1';
                                const patientDone = statuses[1] === '1';

                                $('#status-doctor').html(doctorDone ? '<i class="fas fa-check-circle text-success"></i> Done' : '<i class="fas fa-clock text-muted"></i> Pending');
                                $('#status-patient').html(patientDone ? '<i class="fas fa-check-circle text-success"></i> Done' : '<i class="fas fa-clock text-muted"></i> Pending');

                                // Hide button if current role already completed
                                const userRole = {{ Auth::user()->role }};
                                let alreadyCompleted = false;
                                if (userRole == 4 && doctorDone) alreadyCompleted = true;
                                if (userRole == 5 && patientDone) alreadyCompleted = true;

                                if (alreadyCompleted) {
                                    $('#btn-complete-session').addClass('d-none');
                                } else {
                                    $('#btn-complete-session').removeClass('d-none');
                                }

                                $('#global-appointment-alert').removeClass('d-none');
                            }
                        } else {
                            $('#global-appointment-alert').addClass('d-none');
                        }
                    });
                }

                function completeGlobalAppointment() {
                    if (!globalAppointmentId) return;

                    const btn = $('#btn-complete-session');
                    const originalText = btn.text();
                    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

                    $.post(`/chat/appointment-complete/${globalAppointmentId}`, {
                        _token: '{{ csrf_token() }}'
                    }, function (response) {
                        if (response.success) {
                            // Refresh status immediately instead of hiding
                            checkGlobalOverdue();

                            // Also trigger chat header refresh if present
                            if (typeof fetchAppointmentStatus === 'function') {
                                fetchAppointmentStatus();
                            }
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