@extends('layout')
@section('title', 'Assigned Doctors - Easy Doctor')

@section('content')
    @php

        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));

    @endphp
    <section class="task__section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-0 text-dark fw-bold" style="font-size: 1.5rem;">Assigned Doctors</h2>
                <div class="text-muted small mt-1">
                    Home / Users / Assigned Doctors
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                @if(in_array('slot_add', $roleArray) || in_array('All', $roleArray))
                    <a href="/admin/manage-slot" class="btn btn-default rounded-pill shadow-sm px-4">
                        <i class="bx bx-plus me-1 border-0 bg-transparent text-white p-0"></i> <span>Add New Slot</span>
                    </a>
                @endif
                <button class="btn btn-outline-secondary rounded-pill shadow-sm px-4" title="Export to CSV">
                    <i class="bx bx-download me-1"></i> Export
                </button>
            </div>
        </div>

        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-12 pb-3">
                    <div class="card border-0 shadow-sm rounded-4 w-100">
                        <div class="card-body p-3 table-responsive">
                            <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="50px" class="text-center">Sr. No.</th>
                                        <th>Doctors</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th class="text-center">Status</th>
                                        <th class="wpx-100 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data will be populated here --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection