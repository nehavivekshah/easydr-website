@extends('layout')

@section('title', 'Suppliers - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="text">
            Suppliers
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm" onclick="openAddModal()">
                    <i class="bx bx-plus"></i> <span>Add Supplier</span>
                </button>
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
                                <th width="150px">Action</th>
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
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info text-white"
                                            onclick="editSupplier({{ $supplier->id }})">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <a href="{{ route('suppliers.delete', $supplier->id) }}" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    </td>
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
                <form action="{{ route('suppliers.add') }}" method="POST" id="supplierForm">
                    @csrf
                    <input type="hidden" name="id" id="supplierId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact</label>
                            <input type="text" name="contact" id="contact" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Add Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openAddModal() {
            $('#supplierForm')[0].reset();
            $('#supplierId').val('');
            $('#addSupplierModalLabel').text('Add Supplier');
            $('#saveBtn').text('Add Supplier');
            $('#addSupplierModal').modal('show');
        }

        function editSupplier(id) {
            $.get('/admin/suppliers/edit/' + id, function (data) {
                $('#addSupplierModalLabel').text('Edit Supplier');
                $('#saveBtn').text('Update Supplier');
                $('#addSupplierModal').modal('show');

                $('#supplierId').val(data.id);
                $('#name').val(data.name);
                $('#contact').val(data.contact);
                $('#email').val(data.email);
                $('#address').val(data.address);
            });
        }
    </script>
@endpush