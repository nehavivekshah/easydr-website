@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>
        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex align-items-center"
            style="background-image:url(public/assets/frontend/img/testimonial/test-bg.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                        <div class="breadcrumb-wrap text-center">
                            <div class="breadcrumb-title mb-30">
                                <h2>Contact Us</h2>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Contact </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->
        <!-- contact-area -->
        <section id="contact" class="contact-area contact-bg pt-100 pb-70 p-relative fix"
            style="background-image:url(public/assets/frontend/img/an-bg/an-bg11.png); background-size: cover;background-repeat: no-repeat;">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-img">
                            <img src="public/assets/frontend/img/bg/touch-illustration.png" alt="touch-illustration">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="section-title mb-60">
                            <span>Contact</span>
                            <h2>Get In Touch With Us</h2>
                        </div>
                        <form action="/contact-us" method="POST" class="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="contact-field p-relative c-name mb-20">
                                        <input type="text" name="first_name" placeholder="First Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="contact-field p-relative c-name mb-20">
                                        <input type="text" name="last_name" placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="contact-field p-relative c-email mb-20">
                                        <input type="email" name="email" placeholder="Write here youremail" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="contact-field p-relative c-subject mb-20">
                                        <input type="text" name="subject" placeholder="I would like to discuss">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="contact-field p-relative c-message mb-45">
                                        <textarea name="message" id="message" cols="30" rows="10"
                                            placeholder="Write comments" required></textarea>
                                    </div>
                                    <div class="slider-btn">
                                        <button type="submit" class="btn ss-btn" data-animation="fadeInRight"
                                            data-delay=".8s">Send Message</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </section>
        <!-- contact-area-end -->
        <!-- brand-area -->
        <!-- <section class="brand-area" style="background-image:url(public/assets/frontend/img/an-bg/an-bg12.png); background-size: cover;background-repeat: no-repeat;">
                    <div class="container">
                        <div class="row brand-active">
                            <div class="col-xl-2">
                                <div class="single-brand">
                                    <img src="public/assets/frontend/img/brand/c-logo.png" alt="img">
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="single-brand active">
                                      <img src="public/assets/frontend/img/brand/c-logo02.png" alt="img">
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="single-brand">
                                      <img src="public/assets/frontend/img/brand/c-logo03.png" alt="img">
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="single-brand">
                                      <img src="public/assets/frontend/img/brand/c-logo04.png" alt="img">
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="single-brand">
                                      <img src="public/assets/frontend/img/brand/c-logo.png" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
        <!-- brand-area-end -->
    </main>
    <!-- main-area-end -->
@endsection