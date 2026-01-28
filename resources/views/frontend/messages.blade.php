@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    <!-- Content Area -->
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <h5>Messages</h5>

                            <div style="background: #fff; padding: 25px; border-radius: 5px; box-shadow: var(--shadow-sm); min-height: 400px;"
                                class="d-flex flex-column align-items-center justify-content-center text-center">
                                <div class="mb-4">
                                    <i class='bx bx-message-rounded-dots text-muted'
                                        style="font-size: 5rem; opacity: 0.3;"></i>
                                </div>
                                <h5 class="text-muted mb-3">No Messages Yet</h5>
                                <p class="text-muted mb-4" style="max-width: 400px;">
                                    You don't have any new messages at the moment. When you receive updates from your doctor
                                    or the administration, they will appear here.
                                </p>
                                <a href="/contact-us" class="btn btn-outline-primary rounded-pill px-4">
                                    <i class='bx bx-support me-2'></i> Contact Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection