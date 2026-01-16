@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area d-flex align-items-center pt-60" style="background: #e8f1fc8a; min-height: 200px;">
            <div class="container">

                <!-- Search & Filter Form -->
                <div class="doctor-search-filter">
                    <form action="/doctors" method="GET">
                        <div class="row align-items-end">
                            <div class="col-lg-5 col-md-6 mb-3">
                                <!-- <label for="search" class="form-label fw-bold">Search Doctor</label> -->
                                <input type="text" id="search" name="search" class="form-control form-control-lg" placeholder="Search Doctor or Specialty..." value="{{ request('search') }}">
                            </div>
                            <div class="col-lg-5 col-md-6 mb-3">
                                <!-- <label for="specialty" class="form-label fw-bold">Filter by Specialty</label> -->
                                <select id="specialty" name="specialty" class="form-control form-control-lg" aria-label="Filter by specialty">
                                    <option value="">Select Specialties</option>
                                    @isset($specialists)
                                        @foreach($specialists as $specialist)
                                            <option value="{{ $specialist->title }}" {{ request('specialty') == $specialist->title ? 'selected' : '' }}>
                                                {{ $specialist->title }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary w-100 py-3 top-btn">
                                    <span class="fas fa-search me-1"></span> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End Search & Filter Form -->

            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <!-- doctors-area -->
        <section class="doctors-area pt-0 pb-80 p-relative" style="background: #f2f9fb;">
            <div class="container">
                
                <div class="row mb-30 align-items-center">
                    <div class="col-md-6">
                        @if($doctors->count() > 0)
                            <h6>Showing <span class="fw-bold">{{ $doctors->count() }}</span> matching doctor(s) @if($doctors->count() >= 8) (Top Results) @endif</h6>
                        @endif
                    </div>
                </div>

                <div class="row">
                    @forelse ($doctors as $doctor)
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
                    @empty
                         <div class="col-12">
                            <div class="alert alert-info text-center py-5" role="alert">
                                <i class="fas fa-user-md fa-3x mb-3 d-block"></i>
                                <h4 class="alert-heading">No Doctors Found</h4>
                                <p>We couldn't find any doctors matching your current search or filter criteria.</p>
                                <hr>
                                <a href="/doctors" class="btn btn-outline-primary">Clear Filters & Search</a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination Placeholder -->
                <div class="row">
                     <div class="col-12">
                        <div class="pagination-wrap mt-20 text-center">
                            @if(isset($doctors) && $doctors->count() >= 8)
                               <div class="alert alert-light d-inline-block" role="alert">
                                   Showing top results. Use filters for more specific search.
                                   {{-- Add pagination links here if implemented in controller --}}
                               </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Pagination End -->

            </div>
        </section>
        <!-- doctors-area-end -->

    </main>
    <!-- main-area-end -->
@endsection

@push('scripts')

@endpush