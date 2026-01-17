@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>
        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex align-items-center"
            style="background-image:url(public/assets/frontend/img/testimonial/test-bg.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                        <div class="breadcrumb-wrap text-center">
                            <div class="breadcrumb-title mb-30">
                                <h2>Departments</h2>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Departments</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->
        <!-- department-area -->
        <section class="department-area cta-bg pb-70 pt-100 fix"
            style="background-image:url(public/assets/frontend/img/an-bg/an-bg05.png); background-size: contain;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <ul>
                            @foreach($specialists as $specialist)
                                <li>
                                    <div class="icon">
                                        <div><img
                                                src="{{ !empty($specialist->image) ? asset('assets/images/specialists/' . $specialist->image) : asset('public/assets/frontend/img/icon/de-icon01.png') }}"
                                                alt="{{ $specialist->title }}"></div>
                                    </div>
                                    <a href="/doctors?specialty={{ $specialist->id }}" class="text">
                                        <h3>{{ $specialist->title }}</h3>
                                        {{ $specialist->description ?? 'Specialized medical care services.' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                    <div class="col-lg-6">
                        <div class="s-d-img p-relative">
                            <img src="public/assets/frontend/img/bg/de-illustration.png" alt="img">

                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- department-area-end -->

    </main>
    <!-- main-area-end -->
@endsection