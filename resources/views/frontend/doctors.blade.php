@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>

        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex align-items-center pt-60 pb-60"
            style="background: linear-gradient(135deg, #e8f1fc 0%, #f2f9fb 100%); min-height: 250px;">
            <div class="container">

                <div class="row mb-30">
                    <div class="col-12">
                        <h2 class="mb-3 fw-bold text-dark">Find Our Doctors</h2>
                        <p class="text-muted mb-0">Browse and book appointments with our experienced medical professionals
                        </p>
                    </div>
                </div>

                <!-- Search & Filter Form -->
                <div class="doctor-search-filter">
                    <form action="/doctors" method="GET">
                        <div class="row align-items-end g-3">
                            <div class="col-lg-5 col-md-12">
                                <label for="search" class="form-label fw-600 mb-2 text-muted small">Search by Name or
                                    Expertise</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white border-end-0"
                                        style="border-radius: 8px 0 0 8px;">
                                        <i class="fas fa-search text-primary"></i>
                                    </span>
                                    <input type="text" id="search" name="search" class="form-control border-start-0"
                                        placeholder="e.g. Dr. John or Cardiology..." value="{{ request('search') }}"
                                        style="border-radius: 0 8px 8px 0;">
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-12">
                                <label for="specialty" class="form-label fw-600 mb-2 text-muted small">Filter by
                                    Specialty</label>
                                <select id="specialty" name="specialty" class="form-select form-select-lg"
                                    aria-label="Filter by specialty" style="border-radius: 8px; border: 2px solid #eee;">
                                    <option value="">All Specialties</option>
                                    @isset($specialists)
                                        @foreach($specialists as $specialist)
                                            <option value="{{ $specialist->title }}" {{ request('specialty') == $specialist->title ? 'selected' : '' }}>
                                                {{ $specialist->title }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-12">
                                <button type="submit" class="btn btn-primary w-100 btn-lg fw-600"
                                    style="border-radius: 8px; padding: 12px 20px;">
                                    <i class="fas fa-filter me-2"></i>Filter
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
        <section class="doctors-area py-80" style="background: #f8fafc;">
            <div class="container">

                <div class="row mb-40 align-items-center">
                    <div class="col-md-8">
                        @if($doctors->count() > 0)
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 fw-bold text-dark">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Found <span class="text-primary">{{ $doctors->count() }}</span> matching doctor(s)
                                </h5>
                                @if($doctors->count() >= 8)
                                    <span class="badge bg-light text-dark ms-3">(Top Results)</span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="/doctors" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-redo me-1"></i>Clear Filters
                        </a>
                    </div>
                </div>

                <div class="row">
                    @forelse ($doctors as $doctor)
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
                            <div class="card doctor-card h-100 border-0 overflow-hidden transition-all"
                                style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: all 0.3s ease;">

                                {{-- Doctor Image Container --}}
                                <div class="position-relative bg-light overflow-hidden doctor-image-wrapper"
                                    style="height: 250px;">
                                    <img src="{{ asset(!empty($doctor->photo) ? 'public/assets/images/profiles/' . $doctor->photo : 'public/assets/images/doctor-placeholder.png') }}"
                                        class="card-img-top w-100 h-100"
                                        alt="Dr. {{ $doctor->first_name ?? '' }} {{ $doctor->last_name ?? '' }}"
                                        style="object-fit: cover; transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);">

                                    {{-- Hover Overlay with Button --}}
                                    <div class="doctor-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                        style="background: rgba(30, 41, 99, 0.7); opacity: 0; transition: all 0.3s ease;">
                                        <a href="/doctor/{{ $doctor->uid ?? '' }}/{!! md5($doctor->email ?? '') !!}"
                                            class="btn btn-light rounded-pill px-4 py-2 fw-bold transform-scale"
                                            style="transform: scale(0.9); transition: all 0.3s ease;">
                                            View Profile
                                        </a>
                                    </div>

                                    {{-- Experience Badge --}}
                                    @if(!empty($doctor->experience))
                                        <div class="position-absolute bottom-0 start-0 w-100 p-2"
                                            style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
                                            <span class="badge bg-primary rounded-pill px-2 py-1 font-12 fw-500">
                                                <i class="fas fa-briefcase-medical me-1"></i>{{ $doctor->experience }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Doctor Info Body --}}
                                <div class="card-body d-flex flex-column pt-3 pb-3 px-3 text-center" style="flex-grow: 1;">

                                    {{-- Name --}}
                                    <h5 class="card-title mb-1">
                                        <a href="/doctor/{{ $doctor->uid ?? '' }}/{!! md5($doctor->email ?? '') !!}"
                                            class="text-decoration-none text-dark fw-bold" style="font-size: 1.1rem;">
                                            Dr. {{ $doctor->first_name ?? '' }} {{ $doctor->last_name ?? '' }}
                                        </a>
                                    </h5>

                                    {{-- Specialization --}}
                                    <p class="text-primary mb-1 fw-600 font-13 text-uppercase"
                                        style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                        {{ $doctor->specialist ?? 'Specialist' }}
                                    </p>

                                    {{-- Spacer --}}
                                    <div class="w-100 my-2 border-bottom opacity-50"></div>

                                    {{-- Rating --}}
                                    <div class="mb-2">
                                        @if(isset($doctor->avg_rating) && $doctor->avg_rating > 0)
                                            <div
                                                class="d-inline-flex align-items-center justify-content-center bg-light rounded-pill px-3 py-1">
                                                <i class="fas fa-star text-warning font-12 me-1"></i>
                                                <span
                                                    class="fw-bold font-13 text-dark">{{ number_format($doctor->avg_rating, 1) }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted font-12"><i class="far fa-star me-1"></i>No ratings</span>
                                        @endif
                                    </div>

                                    {{-- Fees --}}
                                    <div class="mt-auto">
                                        @if(!empty($doctor->fees))
                                            <h6 class="text-dark mb-3 fw-bold d-flex align-items-center justify-content-center">
                                                <span class="text-muted font-12 fw-normal me-1">Consultation:</span>
                                                ₹{{ number_format($doctor->fees, 0) }}
                                            </h6>
                                        @endif

                                        <a href="/doctor/{{ $doctor->uid ?? '' }}/{!! md5($doctor->email ?? '') !!}"
                                            class="btn ss-btn btn-primary w-100 fw-600 rounded-3 shadow-sm hover-y-shift text-center"
                                            style="min-width: 100% !important;">
                                            Book Now
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-light border-2 border-primary text-center py-5 rounded-10" role="alert"
                                style="background: linear-gradient(135deg, #f0f7ff 0%, #f5fbff 100%);">
                                <i class="fas fa-search fa-3x mb-4 d-block text-primary opacity-50"></i>
                                <h4 class="alert-heading fw-bold text-dark">No Doctors Found</h4>
                                <p class="text-muted mb-4">We couldn't find any doctors matching your current search or filter
                                    criteria.</p>
                                <hr class="my-4">
                                <a href="/doctors" class="btn btn-primary">
                                    <i class="fas fa-redo me-2"></i>Clear Filters & Try Again
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination & Results Info -->
                <div class="row mt-40">
                    <div class="col-12">
                        <div class="pagination-wrap text-center">
                            @if(isset($doctors) && $doctors->count() >= 8)
                                <div class="alert alert-info alert-light border-2 border-info d-inline-block rounded-10 px-4 py-3"
                                    role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Showing top results.</strong> Use filters above for more specific search results.
                                </div>
                            @else
                                <div class="alert alert-success alert-light border-2 border-success d-inline-block rounded-10 px-4 py-3"
                                    role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    All available doctors matching your criteria are displayed above.
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
    <style>
        .doctor-card .text-muted {
            gap: 7px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .doctor-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .doctor-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .doctor-image-wrapper img {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .doctor-card:hover .doctor-image-wrapper img {
            transform: scale(1.08);
        }

        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .breadcrumb-area {
                min-height: auto !important;
                padding: 40px 0 !important;
            }

            .doctor-card {
                margin-bottom: 20px;
            }
        }
    </style>
@endpush