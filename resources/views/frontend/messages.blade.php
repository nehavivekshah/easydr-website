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
                        <div class="card shadow-sm border-0 rounded-3" style="min-height: 400px;">
                            <div class="card-header bg-white border-bottom py-3">
                                <h4 class="mb-0 text-primary">Messages</h4>
                            </div>
                            <div
                                class="card-body d-flex flex-column align-items-center justify-content-center text-center p-5">
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