@extends('layout')
@section('title','Easy Doctors Register')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center h-90">
        <div class="col-md-4">
            <div class="card w-100 shadow pl-3 pr-3">
                <form action="{{ route('register') }}" method="POST" class="card-body"  autocomplete="off">
                    <h4 class="card-title mb-4">Welcome<br><span class="small">Create a new CRM account</span></h4>
                    
                    @csrf
                    
                    <div class="form-group">
                        <!--<label for="name" class="text-muted">Name*:</label>-->
                        <div class="input-group">
                            <img src="{{ asset('/public/assets/icons/user.svg') }}" class="input-icon" />
                            <input type="text" name="reg_name" class="form-control" placeholder="Enter your name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label for="mobile" class="text-muted">Mobile No.*:</label>-->
                        <div class="input-group">
                            <img src="{{ asset('/public/assets/icons/mob.svg'); }}" class="input-icon" />
                            <input type="text" name="reg_mob" class="form-control" placeholder="Enter your mobile no." required />
                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label for="email" class="text-muted">Email Id*:</label>-->
                        <div class="input-group">
                            <img src="{{ asset('/public/assets/icons/email.svg'); }}" class="input-icon" />
                            <input type="email" name="reg_email" class="form-control" placeholder="Enter your email id" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label for="password" class="text-muted">Password*:</label>-->
                        <div class="input-group">
                            <img src="{{ asset('/public/assets/icons/lock.svg'); }}" class="input-icon" />
                            <input type="password" name="reg_password" class="form-control" placeholder="Password" required />
                        </div>
                    </div>
                    <!--Company Details-->
                    <h4 class="h5 card-title-2">Compnay Details</h4>
                    <div class="form-group">
                        <!--<label for="company" class="text-muted">Company Name*:</label>-->
                        <div class="input-group">
                            <img src="{{ asset('/public/assets/icons/edit.svg'); }}" class="input-icon" />
                            <input type="text" name="reg_company" class="form-control" placeholder="Enter your company name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label for="gst" class="text-muted">GST(Optional):</label>-->
                        <div class="input-group">
                            <img src="{{ asset('/public/assets/icons/edit.svg'); }}" class="input-icon" />
                            <input type="text" name="reg_gst" class="form-control" placeholder="Enter your gst no." />
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary w-100">Submit</button>
                    </div>
                    <div class="form-group text-center">
                        Already Have an Account <a class="text-dark w-100" href="/login">Click Here</a>
                    </div>
                </form>
            </div>
            <!--@if (Session::has('success'))
                <div class="response-msg">
                    <div class="alert alert-success shadow" role="alert">
                        {{ Session::get('success') }}
                    </div>
                </div>
            @endif-->
        </div>
    </div>
</div>
@endsection