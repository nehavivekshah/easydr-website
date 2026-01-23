@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>

        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex align-items-center"
            style="background: linear-gradient(135deg, #f0f4f8 0%, #e2e8f0 100%); padding: 80px 0 60px;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="mb-3 fw-800 display-5 text-dark" style="letter-spacing: -0.5px;">Find Your Specialist
                        </h2>
                        <p class="text-muted lead mb-0 px-lg-5">Connect with top-tier medical professionals for world-class
                            care.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <!-- filter-area -->
        <div class="filter-area position-relative" style="margin-top: -40px; z-index: 10;">
            <div class="container">
                <div class="bg-white p-4 rounded-3 shadow-lg search-filter-card">
                    <form action="/doctors" method="GET">
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-5">
                                <!-- <label for="search" class="visually-hidden">Search Doctor</label> -->
                                <div
                                    class="input-group input-group-lg border rounded-3 overflow-hidden transition-all bg-light">
                                    <span class="input-group-text bg-transparent border-0 ps-3">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" id="search" name="search"
                                        class="form-control border-0 bg-transparent shadow-none"
                                        placeholder="Search by name or keyword..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <!-- <label for="specialty" class="visually-hidden">Specialty</label> -->
                                <div
                                    class="input-group input-group-lg flex-nowrap border rounded-3 overflow-hidden transition-all bg-light">
                                    <span class="input-group-text bg-transparent border-0 ps-3">
                                        <i class="fas fa-stethoscope text-muted"></i>
                                    </span>
                                    <select id="specialty" name="specialty"
                                        class="form-select border-0 bg-transparent shadow-none pr-2 w-100"
                                        style="cursor: pointer;">
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
                            </div>
                            <div class="col-lg-2">
                                <button type="submit"
                                    class="btn ss-btn btn-primary w-100 btn-lg fw-600 rounded-3 shadow-sm btn-filter h-100 d-flex justify-content-center align-items-center">
                                    Find Doctor
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- filter-area-end -->

        <!-- doctors-area -->
        <section class="doctors-area pt-80 pb-80" style="background: #ffffff;">
            <div class="container">

                <div class="row align-items-center mb-5">
                    <div class="col-md-6">
                        @if($doctors->count() > 0)
                            <h5 class="mb-0 fw-700 text-dark">
                                <span class="text-primary">{{ $doctors->count() }}</span> Expert(s) Available
                            </h5>
                        @endif
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        @if(request('search') || request('specialty'))
                            <!-- <a href="/doctors" class="btn btn-link text-decoration-none text-muted p-0 hover-text-primary">
                                                                                        <i class="fas fa-times-circle me-1"></i> Clear all filters
                                                                                    </a> -->
                        @endif
                    </div>
                </div>

                <div class="row g-4">
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
                        <div class="col-12 text-center py-5">
                            <div class="empty-state">
                                <img src="{{ asset('public/assets/images/no-data.svg') }}" alt="No doctors found"
                                    style="width: 120px; opacity: 0.6; margin-bottom: 20px;"
                                    onerror="this.style.display='none'">
                                <h4 class="fw-700 text-dark mb-2">No Doctors Found</h4>
                                <p class="text-muted mx-auto" style="max-width: 400px;">
                                    We couldn't find any doctors matching your criteria. Try adjusting your filters.
                                </p>
                                <a href="/doctors" class="btn btn-outline-primary rounded-pill px-4 mt-3 fw-600">
                                    Reset Filters
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="row mt-50">
                    <div class="col-12">
                        <div class="pagination-wrap text-center d-flex justify-content-center">
                            {{-- Assuming standard Laravel pagination links, otherwise custom style --}}
                            {{-- {{ $doctors->links() }} --}}
                            @if(isset($doctors) && $doctors->count() >= 8)
                                <div class="text-muted small">Showing top results</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- doctors-area-end -->

    </main>
    <!-- main-area-end -->
@endsection

@push('scripts')
    <style>
        /* General Utilities */
        .fw-500 {
            font-weight: 500;
        }

        .fw-600 {
            font-weight: 600;
        }

        .fw-700 {
            font-weight: 700;
        }

        .fw-800 {
            font-weight: 800;
        }

        .font-11 {
            font-size: 11px;
        }

        .font-12 {
            font-size: 12px;
        }

        .font-13 {
            font-size: 13px;
        }

        .font-14 {
            font-size: 14px;
        }

        .font-16 {
            font-size: 16px;
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }

        /* Soft Colors */
        .bg-primary-soft {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .input-group.input-group-lg.border.rounded-3.overflow-hidden.transition-all.bg-light {
            border-radius: 100px !important;
        }

        input#search,
        select#specialty {
            border-top-left-radius: 0px !important;
            border-bottom-left-radius: 0px !important;
            border-top-right-radius: 50px !important;
            border-bottom-right-radius: 50px !important;
        }

        /* Search & Filter */
        .search-filter-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 100px;
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
            border-color: #0d6efd;
            background-color: #fff;
        }

        .input-group input::placeholder {
            color: #adb5bd;
        }

        .doctor-card .text-muted {
            gap: 7px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Doctor Card */
        .doctor-card {
            background: #fff;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.04) !important;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-color: rgba(13, 110, 253, 0.1) !important;
        }

        .doctor-img-wrap img {
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .doctor-card:hover .doctor-img-wrap img {
            transform: scale(1.05);
        }

        .doctor-action-overlay {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .doctor-card:hover .doctor-action-overlay {
            opacity: 1;
        }

        .hover-text-primary:hover {
            color: #0d6efd !important;
        }

        .hover-y-shift {
            transition: transform 0.2s;
        }

        .hover-y-shift:hover {
            transform: translateY(-2px);
        }

        .transform-scale-sm {
            transition: transform 0.2s;
        }

        .transform-scale-sm:hover {
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .filter-area {
                margin-top: 0 !important;
                margin-bottom: 20px;
            }

            .breadcrumb-area {
                padding: 40px 0;
            }
        }
    </style>
@endpush