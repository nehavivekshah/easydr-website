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
                            <h5>My Patients</h5>
                            <div style="background: #fff; padding: 25px; border-radius: 5px; box-shadow: var(--shadow-sm);">
                                @if(isset($patients) && count($patients) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($patients as $patient)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ !empty($patient->photo) ? asset('public/assets/images/profiles/' . $patient->photo) : asset('public/assets/images/user-placeholder.png') }}"
                                                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                                        </td>
                                                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                                        <td>{{ $patient->mobile }}</td>
                                                        <td>{{ $patient->email }}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-sm btn-outline-info">View History</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>No patients found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection