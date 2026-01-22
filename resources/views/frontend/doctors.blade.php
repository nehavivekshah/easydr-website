@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area d-flex align-items-center pt-60 pb-60" style="background: linear-gradient(135deg, #e8f1fc 0%, #f2f9fb 100%); min-height: 250px;">
            <div class="container">

                <div class="row mb-30">
                    <div class="col-12">
                        <h2 class="mb-3 fw-bold text-dark">Find Our Doctors</h2>
                        <p class="text-muted mb-0">Browse and book appointments with our experienced medical professionals</p>
                    </div>
                </div>

                <!-- Search & Filter Form -->
                <div class="doctor-search-filter">
                    <form action="/doctors" method="GET">
                        <div class="row align-items-end g-3">
                            <div class="col-lg-5 col-md-12">
                                <label for="search" class="form-label fw-600 mb-2 text-muted small">Search by Name or Expertise</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white border-end-0" style="border-radius: 8px 0 0 8px;">
                                        <i class="fas fa-search text-primary"></i>
                                    </span>
                                    <input type="text" id="search" name="search" class="form-control border-start-0" placeholder="e.g. Dr. John or Cardiology..." value="{{ request('search') }}" style="border-radius: 0 8px 8px 0;">
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-12">
                                <label for="specialty" class="form-label fw-600 mb-2 text-muted small">Filter by Specialty</label>
                                <select id="specialty" name="specialty" class="form-select form-select-lg" aria-label="Filter by specialty" style="border-radius: 8px; border: 2px solid #eee;">
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
                                <button type="submit" class="btn btn-primary w-100 btn-lg fw-600" style="border-radius: 8px; padding: 12px 20px;">
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
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card doctor-card h-100 border-0 overflow-hidden transition-all" style="border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: all 0.3s ease;">
                            
                            {{-- Doctor Image Container --}}
                            <div class="position-relative bg-light overflow-hidden doctor-image-wrapper" style="height: 240px; background: linear-gradient(135deg, #e8f1fc 0%, #f2f9fb 100%);">
                                <img src="{{ asset( !empty($doctor->photo) ? 'public/assets/images/profiles/' . $doctor->photo : 'public/assets/images/doctor-placeholder.png' ) }}"
                                    class="card-img-top w-100 h-100"
                                    alt="Dr. {{ $doctor->first_name ?? '' }} {{ $doctor->last_name ?? '' }}"
                                    style="object-fit: cover; transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);">
                                
                                {{-- Experience Badge --}}
                                @if(!empty($doctor->experience))
                                <div class="position-absolute top-3 end-3" style="z-index: 10;">
                                    <span class="badge bg-primary rounded-pill px-3 py-2 fw-600" style="font-size: 0.8rem;">
                                        <i class="fas fa-briefcase-medical me-1"></i>{{ $doctor->experience }}
                                    </span>
                                </div>
                                @endif

                                {{-- Wishlist Toggle Button --}}
                                <button class="btn btn-light rounded-circle position-absolute bottom-3 end-3" title="Add to Favorites" style="width: 45px; height: 45px; border: 2px solid #fff; z-index: 10; transition: all 0.3s ease;">
                                    <i class="far fa-heart text-danger" style="font-size: 1.1rem;"></i>
                                </button>
                            </div>

                            {{-- Doctor Info Body --}}
                            <div class="card-body d-flex flex-column pt-4 pb-3 px-4" style="flex-grow: 1;">
                                
                                {{-- Name --}}
                                <h5 class="card-title mb-1">
                                    <a href="/doctor/{{ $doctor->id ?? '' }}/{!! md5($doctor->email ?? '') !!}" class="text-decoration-none text-dark fw-bold" style="font-size: 1.1rem; transition: color 0.3s ease;">
                                        Dr. {{ $doctor->first_name ?? '' }} {{ $doctor->last_name ?? '' }}
                                    </a>
                                </h5>

                                {{-- Specialization --}}
                                <p class="text-primary mb-2 fw-500 font-13" style="font-size: 0.9rem;">
                                    <i class="fas fa-stethoscope me-1"></i>{{ $doctor->specialist ?? 'Specialist' }}
                                </p>

                                {{-- Education --}}
                                @if(!empty($doctor->education))
                                <p class="text-muted font-12 mb-3" style="font-size: 0.85rem;">
                                    <i class="fas fa-graduation-cap me-1"></i>{{ $doctor->education }}
                                </p>
                                @endif

                                {{-- Rating Section --}}
                                <div class="mb-3 pb-2" style="border-bottom: 1px solid #eee;">
                                    @if(isset($doctor->avg_rating) && $doctor->avg_rating > 0)
                                        @php
                                            $rating = round($doctor->avg_rating);
                                            $maxRating = 5;
                                        @endphp
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="text-warning">
                                                @for ($i = 1; $i <= $maxRating; $i++)
                                                    <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star font-12"></i>
                                                @endfor
                                            </span>
                                            <span class="badge bg-light text-dark font-12">{{ number_format($doctor->avg_rating, 1) }}/5</span>
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic font-12">
                                            <i class="fas fa-star-half-alt me-1 text-warning"></i>No ratings yet
                                        </span>
                                    @endif
                                </div>

                                {{-- Fees --}}
                                <div class="mt-auto">
                                    @if(!empty($doctor->fees))
                                    <div class="mb-3">
                                        <p class="text-muted mb-0 font-12">Consultation Fee</p>
                                        <h6 class="text-success mb-0 fw-bold">₹{{ number_format($doctor->fees, 0) }}</h6>
                                    </div>
                                    @endif
                                    
                                    <div class="d-grid gap-2">
                                        <a href="/doctor/{{ $doctor->id ?? '' }}/{!! md5($doctor->email ?? '') !!}" class="btn btn-primary fw-600 py-2" style="border-radius: 8px; transition: all 0.3s ease; font-size: 0.9rem;">
                                            <i class="fas fa-calendar-check me-2"></i>Book Appointment
                                        </a>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    @empty
                         <div class="col-12">
                            <div class="alert alert-light border-2 border-primary text-center py-5 rounded-10" role="alert" style="background: linear-gradient(135deg, #f0f7ff 0%, #f5fbff 100%);">
                                <i class="fas fa-search fa-3x mb-4 d-block text-primary opacity-50"></i>
                                <h4 class="alert-heading fw-bold text-dark">No Doctors Found</h4>
                                <p class="text-muted mb-4">We couldn't find any doctors matching your current search or filter criteria.</p>
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
                               <div class="alert alert-info alert-light border-2 border-info d-inline-block rounded-10 px-4 py-3" role="alert">
                                   <i class="fas fa-info-circle me-2"></i>
                                   <strong>Showing top results.</strong> Use filters above for more specific search results.
                               </div>
                            @else
                                <div class="alert alert-success alert-light border-2 border-success d-inline-block rounded-10 px-4 py-3" role="alert">
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
    .doctor-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .doctor-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15) !important;
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
