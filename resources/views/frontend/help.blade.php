@extends('frontend.layout')

@section('content')
    <main>
        <section class="breadcrumb-area d-flex align-items-center"
            style="background-image:url(public/assets/frontend/img/testimonial/test-bg.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                        <div class="breadcrumb-wrap text-center">
                            <div class="breadcrumb-title mb-30">
                                <h2>Help & Support</h2>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Help</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="service-details-area pt-120 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="service-details-wrap">
                            <div class="service-details-content">
                                <h3>How can we help you?</h3>
                                <p>If you have any questions or need assistance, please contact our support team or visit
                                    our FAQ section.</p>

                                <div class="row mt-50">
                                    <div class="col-lg-4">
                                        <div class="card text-center p-4">
                                            <i class="fas fa-envelope fa-3x mb-3 text-primary"></i>
                                            <h4>Email Support</h4>
                                            <p>support@easydoctor.com</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card text-center p-4">
                                            <i class="fas fa-phone fa-3x mb-3 text-primary"></i>
                                            <h4>Phone Support</h4>
                                            <p>+91 9892220236</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card text-center p-4">
                                            <i class="fas fa-map-marker-alt fa-3x mb-3 text-primary"></i>
                                            <h4>Visit Us</h4>
                                            <p>Mumbai, India</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection