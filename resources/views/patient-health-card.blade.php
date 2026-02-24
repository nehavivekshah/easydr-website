@extends('layout')
@section('title', "Patient Health Cards - Easy Doctor")

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
    @endphp

    <section class="task__section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-0 text-dark fw-bold" style="font-size: 1.5rem;">Patient Health Cards</h2>
                <div class="text-muted small mt-1">
                    Home / Patient Management / Health Cards
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary rounded-pill shadow-sm px-4" title="Export to CSV">
                    <i class="bx bx-download me-1"></i> Export
                </button>
            </div>
        </div>

        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-12 pb-3">
                    <div class="card border-0 shadow-sm rounded-4 w-100">
                        <div class="card-body p-3 table-responsive">
                            <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th width="60px">#</th>
                                <th>Patient Name</th>
                                <th>Health Card No</th>
                                <th>Issue Date</th>
                                <th>Expiry Date</th>
                                <th>Card File</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients as $k => $patient)
                                                <tr>
                                                    <td>{{ $k + 1 }}</td>

                                                    <td>
                                                        {{ $patient->first_name ?? '' }} {{ $patient->last_name ?? '' }}
                                                    </td>

                                                    <td>{{ $patient->health_card ?? '--' }}</td>

                                                    <td>
                                                        {{ $patient->hc_issue_date
                                ? \Carbon\Carbon::parse($patient->hc_issue_date)->format('d M Y')
                                : '--' }}
                                                    </td>

                                                    <td>
                                                        @php
                                                            $expired = $patient->hc_expairy_date &&
                                                                \Carbon\Carbon::parse($patient->hc_expairy_date)->isPast();
                                                        @endphp

                                                        <span class="{{ $expired ? 'text-danger fw-bold' : '' }}">
                                                            {{ $patient->hc_expairy_date
                                ? \Carbon\Carbon::parse($patient->hc_expairy_date)->format('d M Y')
                                : '--' }}
                                                        </span>

                                                        @if($expired)
                                                            <span class="badge bg-danger ms-1">Expired</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if($patient->health_card_file)
                                                            <a href="{{ asset('public/assets/images/healthCards/' . $patient->health_card_file) }}"
                                                                target="_blank" class="btn btn-link btn-sm text-primary">
                                                                View
                                                            </a>
                                                        @else
                                                            --
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if($patient->hc_verified_at)
                                                            <span class="badge bg-success">Verified</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark">Not Verified</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if(in_array('permission_edit', $roleArray) || in_array('All', $roleArray))
                                                            <a href="{{ route('admin.patient.healthcard.edit', $patient->id) }}"
                                                                class="btn btn-info btn-sm text-white me-1 rounded-pill shadow-sm px-3" title="Edit Health Card"><i
                                                                    class="bx bx-edit"></i></a>
                                                            <form action="/admin/patient-health-card" method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $patient->id }}">

                                                            @if($patient->hc_verified_at)
                                                                <button class="btn btn-warning btn-sm text-dark rounded-pill shadow-sm px-3"
                                                                    onclick="return confirm('Are you sure you want to un-verify this health card?')">
                                                                    Unverify
                                                                </button>
                                                            @else
                                                                @php
                                                                    $missingInfo = [];
                                                                    if (empty($patient->health_card))
                                                                        $missingInfo[] = 'Card No';
                                                                    if (empty($patient->health_card_file))
                                                                        $missingInfo[] = 'Card File';
                                                                    if (empty($patient->hc_expairy_date))
                                                                        $missingInfo[] = 'Expiry Date';

                                                                    $canVerify = empty($missingInfo) && !$expired;
                                                                    $title = '';
                                                                    if (!$canVerify) {
                                                                        if ($expired)
                                                                            $title = 'Cannot Verify: Card is expired';
                                                                        else
                                                                            $title = 'Cannot Verify: Missing ' . implode(', ', $missingInfo);
                                                                    }
                                                                @endphp

                                                                <button class="btn btn-success btn-sm rounded-pill shadow-sm px-4" {{ !$canVerify ? 'disabled' : '' }}
                                                                    title="{{ $title }}"
                                                                    onclick="return confirm('Do you want to verify this health card?')">
                                                                    Verify
                                                                </button>
                                                            @endif
                                                            </form>
                                                        @else
                                                            --
                                                        @endif
                                                    </td>
                                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection