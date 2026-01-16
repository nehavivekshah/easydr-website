@extends('layout')
@section('title', "Patient Health Cards - Easy Doctor")

@section('content')
@php
    $roles = session('roles');
    $roleArray = explode(',', ($roles->permissions ?? ''));
@endphp

<section class="task__section">
    <div class="text">
        Patient Health Cards
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 pb-3 table-responsive">
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
                                    <a href="{{ asset('public/assets/images/healthCards/'.$patient->health_card_file) }}"
                                       target="_blank"
                                       class="btn btn-link btn-sm text-primary">
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
                                    <a href="{{ route('admin.patient.healthcard.edit', $patient->id) }}" class="btn btn-info btn-sm me-1" title="Edit Health Card"><i class="bx bx-edit"></i></a>
                                    <form action="/admin/patient-health-card"
                                          method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $patient->id }}">

                                        @if($patient->hc_verified_at)
                                            <button class="btn btn-warning btn-sm">
                                                Unverify
                                            </button>
                                        @else
                                            <button class="btn btn-success btn-sm">
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
</section>
@endsection
