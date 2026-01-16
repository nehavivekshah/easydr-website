@extends('layout')
@section('title','Manage Notification - Easy Doctor')

@section('content')
<section class="task__section">
    <div class="text">
        <h2>{{ isset($notification) ? 'Edit Notification' : 'Add Notification' }}</h2>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="{{ isset($notification) ? route('admin.update-notification', $notification->id) : route('admin.store-notification') }}" method="POST">
                    @csrf
                    @if(isset($notification))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="type">Notification Type</label>
                        <input type="text" name="type" id="type" class="form-control" value="{{ $notification->type ?? old('type') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ $notification->description ?? old('description') }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ (isset($notification) && $notification->status == 1) ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ (isset($notification) && $notification->status == 0) ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ isset($notification) ? 'Update' : 'Add' }}</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
