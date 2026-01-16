@extends('layout')

@section('title', 'Suppliers - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="text">
            Suppliers
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addSupplierModal"><i class="bx bx-plus"></i> <span>Add Supplier</span></button>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table id="lists" class="table table-striped table-bordered m-table" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50px">Sr. No.</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $k => $supplier)
                                <tr>
                                    <td class="text-center">{{ $k + 1 }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->contact }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->address }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('suppliers.add') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact</label>
                            <input type="text" name="contact" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection