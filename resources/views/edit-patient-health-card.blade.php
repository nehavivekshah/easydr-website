@extends('layout')
@section('title', 'Edit Health Card - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="/admin/patient-health-card" class="btn btn-default btn-sm">
                <i class="bx bx-arrow-back fs-5"></i>
            </a>
            <h2 class="mb-0 text-dark fw-bold" style="font-size: 1.5rem;">Edit Health Card</h2>
        </div>

        <div class="container-fluid p-0">
            <div class="row justify-content-center g-3">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm rounded-4 w-100">
                        <div class="card-body">
                            <form action="{{ route('admin.patient.healthcard.update', $patient->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Health Card Number</label>
                                        <input type="text" name="health_card" class="form-control"
                                            value="{{ $patient->health_card }}" placeholder="Enter Health Card Number*"
                                            required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Issue Date</label>
                                        <input type="date" name="hc_issue_date" class="form-control"
                                            value="{{ $patient->hc_issue_date }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Expiry Date</label>
                                        <input type="date" name="hc_expairy_date" class="form-control"
                                            value="{{ $patient->hc_expairy_date }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Health Card File</label>
                                        <input type="file" name="health_card_file" class="form-control">
                                        @if($patient->health_card_file)
                                            <a href="{{ asset('public/assets/images/healthCards/' . $patient->health_card_file) }}"
                                                target="_blank" class="text-primary d-block mt-1">
                                                View Current File
                                            </a>
                                        @endif
                                    </div>

                                    <div class="col-12 d-flex justify-content-between mt-4">
                                        <a href="/admin/patient-health-card"
                                            class="btn btn-light rounded-pill shadow-sm px-4 py-2">
                                            <i class="bx bx-left-arrow-alt me-1"></i> Previous
                                        </a>
                                        <button type="submit"
                                            class="btn btn-default rounded-pill shadow-sm px-5 py-2">Update Health
                                            Card</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection