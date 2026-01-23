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
                                <label for="search" class="visually-hidden">Search Doctor</label>
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
                                <label for="specialty" class="visually-hidden">Specialty</label>
                                <div
                                    class="input-group input-group-lg border rounded-3 overflow-hidden transition-all bg-light">
                                    <span class="input-group-text bg-transparent border-0 ps-3">
                                        <i class="fas fa-stethoscope text-muted"></i>
                                    </span>
                                    <select id="specialty" name="specialty"
                                        class="form-select border-0 bg-transparent shadow-none" style="cursor: pointer;">
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
                                    class="btn btn-primary w-100 btn-lg fw-600 rounded-3 shadow-sm btn-filter h-100">
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
                            <a href="/doctors" class="btn btn-link text-decoration-none text-muted p-0 hover-text-primary">
                                <i class="fas fa-times-circle me-1"></i> Clear all filters
                            </a>
                        @endif
                    </div>
                </div>

                <div class="row g-4">
                    @forelse ($doctors as $doctor)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <div class="card doctor-card h-100 border-0 rounded-4 overflow-hidden position-relative">

                                {{-- Doctor Image --}}
                                <div class="doctor-img-wrap position-relative overflow-hidden bg-light">
                                    <a href="/doctor/{{ $doctor->uid ?? '' }}/{!! md5($doctor->email ?? '') !!}">
                                        <img src="{{ asset(!empty($doctor->photo) ? 'public/assets/images/profiles/' . $doctor->photo : 'public/assets/images/doctor-placeholder.png') }}"
                                            class="card-img-top w-100"
                                            alt="Dr. {{ $doctor->first_name ?? '' }} {{ $doctor->last_name ?? '' }}"
                                            style="height: 280px; object-fit: cover; object-position: top;">
                                    </a>

                                    {{-- Experience Badge --}}
                                    @if(!empty($doctor->experience))
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge bg-white text-dark shadow-sm rounded-pill px-3 py-2 fw-600 font-12">
                                                {{ $doctor->experience }} Exp
                                            </span>
                                        </div>
                                    @endif

                                    {{-- Hover Action --}}
                                    <div
                                        class="doctor-action-overlay position-absolute bottom-0 start-0 w-100 p-3 d-flex justify-content-center">
                                        <a href="/doctor/{{ $doctor->uid ?? '' }}/{!! md5($doctor->email ?? '') !!}"
                                            class="btn btn-light rounded-pill px-4 py-2 fw-600 shadow-sm transform-scale-sm">
                                            View Profile
                                        </a>
                                    </div>
                                </div>

                                {{-- Card Body --}}
                                <div class="card-body p-4 text-center d-flex flex-column">
                                    {{-- Specialization --}}
                                    <div class="mb-2">
                                        <span
                                            class="badge bg-primary-soft text-primary rounded-pill px-3 py-1 font-11 fw-600 text-uppercase tracking-wider">
                                            {{ $doctor->specialist ?? 'General' }}
                                        </span>
                                    </div>

                                    {{-- Name --}}
                                    <h5 class="card-title fw-700 mb-2">
                                        <a href="/doctor/{{ $doctor->uid ?? '' }}/{!! md5($doctor->email ?? '') !!}"
                                            class="text-dark text-decoration-none hover-text-primary transition-colors">
                                            Dr. {{ $doctor->first_name ?? '' }} {{ $doctor->last_name ?? '' }}
                                        </a>
                                    </h5>

                                    {{-- Rating --}}
                                    <div class="mb-3 d-flex justify-content-center align-items-center">
                                        @if(isset($doctor->avg_rating) && $doctor->avg_rating > 0)
                                            <i class="fas fa-star text-warning font-12 me-1"></i>
                                            <span
                                                class="fw-bold text-dark font-14">{{ number_format($doctor->avg_rating, 1) }}</span>
                                            <span class="text-muted ms-1 font-12">({{ $doctor->reviews_count ?? 0 }} reviews)</span>
                                        @else
                                            <span class="text-muted font-13 fst-italic">No ratings yet</span>
                                        @endif
                                    </div>

                                    <div class="border-top w-100 my-3 opacity-25"></div>

                                    {{-- Fees & Action --}}
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted font-13 fw-500">Consultation</span>
                                            <span class="text-dark fw-700 font-16">
                                                @if(!empty($doctor->fees))
                                                    ₹{{ number_format($doctor->fees, 0) }}
                                                @else
                                                    <span class="text-success font-13">Free</span>
                                                @endif
                                            </span>
                                        </div>
                                        <a href="/doctor/{{ $doctor->uid ?? '' }}/{!! md5($doctor->email ?? '') !!}"
                                            class="btn btn-primary w-100 rounded-3 py-2 fw-600 shadow-sm btn-book hover-y-shift">
                                            Book Appointment
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

        /* Search & Filter */
        .search-filter-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
            border-color: #0d6efd;
            background-color: #fff;
        }

        .input-group input::placeholder {
            color: #adb5bd;
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