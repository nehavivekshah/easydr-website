@extends('layout')
@section('title','Medicines - Easy Doctor')

@section('content')
    @php
    
        $roles = session('roles');
        $roleArray = explode(',',($roles->permissions ?? ''));
    
    @endphp
    <section class="task__section">
        <div class="text">
            Medicines
            
            @if(in_array('medicine_add',$roleArray) || in_array('All',$roleArray))
            <div class="btn-group m-0">
                <a href="/admin/manage-medicine" class="btn btn-default btn-sm"><i class="bx bx-plus"></i> <span>Add New</span></a>
            </div>
            @endif
        </div>
        <!--`pharmacy_id`, `name`, `store_id`, `medical_stream`, `cost`, `available`, `label`, `type_id`, `purpose`, `symptoms`, `description`, `stock_quantity`, `expiration_date`-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th width="45px">Photo</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Purpose</th>
                                <th>Price</th>
                                <th>Expiration Date</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicines as $medicine)
                                <tr>
                                    <td>{{ $medicine->id }}</td>
                                    <td width="45px">
                                        @if(!empty($medicine->img))
                                        <img src="/public/{{ $medicine->img }}" class="thumbnail rounded-start" style="width:40px;" />
                                        @endif
                                    </td>
                                    <td>{{ $medicine->name }}</td>
                                    <td>{{ $medicine->type_name }}</td>
                                    <td>{{ $medicine->purpose }}</td>
                                    <td>${{ number_format($medicine->cost, 2) }}</td>
                                    <td>{!! date_format(date_create($medicine->expiration_date), 'd M, Y') !!}</td>
                                    <td class="text-center">@if($medicine->available == '1')<span class="btn btn-success btn-sm">Available</span>@else<span class="btn btn-danger btn-sm">Not Available</span>@endif</td>
                                    <td class="text-center">
                                        @if(in_array('medicine_edit',$roleArray) || in_array('All',$roleArray))
                                        <a href="/admin/manage-medicine?id={{ $medicine->id }}" class="btn btn-info btn-sm" title="Edit"><i class="bx bx-edit"></i></a>
                                        @endif
                                        @if(in_array('medicine_delete',$roleArray) || in_array('All',$roleArray))
                                        <form action="{{ route('medicine.destroy', $medicine->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this medicine?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bx bx-x"></i></button>
                                        </form>
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
