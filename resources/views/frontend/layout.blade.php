<!doctype html>
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
        
        @if (!empty(session('success')) || !empty(session('error')) || !empty($errors->any()))
        <div class="response-msg">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif(!empty(session('error')))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @else
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        <script>
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 3000); // 3 seconds
        </script>
        @endif
    </body>
</html>