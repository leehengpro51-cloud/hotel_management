@extends('layouts.app')

@section('title', 'Operations Dashboard')

@section('content')
<!-- Header Banner -->
<div class="card card-hotel border-0 text-white mb-4 overflow-hidden" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 60%, #1E3E62 100%);">
    <div class="card-body p-4 p-lg-5 position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="hotel-logo-wrapper" style="padding: 2px;">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Angkor Hotel" class="hotel-logo-img" style="width: 52px; height: 52px;">
                    </div>
                    <span class="badge px-3 py-1.5 rounded-pill" style="background: rgba(212, 175, 55, 0.2); color: #D4AF37; border: 1px solid rgba(212, 175, 55, 0.4);">
                        <i class="bi bi-patch-check-fill me-1"></i> Angkor Hotel Operations &bull; Laravel 13
                    </span>
                </div>
                <h1 class="display-6 fw-bold mb-2 font-luxury text-white">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-light opacity-75 mb-4" style="max-width: 650px;">
                    Angkor Hotel Management System overview. Manage room inventories, track real-time occupancy, coordinate guest reservations, and monitor revenue.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('rooms.create') }}" class="btn btn-gold px-3.5 py-2 rounded-3 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-door-open-fill"></i> Add New Room
                    </a>
                    <a href="{{ route('reservations.create') }}" class="btn btn-light px-3.5 py-2 rounded-3 text-dark fw-semibold d-inline-flex align-items-center gap-2">
                        <i class="bi bi-calendar-plus-fill text-primary"></i> New Reservation
                    </a>
                    <a href="{{ route('room-types.create') }}" class="btn btn-outline-light px-3.5 py-2 rounded-3 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-grid-fill"></i> New Room Type
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-light px-3.5 py-2 rounded-3 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-people-fill text-warning"></i> Manage Staff
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="p-4 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10 backdrop-blur">
                    <div class="text-uppercase small fw-bold tracking-wider brand-gold mb-1">Occupancy Rate</div>
                    <div class="display-4 fw-extrabold text-white mb-1">{{ $occupancyRate }}%</div>
                    <div class="progress bg-white bg-opacity-20" style="height: 8px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $occupancyRate }}%" aria-valuenow="{{ $occupancyRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="small text-light opacity-75 mt-2">{{ $occupiedRooms }} of {{ $totalRooms }} rooms occupied</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Counters -->
<div class="row g-3 mb-4">
    <!-- Total Rooms -->
    <div class="col-sm-6 col-lg-3">
        <div class="stat-badge-card">
            <div class="stat-icon-wrapper bg-primary bg-opacity-10 text-primary">
                <i class="bi bi-door-closed"></i>
            </div>
            <div>
                <div class="text-muted small fw-semibold">TOTAL ROOMS</div>
                <div class="fs-3 fw-bold text-dark">{{ $totalRooms }}</div>
                <div class="text-muted" style="font-size: 0.78rem;">Across all hotel wings</div>
            </div>
        </div>
    </div>

    <!-- Available Rooms -->
    <div class="col-sm-6 col-lg-3">
        <div class="stat-badge-card">
            <div class="stat-icon-wrapper bg-success bg-opacity-10 text-success">
                <i class="bi bi-check2-circle"></i>
            </div>
            <div>
                <div class="text-muted small fw-semibold">AVAILABLE ROOMS</div>
                <div class="fs-3 fw-bold text-success">{{ $availableRooms }}</div>
                <div class="text-muted" style="font-size: 0.78rem;">Ready for immediate check-in</div>
            </div>
        </div>
    </div>

    <!-- Occupied Rooms -->
    <div class="col-sm-6 col-lg-3">
        <div class="stat-badge-card">
            <div class="stat-icon-wrapper bg-danger bg-opacity-10 text-danger">
                <i class="bi bi-person-fill-lock"></i>
            </div>
            <div>
                <div class="text-muted small fw-semibold">OCCUPIED ROOMS</div>
                <div class="fs-3 fw-bold text-danger">{{ $occupiedRooms }}</div>
                <div class="text-muted" style="font-size: 0.78rem;">In-house guest stays</div>
            </div>
        </div>
    </div>

    <!-- Total Room Categories -->
    <div class="col-sm-6 col-lg-3">
        <div class="stat-badge-card">
            <div class="stat-icon-wrapper bg-warning bg-opacity-15 text-warning">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </div>
            <div>
                <div class="text-muted small fw-semibold">ROOM CATEGORIES</div>
                <div class="fs-3 fw-bold text-dark">{{ $totalRoomTypes }}</div>
                <div class="text-muted" style="font-size: 0.78rem;">Suites, Villas & Standards</div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="p-3 bg-white rounded-3 border d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-people-fill text-info fs-4"></i>
                <span class="small fw-semibold text-muted">Checked-In Guests:</span>
            </div>
            <span class="fw-bold fs-5 text-dark">{{ $checkedInGuests }}</span>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="p-3 bg-white rounded-3 border d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-tools text-secondary fs-4"></i>
                <span class="small fw-semibold text-muted">Under Maintenance:</span>
            </div>
            <span class="fw-bold fs-5 text-secondary">{{ $maintenanceRooms }}</span>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="p-3 bg-white rounded-3 border d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-cash-coin text-success fs-4"></i>
                <span class="small fw-semibold text-muted">Recorded Bookings Value:</span>
            </div>
            <span class="fw-bold fs-5 text-success">${{ number_format($totalRevenue, 2) }}</span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Bookings Table -->
    <div class="col-lg-8">
        <div class="card card-hotel h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history text-warning"></i> Recent Guest Bookings
                </h5>
                <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-secondary">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hotel align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Guest Name</th>
                            <th>Room</th>
                            <th>Dates</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $b)
                        <tr>
                            <td class="fw-bold text-muted">#{{ $b->booking_id }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $b->guest_name }}</div>
                                <div class="text-muted small">{{ $b->guest_email }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    Room {{ $b->room->room_number ?? 'N/A' }}
                                </span>
                                <div class="text-muted small" style="font-size: 0.75rem;">
                                    {{ $b->room->roomType->type_name ?? '' }}
                                </div>
                            </td>
                            <td>
                                <div class="small fw-semibold">{{ \Carbon\Carbon::parse($b->check_in_date)->format('M d') }} - {{ \Carbon\Carbon::parse($b->check_out_date)->format('M d, Y') }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">{{ $b->total_nights }} night(s)</div>
                            </td>
                            <td>
                                @if($b->status == 'Checked In')
                                    <span class="badge badge-occupied rounded-pill px-2.5 py-1">Checked In</span>
                                @elseif($b->status == 'Confirmed')
                                    <span class="badge badge-reserved rounded-pill px-2.5 py-1">Confirmed</span>
                                @elseif($b->status == 'Checked Out')
                                    <span class="badge badge-available rounded-pill px-2.5 py-1">Checked Out</span>
                                @else
                                    <span class="badge badge-maintenance rounded-pill px-2.5 py-1">{{ $b->status }}</span>
                                @endif
                            </td>
                            <td class="fw-bold text-success">${{ number_format($b->total_amount, 2) }}</td>
                            <td class="text-end">
                                <a href="{{ route('reservations.show', $b->booking_id) }}" class="btn btn-sm btn-outline-primary" title="View Voucher">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No reservations booked yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Room Categories Sidebar -->
    <div class="col-lg-4">
        <div class="card card-hotel h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-tags-fill text-warning"></i> Room Categories
                </h5>
                <a href="{{ route('room-types.index') }}" class="btn btn-sm btn-outline-secondary">
                    Manage
                </a>
            </div>
            <div class="card-body p-3">
                <div class="list-group list-group-flush">
                    @foreach($roomTypesWithCount as $type)
                    <div class="list-group-item px-2 py-3 border-bottom d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fw-bold text-dark">{{ $type->type_name }}</div>
                            <div class="text-muted small">Base: ${{ number_format($type->base_price, 2) }} &bull; Max {{ $type->capacity }} guests</div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5 py-1.5 fw-bold">
                                {{ $type->rooms_count }} Rooms
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer bg-light p-3 border-top">
                <a href="{{ route('room-types.create') }}" class="btn btn-sm btn-outline-primary w-100">
                    <i class="bi bi-plus-circle me-1"></i> Add Room Category
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
