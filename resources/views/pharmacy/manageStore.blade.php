@extends('layout')
@section('title','Manage Store - Easy Doctor')

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    @endphp
    <section class="task__section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 offset-md-2 rounded bg-white shadow-sm border my-4 p-0">
                    <div class="text py-3 px-3 border border-left-0 border-right-0 border-top-0">
                        <h6 class="m-0">
                            <a href="/admin/store-locations" class="text-dark" title="Back"><i class="bx bx-arrow-back h6"></i></a>  
                            <label class="px-3">@if(!empty($_GET['id'])) {{ 'Edit Store' }} @else {{ 'Add New Store' }} @endif</label>
                        </h6>
                    </div>
                    <form action="{{ route('manageStore') }}" method="POST" class="card-body row py-3 px-3">
                        @csrf

                        <!-- Hidden Input for ID -->
                        <input type="hidden" name="LocationID" value="{{ $store->LocationID ?? '' }}" />

                        <!-- Store Information Section -->
                        <div class="form-group col-md-12 mt-2">
                            <h6 class="font-weight-bold h5 mb-0">Store Information</h6>
                        </div>

                        <!-- Location Name -->
                        <div class="form-group col-md-6">
                            <label class="small">Store Name*</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-store"></i></span>
                                <input type="text" name="LocationName" class="form-control" placeholder="Enter Store Name" value="{{ $store->LocationName ?? '' }}" required>
                            </div>
                        </div>
                        
                        <!-- Pharmacy -->
                        <div class="form-group col-md-6">
                            <label class="small">Pharmacy*</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-store"></i></span>
                                <select name="PharmacyID" class="form-control" required>
                                    <option value="">Select Pharmacy</option>
                                    @foreach($pharmacyMasters as $pharmacy)
                                        <option value="{{ $pharmacy->PharmacyID }}" @if(isset($store->PharmacyID) && $store->PharmacyID == $pharmacy->PharmacyID) selected @endif>
                                            {{ $pharmacy->PharmacyName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group col-md-6">
                            <label class="small">Address*</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-home"></i></span>
                                <input type="text" name="Address" class="form-control" placeholder="Enter Address" value="{{ $store->Address ?? '' }}" required>
                            </div>
                        </div>

                        <!-- City -->
                        <div class="form-group col-md-6">
                            <label class="small">City*</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                <input type="text" name="City" class="form-control" placeholder="Enter City" value="{{ $store->City ?? '' }}" required>
                            </div>
                        </div>

                        <!-- State -->
                        <div class="form-group col-md-6">
                            <label class="small">State*</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-flag"></i></span>
                                <input type="text" name="State" class="form-control" placeholder="Enter State" value="{{ $store->State ?? '' }}" required>
                            </div>
                        </div>

                        <!-- Zip Code -->
                        <div class="form-group col-md-6">
                            <label class="small">Zip Code*</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-map-pin"></i></span>
                                <input type="text" name="ZipCode" class="form-control" maxlength="10" placeholder="Enter Zip Code" value="{{ $store->ZipCode ?? '' }}" required>
                            </div>
                        </div>

                        <!-- Map LInk -->
                        <div class="form-group col-md-6">
                            <label class="small">Map Link</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-map-pin"></i></span>
                                <input type="url" name="MapLink" class="form-control" placeholder="Enter Map Link" value="{{ $store->MapLink ?? '' }}" required>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="form-group col-md-12 mt-3">
                            <h6 class="font-weight-bold h5 mb-0">Contact Information</h6>
                        </div>

                        <!-- Contact Name -->
                        <div class="form-group col-md-6">
                            <label class="small">Contact Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" name="ContactName" class="form-control" placeholder="Enter Contact Name" value="{{ $store->ContactName ?? '' }}">
                            </div>
                        </div>

                        <!-- Designation -->
                        <div class="form-group col-md-6">
                            <label class="small">Designation</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" name="Designation" class="form-control" placeholder="Enter Designation" value="{{ $store->Designation ?? '' }}">
                            </div>
                        </div>

                        <!-- Contact Email -->
                        <div class="form-group col-md-6">
                            <label class="small">Contact Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" name="ContactEmail" class="form-control" placeholder="Enter Contact Email" value="{{ $store->ContactEmail ?? '' }}">
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group col-md-6">
                            <label class="small">Phone Number*</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                <input type="number" name="PhoneNumber" class="form-control phone" maxlength="12" placeholder="Enter Phone Number" value="{{ $store->PhoneNumber ?? '' }}" required>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="form-group col-md-12 mt-3">
                            <h6 class="font-weight-bold h5 mb-0">Additional Information</h6>
                        </div>

                        <!-- Hours of Operation -->
                        <div class="form-group col-md-6">
                            <label class="small">Opening Hours Time</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-time"></i></span>
                                <input type="time" name="HoursOfOperation[]" class="form-control" placeholder="e.g. 9 AM - 8 PM" value="{{ $store->HoursOfOperation[0] ?? '' }}">
                            </div>
                        </div>

                        <!-- Hours of Operation -->
                        <div class="form-group col-md-6">
                            <label class="small">Closing Hours Time</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-time"></i></span>
                                <input type="time" name="HoursOfOperation[]" class="form-control" placeholder="e.g. 9 AM - 8 PM" value="{{ $store->HoursOfOperation[1] ?? '' }}">
                            </div>
                        </div>

                        <!-- Square Footage -->
                        <div class="form-group col-md-6">
                            <label class="small">Square Footage</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-ruler"></i></span>
                                <input type="text" name="SquareFootage" class="form-control" placeholder="Enter Square Footage" value="{{ $store->SquareFootage ?? '' }}">
                            </div>
                        </div>

                        <!-- Accessibility Features -->
                        <div class="form-group col-md-6">
                            <label class="small">Accessibility Features</label>
                            <textarea name="AccessibilityFeatures" class="form-control" placeholder="Enter Accessibility Features">{{ $store->AccessibilityFeatures ?? '' }}</textarea>
                        </div>

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