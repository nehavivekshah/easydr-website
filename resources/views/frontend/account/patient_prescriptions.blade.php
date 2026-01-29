@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <h5>Prescriptions</h5>
                            <div style="background: #fff; padding: 25px; border-radius: 5px; box-shadow: var(--shadow-sm); min-height: 300px;"
                                class="d-flex flex-column align-items-center justify-content-center text-center">
                                <div class="mb-3">
                                    <i class="bx bxs-file-plus text-muted opacity-25" style="font-size: 4rem;"></i>
                                </div>
                                <h5 class="text-muted">No Prescriptions Found</h5>
                                <p class="text-secondary small">Your assigned prescriptions will appear here once added by
                                    your doctor.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection