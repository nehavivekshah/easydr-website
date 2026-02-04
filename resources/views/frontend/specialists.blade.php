{{-- resources/views/frontend/specialists.blade.php --}}

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
                                <h2>Specialties</h2>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Specialties</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <!-- specialists-area -->
        <section class="specialists-area pt-60 pb-80 p-relative" style="background: #f2f9fb;">
            <div class="container">

                <div class="row justify-content-center">

                    @forelse ($specialists as $speciality)
                        <div class="col-lg-2 col-md-3 col-sm-6 px-2">
                            <div class="single-specialists shadow mt-30">
                                <a href="/doctors?specialty={{ $speciality->title }}" class="specialists-icon">
                                    @if (!empty($speciality->icons))
                                        <img src="{{ asset('/public/assets/images/specialists/' . $speciality->icons) }}" alt="img">
                                    @else
                                        <img src="/public/assets/icons/image.svg" alt="img">
                                    @endif
                                </a>
                                <div class="specialists-content">
                                    <h6 class="title"><a href="/doctors?specialty={{ $speciality->title }}">
                                            {!! strlen($speciality->title ?? '') > 15 ? substr($speciality->title, 0, 15) . '...' : $speciality->title !!}
                                        </a></h6>
                                </div>
                            </div>
                        </div>
                    @empty

                        <div class="col-12">
                            <div class="alert alert-info text-center py-5" role="alert">
                                <i class="fas fa-tags fa-3x mb-3 d-block"></i>
                                <h4 class="alert-heading">No Specialties Found</h4>
                                <p>We couldn't find any medical specialties listed at this time.</p>
                                <hr>
                                <p class="mb-0">Please check back later or contact support if you believe this is an error.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="row">
                    <div class="col-12 text-center mt-40">
                    </div>
                </div>

            </div>
        </section>
        <!-- specialists-area-end -->

    </main>
    <!-- main-area-end -->
@endsection