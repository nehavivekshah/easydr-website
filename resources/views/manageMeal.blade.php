@extends('layout')
@section('title','Manage Meal - Easy Doctor')

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
                            <a href="/admin/meals" class="text-dark" title="Back">
                                <i class="bx bx-arrow-back h6"></i>
                            </a>  
                            <label class="px-3">
                                @if(!empty($_GET['id'])) {{ 'Edit Meal Instruction' }} 
                                @else {{ 'Add New Meal Instruction' }} 
                                @endif
                            </label>
                        </h6>
                    </div>

                    <form action="{{ route('manageMeal') }}" method="POST" class="card-body py-3 px-3">
                        @csrf
                        <div class="form-group">
                            <label class="small">Meal Instruction*</label><br />
                            <div class="input-group">
                                <img src="{{ asset('/public/assets/icons/user.svg') }}" class="input-icon" />
                                <input type="text" name="name" class="form-control" placeholder="e.g. Before Meal, After Meal, With Food" value="{{ $meal->name ?? '' }}" required />
                            </div>
                            <input type="hidden" name="id" value="{{ $_GET['id'] ?? '' }}" />
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
