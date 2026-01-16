@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>
        <!-- slider-area -->
        <section id="home" class="slider-area fix p-relative">
           
            <div class="slider-active2">
			    <div class="single-slider slider-bg d-flex align-items-center" style="background-image:url(public/assets/frontend/img/an-bg/header-bg.png)">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slider-content s-slider-content text-left">
                                    <h2 data-animation="fadeInUp" data-delay=".4s">Access HealthCare <span>Anywhere</span></h2>
                                    <p data-animation="fadeInUp" data-delay=".6s">Connect with your Doctor and Pharmacy from your Laptop, PC, Mobile or Tablet.
                                        <br>Schedule and Attend Appointment with your medical practicenor<br>Share & Generate Reports, Track Appointments</p>
                                    <div class="slider-btn mt-25">                                          
                                        <a href="/about-us" class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s">Learn More <i class="fas fa-chevron-right"></i></a>					
                                    </div>
                                </div>
                            </div>
							<div class="col-lg-6">
								<img src="public/assets/frontend/img/bg/header-img.png" alt="header-img" class="header-img"/>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- slider-area-end -->

        <!-- specialists-area -->
        <section id="specialists" class="specialists-area p-relative pt-80 pb-80">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <div class="section-title text-left">
                            <h2 class="h4 mb-0">Specialists</h2>
                        </div>
                    </div>
                    <div class="col-4 text-right">
                        <a href="/specialists" class="btn ss-btn float-right">See All <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12">
                    <div class="row justify-content-center px-0">
                        @foreach($specialists as $speciality)
                        <div class="col-lg-2 col-md-3 col-sm-6 px-2">
                            <div class="single-specialists shadow mt-30">
                                <a href="/doctors/{{ Str::slug($speciality->title ?? '') }}" class="specialists-icon">
                                    @if (!empty($speciality->icons))
                                        <img src="{{ asset('/public/assets/images/specialists/' . $speciality->icons) }}" alt="img">
                                    @else 
                                        <img src="/public/assets/icons/image.svg" alt="img">
                                    @endif
                                </a>
                                <div class="specialists-content">
                                    <h6 class="title"><a href="/doctors/{{ Str::slug($speciality->title ?? '') }}">
                                    {!! strlen($speciality->title ?? '') > 15 ? substr($speciality->title, 0, 15) . '...' : $speciality->title !!}
                                    </a></h6>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- <form action="#" class="contact-form" >
						<div class="row">
                            <div class="col-lg-12"> 
                                <ul>
                                    <li> 
                                        <div class="contact-field p-relative c-name">  
                                            <input type="text" placeholder="Enter Name">
                                        </div>      
                                    </li>
                                    <li>
                                        <div class="contact-field p-relative c-email">    
                                             <select class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                                        <option selected>Select Doctor...</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                      </select>
                                        </div> 
                                    </li>
                                    <li>
                                         <div class="contact-field p-relative c-subject mb-20">                     <select class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                                        <option selected>Select Department...</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                      </select>
                                        </div>
                                    
                                    </li>
                                    <li>
                                        <div class="slider-btn">                                          
                                        <a href="#" class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s">Submit Now <i class="fas fa-chevron-right"></i></a>
                                    </div>     
                                    </li>
                                </ul>
                            </div>
                      
                        </div>
                    
                </form> -->
            </div>
        </section>
        <!-- specialists-area-end -->

        <!-- doctors-area-->
        <section id="doctors" class="doctors-area pt-80 pb-80" 
        style="background: #e8f1fc8a; background-image:url(public/assets/frontend/img/an-bg/an-bg13.png); background-size: contain;background-position: center center;background-repeat: no-repeat;">
          
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <div class="section-title text-left">
                            <h2 class="h4 mb-0">Our Doctors</h2>
                        </div>
                    </div>
                    <div class="col-4 text-right">
                        <a href="/doctors" class="btn ss-btn float-right">See All <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="row doctor-active">
                    @foreach ($doctors as $doctor)
                    <div class="col-xl-3 col-lg-3 col-md-4 mt-4">
                        <div class="card h-100 shadow-sm border-0 rounded-10 overflow-hidden">

                            {{-- Doctor Image --}}
                            <div class="position-relative text-center bg-light">
                                <img src="{{ asset( !empty($doctor->photo) ? 'public/assets/images/profiles/' . $doctor->photo : 'public/assets/images/doctor-placeholder.png' ) }}"
                                    class="card-img-top"
                                    alt="Dr. {{ $doctor->first_name ?? '' }} {{ $doctor->last_name ?? '' }}"
                                    style="height: 195px; object-fit: contain; width: 100%;">
                            </div>

                            {{-- Doctor Info --}}
                            <div class="card-body d-flex flex-column line-height-1">
                                {{-- Name --}}
                                <h5 class="card-title mb-0">
                                    <a href="/doctor/{{ $doctor->id ?? '' }}/{!! md5($doctor->email ?? '') !!}" class="text-decoration-none stretched-link text-dark fw-bold">
                                        Dr. {{ $doctor->first_name ?? '' }} {{ $doctor->last_name ?? '' }} {{-- Added "Dr." prefix --}}
                                    </a>
                                </h5>

                                {{-- Specialization --}}
                                <p class="text-mute mb-0 fw-medium font-14">{{ $doctor->specialist ?? 'Specialist' }}</p>

                                {{-- Rating - Using Font Awesome Stars --}}
                                <div class="font-11">
                                    @if(isset($doctor->avg_rating) && $doctor->avg_rating > 0)
                                        @php
                                            $rating = round($doctor->avg_rating);
                                            $maxRating = 5;
                                        @endphp
                                        <span class="text-warning"> {{-- Yellow stars --}}
                                            @for ($i = 1; $i <= $maxRating; $i++)
                                                <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star"></i>
                                            @endfor
                                        </span>
                                        <span class="ms-1 text-muted">({{ number_format($doctor->avg_rating, 1) }})</span>
                                    @else
                                        <span class="text-muted fst-italic">No ratings yet</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- doctors-area-end -->

        <!-- about-area -->
        <section id="about" class="about-area about-p pt-80 pb-80 p-relative" style="background-image:url(public/assets/frontend/img/an-bg/an-bg03.png); background-size: contain; background-repeat: no-repeat;background-position: center center;">
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
                            <p>Nulla lacinia sapien a diam ullamcorper, sed congue leo vulputate. Phasellus et ante ultrices, sagittis purus vitae, sagittis quam. Quisque urna lectus, auctor quis tristique tincidunt, semper vel lectus. Mauris eget eleifend massa. Praesent ex felis, laoreet nec tellus in, laoreet commodo ipsum.</p>
                            
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
                                <a href="/about-us" class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s">Read More <i class="fas fa-chevron-right"></i></a>					
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <!-- about-area-end -->

        <!-- testimonial-area -->
        <section id="testimonios" class="testimonial-area testimonial-p pt-80 pb-80 fix" style="background: #e8f1fc8a;background-image: url(public/assets/frontend/img/an-bg/an-bg07.png);background-position: center; background-repeat: no-repeat;background-size: contain;" >
            <div class="container">
                  <div class="row justify-content-center">
                    
                    <div class="col-lg-8"> 
                 <div class="section-title center-align mb-60 text-center">
                            <span>TESTIMONIAL</span>
                            <h2>What Our Client’s Say’s</h2>
                           <p>Fusce pharetra odio in urna laoreet laoreet. Aliquam erat volutpat. Phasellus nec ligula arcu. Aliquam eu urna pulvinar, iaculis ipsum in, porta massa.</p>
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
							    <div class="com-icon"><img src="public/assets/frontend/img/testimonial/qutation.png" alt="img"></div>
                                    <div class="testi-author">
                                                 <div class="ta-info">                                          
                                        <h6>Adam McWilliams</h6>
                                        <span>CEO & Founder</span>
                                        
                                    </div>
                                </div>
                                <p>Nullam metus mi, sollicitudin eu elit non, laoreet consectetur urna. Nullam quis aliquet elit. Cras augue tortor, lacinia et fermentum eget, suscipit id ligula. Donec id mollis sem, nec tincidunt neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                                    </div>
                               
                            </div>
                            <div class="single-testimonial">
                                 <div class="testi-img">
                                    <img src="public/assets/frontend/img/testimonial/testimonial-img.png" alt="img">                                        
                                </div>
                                <div class="single-testimonial-bg">
							    <div class="com-icon"><img src="public/assets/frontend/img/testimonial/qutation.png" alt="img"></div>
                                    <div class="testi-author">
                                                 <div class="ta-info">                                          
                                        <h6>Rose Dose</h6>
                                        <span>Sale Executive</span>
                                        
                                    </div>
                                </div>
                                <p>Nullam metus mi, sollicitudin eu elit non, laoreet consectetur urna. Nullam quis aliquet elit. Cras augue tortor, lacinia et fermentum eget, suscipit id ligula. Donec id mollis sem, nec tincidunt neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                                    </div>
                               
                            </div>
                                <div class="single-testimonial">
                                 <div class="testi-img">
                                    <img src="public/assets/frontend/img/testimonial/testimonial-img.png" alt="img">                                        
                                </div>
                                <div class="single-testimonial-bg">
							    <div class="com-icon"><img src="public/assets/frontend/img/testimonial/qutation.png" alt="img"></div>
                                    <div class="testi-author">
                                                 <div class="ta-info">                                          
                                        <h6>Margie R. Robinson</h6>
                                        <span>Web Developer</span>
                                        
                                    </div>
                                </div>
                                <p>Nullam metus mi, sollicitudin eu elit non, laoreet consectetur urna. Nullam quis aliquet elit. Cras augue tortor, lacinia et fermentum eget, suscipit id ligula. Donec id mollis sem, nec tincidunt neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                                    </div>
                               
                            </div>
                                 <div class="single-testimonial">
                                 <div class="testi-img">
                                    <img src="public/assets/frontend/img/testimonial/testimonial-img.png" alt="img">                                        
                                </div>
                                <div class="single-testimonial-bg">
							    <div class="com-icon"><img src="public/assets/frontend/img/testimonial/qutation.png" alt="img"></div>
                                    <div class="testi-author">
                                                 <div class="ta-info">                                          
                                        <h6>Jone Dose</h6>
                                        <span>MD & Founder</span>
                                        
                                    </div>
                                </div>
                                <p>Nullam metus mi, sollicitudin eu elit non, laoreet consectetur urna. Nullam quis aliquet elit. Cras augue tortor, lacinia et fermentum eget, suscipit id ligula. Donec id mollis sem, nec tincidunt neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                                    </div>
                               
                            </div>
                        
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <!-- testimonial-area-end -->

        <!-- mobile-app-area -->
        <div class="call-area pt-80 pb-80" style="background: #e8f1fc8a;background-image:url(public/assets/frontend/img/an-bg/an-bg09.png); background-repeat: no-repeat; background-position: center;background-size: cover;">
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
                            <p class="text-dark">Access video consultation with expert doctors anytime, anywhere. Download the easyDoctor app for 24/7 healthcare at your fingertips.</p>
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