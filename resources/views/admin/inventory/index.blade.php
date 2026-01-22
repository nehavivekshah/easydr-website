@extends('layout')

@section('title', 'Inventory - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="text">
            Inventory (Store ID: {{ $store_id ?? 'N/A' }})
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm" onclick="openAddModal()">
                    <i class="bx bx-plus"></i> <span>Update Stock</span>
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
                                <th>Medicine ID</th>
                                <th>Quantity</th>
                                <th>Updated At</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventory as $k => $item)
                                <tr>
                                    <td class="text-center">{{ $k + 1 }}</td>
                                    <td>{{ $item->medicine_id }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info text-white" onclick="editInventory({{ $item->id }})">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <a href="{{ route('inventory.delete', $item->id) }}" class="btn btn-sm btn-danger"
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
    <div class="modal fade" id="updateInventoryModal" tabindex="-1" aria-labelledby="updateInventoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('inventory.update') }}" method="POST" id="inventoryForm">
                    @csrf
                    <input type="hidden" name="id" id="inventoryId">
                    <input type="hidden" name="store_id" value="{{ $store_id ?? '' }}" id="hidden_store_id_primary">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateInventoryModalLabel">Update Inventory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Store ID</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-store'></i></span>
                                <input type="number" name="store_id_display" class="form-control" placeholder="Enter store ID" value="{{ $store_id ?? '' }}"
                                    {{ isset($store_id) ? 'disabled' : '' }}>
                            </div>
                            @if(!isset($store_id))
                                <script>
                                    document.querySelector('input[name="store_id_display"]').addEventListener('input', function (e) {
                                        document.getElementById('hidden_store_id_primary').value = e.target.value;
                                    });
                                </script>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Medicine ID</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-capsule'></i></span>
                                <input type="number" name="medicine_id" id="medicine_id" class="form-control" placeholder="Enter medicine ID" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-package'></i></span>
                                <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openAddModal() {
            $('#inventoryForm')[0].reset();
            $('#inventoryId').val('');
            $('#updateInventoryModalLabel').text('Add Inventory Item');
            $('#saveBtn').text('Add Item');
            $('#updateInventoryModal').modal('show');
        }

        function editInventory(id) {
            $.get('/admin/inventory/edit/' + id, function (data) {
                $('#updateInventoryModalLabel').text('Edit Inventory Item');
                $('#saveBtn').text('Update Item');
                $('#updateInventoryModal').modal('show');

                $('#inventoryId').val(data.id);
                $('#medicine_id').val(data.medicine_id);
                $('#quantity').val(data.quantity);
                // Store ID logic is a bit complex due to view dependency, assuming current store context or data.store_id
            });
        }
    </script>
@endpush