@extends('layout')
@section('title', 'Edit Health Card - Easy Doctor')

@section('content')
<section class="task__section">
    <div class="text">
        <a href="/admin/patient-health-card" class="btn btn-default btn-sm back-btn"><i class="bx bx-arrow-back"></i></a>
         Edit Health Card
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="col-md-12 bg-white rounded border shadow-sm py-3 px-4">
                    <div class="card-body">
                        <form action="{{ route('admin.patient.healthcard.update', $patient->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Health Card Number</label>
                                    <input type="text" name="health_card" class="form-control" value="{{ $patient->health_card }}" placeholder="Enter Health Card Number*" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Issue Date</label>
                                    <input type="date" name="hc_issue_date" class="form-control" value="{{ $patient->hc_issue_date }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="date" name="hc_expairy_date" class="form-control" value="{{ $patient->hc_expairy_date }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Health Card File</label>
                                    <input type="file" name="health_card_file" class="form-control">
                                    @if($patient->health_card_file)
                                        <a href="{{ asset('public/assets/images/healthCards/'.$patient->health_card_file) }}" target="_blank" class="text-primary d-block mt-1">
                                            View Current File
                                        </a>
                                    @endif
                                </div>

                                <div class="col-12 d-flex justify-content-between mt-3">
                                    <a href="/admin/patient-health-card" class="btn btn-light border">
                                        <i class="bx bx-left-arrow-alt"></i> Previous
                                    </a>
                                    <button type="submit" class="btn btn-default px-4">Update Health Card</button>
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
