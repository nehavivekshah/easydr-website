@extends('layout')
@section('title','Frequencies - Easy Doctor')

@section('content')
    @php
        $roles = session('roles');
        $roleArray = explode(',', ($roles->permissions ?? ''));
    @endphp

    <section class="task__section">
        <div class="text">
            Frequencies

            @if(in_array('frequency_add', $roleArray) || in_array('All', $roleArray))
            <div class="btn-group m-0">
                <a href="/admin/manage-frequency" class="btn btn-default btn-sm">
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
                                <th>Frequency Name</th>
                                <th class="wpx-100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($frequencies as $k => $frequency)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $frequency->name ?? '--' }}</td>
                                <td class="text-center">
                                    @if(in_array('frequency_edit', $roleArray) || in_array('All', $roleArray))
                                    <a href="/admin/manage-frequency?id={{ $frequency->id }}" class="btn btn-info btn-sm" title="Edit">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    @endif
                                    @if(in_array('frequency_delete', $roleArray) || in_array('All', $roleArray))
                                    <a class="btn btn-danger btn-sm m-none delete" data-id="{{ $frequency->id }}" data-page="frequency" title="Delete">
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
