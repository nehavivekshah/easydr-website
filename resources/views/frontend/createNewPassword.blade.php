@extends('frontend.layout')

@section('content')
<!-- main-area -->
<main>
    <!-- new-password-area -->
    <section id="new-password" class="team-area pt-100 pb-40">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center mb-4">Reset Your Password</h4>
                            <form method="POST" action="/create-new-password">
                                @csrf
                                <div class="form-group">
                                    <label for="password">New Password*</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="password" 
                                        name="password" 
                                        required 
                                        placeholder="Enter your new password"
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm New Password*</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="password_confirmation" 
                                        name="password_confirmation" 
                                        required 
                                        placeholder="Confirm your new password"
                                    >
                                </div>
                                <button type="submit" class="btn btn-primary top-btn mb-3 rounded">
                                    Update Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- new-password-area-end -->
</main>
<!-- main-area-end -->
@endsection
