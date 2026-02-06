@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Availability</h4>
                                <button type="button" class="btn ss-btn text-white" data-bs-toggle="modal"
                                    data-bs-target="#addSlotModal">
                                    <i class="fas fa-plus pe-1"></i> Add New Slot
                                </button>
                            </div>

                            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                                <div class="card-body p-4">
                                    <ul class="nav nav-pills nav-pills-custom mb-4" id="slotTabs" role="tablist">
                                        <li class="nav-item me-2" role="presentation">
                                            <button class="nav-link active" id="active-tab" data-bs-toggle="pill"
                                                data-bs-target="#active" type="button" role="tab" aria-controls="active"
                                                aria-selected="true">
                                                <i class="fas fa-calendar-day me-2"></i>
                                                <span>Active (Today)</span>
                                            </button>
                                        </li>
                                        <li class="nav-item me-2" role="presentation">
                                            <button class="nav-link" id="upcoming-tab" data-bs-toggle="pill"
                                                data-bs-target="#upcoming" type="button" role="tab" aria-controls="upcoming"
                                                aria-selected="false">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                <span>Upcoming</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="past-tab" data-bs-toggle="pill"
                                                data-bs-target="#past" type="button" role="tab" aria-controls="past"
                                                aria-selected="false">
                                                <i class="fas fa-history me-2"></i>
                                                <span>Past</span>
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="slotTabsContent">
                                        <!-- Active Slots -->
                                        <div class="tab-pane fade show active" id="active" role="tabpanel"
                                            aria-labelledby="active-tab">
                                            @forelse($activeSlots as $dateGroup)
                                                <div class="mb-4 border-0 shadow-sm rounded-3 overflow-hidden">
                                                    <div class="p-3 bg-light border-bottom">
                                                        <h6 class="mb-0 fw-bold text-primary">
                                                            <i class="fas fa-calendar-day me-2"></i>{{ $dateGroup['date'] }}
                                                        </h6>
                                                    </div>
                                                    <div class="p-3 bg-white">
                                                        <div class="d-flex flex-wrap justify-content-between gap-3">
                                                            @foreach($dateGroup['slots'] as $slot)
                                                                <button type="button"
                                                                    class="btn px-3 py-2 fw-medium shadow-sm transition-all"
                                                                    style="border-radius: 6px; min-width: 140px; 
                                                                    {{ $slot['is_past'] 
                                                                        ? 'background: #f8f9fa!important; border: 1px solid #e9ecef!important; color: #adb5bd!important; cursor: not-allowed;' 
                                                                        : 'background: #fff!important; border: 1px solid #cfd8dc!important; color: #455a64!important;' }}"
                                                                    {{ $slot['is_past'] ? 'disabled' : '' }}
                                                                    onmouseover="if(!this.disabled){this.style.backgroundColor='#0ab7e3!important'; this.style.color='#fff!important'; this.style.borderColor='#0ab7e3!important';}" 
                                                                    onmouseout="if(!this.disabled){this.style.backgroundColor='#fff!important'; this.style.color='#455a64!important'; this.style.borderColor='#cfd8dc!important';}">
                                                                    {{ $slot['time'] }}
                                                                </button>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-5">
                                                    <p class="text-muted">No active availabilities for today.</p>
                                                </div>
                                            @endforelse
                                        </div>

                                        <!-- Upcoming Slots -->
                                        <div class="tab-pane fade" id="upcoming" role="tabpanel"
                                            aria-labelledby="upcoming-tab">
                                            @forelse($upcomingSlots as $dateGroup)
                                                <div class="mb-4 border-0 shadow-sm rounded-3 overflow-hidden">
                                                    <div class="p-3 bg-light border-bottom">
                                                        <h6 class="mb-0 fw-bold text-dark">
                                                            <i
                                                                class="fas fa-calendar-alt me-2 text-success"></i>{{ $dateGroup['date'] }}
                                                        </h6>
                                                    </div>
                                                    <div class="p-3 bg-white">
                                                        <div class="d-flex flex-wrap justify-content-between gap-3">
                                                            @foreach($dateGroup['slots'] as $slot)
                                                                <button type="button"
                                                                    class="btn px-3 py-2 fw-medium shadow-sm transition-all"
                                                                    style="border-radius: 6px; min-width: 140px; background: #fff; border: 1px solid #cfd8dc; color: #455a64;"
                                                                    onmouseover="this.style.backgroundColor='#0ab7e3!important'; this.style.color='#fff!important'; this.style.borderColor='#0ab7e3!important';" 
                                                                    onmouseout="this.style.backgroundColor='#fff!important'; this.style.color='#455a64!important'; this.style.borderColor='#cfd8dc!important';">
                                                                    {{ $slot['time'] }}
                                                                </button>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-5">
                                                    <p class="text-muted">No upcoming availabilities found.</p>
                                                </div>
                                            @endforelse
                                        </div>

                                        <!-- Past Slots -->
                                        <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
                                            @forelse($pastSlots as $dateGroup)
                                                <div class="mb-4 border-0 shadow-sm rounded-3 overflow-hidden">
                                                    <div class="p-3 bg-light border-bottom">
                                                        <h6 class="mb-0 fw-bold text-muted">
                                                            <i class="fas fa-history me-2"></i>{{ $dateGroup['date'] }}
                                                        </h6>
                                                    </div>
                                                    <div class="p-3 bg-white">
                                                        <div class="d-flex flex-wrap justify-content-between gap-3">
                                                            @foreach($dateGroup['slots'] as $slot)
                                                                <button type="button"
                                                                    class="btn px-3 py-2 fw-medium transition-all"
                                                                    style="border-radius: 6px; min-width: 140px; background: #f8f9fa!important; border: 1px solid #e9ecef!important; color: #adb5bd!important; cursor: not-allowed!important;"
                                                                    disabled>
                                                                    {{ $slot['time'] }}
                                                                </button>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-5">
                                                    <p class="text-muted">No past availabilities found.</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add Slot Modal -->
                        <div class="modal fade" id="addSlotModal" tabindex="-1" aria-labelledby="addSlotModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('saveSlot') }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addSlotModalLabel">Add New Availability Slot</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">From Date</label>
                                                    <input type="date" name="from_date" class="form-control" required
                                                        min="{{ date('Y-m-d') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">To Date</label>
                                                    <input type="date" name="to_date" class="form-control" required
                                                        min="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label d-block">Available Days</label>
                                                @php
                                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                                @endphp
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($days as $day)
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="checkbox" name="days[]"
                                                                value="{{ $day }}" id="day_{{ $day }}">
                                                            <label class="form-check-label" for="day_{{ $day }}">
                                                                {{ substr($day, 0, 3) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Start Time</label>
                                                    <input type="time" name="start_time" class="form-control" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">End Time</label>
                                                    <input type="time" name="end_time" class="form-control" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Duration (Minutes)</label>
                                                    <input type="number" name="duration" class="form-control" required
                                                        min="5" value="15">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary text-white">Save Slot</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection