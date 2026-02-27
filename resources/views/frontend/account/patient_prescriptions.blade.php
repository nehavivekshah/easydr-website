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
                                <h4 class="mb-0 fw-bold text-dark" style="letter-spacing: -0.5px;">My Prescriptions</h4>
                            </div>

                            @if(count($prescriptions) > 0)
                                <div class="row g-4">
                                    @foreach($prescriptions as $p)
                                        <div class="col-12">
                                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #fff;">
                                                <div class="card-header bg-transparent border-bottom px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                            <i class="fas fa-prescription fs-4"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="fw-bold mb-1 text-dark">Prescription on {{ \Carbon\Carbon::parse($p->created_at)->format('d M, Y') }}</h6>
                                                            <div class="d-flex align-items-center">
                                                                @php
                                                                    $avatar = "https://ui-avatars.com/api/?name=" . urlencode('Dr. ' . $p->doctor_first_name) . "&background=0D8ABC&color=fff";
                                                                    $photo = $p->doctor_photo ? asset('public/assets/images/profiles/' . $p->doctor_photo) : $avatar;
                                                                @endphp
                                                                <img src="{{ $photo }}" class="rounded-circle me-2 border" width="24" height="24" style="object-fit: cover;">
                                                                <small class="text-muted">Dr. {{ $p->doctor_first_name }} {{ $p->doctor_last_name }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <a href="{{ route('downloadPrescription', ['id' => $p->id]) }}" class="btn btn-outline-primary rounded-pill fw-bold px-4" target="_blank">
                                                            <i class="fas fa-file-pdf me-2"></i> Download PDF
                                                        </a>
                                                    </div>
                                                </div>
                                                
                                                <div class="card-body p-0">
                                                    @if($p->symptoms || $p->diagnosis || $p->test)
                                                    <div class="px-4 py-3 bg-light border-bottom">
                                                        <div class="row g-3">
                                                            @if($p->symptoms)
                                                            <div class="col-md-4">
                                                                <small class="text-muted d-block fw-bold mb-1">Symptoms:</small>
                                                                <span class="text-dark small">{{ $p->symptoms }}</span>
                                                            </div>
                                                            @endif
                                                            @if($p->diagnosis)
                                                            <div class="col-md-4">
                                                                <small class="text-muted d-block fw-bold mb-1">Diagnosis:</small>
                                                                <span class="text-dark small">{{ $p->diagnosis }}</span>
                                                            </div>
                                                            @endif
                                                            @if($p->test)
                                                            <div class="col-md-4">
                                                                <small class="text-muted d-block fw-bold mb-1">Tests Advised:</small>
                                                                <span class="text-dark small">{{ $p->test }}</span>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="list-group list-group-flush">
                                                        @if(count($p->medicines) > 0)
                                                            @foreach($p->medicines as $m)
                                                            <div class="list-group-item px-4 py-3 border-0 border-bottom">
                                                                <div class="d-flex align-items-start gap-3">
                                                                    <div class="text-primary mt-1">
                                                                        <i class="fas fa-pills fs-5"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="fw-bold text-dark mb-1">{{ $m->medicine_name }}</h6>
                                                                        <div class="d-flex flex-wrap gap-2 gap-md-4 text-secondary small">
                                                                            <span><i class="fas fa-clock text-muted me-1"></i> {{ $m->dosage }}</span>
                                                                            <span><i class="fas fa-redo text-muted me-1"></i> {{ $m->frequency }}</span>
                                                                            <span><i class="fas fa-calendar-day text-muted me-1"></i> {{ $m->duration }}</span>
                                                                            @if($m->instruction)
                                                                            <span class="text-info"><i class="fas fa-info-circle me-1"></i> {{ $m->instruction }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @else
                                                            <div class="px-4 py-4 text-center text-muted small">No medicines recorded for this prescription.</div>
                                                        @endif
                                                        
                                                        @if($p->advice)
                                                        <div class="list-group-item px-4 py-3 border-0 bg-warning-subtle text-dark">
                                                            <div class="d-flex align-items-start gap-2">
                                                                <i class="fas fa-lightbulb text-warning mt-1"></i>
                                                                <div>
                                                                    <span class="fw-bold d-block mb-1">Doctor's Advice:</span>
                                                                    <small>{{ $p->advice }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        
                                                        @if(count($p->medicines) > 0)
                                                        <div class="list-group-item px-4 py-3 border-0 bg-light text-end">
                                                            <form action="{{ route('cart.addPrescription') }}" method="POST" class="d-inline-block">
                                                                @csrf
                                                                <input type="hidden" name="prescription_id" value="{{ $p->id }}">
                                                                <button type="submit" class="btn btn-primary rounded-pill fw-bold shadow-sm px-4">
                                                                    <i class="fas fa-shopping-basket me-2"></i> Buy Available Medicines
                                                                </button>
                                                            </form>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $prescriptions->links() }}
                                </div>
                            @else
                                <div style="background: #fff; padding: 40px 25px; border-radius: 16px; box-shadow: var(--shadow-sm); min-height: 400px; border: 1px dashed #ced4da;"
                                    class="d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="mb-4 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                        <i class="fas fa-file-prescription text-muted opacity-50" style="font-size: 3rem;"></i>
                                    </div>
                                    <h4 class="text-dark fw-bold mb-2">No Prescriptions Found</h4>
                                    <p class="text-secondary mb-4" style="max-width: 400px;">
                                        Your assigned prescriptions will appear here once they are added by your doctor after a consultation.
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