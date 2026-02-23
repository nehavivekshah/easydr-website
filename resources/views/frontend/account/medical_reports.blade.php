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
                        <div class="dashboard_content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0 fw-bold text-dark" style="letter-spacing: -0.5px;">Medical Reports</h4>
                            </div>

                            @if(count($reports) > 0)
                                <div class="row g-4">
                                    @foreach($reports as $report)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="transition: transform 0.2s, box-shadow 0.2s; background: #fff;">
                                                <div class="card-body p-4 d-flex flex-column">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div class="bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                            <i class="fas fa-file-medical-alt fs-4"></i>
                                                        </div>
                                                        <span class="badge bg-light text-secondary border">
                                                            {{ \Carbon\Carbon::parse($report->created_at)->format('d M, Y') }}
                                                        </span>
                                                    </div>
                                                    
                                                    <h6 class="fw-bold mb-1 text-dark text-truncate" title="{{ $report->message ?: 'Medical Document' }}">
                                                        {{ $report->message ?: 'Medical Document' }}
                                                    </h6>
                                                    
                                                    <div class="d-flex align-items-center mt-2 mb-4">
                                                        @php
                                                            $avatar = "https://ui-avatars.com/api/?name=" . urlencode('Dr. ' . $report->doctor_first_name) . "&background=0D8ABC&color=fff";
                                                            $photo = $report->doctor_photo ? asset('public/assets/images/profiles/' . $report->doctor_photo) : $avatar;
                                                        @endphp
                                                        <img src="{{ $photo }}" class="rounded-circle me-2" width="24" height="24" style="object-fit: cover;">
                                                        <small class="text-muted text-truncate">Dr. {{ $report->doctor_first_name }} {{ $report->doctor_last_name }}</small>
                                                    </div>
                                                    
                                                    <div class="mt-auto pt-3 border-top">
                                                        <a href="{{ asset('public/assets/images/chats/' . $report->file) }}" target="_blank" class="btn btn-outline-primary w-100 rounded-pill fw-bold" style="padding: 8px 16px;">
                                                            <i class="fas fa-eye me-2"></i> View Report
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $reports->links() }}
                                </div>
                            @else
                                <div style="background: #fff; padding: 40px 25px; border-radius: 16px; box-shadow: var(--shadow-sm); min-height: 400px; border: 1px dashed #ced4da;"
                                    class="d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="mb-4 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                        <i class="fas fa-folder-open text-muted opacity-50" style="font-size: 3rem;"></i>
                                    </div>
                                    <h4 class="text-dark fw-bold mb-2">No Reports Available</h4>
                                    <p class="text-secondary mb-4" style="max-width: 400px;">
                                        Medical reports uploaded by your doctor during or after a consultation will appear here.
                                    </p>
                                    <a href="/my-doctors" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                                        View My Doctors
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection