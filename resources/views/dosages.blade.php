@extends('layout')
@section('title','Dosages - Easy Doctor')

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
    @endphp

    <section class="task__section">
        <div class="text">
            Dosages

            @if(in_array('dosages_add', $roleArray) || in_array('All', $roleArray))
            <div class="btn-group m-0">
                <a href="/admin/manage-dosage" class="btn btn-default btn-sm">
                    <i class="bx bx-plus"></i> <span>Add New</span>
                </a>
            </div>
            @endif
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pb-3 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Dosage (e.g., 500mg, 2 tablets)</th>
                                <th class="wpx-100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dosages as $k => $dosage)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $dosage->name ?? '--' }}</td>
                                <td class="text-center">
                                    @if(in_array('dosages_edit', $roleArray) || in_array('All', $roleArray))
                                    <a href="/admin/manage-dosage?id={{ $dosage->id }}" class="btn btn-info btn-sm" title="Edit">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    @endif
                                    @if(in_array('dosages_delete', $roleArray) || in_array('All', $roleArray))
                                    <a class="btn btn-danger btn-sm m-none delete" data-id="{{ $dosage->id }}" data-page="dosage" title="Delete">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
