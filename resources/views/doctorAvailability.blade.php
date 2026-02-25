@extends('layout')
@section('title', 'Doctor Availability Slots - Easy Doctor')

@push('styles')
<style>
    .task__section .text {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-responsive {
        border-radius: 16px;
        background: #fff;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .table thead th {
        background: var(--color-default) !important;
        color: white !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding: 15px !important;
        border: none;
    }

    .table thead tr th:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .table thead tr th:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .table tbody td {
        padding: 15px !important;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 0.95rem;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    .badge {
        font-weight: 600;
        padding: 8px 12px;
        border-radius: 20px;
        letter-spacing: 0.5px;
    }

    .bg-success {
        background-color: rgba(16, 185, 129, 0.15) !important;
        color: #059669 !important;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .bg-danger {
        background-color: rgba(239, 68, 68, 0.15) !important;
        color: #dc2626 !important;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
        box-shadow: 0 2px 4px rgba(7, 204, 236, 0.2);
    }

    .btn-action i {
        font-size: 1.1rem;
    }

    .btn-action.btn-info {
        background: linear-gradient(135deg, #07CCEC 0%, #05a7c2 100%);
        border: none;
        color: white;
    }

    .btn-action.btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(7, 204, 236, 0.3);
    }

    @push('styles') <style>.icon-box {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .text-purple {
                color: #6f42c1 !important;
            }

            .bg-light {
                background-color: #f8f9fa !important;
            }

            .doctor-card {
                transition: transform 0.2s, box-shadow 0.2s;
                border-radius: 12px;
                overflow: hidden;
            }

            .doctor-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
            }
        </style>
    @endpush

<section class="task__section">
    <div class="text">
        <span>Doctor Availability Slots</span>
        @if(in_array('slot_add', $roleArray) || in_array('All', $roleArray))
            <a href="/admin/manage-slot"
                class="btn btn-primary rounded-pill shadow-sm px-4 py-2 d-flex align-items-center fw-bold"
                style="font-size: 0.95rem;">
                <i class="bx bx-plus me-2" style="font-size: 1.2rem;"></i> Add New Slot
            </a>
        @endif
    </div>

    <div class="container-fluid mt-4">
        <div class="row">
            @forelse($daSlots as $k => $daSlot)
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                    <div class="card shadow-sm h-100 doctor-card border-0">
                        <!-- Card Header: Doctor Info & Status -->
                        <div
                            class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1 fw-bold text-dark">
                                    {!! ($daSlot->first_name ?? '') . ' ' . ($daSlot->last_name ?? '') !!}</h5>
                                <p class="text-muted small mb-0">{!! ($daSlot->specialist ?? '') !!}</p>
                            </div>
                            <div class="text-end">
                                @if($daSlot->status == '1' && ($daSlot->to_date > now()->toDateString() || ($daSlot->to_date === now()->toDateString() && $daSlot->end_time >= now()->format('H:i'))))
                                    <a href="javascript:void(0)" class="badge bg-success rowStatus text-decoration-none"
                                        data-id="{{ $daSlot->id ?? '' }}">Active</a>
                                @elseif($daSlot->status == '1' && ($daSlot->to_date < now()->toDateString() || ($daSlot->to_date === now()->toDateString() && $daSlot->end_time < now()->format('H:i'))))
                                    <span class="badge bg-danger">Expired</span>
                                @else
                                    <a href="javascript:void(0)" class="badge bg-danger rowStatus text-decoration-none"
                                        data-id="{{ $daSlot->id ?? '' }}">Deactive</a>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body: Icon Boxes (Mirrors Frontend) -->
                        <div class="card-body p-4">
                            <!-- Date Range -->
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="icon-box me-3 text-success bg-light rounded p-2"
                                            style="font-size: 1.2rem;">
                                            <i class="bx bx-calendar-check"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark">
                                                {!! date_format(date_create($daSlot->from_date ?? ''), 'd M, Y') !!}</h6>
                                            <p class="text-muted small mb-0">From Date</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="icon-box me-3 text-danger bg-light rounded p-2"
                                            style="font-size: 1.2rem;">
                                            <i class="bx bx-calendar-x"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark">
                                                {!! date_format(date_create($daSlot->to_date ?? ''), 'd M, Y') !!}</h6>
                                            <p class="text-muted small mb-0">To Date</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Available Days -->
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-box me-3 text-warning bg-light rounded p-2" style="font-size: 1.2rem;">
                                    <i class="bx bx-grid-vertical"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark lh-base">
                                        {!! str_replace(',', ' | ', ($daSlot->available_days ?? '')) !!}
                                    </h6>
                                    <p class="text-muted small mb-0">Available Days</p>
                                </div>
                            </div>

                            <!-- Available Hours -->
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-box me-3 text-primary bg-light rounded p-2" style="font-size: 1.2rem;">
                                    <i class="bx bx-time"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">
                                        {!! date_format(date_create($daSlot->start_time ?? ''), 'h:i A') !!} -
                                        {!! date_format(date_create($daSlot->end_time ?? ''), 'h:i A') !!}
                                    </h6>
                                    <p class="text-muted small mb-0">Available Hours</p>
                                </div>
                            </div>

                            <!-- Slot Duration -->
                            <div class="d-flex align-items-start">
                                <div class="icon-box me-3 text-purple bg-light rounded p-2" style="font-size: 1.2rem;">
                                    <i class="bx bx-stopwatch"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">
                                        {{ $daSlot->duration ?? '30' }} minutes
                                    </h6>
                                    <p class="text-muted small mb-0">Slot Duration</p>
                                </div>
                            </div>

                        </div>

                        <!-- Card Footer: Actions -->
                        @if(in_array('slot_edit', $roleArray) || in_array('All', $roleArray))
                            <div class="card-footer bg-white border-top p-3 d-flex justify-content-end">
                                <a href="/admin/manage-slot?id={{ $daSlot->id }}"
                                    class="btn-action btn-info px-3 py-1 rounded shadow-sm text-decoration-none d-inline-flex align-items-center"
                                    title="Edit Slot">
                                    <i class="bx bx-edit me-1"></i> Edit
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted">
                        <i class="bx bx-calendar-x" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">No Availability Slots Found</h5>
                        <p>Get started by adding a new slot.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection