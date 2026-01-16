    @if(Request::segment(2) == 'login' || Request::segment(2) == 'register')
        <!-- Link Styles -->
        <link href="{{ asset('/public/assets/css/app.css'); }}" rel="stylesheet" />
        
    @else
    
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        
        <!-- Flatpickr CSS -->
        <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
        <link rel="stylesheet" href="{{ asset('/public/assets/css/style.css') }}">
    @endif