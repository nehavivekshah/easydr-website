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
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-header bg-white border-bottom p-3">
                                <h4 class="mb-0">My Prescriptions</h4>
                            </div>
                            <div class="card-body p-5 text-center">
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