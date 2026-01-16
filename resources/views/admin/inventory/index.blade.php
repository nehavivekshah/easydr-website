@extends('layout')

@section('title', 'Inventory - Easy Doctor')

@section('content')
    <section class="task__section">
        <div class="text">
            Inventory (Store ID: {{ $store_id ?? 'N/A' }})
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm" data-bs-toggle="modal"
                    data-bs-target="#updateInventoryModal"><i class="bx bx-plus"></i> <span>Update Stock</span></button>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventory as $k => $item)
                                <tr>
                                    <td class="text-center">{{ $k + 1 }}</td>
                                    <td>{{ $item->medicine_id }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->updated_at }}</td>
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
                <form action="{{ route('inventory.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="store_id" value="{{ $store_id ?? '' }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateInventoryModalLabel">Update Inventory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Store ID</label>
                            <input type="number" name="store_id_display" class="form-control" value="{{ $store_id ?? '' }}"
                                {{ isset($store_id) ? 'disabled' : '' }}>
                            @if(!isset($store_id))
                                <input type="hidden" name="store_id" id="hidden_store_id">
                                <script>
                                    document.querySelector('input[name="store_id_display"]').addEventListener('input', function (e) {
                                        document.getElementById('hidden_store_id').value = e.target.value;
                                    });
                                </script>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Medicine ID</label>
                            <input type="number" name="medicine_id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection