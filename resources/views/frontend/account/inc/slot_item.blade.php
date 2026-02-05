<div class="card mb-3 border">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4">
                <h6 class="mb-1 text-primary">
                    <i class="far fa-calendar-alt me-1"></i>
                    {{ \Carbon\Carbon::parse($slot->from_date)->format('d M Y') }} -
                    {{ \Carbon\Carbon::parse($slot->to_date)->format('d M Y') }}
                </h6>
                <small class="text-muted">
                    <i class="far fa-clock me-1"></i> {{ $slot->start_time }} - {{ $slot->end_time }}
                    ({{ $slot->duration }} mins)
                </small>
            </div>
            <div class="col-md-8">
                <div class="d-flex flex-wrap gap-1">
                    @foreach(explode(',', $slot->available_days) as $day)
                        <span class="badge bg-light text-dark border">{{ substr($day, 0, 3) }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>