@extends('frontend.layout')

@section('content')
    <style>
        /* Card Container */
        .doctor-card {
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .doctor-profile {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 20px;
        }

        .doctor-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #eef2f6;
        }

        .doctor-info h5 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .doctor-meta {
            font-size: 0.85rem;
            color: #6c757d;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .doctor-meta i {
            width: 16px;
            color: #3498db;
        }

        .doctor-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            display: block;
            font-weight: 700;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-view-details {
            width: 100%;
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.2s;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-view-details:hover {
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .specialty-badge {
            background-color: #e3f2fd;
            color: #0d47a1;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 8px;
        }
    </style>

    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    <!-- Content Area -->
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold">My Doctors</h4>
                                <div class="badge rounded-pill px-3 py-2 bg-primary text-white">{{ count($doctors) }} Total Doctors</div>
                            </div>

                            <div class="row">
                                @if(isset($doctors) && count($doctors) > 0)
                                    @foreach($doctors as $doctor)
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="doctor-card">
                                                <div>
                                                    <div class="doctor-profile">
                                                        <img src="{{ !empty($doctor->photo) ? asset('public/assets/images/profiles/' . $doctor->photo) : 'https://ui-avatars.com/api/?name=Dr.+' . $doctor->first_name . '+' . $doctor->last_name . '&background=0D8ABC&color=fff' }}"
                                                            class="doctor-img">
                                                        <div class="doctor-info w-100">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <h5 class="mb-1">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h5>
                                                                <div class="text-warning small pt-1">
                                                                    <i class="fas fa-star"></i> {{ number_format($doctor->avg_rating, 1) }}
                                                                </div>
                                                            </div>
                                                            <div class="specialty-badge">
                                                                {{ $doctor->specialist ?? 'General' }} 
                                                                @if($doctor->education)
                                                                    <span class="text-muted fw-normal"> | {{ $doctor->education }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="doctor-meta">
                                                                <span><i class="fas fa-map-marker-alt"></i> 
                                                                    {{ implode(', ', array_filter([$doctor->city, $doctor->state])) ?: 'Location not specified' }}
                                                                </span>
                                                                @if($doctor->mobile)
                                                                <span class="mt-1"><i class="fas fa-phone-alt"></i> 
                                                                    <a href="tel:{{ $doctor->mobile }}" class="text-decoration-none text-secondary">{{ $doctor->mobile }}</a>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($doctor->about)
                                                    <div class="mb-3 text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                                        "{{ strip_tags($doctor->about) }}"
                                                    </div>
                                                    @endif

                                                    <div class="doctor-stats">
                                                        <div class="stat-item">
                                                            <span class="stat-value">{{ $doctor->total_appointments }}</span>
                                                            <span class="stat-label">Total Sessions</span>
                                                        </div>
                                                        <div class="stat-item">
                                                            <span class="stat-value">{{ $doctor->last_visit ? \Carbon\Carbon::parse($doctor->last_visit)->format('M d, y') : 'N/A' }}</span>
                                                            <span class="stat-label">Last Session</span>
                                                        </div>
                                                        <div class="stat-item">
                                                            <span class="stat-value">{{ $doctor->experience ? $doctor->experience . ' Yrs' : 'N/A' }}</span>
                                                            <span class="stat-label">Experience</span>
                                                        </div>
                                                        <div class="stat-item">
                                                            <span class="stat-value">{{ $doctor->fees ? '₹' . $doctor->fees : 'Free' }}</span>
                                                            <span class="stat-label">Consult Fee</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <a href="/doctor/{{ $doctor->doctor_table_id }}/{{ Str::slug($doctor->first_name . '-' . $doctor->last_name) }}" class="btn-view-details mt-3">
                                                    View Doctor Profile
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                                            <p class="text-muted text-lg font-weight-bold">No connected doctors yet.</p>
                                            <p class="text-muted small">You haven't completed any appointments with a doctor yet. After your first visit, your doctor will appear here.</p>
                                            <a href="/doctors" class="btn btn-primary mt-3 rounded-pill px-4 py-2 shadow-sm font-weight-bold">Browse Doctors</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection