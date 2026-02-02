@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    <!-- Content Area -->
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <h5>Edit Profile</h5>

                            <div style="background: #fff; padding: 25px; border-radius: 5px; box-shadow: var(--shadow-sm);">
                                <form action="{{ route('manageUser') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    @php
                                        $role = Auth::user()->role;
                                        $pageType = $role == 4 ? 'doctor-directory' : ($role == 5 ? 'patient-directory' : 'admin-accounts');
                                    @endphp
                                    <input type="hidden" name="pagetype" value="{{ $pageType }}">
                                    <input type="hidden" name="role" value="{{ $role }}">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $user->first_name }} {{ $user->last_name }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control" name="mob" value="{{ $user->mobile }}"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" name="dob" value="{{ $user->dob }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Gender</label>
                                            <select class="form-control" name="gender">
                                                <option value="1" {{ $user->gender == '1' ? 'selected' : '' }}>Male</option>
                                                <option value="2" {{ $user->gender == '2' ? 'selected' : '' }}>Female</option>
                                                <option value="3" {{ $user->gender == '3' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Aadhar Number</label>
                                            <input type="text" class="form-control" name="adhar"
                                                value="{{ $user->adhar ?? '' }}" placeholder="12 Digit Aadhar Number">
                                        </div>
                                    </div>

                                    <hr>
                                    <h5>Address Details</h5>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" name="address"
                                                rows="2">{{ $user->address ?? '' }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ $user->city ?? '' }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">State</label>
                                            <input type="text" class="form-control" name="state"
                                                value="{{ $user->state ?? '' }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Country</label>
                                            <input type="text" class="form-control" name="country"
                                                value="{{ $user->country ?? '' }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Pincode</label>
                                            <input type="text" class="form-control" name="pincode"
                                                value="{{ $user->pincode ?? '' }}">
                                        </div>
                                    </div>

                                    @if($role == 5)
                                        <hr>
                                        <h5>Medical Information</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Blood Group</label>
                                                <select class="form-control" name="bloodgroup">
                                                    <option value="">Select Blood Group</option>
                                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                                        <option value="{{ $bg }}" {{ ($user->blood_group ?? '') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Marital Status</label>
                                                <select class="form-control" name="marital_status">
                                                    <option value="">Select Status</option>
                                                    <option value="1" {{ ($user->marital_status ?? '') == 1 ? 'selected' : '' }}>
                                                        Single</option>
                                                    <option value="2" {{ ($user->marital_status ?? '') == 2 ? 'selected' : '' }}>
                                                        Married</option>
                                                    <option value="3" {{ ($user->marital_status ?? '') == 3 ? 'selected' : '' }}>
                                                        Divorced</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Height (cm)</label>
                                                <input type="text" class="form-control" name="height"
                                                    value="{{ $user->height ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Weight (kg)</label>
                                                <input type="text" class="form-control" name="weight"
                                                    value="{{ $user->weight ?? '' }}">
                                            </div>
                                        </div>
                                    @endif

                                    @if($role == 4)
                                        <hr>
                                        <h5>Professional Details</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Specialist</label>
                                                <input type="text" class="form-control" name="specialization"
                                                    value="{{ $user->specialist ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">License No.</label>
                                                <input type="text" class="form-control" name="license"
                                                    value="{{ $user->license ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Education</label>
                                                <input type="text" class="form-control" name="education"
                                                    value="{{ $user->education ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Consultation Fees</label>
                                                <input type="number" class="form-control" name="fees"
                                                    value="{{ $user->fees ?? '' }}">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">About Me</label>
                                                <textarea class="form-control" name="about"
                                                    rows="3">{{ $user->about ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Profile Photo</label>
                                            <input type="file" class="form-control" name="profile_photo">
                                            @if($user->photo)
                                                <div class="mt-2">
                                                    <img src="{{ asset('assets/images/profiles/' . $user->photo) }}"
                                                        alt="Profile" width="50" class="rounded-circle">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">New Password (Optional)</label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Leave blank to keep current">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection