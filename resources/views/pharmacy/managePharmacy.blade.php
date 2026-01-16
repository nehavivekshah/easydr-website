@extends('layout')
@section('title','Manage Pharmacy - Easy Doctor')

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    @endphp

    <section class="task__section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-10 col-sm-12 offset-lg-2 offset-md-1 rounded bg-white shadow-sm border my-4 p-0">
                    <div class="text py-3 px-3 border border-left-0 border-right-0 border-top-0">
                        <h6 class="m-0">
                            <a href="/admin/pharmacy" class="text-dark" title="Back">
                                <i class="bx bx-arrow-back h6"></i>
                            </a>
                            <label class="px-3">
                                @if(!empty($pharmacyMaster)) 
                                    {{ 'Edit Pharmacy' }} 
                                @else 
                                    {{ 'Add New Pharmacy' }} 
                                @endif
                            </label>
                        </h6>
                    </div>
                    <form action="{{ route('managePharmacy') }}" method="POST" class="card-body py-3 px-3">
                        @csrf

                        <input type="hidden" name="PharmacyID" value="{{ $pharmacyMaster->PharmacyID ?? '' }}">

                        <!-- Pharmacy Information -->
                        <div class="col-md-12 text-left pt-2">
                            <h4 class="font-weight-bold h5">Pharmacy Information</h4>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label class="small">Pharmacy Code*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" name="PharmacyCode" class="form-control" maxlength="20" placeholder="Enter Pharmacy Code" value="{{ $pharmacyMaster->PharmacyCode ?? '' }}" required>
                                </div>
                            </div>
                            
                            <!-- Pharmacy Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Pharmacy Name*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-store"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="PharmacyName" 
                                            class="form-control" 
                                            placeholder="Enter Pharmacy Name" 
                                            value="{{ $pharmacyMaster->PharmacyName ?? '' }}" 
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Row -->

                        <div class="row">
                            <!-- Pharmacy Type -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Pharmacy Type*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-category"></i>
                                        </span>
                                        <select 
                                            name="PharmacyType" 
                                            class="form-control" 
                                            required
                                        >
                                            @foreach($pharmacy_types as $pharmacy_type)
                                                <option 
                                                    value="{{ $pharmacy_type->title }}" 
                                                    @if($pharmacy_type->title == ($pharmacyMaster->PharmacyType ?? '')) 
                                                        selected 
                                                    @endif
                                                >
                                                    {{ $pharmacy_type->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Ownership Type (Optional) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Ownership Type</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-copyright"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="OwnershipType" 
                                            class="form-control" 
                                            placeholder="Enter Ownership Type" 
                                            value="{{ $pharmacyMaster->OwnershipType ?? '' }}"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Row -->
                        @php
                            $HoursOfOperation = $pharmacyMaster->HoursOfOperation ?? [];
                        @endphp
                        <div class="row">
                            <!-- Hours of Operation (Optional) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Start Time</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-time"></i>
                                        </span>
                                        <input 
                                            type="time" 
                                            name="HoursOfOperation[]" 
                                            class="form-control" 
                                            placeholder="Select Start Time" 
                                            value="{{ $HoursOfOperation[0] ?? '' }}"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">End Time</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-time"></i>
                                        </span>
                                        <input 
                                            type="time" 
                                            name="HoursOfOperation[]" 
                                            class="form-control" 
                                            placeholder="Select End Time" 
                                            value="{{ $HoursOfOperation[1] ?? '' }}"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Emergency Services (Optional) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Emergency Services</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-warning"></i>
                                        </span>
                                        <select 
                                            name="EmergencyServices" 
                                            class="form-control"
                                        >
                                            <option 
                                                value="1" 
                                                @if(isset($pharmacyMaster->EmergencyServices) && $pharmacyMaster->EmergencyServices == 1) 
                                                    selected 
                                                @endif
                                            >
                                                Yes
                                            </option>
                                            <option 
                                                value="0" 
                                                @if(isset($pharmacyMaster->EmergencyServices) && $pharmacyMaster->EmergencyServices == 0) 
                                                    selected 
                                                @endif
                                            >
                                                No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Services Offered (Optional) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Services Offered</label>
                                    <textarea 
                                        name="ServicesOffered" 
                                        class="form-control" 
                                        placeholder="Enter Services Offered"
                                    >{{ $pharmacyMaster->ServicesOffered ?? '' }}</textarea>
                                </div>
                            </div>
                        </div> <!-- End Row -->

                        <!-- Contact Details -->
                        <div class="col-md-12 text-left">
                            <h4 class="font-weight-bold h5">Contact Details</h4>
                        </div>

                        <div class="row">
                            <!-- Primary Contact Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Primary Contact Name*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-user"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="PrimaryContactName" 
                                            class="form-control" 
                                            placeholder="Enter Primary Contact Name" 
                                            value="{{ $pharmacyMaster->PrimaryContactName ?? '' }}" 
                                            required
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="small">Designation</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" name="Designation" class="form-control" placeholder="Enter Designation" value="{{ $pharmacyMaster->Designation ?? '' }}">
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Phone Number*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-phone"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="PhoneNumber" 
                                            class="form-control" 
                                            placeholder="Enter Phone Number" 
                                            value="{{ $pharmacyMaster->PhoneNumber ?? '' }}" 
                                            required
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Mobile Number*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-phone"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="MobileNumber" 
                                            class="form-control" 
                                            placeholder="Enter Mobile Number" 
                                            value="{{ $pharmacyMaster->MobileNumber ?? '' }}"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Row -->

                        <div class="row">
                            <!-- Fax Number (Optional) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Fax Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-printer"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="FaxNumber" 
                                            class="form-control" 
                                            placeholder="Enter Fax Number" 
                                            value="{{ $pharmacyMaster->FaxNumber ?? '' }}"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Email Address*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-envelope"></i>
                                        </span>
                                        <input 
                                            type="email" 
                                            name="EmailAddress" 
                                            class="form-control" 
                                            placeholder="Enter Email Address" 
                                            value="{{ $pharmacyMaster->EmailAddress ?? '' }}" 
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Row -->

                        <div class="row">
                            <!-- Website URL (Optional) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Website URL</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-world"></i>
                                        </span>
                                        <input 
                                            type="url" 
                                            name="WebsiteURL" 
                                            class="form-control" 
                                            placeholder="Enter Website URL" 
                                            value="{{ $pharmacyMaster->WebsiteURL ?? '' }}"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Row -->

                        <!-- Location Details -->
                        <div class="col-md-12 text-left pt-3">
                            <h4 class="font-weight-bold h5">Head Office Location Details</h4>
                        </div>

                        <div class="row">
                            <!-- Address -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Address*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-home"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="Address" 
                                            class="form-control" 
                                            placeholder="Enter Address" 
                                            value="{{ $pharmacyMaster->Address ?? '' }}" 
                                            required
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">City*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-buildings"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="City" 
                                            class="form-control" 
                                            placeholder="Enter City" 
                                            value="{{ $pharmacyMaster->City ?? '' }}" 
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Row -->

                        <div class="row">
                            <!-- State -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">State*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-flag"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="State" 
                                            class="form-control" 
                                            placeholder="Enter State" 
                                            value="{{ $pharmacyMaster->State ?? '' }}" 
                                            required
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Zip Code -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Zip Code*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-map-pin"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="ZipCode" 
                                            class="form-control" 
                                            placeholder="Enter Zip Code" 
                                            value="{{ $pharmacyMaster->ZipCode ?? '' }}" 
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Row -->

                        <!-- Licensing Details -->
                        <div class="col-md-12 text-left pt-3">
                            <h4 class="font-weight-bold h5">Licensing Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">NPI</label>
                                     <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                                        <input type="text" name="NPI" class="form-control" placeholder="Enter NPI" value="{{ $pharmacyMaster->NPI ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="small">DEA Number</label>
                                     <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-shield-alt-2"></i></span>
                                        <input type="text" name="DEANumber" class="form-control" placeholder="Enter DEA Number" value="{{ $pharmacyMaster->DEANumber ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- License Number -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">License Number*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-key"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="LicenseNumber" 
                                            class="form-control" 
                                            placeholder="Enter License Number" 
                                            value="{{ $pharmacyMaster->LicenseNumber ?? '' }}" 
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                            <!-- License Expiration Date -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">License Expiration Date*</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-calendar"></i>
                                        </span>
                                        <input 
                                            type="date" 
                                            name="LicenseExpirationDate" 
                                            class="form-control" 
                                            value="{{ $pharmacyMaster->LicenseExpirationDate ?? '' }}" 
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->

                        <div class="col-md-12 text-left pt-3">
                            <h4 class="font-weight-bold h5">Payment Details</h4>
                        </div>
                        <div class="row">
                             <!-- Bank Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Bank Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bxs-bank'></i></span>
                                        <input type="text" name="BankName" class="form-control" placeholder="Enter Bank Name" value="{{ $pharmacyMaster->bankname ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <!-- Bank Branch -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Bank Branch</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-git-branch'></i></span>
                                        <input type="text" name="BranchName" class="form-control" placeholder="Enter Bank Branch Name/Location" value="{{ $pharmacyMaster->branchname ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Row -->

                        <div class="row">
                            <!-- Account Type -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Account Type</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-list-ul'></i></span>
                                        <select name="AccountType" class="form-control">
                                            <option value="" @if(empty($pharmacyMaster->account_type)) selected @endif>Select Type</option>
                                            <option value="Savings" @if(($pharmacyMaster->account_type ?? '') == 'Savings') selected @endif>Savings</option>
                                            <option value="Checking" @if(($pharmacyMaster->account_type ?? '') == 'Checking') selected @endif>Checking / Current</option>
                                            {{-- Add other types if necessary --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Account No. -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Account Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-hash'></i></span>
                                        <input type="text" name="AccountNumber" class="form-control" placeholder="Enter Account Number" value="{{ $pharmacyMaster->account_number ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Row -->

                        <div class="row">
                             <!-- Account Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Account Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-user-check'></i></span>
                                        <input type="text" name="AccountName" class="form-control" placeholder="Enter Name Associated with Account" value="{{ $pharmacyMaster->account_name ?? '' }}">
                                    </div>
                                </div>
                            </div>
                             <!-- Account Code -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Bank/Account Code</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-barcode-reader'></i></span>
                                        <input type="text" name="AccountCode" class="form-control" placeholder="e.g., IFSC, SWIFT, Sort Code" value="{{ $pharmacyMaster->ifsccode ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Row -->

                         <div class="row">
                           <!-- Account Status -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Account Status</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-toggle-right'></i></span>
                                        <select name="AccountStatus" class="form-control">
                                             <option value="" @if(empty($pharmacyMaster->status)) selected @endif>Select Status</option>
                                            <option value="1" @if(($pharmacyMaster->status ?? '') == '1') selected @endif>Active</option>
                                            <option value="0" @if(($pharmacyMaster->status ?? '') == '0') selected @endif>Inactive</option>
                                            {{-- Add other statuses if necessary --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Row -->

                        <!-- Other Details (All Optional) -->
                        <div class="col-md-12 text-left pt-3">
                            <h4 class="font-weight-bold h5">Other Details</h4>
                        </div>

                        <div class="row">
                            @php
                                $TaxID = $pharmacyMaster->TaxID ?? [];
                            @endphp
                            <!-- Tax ID (Optional) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Tax Code 1</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-calculator"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="TaxID[]" 
                                            class="form-control" 
                                            placeholder="Enter Tax ID" 
                                            value="{{ $TaxID[0] ?? '' }}"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Tax Code 2</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-calculator"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="TaxID[]" 
                                            class="form-control" 
                                            placeholder="Enter Tax ID" 
                                            value="{{ $TaxID[1] ?? '' }}"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Tax Code 3</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-calculator"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="TaxID[]" 
                                            class="form-control" 
                                            placeholder="Enter Tax ID" 
                                            value="{{ $TaxID[2] ?? '' }}"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Tax Code 4</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-calculator"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            name="TaxID[]" 
                                            class="form-control" 
                                            placeholder="Enter Tax ID" 
                                            value="{{ $TaxID[3] ?? '' }}"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Row -->

                        <!-- Submit Button -->
                        <div class="form-group mt-3 mb-0 text-right">
                            <button type="submit" id="submitButton" class="btn btn-default border">Submit</button>
                            <button type="reset" class="btn btn-white border">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
