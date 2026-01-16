@extends('layout')
@section('title','Manage Payment Gateway - Easy Doctor')

@section('content')
@php
    $roles = session('roles');
    $roleArray = explode(',',($roles->permissions ?? ''));
@endphp

<section class="task__section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12 offset-md-3 rounded bg-white shadow-sm border mt-4 p-0">
                <div class="text py-3 px-3 border-bottom">
                    <h6 class="m-0">
                        <a href="/admin/payment-gateway-configs" class="text-dark" title="Back"><i class="bx bx-arrow-back h6"></i></a>
                        <label class="px-3">
                            @if(!empty($_GET['id'])) {{ 'Edit Payment Gateway' }} @else {{ 'Add New Payment Gateway' }} @endif
                        </label>
                    </h6>
                </div>

                <form action="/admin/manage-payment-gateway-config" method="POST" class="card-body py-3 px-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}">

                    <div class="form-group">
                        <label class="small">Gateway Name*</label>
                        <input type="text" name="gateway_name" class="form-control" placeholder="Gateway Name*" value="{{ $pgc->gateway_name ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="small">Merchant ID*</label>
                        <input type="text" name="merchant_id" class="form-control" placeholder="Merchant ID*" value="{{ $pgc->merchant_id ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="small">API Key*</label>
                        <input type="text" name="api_key" class="form-control" placeholder="API Key*" value="{{ $pgc->api_key ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="small">API Secret*</label>
                        <input type="text" name="api_secret" class="form-control" placeholder="API Secret*" value="{{ $pgc->api_secret ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="small">Webhook Secret</label>
                        <input type="text" name="webhook_secret" class="form-control" placeholder="Webhook Secret" value="{{ $pgc->webhook_secret ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label class="small">Environment*</label>
                        <select name="environment" class="form-control" required>
                            <option value="">-- Select Environment --</option>
                            <option value="sandbox" {{ (isset($pgc->environment) && $pgc->environment == 'sandbox') ? 'selected' : '' }}>Sandbox</option>
                            <option value="production" {{ (isset($pgc->environment) && $pgc->environment == 'production') ? 'selected' : '' }}>Production</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="small">Status*</label>
                        <select name="is_active" class="form-control" required>
                            <option value="1" {{ (isset($pgc->is_active) && $pgc->is_active == 1) ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ (isset($pgc->is_active) && $pgc->is_active == 0) ? 'selected' : '' }}>Deactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="small">Additional Config (JSON)</label>
                        <textarea name="additional_config" class="form-control" rows="4" placeholder='{"key": "value"}'>{{ $pgc->additional_config ?? '{}' }}</textarea>
                    </div>

                    <div class="form-group mt-3 mb-0 text-right">
                        <button type="submit" class="btn btn-default border">Submit</button>
                        <button type="reset" class="btn btn-white border">Reset</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
@endsection
