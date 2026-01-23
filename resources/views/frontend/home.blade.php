@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>
        <!-- slider-area -->
        <section id="home" class="slider-area fix p-relative">

            <div class="slider-active2">
                <div class="single-slider slider-bg d-flex align-items-center"
                    style="background-image:url(public/assets/frontend/img/an-bg/header-bg.png)">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slider-content s-slider-content text-left">
                                    <h2 data-animation="fadeInUp" data-delay=".4s">Access HealthCare <span>Anywhere</span>
                                    </h2>
                                    <p data-animation="fadeInUp" data-delay=".6s">Connect with your Doctor and Pharmacy from
                                        your Laptop, PC, Mobile or Tablet.
                                        <br>Schedule and Attend Appointment with your medical practicenor<br>Share &
                                        Generate Reports, Track Appointments
                                    </p>
                                    <div class="slider-btn mt-25">
                                        <a href="/about-us" class="btn ss-btn" data-animation="fadeInRight"
                                            data-delay=".8s">Learn More <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <img src="public/assets/frontend/img/bg/header-img.png" alt="header-img"
                                    class="header-img" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- slider-area-end -->

        <!-- doctors-area -->
        <section id="doctors" class="doctors-area pt-80 pb-80">
            <div class="container">
                <div class="row">
                    @foreach ($doctors as $doctor)
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
                            <div class="card doctor-card h-100 border-0 overflow-hidden transition-all"
                                style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: all 0.3s ease;">

                                {{-- Doctor Image Container --}}
                                <div class="position-relative bg-light overflow-hidden doctor-image-wrapper"
                                    style="height: 250px;">
                                    <img src="{{ asset(!empty($doctor->photo) ? 'public/assets/images/profiles/' . $doctor->photo : 'public/assets/images/doctor-placeholder.png') }}"
                                        class="card-img-top w-100 h-100"
                                        alt="Dr. {{ $doctor->first_name ?? '' }} {{ $doctor->last_name ?? '' }}"
                                        style="object-fit: cover; transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);">

                                    {{-- Hover Overlay with Button --}}
                                    <div class="doctor-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                        style="background: rgba(30, 41, 99, 0.7); opacity: 0; transition: all 0.3s ease;">
                                        <a href="/doctor/{{ $doctor->uid ?? '' }}/{!! md5($doctor->email ?? '') !!}"
                                            class="btn btn-light rounded-pill px-4 py-2 fw-bold transform-scale"
                                            style="transform: scale(0.9); transition: all 0.3s ease;">
                                            View Profile
                                        </a>
                                    </div>

                                    {{-- Experience Badge --}}
                                    @if(!empty($doctor->experience))
                                        <div class="position-absolute bottom-0 start-0 w-100 p-2"
                                            style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
                                            <span class="badge bg-primary rounded-pill px-2 py-1 font-12 fw-500">
                                                <i class="fas fa-briefcase-medical me-1"></i>{{ $doctor->experience }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Doctor Info Body --}}
                                <div class="card-body d-flex flex-column pt-3 pb-3 px-3 text-center" style="flex-grow: 1;">

                                    {{-- Name --}}
                                    <h5 class="card-title mb-1">
                                        <a href="/doctor/{{ $doctor->uid ?? '' }}/{!! md5($doctor->email ?? '') !!}"
                                            class="text-decoration-none text-dark fw-bold" style="font-size: 1.1rem;">
                                            Dr. {{ $doctor->first_name ?? '' }} {{ $doctor->last_name ?? '' }}
                                        </a>
                                    </h5>

                                    {{-- Specialization --}}
                                    <p class="text-primary mb-1 fw-600 font-13 text-uppercase"
                                        style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                        {{ $doctor->specialist ?? 'Specialist' }}
                                    </p>

                                    {{-- Spacer --}}
                                    <div class="w-100 my-2 border-bottom opacity-50"></div>

                                    {{-- Rating --}}
                                    <div class="mb-2">
                                        @if(isset($doctor->avg_rating) && $doctor->avg_rating > 0)
                                            <div
                                                class="d-inline-flex align-items-center justify-content-center bg-light rounded-pill px-3 py-1">
                                                <i class="fas fa-star text-warning font-12 me-1"></i>
                                                <span
                                                    class="fw-bold font-13 text-dark">{{ number_format($doctor->avg_rating, 1) }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted font-12"><i class="far fa-star me-1"></i>No ratings</span>
                                        @endif
                                    </div>

                                    {{-- Fees --}}
                                    <div class="mt-auto">
                                        @if(!empty($doctor->fees))
                                            <h6 class="text-dark mb-3 fw-bold d-flex align-items-center justify-content-center">
                                                <span class="text-muted font-12 fw-normal me-1">Consultation:</span>
                                                ₹{{ number_format($doctor->fees, 0) }}
                                            </h6>
                                        @endif

                                        <a href="/doctor/{{ $doctor->uid ?? '' }}/{!! md5($doctor->email ?? '') !!}"
                                            class="btn ss-btn btn-primary w-100 fw-600 rounded-3 shadow-sm hover-y-shift text-center"
                                            style="min-width: 100% !important;">
                                            Book Now
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- doctors-area-end -->

        {{-- Custom Styles for this section --}}
        <style>
            .doctor-card .text-muted {
                gap: 7px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .doctor-card:hover .doctor-overlay {
                opacity: 1 !important;
            }

            .doctor-card:hover .doctor-overlay .btn {
                transform: scale(1) !important;
            }

            .doctor-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            }

            .hover-y-shift {
                transition: transform 0.2s;
            }

            .hover-y-shift:hover {
                transform: translateY(-2px);
            }
        </style>

        <!-- about-area -->
        <section id="about" class="about-area about-p pt-80 pb-80 p-relative"
            style="background-image:url(public/assets/frontend/img/an-bg/an-bg03.png); background-size: contain; background-repeat: no-repeat;background-position: center center;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="s-about-img p-relative">
                            <img src="public/assets/frontend/img/bg/illlustration.png" alt="img">

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="about-content s-about-content pl-30">
                            <div class="section-title mb-20">
                                <span>About Us</span>
                                <h2>We Are Specialize in Medical Diagnositics</h2>
                            </div>
                            <p>Nulla lacinia sapien a diam ullamcorper, sed congue leo vulputate. Phasellus et ante
                                ultrices, sagittis purus vitae, sagittis quam. Quisque urna lectus, auctor quis tristique
                                tincidunt, semper vel lectus. Mauris eget eleifend massa. Praesent ex felis, laoreet nec
                                tellus in, laoreet commodo ipsum.</p>

                            <ul>
                                <li>
                                    <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    <div class="text">Pellentesque placerat, nisi congue vehicula efficitur.
                                    </div>
                                </li>
                                <li>
                                    <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    <div class="text">Pellentesque placerat, nisi congue vehicula efficitur.
                                    </div>
                                </li>
                            </ul>

                            <div class="slider-btn mt-30">
                                <a href="/about-us" class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s">Read
                                    More <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- about-area-end -->

        <!-- testimonial-area -->
        <section id="testimonios" class="testimonial-area testimonial-p pt-80 pb-80 fix"
            style="background: #e8f1fc8a;background-image: url(public/assets/frontend/img/an-bg/an-bg07.png);background-position: center; background-repeat: no-repeat;background-size: contain;">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-lg-8">
                        <div class="section-title center-align mb-60 text-center">
                            <span>TESTIMONIAL</span>
                            <h2>What Our Client’s Say’s</h2>
                            <p>Fusce pharetra odio in urna laoreet laoreet. Aliquam erat volutpat. Phasellus nec ligula
                                arcu. Aliquam eu urna pulvinar, iaculis ipsum in, porta massa.</p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">

                    <div class="col-lg-10">
                        <div class="testimonial-active">


                            <div class="single-testimonial">
                                <div class="testi-img">
                                    <img src="public/assets/frontend/img/testimonial/testimonial-img.png" alt="img">
                                </div>
                                <div class="single-testimonial-bg">
                                    <div class="com-icon"><img src="public/assets/frontend/img/testimonial/qutation.png"
                                            alt="img"></div>
                                    <div class="testi-author">
                                        <div class="ta-info">
                                            <h6>Adam McWilliams</h6>
                                            <span>CEO & Founder</span>

                                        </div>
                                    </div>
                                    <p>Nullam metus mi, sollicitudin eu elit non, laoreet consectetur urna. Nullam quis
                                        aliquet elit. Cras augue tortor, lacinia et fermentum eget, suscipit id ligula.
                                        Donec id mollis sem, nec tincidunt neque. Pellentesque habitant morbi tristique
                                        senectus et netus et malesuada fames ac turpis egestas.</p>
                                </div>

                            </div>
                            <div class="single-testimonial">
                                <div class="testi-img">
                                    <img src="public/assets/frontend/img/testimonial/testimonial-img.png" alt="img">
                                </div>
                                <div class="single-testimonial-bg">
                                    <div class="com-icon"><img src="public/assets/frontend/img/testimonial/qutation.png"
                                            alt="img"></div>
                                    <div class="testi-author">
                                        <div class="ta-info">
                                            <h6>Rose Dose</h6>
                                            <span>Sale Executive</span>

                                        </div>
                                    </div>
                                    <p>Nullam metus mi, sollicitudin eu elit non, laoreet consectetur urna. Nullam quis
                                        aliquet elit. Cras augue tortor, lacinia et fermentum eget, suscipit id ligula.
                                        Donec id mollis sem, nec tincidunt neque. Pellentesque habitant morbi tristique
                                        senectus et netus et malesuada fames ac turpis egestas.</p>
                                </div>

                            </div>
                            <div class="single-testimonial">
                                <div class="testi-img">
                                    <img src="public/assets/frontend/img/testimonial/testimonial-img.png" alt="img">
                                </div>
                                <div class="single-testimonial-bg">
                                    <div class="com-icon"><img src="public/assets/frontend/img/testimonial/qutation.png"
                                            alt="img"></div>
                                    <div class="testi-author">
                                        <div class="ta-info">
                                            <h6>Margie R. Robinson</h6>
                                            <span>Web Developer</span>

                                        </div>
                                    </div>
                                    <p>Nullam metus mi, sollicitudin eu elit non, laoreet consectetur urna. Nullam quis
                                        aliquet elit. Cras augue tortor, lacinia et fermentum eget, suscipit id ligula.
                                        Donec id mollis sem, nec tincidunt neque. Pellentesque habitant morbi tristique
                                        senectus et netus et malesuada fames ac turpis egestas.</p>
                                </div>

                            </div>
                            <div class="single-testimonial">
                                <div class="testi-img">
                                    <img src="public/assets/frontend/img/testimonial/testimonial-img.png" alt="img">
                                </div>
                                <div class="single-testimonial-bg">
                                    <div class="com-icon"><img src="public/assets/frontend/img/testimonial/qutation.png"
                                            alt="img"></div>
                                    <div class="testi-author">
                                        <div class="ta-info">
                                            <h6>Jone Dose</h6>
                                            <span>MD & Founder</span>

                                        </div>
                                    </div>
                                    <p>Nullam metus mi, sollicitudin eu elit non, laoreet consectetur urna. Nullam quis
                                        aliquet elit. Cras augue tortor, lacinia et fermentum eget, suscipit id ligula.
                                        Donec id mollis sem, nec tincidunt neque. Pellentesque habitant morbi tristique
                                        senectus et netus et malesuada fames ac turpis egestas.</p>
                                </div>

                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- testimonial-area-end -->

        <!-- mobile-app-area -->
        <div class="call-area pt-80 pb-80"
            style="background: #e8f1fc8a;background-image:url(public/assets/frontend/img/an-bg/an-bg09.png); background-repeat: no-repeat; background-position: center;background-size: cover;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="single-counter-img fadeInUp animated">
                            <img src="public/assets/frontend/img/video-calling.png" alt="easyDoctor Video Call" class="img">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="section-title mt-0">
                            <h2>Download the easyDoctor app</h2>
                            <p class="text-dark">Access video consultation with expert doctors anytime, anywhere. Download
                                the easyDoctor app for 24/7 healthcare at your fingertips.</p>
                            <div class="app-buttons mt-3">
                                <a href="#" class="btn ss-btn mx-1">
                                    <i class="fab fa-google-play"></i> Google Play
                                </a>
                                <a href="#" class="btn ss-btn mx-1">
                                    <i class="fab fa-apple"></i> App Store
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- counter-area-end -->

    </main>
@endsection