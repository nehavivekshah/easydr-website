@extends('layout')

@php
    $pagename = explode('-', $type);
    $isProfile = Request::segment(2) == 'my-profile';
    $isPatient = Request::segment(3) == 'patient-directory';
    $isDoctor = Request::segment(3) == 'doctor-directory';
@endphp

@section('title', "Manage ".ucfirst($pagename[0] ?? 'User')." - Easy Doctor")

@push('styles')
<style>
    /* Multi-step Logic Styles */
    .form-step { display: none; }
    .form-step-active { display: block !important; }
    
    /* Progress Bar Theme - Matching Easy Doctor Blue/White */
    .step-indicator { display: flex; justify-content: space-between; margin-bottom: 30px; padding: 15px; background: #f8f9fa; border-radius: 8px; border: 1px solid #eee; }
    .step { flex: 1; text-align: center; position: relative; font-weight: 600; color: #ccc; font-size: 13px; }
    .step.active { color: #2c3e50; }
    .step.active .bullet { background-color: #007bff; color: white; border-color: #007bff; }
    .bullet { height: 25px; width: 25px; border: 2px solid #ccc; display: inline-block; border-radius: 50%; line-height: 22px; margin-bottom: 5px; background: #fff; }
    
    /* Easy Doctor Theme Overrides */
    .media-icon { width: 45px; height: 45px; object-fit: cover; border-radius: 5px; margin-right: 10px; border: 1px solid #ddd; }
    .form-group { margin-bottom: 1.2rem; }
    .task__section .text { font-size: 1.2rem; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; }
</style>
@endpush

@section('content')
<section class="task__section">
    <div class="text mb-0">
        @if(!$isProfile)
            <a href="/admin/users/{{$type ?? ''}}" class="btn btn-default btn-sm back-btn"><i class="bx bx-arrow-back"></i></a>
            @if(!empty($id)) Edit {{ucfirst($pagename[0] ?? 'User')}} @else Add New {{ucfirst($pagename[0] ?? 'User')}} @endif
        @else
            Profile Settings
        @endif
    </div>

    <div class="container-fluid">
        <div class="row g-3 px-2">
            <div class="col-md-12 bg-white rounded border shadow-sm p-4">
                
                <!-- Step Progress Bar -->
                <div class="step-indicator">
                    <div class="step active" id="ind-1"><span class="bullet">1</span><br>ACCOUNT INFO</div>
                    <div class="step" id="ind-2"><span class="bullet">2</span><br>PERSONAL INFO</div>
                    <div class="step" id="ind-3"><span class="bullet">3</span><br>LOCATION & ROLE</div>
                </div>

                <form id="multiStepForm" action="{{ $isProfile ? '/admin/my-profile' : '/admin/manage-user' }}" method="post" enctype="multipart/form-data" class="row">
                    @csrf
                    <input type="hidden" name="pagetype" value="{{ $type ?? '' }}">
                    <input type="hidden" name="id" value="{{ $id ?? '' }}">

                    <!-- STEP 1: Basic Account Details -->
                    <div class="form-step form-step-active" id="step-1">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="name">Name*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text" class="form-control" name="name" value="{{ trim(($users->first_name ?? '').' '.($users->last_name ?? '')) }}" placeholder="Enter Name*" required>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="email">Email Id*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                    <input type="email" class="form-control" name="email" placeholder="Enter Email id*" value="{{ $users->email ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="mobile">Mobile No.*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-phone'></i></span>
                                    <input type="text" class="form-control" name="mob" placeholder="Enter Mobile No.*" value="{{ $users->mobile ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="mob2">Alternative Mobile No.</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-phone'></i></span>
                                    <input type="text" class="form-control" name="mob2" placeholder="Enter Alternative Mobile No." value="{{ $users->altr_mobile ?? '' }}">
                                </div>
                            </div>
                            @if(!$isProfile)
                            <div class="col-md-4 form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-lock'></i></span>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password">
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-default px-5 next-step">Next <i class='bx bx-right-arrow-alt'></i></button>
                        </div>
                    </div>

                    <!-- STEP 2: Personal, Physical & Health Details -->
                    <div class="form-step" id="step-2">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Upload (Profile Photo): Jpg, jpeg, Png</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-upload'></i></span>
                                    @if(!empty($users->photo)) <img src="/public/assets/images/profiles/{{ $users->photo }}" class="media-icon"> @endif
                                    <input type="file" class="form-control" name="profile_photo" accept="image/jpg, image/jpeg, image/png">
                                </div>
                            </div>

                            @if($isPatient)
                            <div class="col-md-4 form-group">
                                <label>Date of Birth</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                                    <input type="date" class="form-control" name="dob" value="{{ $users->dob ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Gender</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-male-female'></i></span>
                                    <select class="form-control" name="gender">
                                        <option value="1" @if(($users->gender ?? '') == '1') selected @endif>Male</option>
                                        <option value="2" @if(($users->gender ?? '') == '2') selected @endif>Female</option>
                                        <option value="3" @if(($users->gender ?? '') == '3') selected @endif>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Blood Group</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-droplet'></i></span>
                                    <input type="text" class="form-control" name="bloodgroup" placeholder="Blood Group" value="{{ $users->blood_group ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Marital Status</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-heart'></i></span>
                                    <select class="form-control" name="marital_status">
                                        <option value="1" @if(($users->marital_status ?? '') == '1') selected @endif>Single</option>
                                        <option value="2" @if(($users->marital_status ?? '') == '2') selected @endif>Married</option>
                                        <option value="3" @if(($users->marital_status ?? '') == '3') selected @endif>Divorced</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Height (Inch)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-ruler'></i></span>
                                    <input type="text" class="form-control" name="height" placeholder="Enter Height" value="{{ $users->height ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Weight (Kg)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-bar-chart-alt-2'></i></span>
                                    <input type="text" class="form-control" name="weight" placeholder="Enter Weight" value="{{ $users->weight ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Health Card No.</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-id-card'></i></span>
                                    <input type="text" class="form-control" name="health_card" placeholder="Enter Health Card No." value="{{ $users->health_card ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Upload (Health Card): Jpg, jpeg, Png</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-upload'></i></span>
                                    @if(!empty($users->health_card_file)) <img src="/public/assets/images/healthCards/{{ $users->health_card_file }}" class="media-icon"> @endif
                                    <input type="file" class="form-control" name="health_card_file" accept="image/*">
                                </div>
                            </div>
                            @endif
                            
                            @if($isDoctor)
                            <div class="col-md-4 form-group">
                                <label>Specialization*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-briefcase'></i></span>
                                    <input type="text" class="form-control" name="specialization" placeholder="Enter Specialization*" value="{{ $users->specialist ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Education*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-book'></i></span>
                                    <input type="text" class="form-control" name="education" placeholder="Enter Education*" value="{{ $users->education ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Medical License Number*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-id-card'></i></span>
                                    <input type="text" class="form-control" name="license" placeholder="Enter Medical License Number*" value="{{ $users->license ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>About</label>
                                <textarea class="form-control border" name="about" placeholder="Write Here..." rows="2">{{ $users->about ?? '' }}</textarea>
                            </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-light border prev-step"><i class='bx bx-left-arrow-alt'></i> Previous</button>
                            <button type="button" class="btn btn-default px-5 next-step">Next <i class='bx bx-right-arrow-alt'></i></button>
                        </div>
                    </div>

                    <!-- STEP 3: Location, Professional & Role Details -->
                    <div class="form-step" id="step-3">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-home'></i></span>
                                    <input type="text" class="form-control" name="address" placeholder="Enter Address" value="{{ $users->address ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>City</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-buildings'></i></span>
                                    <input type="text" class="form-control" name="city" placeholder="Enter City" value="{{ $users->city ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>State</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-map'></i></span>
                                    <input type="text" class="form-control" name="state" placeholder="Enter State" value="{{ $users->state ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Country</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-globe'></i></span>
                                    <input type="text" class="form-control" name="country" placeholder="Enter Country" value="{{ $users->country ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Pincode</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-map-pin'></i></span>
                                    <input type="text" class="form-control" name="pincode" placeholder="Enter Pincode" value="{{ $users->pincode ?? '' }}">
                                </div>
                            </div>

                            @if(!$isProfile)
                                @if($isPatient || $isDoctor)
                                    <input type="hidden" name="role" value="{{ $roles[0]->id ?? '' }}">
                                @else
                                <div class="col-md-4 form-group">
                                    <label>Role*</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-briefcase'></i></span>
                                        <select class="form-control" name="role" required>
                                            @foreach($roles as $role)
                                            <option value="{{$role->id}}" @if(($users->role ?? '') == $role->id) selected @endif>{{$role->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                            @endif
                            <div class="col-md-4 form-group">
                                <label>Status*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-check-circle'></i></span>
                                    <select class="form-control" name="status" required>
                                        <option value="1" @if(($users->status ?? '') == '1') selected @endif>Active</option>
                                        <option value="2" @if(($users->status ?? '') == '2') selected @endif>Deactive</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-light border prev-step"><i class='bx bx-left-arrow-alt'></i> Previous</button>
                            <div>
                                <button type="submit" class="btn btn-default px-4">Submit</button>
                                <button type="reset" class="btn btn-light border px-4">Reset</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var currentStep = 1;

        function updateDisplay() {
            $('.form-step').removeClass('form-step-active');
            $('#step-' + currentStep).addClass('form-step-active');
            
            $('.step').removeClass('active');
            for(var i=1; i<=currentStep; i++) {
                $('#ind-' + i).addClass('active');
            }
            window.scrollTo(0, 0);
        }

        $(".next-step").click(function () {
            // Validate required fields in the current step only
            var isValid = true;
            $('#step-' + currentStep + ' [required]').each(function() {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (isValid) {
                currentStep++;
                updateDisplay();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Step',
                    text: 'Please fill in all required fields marked with *'
                });
            }
        });

        $(".prev-step").click(function () {
            if (currentStep > 1) {
                currentStep--;
                updateDisplay();
            }
        });
    });
</script>
@endpush