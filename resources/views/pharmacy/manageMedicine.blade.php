@extends('layout')
@section('title','Manage Medicine - Easy Doctor')

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    @endphp

    <section class="task__section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 rounded bg-white shadow-sm border mt-4 p-0">
                    <div class="text py-3 px-3 border border-left-0 border-right-0 border-top-0">
                        <h6 class="m-0">
                            <a href="/admin/medicine-listings" class="text-dark" title="Back">
                                <i class="bx bx-arrow-back h6"></i>
                            </a>  
                            <label class="px-3">@if(!empty($_GET['id'])) {{ 'Edit Medicine' }} @else {{ 'Add New Medicine' }} @endif</label>
                        </h6>
                    </div>

                    <form action="{{ route('manageMedicine') }}" method="POST" enctype="multipart/form-data" class="card-body py-3 px-3">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="small">Thumbnail Image*</label><br />
                                <div class="input-group">
                                    @if(!empty($medicine->img))
                                    <img src="/public/{{ $medicine->img ?? '' }}" class="thumbnail rounded-start" style="width:40px;" />
                                    @endif
                                    <input type="file" name="thumbnail" class="form-control" accept="image/*" @if(empty($medicine->img)) required @endif>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="small">Additional Images (up to 4)</label><br />
                                <div class="input-group d-flex gap-2 align-items-center">
                                    @php
                                        $gallery = json_decode($medicine->gallery ?? '[]', true);
                                    @endphp
                            
                                    @if(!empty($gallery))
                                        @foreach(array_slice($gallery, 0, 4) as $img)
                                            <img src="{{ asset('/public/'.$img) }}" class="thumbnail rounded-start" style="width:40px; height:40px; object-fit:cover;" />
                                        @endforeach
                                        @if(count($gallery) > 4)
                                            <span class="badge bg-secondary">{{ count($gallery) }} total</span>
                                        @endif
                                    @endif
                            
                                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                                </div>
                                <small class="text-muted">You can select up to 4 images.</small>
                            </div>


                            <div class="form-group col-md-6">
                                <label class="small">Medicine Name*</label><br />
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-capsule"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Medicine Name" value="{{ $medicine->name ?? '' }}" required>
                                    <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" required>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="small">Label*</label><br />
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-label"></i></span>
                                    <input type="text" name="label" class="form-control" placeholder="Enter Label" value="{{ $medicine->label ?? '' }}">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="small">Cost($)*</label><br>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                    <input type="number" step="0.01" name="cost" class="form-control" placeholder="Original Cost" value="{{ $medicine->cost ?? 0 }}" required="">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="small">Discount Cost ($)</label><br>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-tag"></i></span>
                                    <input type="number" step="0.01" name="discount_cost" class="form-control" placeholder="Discounted Cost" value="{{ $medicine->discount_cost ?? 0 }}">
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="small">Medicine Type*</label><br />
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-category"></i></span>
                                    <select name="type_id" class="form-select" required>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" @if(($type->id ?? '') == ($medicine->type_id ?? '')) selected @endif>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="small">Medicine Category*</label><br>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-check-shield"></i></span>
                                    <select name="medicine_category" class="form-select" required="">
                                        <option value="">Select Category</option>
                                        <option value="otc" @if(($medicine->medicine_category ?? '') == 'otc') selected @endif>OTC</option>
                                        <option value="prescribed" @if(($medicine->medicine_category ?? '') == 'prescribed') selected @endif>Prescribed</option>
                                        <option value="prescribed" @if(($medicine->medicine_category ?? '') == 'spacial') selected @endif>Spacial Medicine</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="small">Pharmacy*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-clinic"></i></span>
                                    <select name="store_id" id="pharmacySelect" class="form-select" required>
                                        <option value="">Select Pharmacy</option>
                                        @foreach($stores as $store)
                                            <option value="{{ $store->PharmacyID }}" @if(($store->PharmacyID ?? '') == ($medicine->pharmacy_id ?? '')) selected @endif>{{ $store->PharmacyName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="small">Store Locations*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-map"></i></span>
                                    <select name="store_locations[]" id="storeLocationsSelect" class="form-control" multiple="multiple" required>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->LocationID  }}" @if(($medicine->store_id ?? '') == ($location->LocationID ?? '')) selected @endif>{{ $location->LocationName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="small">Purpose*</label><br />
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-target-lock"></i></span>
                                    <input type="text" name="purpose" class="form-control" placeholder="Enter Purpose" value="{{ $medicine->purpose ?? '' }}">
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="small">Medical Stream*</label><br />
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-book"></i></span>
                                    <input type="text" name="medical_stream" class="form-control" placeholder="Enter Medical Stream" value="{{ $medicine->medical_stream ?? '' }}" required>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="small">Symptoms*</label><br />
                                <textarea name="symptoms" class="form-control border" rows="3" placeholder="Enter Symptoms">{{ $medicine->symptoms ?? '' }}</textarea>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="small">Description*</label><br />
                                <textarea name="description" class="form-control border" rows="3" placeholder="Enter Description">{{ $medicine->description ?? '' }}</textarea>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="small">Expiry Date*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="expiry_date" class="form-control" value="{{ $medicine->expiration_date ?? '' }}" required>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="small">Available*</label><br />
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-check-circle"></i></span>
                                    <select name="available" class="form-select" required>
                                        <option value="1" {{ ($medicine->available ?? '') == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ ($medicine->available ?? '') == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mt-2 mb-0 text-right">
                            <button type="submit" id="submitButton" class="btn btn-default border">Submit</button>
                            <button type="reset" class="btn btn-white border">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- jQuery & Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('#storeLocationsSelect').select2({
                placeholder: "Select Store Locations",
                allowClear: true
            });

            // Pharmacy Selection Change
            $('#pharmacySelect').on('change', function () {
                let pharmacyId = $(this).val();
                let storeSelect = $('#storeLocationsSelect');

                storeSelect.html('<option value="">Loading...</option>');

                if (pharmacyId) {
                    $.ajax({
                        url: `/get-locations/${pharmacyId}`,
                        type: 'GET',
                        success: function (data) {
                            storeSelect.html('');
                            if (data.length > 0) {
                                data.forEach(location => {
                                    storeSelect.append(`<option value="${location.LocationID}">${location.LocationName}</option>`);
                                });
                            } else {
                                storeSelect.html('<option value="">No Locations Found</option>');
                            }
                        },
                        error: function () {
                            console.error('Failed to fetch locations.');
                        }
                    });
                } else {
                    storeSelect.html('<option value="">Select Store Locations</option>');
                }
            });
        });
        
        document.querySelector('input[name="images[]"]').addEventListener('change', function(e) {
            if (this.files.length > 4) {
                alert("You can only upload up to 4 images.");
                this.value = ""; // Clear selection
            }
        });
    </script>
@endsection