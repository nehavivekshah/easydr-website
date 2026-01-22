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
        <button class="scroll-to-top" id="scrollToTop" aria-label="Scroll to top">
            <i class="fas fa-chevron-up"></i>
        </button>

        <!-- Alert Messages -->
        @if (!empty(session('success')) || !empty(session('error')) || !empty($errors->any()))
        <div class="response-msg" style="margin-top: 80px;">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif(!empty(session('error')))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @else
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Errors occurred:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        @endif

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        <script src="{{ asset('public/assets/frontend/js/app.js') }}"></script>
        
        @stack('scripts')
    </body>
</html>