@extends('layout')
@section('title','Admin Login - Easy Doctor')
@php if(Auth::check()){ Auth::logout(); } @endphp

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center h-90">
        <div class="col-md-4">
            <div class="card w-100 shadow pl-3 pr-3">
                <form action="{{ route('login') }}" method="POST" class="card-body">
                    <h4 class="card-title mb-4 mt-3">Welcome Back<br><span class="small">Login To Your Account</span></h4>
                    
                    @csrf
                    
                    <div class="form-group">
                        <!--label for="Username" class="text-muted">Username*:</label-->
                        <div class="input-group">
                            <img src="{{ asset('/public/assets/icons/email.svg'); }}" class="input-icon" />
                            <input type="email" name="login_email" class="form-control" placeholder="Email Id" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <!--label for="Username" class="text-muted">Password*:</label-->
                        <div class="input-group">
                            <img src="{{ asset('/public/assets/icons/lock.svg'); }}" class="input-icon" />
                            <input type="password" name="login_password" class="form-control" placeholder="Password" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button class="btn btn-default w-100">Login</button>
                    </div>
                    <div class="form-group text-center m-0">
                        <!--Don't Have an Account? <a class="text-dark w-100" href="/register">Click Here</a>-->
                    </div>
                </form>
            </div>
            <!--@if (Session::has('error'))
                <div class="response-msg">
                    <div class="alert alert-danger shadow" role="alert">
                        {{ Session::get('error') }}
                    </div>
                </div>
            @endif-->
        </div>
    </div>
</div>
@endsection