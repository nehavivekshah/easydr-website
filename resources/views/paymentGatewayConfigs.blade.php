@extends('layout')
@section('title','Payment Gateway Configs - Easy Doctor')

@section('content')
    @php
    
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    
    @endphp
    <section class="task__section">
        <div class="text">
            Payment Gateway Configs
            @if(in_array('pgc_add',$roleArray) || in_array('All',$roleArray))
            <div class="btn-group m-0">
                <a href="/admin/manage-payment-gateway-config" class="btn btn-default btn-sm"><i class="bx bx-plus"></i> <span>Add New</span></a>
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
                                <th>Gateway</th>
                                <th>Merchant ID</th>
                                <th>API Key</th>
                                <th>API Secret</th>
                                <th>Webhook Secret</th>
                                <th>Environment</th>
                                <th class="text-center">Status</th>
                                <th class="wpx-100 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pgc as $k => $pg)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td class="wpx-100 text-center">
                                    <div>{{ $pg->gateway_name ?? '--' }}</div>
                                </td>
                                <td>{{ $pg->merchant_id ?? '--' }}</td>
                                <td>{{ $pg->api_key ?? '--' }}</td>
                                <td>{{ $pg->api_secret ? '********' : '--' }}</td>
                                <td>{{ $pg->webhook_secret ? '********' : '--' }}</td>
                                <td>{{ ucfirst($pg->environment ?? '--') }}</td>
                                <td class="text-center">
                                    @if($pg->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(in_array('pgc_edit',$roleArray) || in_array('All',$roleArray))
                                    <a href="/admin/manage-payment-gateway-config?id={{ $pg->id }}" class="btn btn-info btn-sm" title="Edit"><i class="bx bx-edit"></i></a>
                                    @endif
                                    @if(in_array('pgc_delete',$roleArray) || in_array('All',$roleArray))
                                    <a class="btn btn-danger btn-sm m-none delete" data-id="{{ $pg->id }}" data-page="pgc" title="Delete"><i class="bx bx-x"></i></a>
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