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
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h4 class="mb-4">Manage Slots</h4>
                                <div class="alert alert-info">
                                    Slot management functionality is coming soon. Please use the mobile app for full
                                    functionality.
                                </div>
                                @if(isset($slots) && count($slots) > 0)
                                    <ul class="list-group">
                                        @foreach($slots as $slot)
                                            <li class="list-group-item">
                                                {{ $slot->start_time }} - {{ $slot->end_time }} ({{ $slot->available_days }})
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No slots configured.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection