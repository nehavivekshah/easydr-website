<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('frontend.libs.meta-data')
    @include('frontend.libs.header')
</head>

<body>
    @include('frontend.libs.menu')

    @yield('content')

    @include('frontend.libs.footer-widgets')
    @include('frontend.libs.footer')

    <!-- Scroll to Top Button -->
    <!-- <button class="scroll-to-top" id="scrollToTop" aria-label="Scroll to top">
            <i class="fas fa-chevron-up"></i>
        </button> -->

    <!-- Alert Messages / Toast Notifications -->
    @include('frontend.inc.toast')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="{{ asset('public/assets/frontend/js/app.js') }}"></script>
    @include('frontend.inc.auth_modal')
    @stack('scripts')
</body>

</html>