@extends('layout')
@section('title', 'Manage Medicine - Easy Doctor')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
    .page-header-title { font-size:1.35rem; font-weight:700; color:#111827; margin:0; }
    .wizard-stepper { display:flex; align-items:center; justify-content:center; background:#f8f9fa; border-radius:12px; padding:20px 30px; margin-bottom:28px; }
    .wizard-step { display:flex; flex-direction:column; align-items:center; flex:1; position:relative; cursor:pointer; }
    .wizard-step:not(:last-child)::after { content:''; position:absolute; top:18px; left:calc(50% + 22px); width:calc(100% - 44px); height:2px; background:#dee2e6; z-index:0; }
    .wizard-step.active:not(:last-child)::after, .wizard-step.done:not(:last-child)::after { background:#2563eb; }
    .step-circle { width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.9rem; border:2px solid #dee2e6; background:#fff; color:#adb5bd; z-index:1; transition:all .25s; }
    .wizard-step.active .step-circle { background:#2563eb; border-color:#2563eb; color:#fff; box-shadow:0 4px 12px rgba(37,99,235,.35); }
    .wizard-step.done .step-circle { background:#2563eb; border-color:#2563eb; color:#fff; }
    .step-label { font-size:.7rem; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#adb5bd; margin-top:8px; }
    .wizard-step.active .step-label, .wizard-step.done .step-label { color:#2563eb; }
    .wizard-panel { display:none; }
    .wizard-panel.active { display:block; }
    .form-section-title { font-size:.8rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#6c757d; margin:8px 0 18px; padding-bottom:8px; border-bottom:1px solid #e9ecef; }
    .input-group-text { background:#f0f4ff; border-right:none; color:#2563eb; min-width:42px; justify-content:center; }
    .input-group .form-control, .input-group .form-select { border-left:none; background:#f8f9fb; }
    .input-group .form-control:focus, .input-group .form-select:focus { border-color:#2563eb; box-shadow:none; background:#fff; }
    .btn-wizard-next, .btn-wizard-submit { background:linear-gradient(135deg,#1d4ed8,#2563eb); color:#fff; border:none; border-radius:50px; padding:10px 32px; font-weight:600; font-size:.92rem; box-shadow:0 4px 14px rgba(37,99,235,.3); transition:all .2s; }
    .btn-wizard-next:hover, .btn-wizard-submit:hover { background:linear-gradient(135deg,#1e40af,#1d4ed8); box-shadow:0 6px 20px rgba(37,99,235,.4); transform:translateY(-1px); color:#fff; }
    .btn-wizard-back { background:#fff; color:#374151; border:1.5px solid #d1d5db; border-radius:50px; padding:10px 28px; font-weight:600; font-size:.92rem; transition:all .2s; }
    .btn-wizard-back:hover { background:#f3f4f6; border-color:#9ca3af; }
    .wizard-card { background:#fff; border-radius:16px; border:1px solid #e5e7eb; box-shadow:0 4px 24px rgba(0,0,0,.07); overflow:hidden; }
    .wizard-banner { background:linear-gradient(135deg,#1d4ed8,#2563eb); padding:22px 32px; display:flex; align-items:center; gap:16px; }
    .wizard-banner-icon { width:46px; height:46px; background:rgba(255,255,255,.18); border-radius:13px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.4rem; flex-shrink:0; }
    .wizard-banner-title { color:#fff; font-size:1.05rem; font-weight:700; margin:0; }
    .wizard-banner-sub   { color:rgba(255,255,255,.8); font-size:.78rem; margin:2px 0 0; }
    .wizard-back-btn { width:36px; height:36px; background:rgba(255,255,255,.18); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; font-size:1rem; flex-shrink:0; transition:background .2s; margin-right:4px; }
    .wizard-back-btn:hover { background:rgba(255,255,255,.3); color:#fff; }
    .wizard-card-body { padding:28px 32px 32px; }

    /* Gallery preview */
    .gallery-preview { display:flex; gap:8px; flex-wrap:wrap; margin-top:8px; }
    .gallery-preview img { width:48px; height:48px; object-fit:cover; border-radius:8px; border:1px solid #e5e7eb; }

    /* Select2 match our style */
    .select2-container--default .select2-selection--multiple {
        border-left:none;
        background:#f8f9fb;
        border-radius:0 .375rem .375rem 0;
        border-color:#ced4da;
        min-height:40px;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color:#2563eb;
    }
</style>
@endpush

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
        $isEdit = !empty(request('id'));
        $gallery = json_decode($medicine->gallery ?? '[]', true);
    @endphp

    <section class="task__section">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="page-header-title">{{ $isEdit ? 'Edit Medicine' : 'Add New Medicine' }}</h4>
                    <nav aria-label="breadcrumb" class="mt-1"><ol class="breadcrumb mb-0" style="font-size:.8rem;">
                        <li class="breadcrumb-item"><a href="/admin/dashboard" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/medicine-listings" class="text-decoration-none text-muted">Medicine Listings</a></li>
                        <li class="breadcrumb-item active text-muted">{{ $isEdit ? 'Edit Medicine' : 'Add Medicine' }}</li>
                    </ol></nav>
                </div>
            </div>
            <div class="wizard-card">
                <div class="wizard-banner">
                    <a href="/admin/medicine-listings" class="wizard-back-btn" title="Back"><i class="bx bx-arrow-back"></i></a>
                    <div class="wizard-banner-icon"><i class="bx bx-capsule"></i></div>
                    <div>
                        <p class="wizard-banner-title">{{ $isEdit ? 'Edit Medicine' : 'Add New Medicine' }}</p>
                        <p class="wizard-banner-sub">Configure medicine details, availability and images across 2 steps</p>
                    </div>
                </div>
                <div class="wizard-card-body">
                {{-- Stepper --}}
                <div class="wizard-stepper">
                    <div class="wizard-step active" data-step="1"><div class="step-circle">1</div><div class="step-label">Basic Info</div></div>
                    <div class="wizard-step" data-step="2"><div class="step-circle">2</div><div class="step-label">Details &amp; Availability</div></div>
                </div>

                        <form action="{{ route('manageMedicine') }}" method="POST" enctype="multipart/form-data" id="medicineWizardForm">
                            @csrf
                            <input type="hidden" name="id" value="{{ request('id') ?? '' }}">

                            {{-- ============================
                                 STEP 1: Basic Info
                                 ============================ --}}
                            <div class="wizard-panel active" id="step-1">
                                <div class="form-section-title"><i class="bx bx-capsule me-2"></i>Medicine Information</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Medicine Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-capsule"></i></span>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Enter Medicine Name"
                                                value="{{ $medicine->name ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Label</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-label"></i></span>
                                            <input type="text" name="label" class="form-control"
                                                placeholder="Enter Label"
                                                value="{{ $medicine->label ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Medicine Type <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-category"></i></span>
                                            <select name="type_id" class="form-select" required>
                                                @foreach($types as $type)
                                                    <option value="{{ $type->id }}" @if(($type->id ?? '') == ($medicine->type_id ?? '')) selected @endif>{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Medicine Category <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-check-shield"></i></span>
                                            <select name="medicine_category" class="form-select" required>
                                                <option value="">Select Category</option>
                                                <option value="otc" @if(($medicine->medicine_category ?? '') == 'otc') selected @endif>OTC</option>
                                                <option value="prescribed" @if(($medicine->medicine_category ?? '') == 'prescribed') selected @endif>Prescribed</option>
                                                <option value="spacial" @if(($medicine->medicine_category ?? '') == 'spacial') selected @endif>Special Medicine</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Cost (Rs.) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-rupee"></i></span>
                                            <input type="number" step="0.01" name="cost" class="form-control"
                                                placeholder="Original Cost"
                                                value="{{ $medicine->cost ?? 0 }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Discount Cost (Rs.)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-tag"></i></span>
                                            <input type="number" step="0.01" name="discount_cost" class="form-control"
                                                placeholder="Discounted Cost"
                                                value="{{ $medicine->discount_cost ?? 0 }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Pharmacy <span class="text-danger">*</span></label>
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
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Store Locations <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-map"></i></span>
                                            <select name="store_locations[]" id="storeLocationsSelect" class="form-control" multiple="multiple" required>
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->LocationID }}" @if(($medicine->store_id ?? '') == ($location->LocationID ?? '')) selected @endif>{{ $location->LocationName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn-wizard-next" onclick="goToStep(2)">
                                        Next <i class="bx bx-right-arrow-alt ms-1"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- ============================
                                 STEP 2: Details & Availability
                                 ============================ --}}
                            <div class="wizard-panel" id="step-2">
                                <div class="form-section-title"><i class="bx bx-info-circle me-2"></i>Description &amp; Details</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Purpose</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-target-lock"></i></span>
                                            <input type="text" name="purpose" class="form-control"
                                                placeholder="Enter Purpose"
                                                value="{{ $medicine->purpose ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Medical Stream <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-book"></i></span>
                                            <input type="text" name="medical_stream" class="form-control"
                                                placeholder="Enter Medical Stream"
                                                value="{{ $medicine->medical_stream ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Symptoms</label>
                                        <textarea name="symptoms" class="form-control" rows="3"
                                            placeholder="Enter Symptoms" style="border-radius:.375rem;">{{ $medicine->symptoms ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Description</label>
                                        <textarea name="description" class="form-control" rows="3"
                                            placeholder="Enter Description" style="border-radius:.375rem;">{{ $medicine->description ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Expiry Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input type="date" name="expiry_date" class="form-control"
                                                value="{{ $medicine->expiration_date ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Available <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-check-circle"></i></span>
                                            <select name="available" class="form-select" required>
                                                <option value="1" {{ ($medicine->available ?? '') == 1 ? 'selected' : '' }}>Yes</option>
                                                <option value="0" {{ ($medicine->available ?? '') == 0 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-title mt-4"><i class="bx bx-image-alt me-2"></i>Images</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Thumbnail <span class="text-danger">{{ empty($medicine->img) ? '*' : '' }}</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-image"></i></span>
                                            <input type="file" name="thumbnail" class="form-control" accept="image/*"
                                                @if(empty($medicine->img)) required @endif>
                                        </div>
                                        @if(!empty($medicine->img))
                                            <div class="gallery-preview mt-2">
                                                <img src="/public/{{ $medicine->img }}" alt="thumbnail">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Gallery (up to 4 images)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-images"></i></span>
                                            <input type="file" name="images[]" id="galleryInput" class="form-control" accept="image/*" multiple>
                                        </div>
                                        @if(!empty($gallery))
                                            <div class="gallery-preview mt-2">
                                                @foreach(array_slice($gallery, 0, 4) as $img)
                                                    <img src="{{ asset('/public/' . $img) }}" alt="gallery">
                                                @endforeach
                                                @if(count($gallery) > 4)
                                                    <span class="badge bg-secondary align-self-center">{{ count($gallery) }} total</span>
                                                @endif
                                            </div>
                                        @endif
                                        <small class="text-muted">You can select up to 4 images.</small>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn-wizard-back" onclick="goToStep(1)">
                                        <i class="bx bx-left-arrow-alt me-1"></i> Back
                                    </button>
                                    <button type="submit" id="submitButton" class="btn-wizard-submit">
                                        <i class="bx bx-check me-1"></i> {{ $isEdit ? 'Update Medicine' : 'Save Medicine' }}
                                    </button>
                                </div>
                            </div>

                    </form>
                </div>{{-- /.wizard-card-body --}}
            </div>{{-- /.wizard-card --}}
        </div>{{-- /.container-fluid --}}
    </section>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#storeLocationsSelect').select2({ placeholder: "Select Store Locations", allowClear: true });

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
                            data.forEach(loc => storeSelect.append(`<option value="${loc.LocationID}">${loc.LocationName}</option>`));
                        } else {
                            storeSelect.html('<option value="">No Locations Found</option>');
                        }
                        storeSelect.trigger('change');
                    },
                    error: function () { console.error('Failed to fetch locations.'); }
                });
            } else {
                storeSelect.html('<option value="">Select Store Locations</option>');
            }
        });
    });

    document.getElementById('galleryInput').addEventListener('change', function () {
        if (this.files.length > 4) {
            alert("You can only upload up to 4 images.");
            this.value = "";
        }
    });

    function goToStep(stepNum) {
        const currentPanel = document.querySelector('.wizard-panel.active');
        if (stepNum > parseInt(currentPanel.id.split('-')[1])) {
            const required = currentPanel.querySelectorAll('[required]');
            let valid = true;
            required.forEach(f => { if (!f.value.trim()) { f.classList.add('is-invalid'); valid = false; } else { f.classList.remove('is-invalid'); } });
            if (!valid) return;
        }
        document.querySelectorAll('.wizard-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('step-' + stepNum).classList.add('active');
        document.querySelectorAll('.wizard-step').forEach((s, i) => {
            s.classList.remove('active','done');
            if (i + 1 < stepNum) s.classList.add('done');
            if (i + 1 === stepNum) s.classList.add('active');
        });
        document.querySelector('.wizard-banner').scrollIntoView({ behavior:'smooth', block:'start' });
    }

    document.querySelectorAll('[required]').forEach(f => f.addEventListener('input', () => f.classList.remove('is-invalid')));
</script>
@endpush