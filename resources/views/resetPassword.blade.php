@extends('layout')
@section('title','Reset Password - Easy Doctor')

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
                            Reset Password
                        </h6>
                    </div>
                    <form action="{{ route('resetPassword') }}" method="POST" class="card-body py-3 px-3">
                        @csrf
                        <div class="form-group">
                            <label class="small">Current Password*</label><br />
                            <div class="input-group">
                                <img src="{{ asset('/public/assets/icons/lock.svg') }}" class="input-icon" />
                                <input type="password" name="cur_password" id="cur_password" class="form-control" placeholder="Current Password" required />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="small">New Password*</label><br />
                            <div class="input-group">
                                <img src="{{ asset('/public/assets/icons/lock.svg') }}" class="input-icon" />
                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password" required />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="small">Re-enter New Password*</label><br />
                            <div class="input-group">
                                <img src="{{ asset('/public/assets/icons/lock.svg') }}" class="input-icon" />
                                <input type="password" name="new_password_confirmation" id="cn_password" class="form-control" placeholder="Confirm Password" required />
                            </div>
                            <div id="passwordError" class="text-danger newPassword" style="display:none;">Passwords do not match.</div>
                        </div>
                        
                        <div class="form-group text-right mt-3 mb-0">
                            <button type="submit" id="submitButtonv" class="btn btn-default">Submit</button>
                            <button type="reset" class="btn btn-light border">Reset</button>
                        </div>
                    </form>
                <div>
            </div>
        </div>
    </section>
    
    <!-- Scripts -->
    <script>
        
        document.getElementById('new_password').addEventListener('keyup', validatePasswordMatch);
        document.getElementById('cn_password').addEventListener('keyup', validatePasswordMatch);
        
        function validatePasswordMatch() {
            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('cn_password').value;
            var passwordError = document.getElementById('passwordError');
        
            if (newPassword !== confirmPassword) {
                document.getElementById('submitButtonv').disabled = true;
                passwordError.style.display = 'block';
            } else {
                document.getElementById('submitButtonv').disabled = false;
                passwordError.style.display = 'none';
            }
        }
        
    </script>
@endsection