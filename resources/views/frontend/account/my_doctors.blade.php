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
                            <h5>My Doctors</h5>
                            <div style="background: #fff; padding: 25px; border-radius: 5px; box-shadow: var(--shadow-sm);">
                                @if(isset($doctors) && count($doctors) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Doctor Name</th>
                                                    <th>Specialist</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($doctors as $doctor)
                                                    <tr>
                                                        <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                                                        <td>{{ $doctor->specialist }}</td>
                                                        <td>
                                                            <a href="/doctor/{{ $doctor->id }}/{{ Str::slug($doctor->first_name . '-' . $doctor->last_name) }}"
                                                                class="btn btn-sm btn-outline-primary">View Profile</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>No doctors found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection