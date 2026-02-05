<div class="card mb-3 border-0 shadow-sm" style="border-radius: 12px; transition: all 0.2s ease;">
    <div class="card-body p-3">
        <div class="row align-items-center">
            <div class="col-md-5">
                <h6 class="mb-1 fw-bold text-dark">
                    <i class="far fa-calendar-alt me-2 text-primary"></i>
                    {{ \Carbon\Carbon::parse($slot->from_date)->format('d M, Y') }} <span
                        class="text-muted px-1">-</span> {{ \Carbon\Carbon::parse($slot->to_date)->format('d M, Y') }}
                </h6>
                <div class="mt-2 d-flex align-items-center">
                    <span class="badge bg-light text-secondary rounded-pill border px-3 py-2 me-2">
                        <i class="far fa-clock me-1 text-info"></i>
                        {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} -
                        {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                    </span>
                    <small class="text-muted fw-bold">{{ $slot->duration }} min</small>
                </div>
            </div>
            <div class="col-md-7">
                <div class="d-flex flex-wrap gap-2 justify-content-md-end mt-3 mt-md-0">
                    @foreach(explode(',', $slot->available_days) as $day)
                        <span class="badge rounded-pill fw-normal px-3 py-2"
                            style="background-color: #e0f7fa; color: #006064; border: 1px solid #b2ebf2;">
                            {{ substr($day, 0, 3) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>