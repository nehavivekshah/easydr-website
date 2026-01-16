@extends('layout')
@section('title','Video Call Gateway Configs - Easy Doctor')

@section('content')
@php
    $roles = session('roles');
    $roleArray = explode(',', ($roles->permissions ?? ''));
@endphp

<section class="task__section">
    <div class="text">
        Video Call Gateway Configs

        @if(in_array('vcgc_add', $roleArray) || in_array('All', $roleArray))
        <div class="btn-group m-0">
            <a href="/admin/manage-video-call-gateway-config" class="btn btn-default btn-sm"><i class="bx bx-plus"></i> <span>Add New</span></a>
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
                            <th>Provider</th>
                            <th>App ID</th>
                            <th>App Secret</th>
                            <th>API Key</th>
                            <th>API Secret</th>
                            <th>Webhook Secret</th>
                            <th>Environment</th>
                            <th class="text-center">Status</th>
                            <th class="wpx-100 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vcgc as $k => $item)
                        <tr>
                            <td>{{ $k + 1 }}</td>
                            <td>{{ $item->provider_name ?? '--' }}</td>
                            <td>{{ $item->app_id ?? '--' }}</td>
                            <td>{{ $item->app_secret ? '********' : '--' }}</td>
                            <td>{{ $item->api_key ?? '--' }}</td>
                            <td>{{ $item->api_secret ? '********' : '--' }}</td>
                            <td>{{ $item->webhook_secret ? '********' : '--' }}</td>
                            <td>{{ ucfirst($item->environment ?? '--') }}</td>
                            <td class="text-center">
                                @if($item->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Deactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(in_array('vcgc_edit', $roleArray) || in_array('All', $roleArray))
                                <a href="/admin/manage-video-call-gateway-config?id={{ $item->id }}" class="btn btn-info btn-sm" title="Edit"><i class="bx bx-edit"></i></a>
                                @endif
                                @if(in_array('vcgc_delete', $roleArray) || in_array('All', $roleArray))
                                <a class="btn btn-danger btn-sm m-none delete" data-id="{{ $item->id }}" data-page="video_call_gateway_config" title="Delete"><i class="bx bx-trash"></i></a>
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
