@extends('layout')
@section('title','Role Settings - Easy Doctors')

@section('content')
<section class="task__section">
    <div class="text">
        <a href="/admin/role-settings" class="btn btn-default btn-sm back-btn"><i class="bx bx-arrow-back"></i></a>
        @if(!empty(request()->get('id'))) Edit Role @else Add New Role @endif
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                
                <form action="manage-role-setting" method="post" class="row g-3 px-2">
                    @csrf
                    
                    <div class="col-md-12 bg-white border rounded shadow-sm py-3 px-4">
                        
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="role">Role*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text" class="form-control" id="role" name="role" placeholder="Enter Role*" value="{{ $roles->title ?? '' }}" required>
                                </div>
                                <input type="hidden" name="id" value="{{ request()->get('id') ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="subrole">Designation</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text" class="form-control" id="subrole" name="subrole" placeholder="Enter Designation" value="{{ $roles->subtitle ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="status">Status*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="1" @if(($roles->status ?? '') == '1') selected @endif>Active</option>
                                        <option value="2" @if(($roles->status ?? '') == '2') selected @endif>Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        @php
                            $features = explode(',', ($roles->features ?? ''));
                            $permissions = explode(',', ($roles->permissions ?? ''));
                        @endphp

                        <div class="form-group">
                            <label for="features">Features & Access Permissions*</label><br>
                        
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Feature</th>
                                        <th>Add</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <!-- Doctors Management -->
                                    <tr>
                                        <td>Doctors Management</td>
                                        <td>
                                            <input type="checkbox" name="permissions[doctors][]" value="add" @if(in_array('doctors_add', $permissions)) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[doctors][]" value="edit" @if(in_array('doctors_edit', $permissions)) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[doctors][]" value="delete" @if(in_array('doctors_delete', $permissions)) checked @endif>
                                        </td>
                                    </tr>
                        
                                    <!-- Patients Management -->
                                    <tr>
                                        <td>Patients Management</td>
                                        <td>
                                            <input type="checkbox" name="permissions[patients][]" value="add" @if(in_array('patients_add', $permissions)) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[patients][]" value="edit" @if(in_array('patients_edit', $permissions)) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[patients][]" value="delete" @if(in_array('patients_delete', $permissions)) checked @endif>
                                        </td>
                                    </tr>
                        
                                    <!-- Stores Management -->
                                    <tr>
                                        <td>Stores Management</td>
                                        <td>
                                            <input type="checkbox" name="permissions[stores][]" value="add" @if(in_array('stores_add', $permissions)) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[stores][]" value="edit" @if(in_array('stores_edit', $permissions)) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[stores][]" value="delete" @if(in_array('stores_delete', $permissions)) checked @endif>
                                        </td>
                                    </tr>
                                    
                                    <!-- Users Management -->
                                    <tr>
                                        <td>Users Management</td>
                                        <td>
                                            <input type="checkbox" name="permissions[users][]" value="add" @if(in_array('users_add', $permissions)) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[users][]" value="edit" @if(in_array('users_edit', $permissions)) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[users][]" value="delete" @if(in_array('users_delete', $permissions)) checked @endif>
                                        </td>
                                    </tr>
                        
                                    <!-- Setting Management -->
                                    <tr>
                                        <td>Setting Management</td>
                                        <td>
                                            <input type="checkbox" name="permissions[setting][]" value="add" @if(in_array('setting_add', $permissions)) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[setting][]" value="edit" @if(in_array('setting_edit', $permissions)) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[setting][]" value="delete" @if(in_array('setting_delete', $permissions)) checked @endif>
                                        </td>
                                    </tr>
                        
                                    <!-- Listing Management -->
                                    <tr>
                                        <td>Listing Management</td>
                                        <td>
                                            <input type="checkbox" name="permissions[listing][]" value="add" @if(in_array('listing_add', $permissions)) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[listing][]" value="edit" @if(in_array('listing_edit', $permissions)) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[listing][]" value="delete" @if(in_array('listing_delete', $permissions)) checked @endif>
                                        </td>
                                    </tr>
                        
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group text-right mt-2 pt-2">
                            <button type="submit" class="btn btn-default px-4">Submit</button>
                            <button type="reset" class="btn btn-light border px-4">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
