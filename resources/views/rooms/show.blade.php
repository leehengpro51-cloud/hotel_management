@extends('layouts.app')

@section('title', 'Room #' . $room->room_number)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Breadcrumb & Actions -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}" class="text-decoration-none">Rooms</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Room #{{ $room->room_number }}</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0 text-dark font-luxury">Room Profile: #{{ $room->room_number }}</h3>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <a href="{{ route('rooms.edit', $room->room_id) }}" class="btn btn-navy">
                    <i class="bi bi-pencil-square text-warning"></i> Edit Room
                </a>
                <a href="{{ route('reservations.create', ['room_id' => $room->room_id]) }}" class="btn btn-gold">
                    <i class="bi bi-calendar-plus"></i> Book Guest
                </a>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- Room Overview Card -->
            <div class="col-md-7">
                <div class="card card-hotel h-100">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-door-open-fill text-warning me-1"></i> Specifications
                        </h5>
                        @if($room->status == 'Available')
                            <span class="badge badge-available px-3 py-1.5 rounded-pill">Available</span>
                        @elseif($room->status == 'Occupied')
                            <span class="badge badge-occupied px-3 py-1.5 rounded-pill">Occupied</span>
                        @elseif($room->status == 'Reserved')
                            <span class="badge badge-reserved px-3 py-1.5 rounded-pill">Reserved</span>
                        @else
                            <span class="badge badge-maintenance px-3 py-1.5 rounded-pill">Maintenance</span>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <div class="text-muted small">ROOM NUMBER</div>
                                <div class="fs-4 fw-bold text-dark">{{ $room->room_number }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small">FLOOR LEVEL</div>
                                <div class="fs-5 fw-semibold text-dark">{{ $room->floor }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small">BEDDING CONFIGURATION</div>
                                <div class="fs-6 fw-semibold text-dark">{{ $room->bed_type }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small">NIGHTLY TARIFF</div>
                                <div class="fs-4 fw-bold text-success">${{ number_format($room->price_per_night, 2) }}</div>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-2">
                            <div class="text-muted small mb-1">AMENITIES & DESCRIPTION</div>
                            <p class="text-secondary mb-0">
                                {{ $room->description ?: 'No special notes recorded for this room.' }}
                            </p>
                        </div>
                    </div>
                    <div class="card-footer bg-light px-4 py-3 small text-muted d-flex justify-content-between">
                        <span>Record created: {{ $room->created_at->format('M d, Y') }}</span>
                        <span>Last updated: {{ $room->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Relational Category Info -->
            <div class="col-md-5">
                <div class="card card-hotel h-100">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-tag-fill text-warning me-1"></i> Category Assignment
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if($room->roomType)
                            <div class="p-3 rounded-3 mb-3" style="background: var(--brand-gold-soft); border: 1px solid rgba(212, 175, 55, 0.4);">
                                <div class="brand-gold small fw-bold text-uppercase">Room Type (Parent Table)</div>
                                <h4 class="fw-bold text-dark mb-1">{{ $room->roomType->type_name }}</h4>
                                <div class="text-muted small">Base Rate: ${{ number_format($room->roomType->base_price, 2) }} &bull; Capacity: {{ $room->roomType->capacity }} guests</div>
                            </div>

                            <ul class="list-unstyled small mb-0 text-secondary">
                                <li class="mb-2">
                                    <i class="bi bi-person-badge text-primary me-2"></i>
                                    <strong>Manager In-Charge:</strong> {{ $room->roomType->manager_id ?? 'Front Office GM' }}
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                    <strong>Location/Zone:</strong> {{ $room->roomType->location_id ?? 'Main Tower' }}
                                </li>
                                <li>
                                    <i class="bi bi-info-circle text-info me-2"></i>
                                    <strong>Category Details:</strong> {{ Str::limit($room->roomType->description, 100) }}
                                </li>
                            </ul>
                        @else
                            <p class="text-muted">No category assigned to this room.</p>
                        @endif
                    </div>
                    <div class="card-footer bg-light p-3">
                        @if($room->roomType)
                            <a href="{{ route('room-types.show', $room->roomType->type_id) }}" class="btn btn-outline-primary btn-sm w-100">
                                View Full Category Profile <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Reservation History for this room -->
        <div class="card card-hotel">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-calendar-event text-warning me-1"></i> Booking & Stay History
                </h5>
                <span class="badge bg-light text-dark border">{{ $room->reservations->count() }} records</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hotel align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Guest Name</th>
                            <th>Contact</th>
                            <th>Stay Dates</th>
                            <th>Status</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($room->reservations as $res)
                        <tr>
                            <td class="fw-bold text-muted">#{{ $res->booking_id }}</td>
                            <td class="fw-semibold text-dark">{{ $res->guest_name }}</td>
                            <td class="small text-muted">{{ $res->guest_phone }}</td>
                            <td class="small">{{ \Carbon\Carbon::parse($res->check_in_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($res->check_out_date)->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $res->status }}</span>
                            </td>
                            <td class="fw-bold text-success">${{ number_format($res->total_amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No reservations recorded for this room yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
