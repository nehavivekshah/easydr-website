@extends('layout')
@section('title','Assigned Doctors - Easy Doctor')

@section('content')
    @php
    
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    
    @endphp
    <section class="task__section">
        <div class="text">
            Assigned Doctors
            @if(in_array('slot_add',$roleArray) || in_array('All',$roleArray))
            <div class="btn-group">
                <!--<a href="/admin/manage-slot" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> <span>Add New</span></a>-->
            </div>
            @endif
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pb-3 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">Sr. No.</th>
                                <th>Doctors</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th class="wpx-100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection