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

                            <div class="card-modern p-4 mb-4" id="wizardContainer">
                                <div class="card-header bg-transparent border-0 mb-4 px-0">
                                    <h5 class="fw-bold text-primary mb-0">Edit Profile</h5>
                                    <p class="text-muted small">Update your personal and professional information</p>
                                </div>

                                <!-- Progress Bar -->
                                <div class="wizard-progress mb-5 px-lg-5">
                                    <div class="step-item active" id="step-1-indicator">
                                        <div class="step-circle shadow-sm">1</div>
                                        <div class="step-label fw-bold">Basic Info</div>
                                    </div>
                                    <div class="step-item" id="step-2-indicator">
                                        <div class="step-circle shadow-sm">2</div>
                                        <div class="step-label fw-bold">Address</div>
                                    </div>
                                    <div class="step-item" id="step-3-indicator">
                                        <div class="step-circle shadow-sm">3</div>
                                        <div class="step-label fw-bold">{{ $role == 4 ? 'Professional' : 'Medical' }}</div>
                                    </div>
                                    <div class="step-item" id="step-4-indicator">
                                        <div class="step-circle shadow-sm">4</div>
                                        <div class="step-label fw-bold">Security</div>
                                    </div>
                                <style>
                                    .form-step { display: none; }
                                    .form-step-active { display: block; }
                                    .wizard-progress { display: flex; justify-content: space-between; position: relative; }
                                    .wizard-progress::before { content: ""; position: absolute; top: 16px; left: 0; width: 100%; height: 2px; background: #eef2f6; z-index: 1; }
                                    .step-item { position: relative; z-index: 2; text-align: center; flex: 1; }
                                    .step-circle { width: 32px; height: 32px; background: #fff; border: 2px solid #eef2f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-weight: 700; color: #cbd5e0; transition: all 0.3s; font-size: 14px; }
                                    .step-item.active .step-circle { border-color: #1a4b8c; color: #1a4b8c; transform: scale(1.1); box-shadow: 0 0 0 4px rgba(26, 75, 140, 0.1); }
                                    .step-item.completed .step-circle { background: #1a4b8c; border-color: #1a4b8c; color: #fff; }
                                    .step-label { font-size: 11px; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; }
                                    .step-item.active .step-label { color: #1a4b8c; }
                                    .wizard-buttons { margin-top: 30px; display: flex; justify-content: space-between; gap: 15px; }
                                    .form-control { border-radius: 8px !important; padding: 10px 15px !important; border: 1px solid #e2e8f0 !important; }
                                    .form-control:focus { border-color: #1a4b8c !important; box-shadow: 0 0 0 3px rgba(26, 75, 140, 0.1) !important; }
                                    .form-label { font-weight: 600; color: #4a5568; font-size: 14px; margin-bottom: 8px; }
                                    .user-photo-preview { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 3px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
                                </style>

                                <form action="{{ route('manageUser') }}" method="POST" enctype="multipart/form-data" id="wizardForm" oninput="clearInvalid(event)">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <input type="hidden" name="pagetype" value="{{ $pageType }}">
                                    <input type="hidden" name="role" value="{{ $role }}">
                                    <input type="hidden" name="is_frontend" value="1">

                                    <!-- Step 1: Basic Information -->
                                    <div class="form-step form-step-active" id="step-1">
                                        <h5>Basic Information</h5>
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
                                                <label class="form-label">Alternate Mobile Number</label>
                                                <input type="text" class="form-control" name="altr_mob" value="{{ $user->altr_mobile }}">
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
                                                <label class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" name="dob" value="{{ $user->dob }}">
                                            </div>
                                            @if($role == 5)
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Aadhar Number</label>
                                                <input type="text" class="form-control" name="adhar"
                                                    value="{{ $user->adhar ?? '' }}" placeholder="12 Digit Aadhar Number">
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Step 2: Address Details -->
                                    <div class="form-step" id="step-2">
                                        <h5>Address Details</h5>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Address</label>
                                                <textarea class="form-control" name="address" rows="3">{{ $user->address ?? '' }}</textarea>
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
                                    </div>

                                    <!-- Step 3: Role Specific -->
                                    <div class="form-step" id="step-3">
                                        @if($role == 5)
                                            <h5>Family Doctor & Medical Info</h5>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Select Family Doctor</label>
                                                    <select class="form-control" name="family_doctor_id" id="familyDoctorSelect">
                                                        <option value="">Select Doctor</option>
                                                        @if(isset($doctors))
                                                            @foreach($doctors as $doc)
                                                                <option value="{{ $doc->id }}" {{ ($user->family_doctor_id ?? '') == $doc->id ? 'selected' : '' }}>
                                                                    {{ $doc->first_name }} {{ $doc->last_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <small class="text-muted"><a href="javascript:void(0);"
                                                            onclick="toggleNewDoctor()" id="toggleNewDocLink">Doctor not found?
                                                            Click here to add.</a></small>
                                                </div>
                                            </div>

                                            <div id="newDoctorFields"
                                                style="display: none; background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                                                <h6>Add New Family Doctor</h6>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Doctor Name</label>
                                                        <input type="text" class="form-control" name="new_doc_name"
                                                            placeholder="First Name Last Name">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Doctor Mobile</label>
                                                        <input type="text" class="form-control" name="new_doc_mobile"
                                                            placeholder="Mobile Number">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Doctor Email (Optional)</label>
                                                        <input type="email" class="form-control" name="new_doc_email"
                                                            placeholder="Email Address">
                                                    </div>
                                                </div>
                                            </div>

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
                                                        <option value="1" {{ ($user->marital_status ?? '') == 1 ? 'selected' : '' }}>Single</option>
                                                        <option value="2" {{ ($user->marital_status ?? '') == 2 ? 'selected' : '' }}>Married</option>
                                                        <option value="3" {{ ($user->marital_status ?? '') == 3 ? 'selected' : '' }}>Divorced</option>
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
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Health Card No.</label>
                                                    <input type="text" class="form-control" name="health_card"
                                                        value="{{ $user->health_card ?? '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Health Card File</label>
                                                    <input type="file" class="form-control" name="health_card_file">
                                                    @if($user->health_card_file)
                                                        <div class="mt-2 text-truncate">
                                                            <a href="{{ asset('public/assets/images/healthCards/' . $user->health_card_file) }}"
                                                                target="_blank" class="btn btn-sm btn-info text-white">View Current Card</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        @if($role == 4)
                                            <h5>Professional Details</h5>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Specialist</label>
                                                    <input type="text" class="form-control" name="specialization"
                                                        value="{{ $user->specialist ?? '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Experience:</label>
                                                    <input type="text" class="form-control" name="experience"
                                                        value="{{ $user->experience ?? '' }}">
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
                                                        value="{{ $user->fees ?? '' }}" readonly>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">About Me</label>
                                                    <textarea class="form-control" name="about" rows="3">{{ $user->about ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Step 4: Finalization -->
                                    <div class="form-step" id="step-4">
                                        <h5>Security & Profile Photo</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3 text-center text-md-start">
                                                <label class="form-label d-block">Profile Photo</label>
                                                <div class="d-flex align-items-center flex-column flex-md-row">
                                                    @if($user->photo)
                                                        <div class="mr-md-3 mb-3 mb-md-0">
                                                            <img src="{{ asset('public/assets/images/profiles/' . $user->photo) }}"
                                                                alt="Profile" class="user-photo-preview">
                                                        </div>
                                                    @endif
                                                    <div class="flex-grow-1 w-100">
                                                        <input type="file" class="form-control" name="profile_photo">
                                                        <small class="text-muted">Recommended: Square image, max 2MB</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">New Password (Optional)</label>
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Leave blank to keep current">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="wizard-buttons mt-5">
                                        <button type="button" class="btn btn-light btn-pill-modern border fw-bold text-muted" id="prevBtn" onclick="nextPrev(-1)" style="display:none;">
                                            <i class="fas fa-arrow-left mr-2"></i> Previous
                                        </button>
                                        <div class="flex-grow-1"></div>
                                        <button type="button" class="btn btn-primary btn-pill-modern fw-bold px-5 py-3 shadow-sm" id="nextBtn" onclick="nextPrev(1)">
                                            Next Step <i class="fas fa-arrow-right ml-2"></i>
                                        </button>
                                        <button type="submit" class="btn btn-success btn-pill-modern fw-bold px-5 py-3 shadow-sm" id="submitBtn" style="display:none;">
                                            Save Changes <i class="fas fa-check-circle ml-2"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("form-step");
            x[n].style.display = "block";
            
            // ... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").style.display = "none";
                document.getElementById("submitBtn").style.display = "flex";
            } else {
                document.getElementById("nextBtn").style.display = "inline";
                document.getElementById("submitBtn").style.display = "none";
            }
            
            // ... and run a function that will display the correct step indicator:
            fixStepIndicator(n);

            // Scroll to the top of the wizard container
            document.getElementById("wizardContainer").scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("form-step");
            
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            
            // Hide the current tab:
            x[currentTab].style.display = "none";
            
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("wizardForm").submit();
                return false;
            }
            
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields in the current step
            var x, y, i, valid = true;
            x = document.getElementsByClassName("form-step");
            y = x[currentTab].getElementsByTagName("input");
            
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty and HAS required attribute...
                if (y[i].value == "" && y[i].hasAttribute('required')) {
                    // add an "invalid" class to the field:
                    if (!y[i].classList.contains("is-invalid")) {
                        y[i].classList.add("is-invalid");
                    }
                    // and set the current valid status to false
                    valid = false;
                }
            }
            
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step-item")[currentTab].classList.add("completed");
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step-item");
            for (i = 0; i < x.length; i++) {
                x[i].classList.remove("active");
            }
            //... and adds the "active" class on the current step:
            x[n].classList.add("active");
        }

        function clearInvalid(event) {
            if (event.target.classList.contains("is-invalid")) {
                event.target.classList.remove("is-invalid");
            }
        }

        function toggleNewDoctor() {
            var x = document.getElementById("newDoctorFields");
            var link = document.getElementById("toggleNewDocLink");
            var select = document.getElementById("familyDoctorSelect");

            if (x.style.display === "none") {
                x.style.display = "block";
                link.innerHTML = "Select from existing list";
                select.disabled = true;
                select.value = "";
            } else {
                x.style.display = "none";
                link.innerHTML = "Doctor not found? Click here to add.";
                select.disabled = false;
            }
        }
    </script>
@endsection