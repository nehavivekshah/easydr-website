@extends('frontend.layout')
@section('title', 'Video Consultation - EasyDoctor')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container-fluid px-lg-5">
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="https://meet.jit.si/external_api.js"></script>
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

            const domain = 'meet.jit.si';
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

            // Hide loader and start Jitsi
            setTimeout(() => {
                document.getElementById('loading-video').style.display = 'none';
                const api = new JitsiMeetExternalAPI(domain, options);

                // Handle meeting left
                api.addEventListener('videoConferenceLeft', () => {
                    window.location.href = "{{ url()->previous() }}";
                });
            }, 1000);
        });
    </script>
@endpush