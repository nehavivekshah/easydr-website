<!-- header -->
<header class="header-area">
    <div class="header-top second-header d-none d-md-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8 d-none  d-md-block">
                    <div class="header-cta">
                        <ul>
                            <li>
                                <a href="https://apps.apple.com/in/app/" target="_blank"><i
                                        class="fab fa-apple"></i></a>
                                <a href="https://play.google.com/store/apps/details?id=com.easy.doctor"
                                    target="_blank"><i class="fab fa-android"></i></a>
                                <span>Download EasyDoctor App</span>
                            </li>
                            <!--<li>
                                <i class="icon dripicons-mail"></i>
                                <span>imtiazsmerchant@gmail.com</span>
                            </li>
                             <li>
                                <i class="icon dripicons-phone"></i>
                                <span>+91 9892220236</span>
                            </li>-->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-3 d-none d-lg-block">
                    <div class="header-cta text-right">
                        <ul>
                            <li><a href="/about-us" class="text-white">About Us</a></li>
                            <li><a href="/blog" class="text-white">Blog</a></li>
                            <li><a href="/career" class="text-white">Career</a></li>
                            <li><a href="/health-tips" class="text-white">Health Tips</a></li>
                            <!--<li>
                                <i class="icon dripicons-mail"></i>
                                <span>imtiazsmerchant@gmail.com</span>
                            </li>
                             <li>
                                <i class="icon dripicons-phone"></i>
                                <span>+91 9892220236</span>
                            </li>-->
                        </ul>
                        <!--<span>
                            <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>                               
                        </span> -->
                        <!--  /social media icon redux -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div id="header-sticky" class="menu-area menu-area2">
        <div class="container">
            <div class="second-menu">
                <div class="row align-items-center">
                    <div class="col-xl-2 col-lg-2">
                        <div class="logo2">
                            <a href="/"><img src="/public/assets/frontend/img/logo/logo.jpeg" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8">
                        <div class="main-menu text-right pe-15">
                            <nav id="mobile-menu">
                                <ul>
                                    <!--<li class="has-sub">
										<a href="/">Home</a>
									</li>-->
                                    <!--<li><a href="/patients">Patients</a></li>-->
                                    <li class="has-sub">
                                        <a href="/doctors">Find Doctors</a>
                                    </li>
                                    <li class="has-sub">
                                        <a href="/pharmacy">Pharmacy</a>
                                    </li>
                                    <li class="has-sub">
                                        <a href="/data-security">Data Security</a>
                                    </li>
                                    <li class="has-sub">
                                        <a href="/help">Help & Support</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 d-none d-lg-block text-center">
                        @if(!empty(Auth::User()->role))
                            <div class="main-menu text-right">
                                <ul>
                                    <li class="has-sub">
                                        <a href="javascript:void(0)"><span class="top-btn"><i class="fas fa-user pe-1"></i>
                                                {{Auth::User()->first_name}}</span></a>
                                        <ul class="has-right">
                                            <li><a href="/my-account"><i class="fas fa-user pe-1"></i> My Account</a></li>
                                            <li><a href="/reset-posswprd"><i class="fas fa-key pe-1"></i> Reset Password</a>
                                            </li>
                                            <li><a href="/logout"><i class="fas fa-sign-out-alt pe-2"></i>Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#authModal"
                                class="top-btn">Login / Signup</a>
                        @endif
                    </div>
                    <div class="col-12">
                        <div class="mobile-menu"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header-end -->