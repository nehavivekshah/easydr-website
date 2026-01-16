@extends('layout')
@section('title','Manage Pharmacy Type - Easy Doctor')

@section('content')
    @php
    
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    
    @endphp
    <section class="task__section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-4 offset-md-4 rounded bg-white shadow-sm border mt-4 p-0">
                    <div class="text py-3 px-3 border border-left-0 border-right-0 border-top-0">
                        <h6 class="m-0">
                            <a href="/admin/pharmacy-types" class="text-dark" title="Back"><i class="bx bx-arrow-back h6"></i></a>  
                            <label class="px-3">@if(!empty($_GET['id'])) {{ 'Edit Pharmacy Type' }} @else {{ 'Add New Pharmacy Type' }} @endif</label>
                        </h6>
                    </div>
                    <form action="{{ route('managePharmacyType') }}" method="POST" class="card-body py-3 px-3">
                        @csrf
                        <div class="form-group">
                            <label class="small">Title*</label><br />
                            <div class="input-group">
                                <img src="{{ asset('/public/assets/icons/user.svg') }}" class="input-icon" />
                                <input type="text" name="title" class="form-control" placeholder="Enter Title*" value="{{ $pharmacyType->title ?? '' }}" required />
                            </div>
                            <input type="hidden" name="id" value="{{$_GET['id'] ?? ''}}" />
                        </div>
                        
                        <div class="form-group mt-3 mb-0 text-right">
                            <button type="submit" id="submitButton" class="btn btn-default border">Submit</button>
                            <button type="reset" class="btn btn-white border">Reset</button>
                        </div>
                    </form>
                <div>
            </div>
        </div>
    </section>
@endsection