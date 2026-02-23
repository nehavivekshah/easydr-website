@extends('frontend.layout')
@section('title', 'Video Consultation - EasyDoctor')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container px-lg-5">
                <div class="row mb-3">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1"><i class="fas fa-video text-primary me-2"></i> Video Consultation</h4>
                            <p class="text-muted mb-0">Secure, encrypted connection for your appointment.</p>
                        </div>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="height: 75vh;">
                            @if($videoConfig)
                                @if($userRole == 5 && !$appointment->is_video_started)
                                    <!-- Patient Waiting Room UI -->
                                    <div class="d-flex justify-content-center align-items-center h-100 flex-column bg-light text-center p-5"
                                        id="waiting-room-ui">
                                        <div class="icon-box bg-white shadow-sm mb-4"
                                            style="width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <h3 class="text-dark font-weight-bold mb-2">Waiting for Dr.
                                            {{ $appointment->doctor_last_name }}...</h3>
                                        <p class="text-muted mb-4" style="max-width: 450px;">
                                            Please stay on this page. You will automatically join the consultation as soon as the
                                            doctor starts the secure video session.
                                        </p>
                                        <div class="d-flex align-items-center justify-content-center text-primary p-3 bg-white rounded-3 shadow-sm"
                                            style="display:inline-flex;">
                                            <i class="fas fa-shield-alt me-2"></i> End-to-end Encrypted Call
                                        </div>
                                    </div>
                                    <div id="jitsi-container" style="width: 100%; height: 100%; display: none;"></div>
                                @else
                                    <div id="jitsi-container" style="width: 100%; height: 100%;">
                                        <!-- Jitsi Meet Will Load Here -->
                                        <div class="d-flex justify-content-center align-items-center h-100 flex-column"
                                            id="loading-video">
                                            <div class="spinner-border text-primary shadow-sm" role="status"
                                                style="width: 3rem; height: 3rem;">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <h5 class="mt-4 text-muted">Establishing secure connection...</h5>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div
                                    class="d-flex justify-content-center align-items-center h-100 flex-column bg-light text-center p-5">
                                    <div class="icon-box bg-white shadow-sm mb-4"
                                        style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-video-slash text-danger fa-2x"></i>
                                    </div>
                                    <h4 class="text-dark font-weight-bold mb-2">Video Gateway Offline</h4>
                                    <p class="text-muted mb-4" style="max-width: 400px;">
                                        The secure video consultation gateway is currently disabled or unconfigured by the
                                        administration.
                                    </p>
                                    <a href="{{ url()->previous() }}" class="btn btn-primary rounded-pill px-4 py-2">
                                        Return to Appointments
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@if($videoConfig)
    @push('scripts')
        <script src="https://{{ $videoConfig->app_id ?? 'meet.jit.si' }}/external_api.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                @php
                    // Create a unique, complex room name based on the appointment ID and app name
                    $roomName = 'EasyDoctor-Appt-' . md5($appointment->id . config('app.key'));

                    // Determine user details based on role (Patient or Doctor)
                    $userRole = Auth::user()->role;
                    if ($userRole == 4) {
                        // Doctor
                        $userName = 'Dr. ' . Auth::user()->first_name . ' ' . Auth::user()->last_name;
                    } else {
                        // Patient
                        $userName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
                    }
                @endphp

                const domain = '{{ $videoConfig->app_id ?? 'meet.jit.si' }}';
                const options = {
                    roomName: '{{ $roomName }}',
                    width: '100%',
                    height: '100%',
                    parentNode: document.querySelector('#jitsi-container'),
                    userInfo: {
                        displayName: '{{ $userName }}'
                    },
                    configOverwrite: {
                        startWithAudioMuted: false,
                        startWithVideoMuted: false,
                        prejoinPageEnabled: true, // Let them test mic/cam before joining
                        disableDeepLinking: true  // Force web browser instead of prompting to download Jitsi app
                    },
                    interfaceConfigOverwrite: {
                        SHOW_JITSI_WATERMARK: false,
                        SHOW_WATERMARK_FOR_GUESTS: false,
                        DISABLE_VIDEO_BACKGROUND: true,
                        DEFAULT_LOGO_URL: '',
                        DEFAULT_WELCOME_PAGE_LOGO_URL: '',
                        TOOLBAR_BUTTONS: [
                            'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                            'fodeviceselection', 'hangup', 'profile', 'chat', 'settings',
                            'videoquality', 'filmstrip', 'shortcuts', 'tileview'
                        ]
                    }
                };

                const isPatient = {{ $userRole == 5 ? 'true' : 'false' }};
                const isVideoStarted = {{ $appointment->is_video_started ? 'true' : 'false' }};

                function startJitsi() {
                    const waitingUi = document.getElementById('waiting-room-ui');
                    const loader = document.getElementById('loading-video');
                    const container = document.getElementById('jitsi-container');

                    if (waitingUi) waitingUi.style.display = 'none';
                    if (loader) loader.style.display = 'none';
                    if (container) container.style.display = 'block';

                    try {
                        const api = new JitsiMeetExternalAPI(domain, options);

                        // Handle meeting left
                        api.addEventListener('videoConferenceLeft', () => {
                            window.location.href = "{{ url()->previous() }}";
                        });
                    } catch (error) {
                        console.error("Video Server Error", error);
                        document.getElementById('jitsi-container').innerHTML = `
                                        <div class="d-flex justify-content-center align-items-center h-100 flex-column p-4 text-center">
                                            <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                            <h5 class="text-dark">Could not connect to the Video Server.</h5>
                                            <p class="text-muted">Domain '${domain}' is unresponsive or misconfigured.</p>
                                        </div>
                                    `;
                    }
                }

                if (isPatient && !isVideoStarted) {
                    // Poll the server every 5 seconds to check if doctor has started the call
                    const pollInterval = setInterval(() => {
                        fetch(`{{ url('/api/check-video-status') }}/{{ $appointment->id }}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success && data.is_video_started) {
                                    clearInterval(pollInterval);
                                    window.location.reload(); // Reload cleanly opens Jitsi for patient
                                }
                            })
                            .catch(error => console.error('Error polling video status:', error));
                    }, 5000);
                } else {
                    // Doctor or Patient where video is already started
                    setTimeout(() => startJitsi(), 1000);
                }
            });
        </script>
    @endpush
@endif