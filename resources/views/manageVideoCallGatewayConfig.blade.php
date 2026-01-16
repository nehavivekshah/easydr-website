@extends('layout')
@section('title','Manage Video Call Gateway - Easy Doctor')

@section('content')
@php
    $roles = session('roles');
    $roleArray = explode(',', ($roles->permissions ?? ''));
@endphp

<section class="task__section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 bg-white shadow-sm border mt-4 p-0 rounded">
                <div class="text py-3 px-3 border-bottom">
                    <h6 class="m-0">
                        <a href="/admin/video-call-gateway-configs" class="text-dark" title="Back">
                            <i class="bx bx-arrow-back h6"></i>
                        </a>
                        <label class="px-3">
                            @if(!empty($_GET['id'])) Edit Video Call Gateway @else Add New Video Call Gateway @endif
                        </label>
                    </h6>
                </div>

                <form action="{{ route('manageVideoCallGatewayConfig') }}" method="POST" class="card-body py-3 px-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" />

                    <div class="form-group">
                        <label class="small">Provider Name*</label>
                        <input type="text" name="provider_name" class="form-control" placeholder="Enter Provider Name" value="{{ $vcgc->provider_name ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label class="small">App ID</label>
                        <input type="text" name="app_id" class="form-control" value="{{ $vcgc->app_id ?? '' }}" />
                    </div>

                    <div class="form-group">
                        <label class="small">App Secret</label>
                        <input type="text" name="app_secret" class="form-control" value="{{ $vcgc->app_secret ?? '' }}" />
                    </div>

                    <div class="form-group">
                        <label class="small">API Key</label>
                        <input type="text" name="api_key" class="form-control" value="{{ $vcgc->api_key ?? '' }}" />
                    </div>

                    <div class="form-group">
                        <label class="small">API Secret</label>
                        <input type="text" name="api_secret" class="form-control" value="{{ $vcgc->api_secret ?? '' }}" />
                    </div>

                    <div class="form-group">
                        <label class="small">Webhook Secret</label>
                        <input type="text" name="webhook_secret" class="form-control" value="{{ $vcgc->webhook_secret ?? '' }}" />
                    </div>

                    <div class="form-group">
                        <label class="small">Environment</label>
                        <select name="environment" class="form-control">
                            <option value="sandbox" {{ (isset($vcgc) && $vcgc->environment == 'sandbox') ? 'selected' : '' }}>Sandbox</option>
                            <option value="production" {{ (isset($vcgc) && $vcgc->environment == 'production') ? 'selected' : '' }}>Production</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="small">Is Active?</label><br />
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" value="1" {{ (isset($vcgc) && $vcgc->is_active == 1) ? 'checked' : '' }}>
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" value="0" {{ (isset($vcgc) && $vcgc->is_active == 0) ? 'checked' : '' }}>
                            <label class="form-check-label">No</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small">Additional Config (JSON)</label>
                        <textarea name="additional_config" class="form-control" rows="4" placeholder='{"key":"value"}'>{{ $vcgc->additional_config ?? '' }}</textarea>
                    </div>

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
