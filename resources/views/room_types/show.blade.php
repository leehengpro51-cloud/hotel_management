@extends('layouts.app')

@section('title', 'Category - ' . $roomType->type_name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Top bar -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('room-types.index') }}" class="text-decoration-none">Room Categories</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $roomType->type_name }}</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0 text-dark font-luxury">{{ $roomType->type_name }}</h3>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('room-types.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <a href="{{ route('room-types.edit', $roomType->type_id) }}" class="btn btn-navy">
                    <i class="bi bi-pencil-square text-warning"></i> Edit Category
                </a>
                <a href="{{ route('rooms.create', ['type_id' => $roomType->type_id]) }}" class="btn btn-gold">
                    <i class="bi bi-plus-lg"></i> Add Room to Category
                </a>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card card-hotel mb-4">
            <div class="card-body p-4 p-md-5">
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded-3 text-center border">
                            <div class="text-muted small">BASE RATE</div>
                            <div class="fs-3 fw-bold text-success">${{ number_format($roomType->base_price, 2) }}</div>
                            <div class="text-muted small">per night</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded-3 text-center border">
                            <div class="text-muted small">MAX OCCUPANCY</div>
                            <div class="fs-3 fw-bold text-dark">{{ $roomType->capacity }}</div>
                            <div class="text-muted small">Guests</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded-3 text-center border">
                            <div class="text-muted small">ASSIGNED ROOMS</div>
                            <div class="fs-3 fw-bold text-primary">{{ $roomType->rooms->count() }}</div>
                            <div class="text-muted small">Units</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded-3 text-center border">
                            <div class="text-muted small">MANAGER IN-CHARGE</div>
                            <div class="fs-6 fw-bold text-dark text-truncate">{{ $roomType->manager_id ?: 'General Office' }}</div>
                            <div class="text-muted small">{{ $roomType->location_id ?: 'All Towers' }}</div>
                        </div>
                    </div>
                </div>

                @if($roomType->description)
                <div class="mt-4 pt-3 border-top">
                    <h6 class="fw-bold text-dark">Category Overview & Features:</h6>
                    <p class="text-secondary mb-0">{{ $roomType->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Rooms Belonging to this category (Relational Table) -->
        <div class="card card-hotel">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-door-open text-warning me-1"></i> Rooms In This Category (Relational HasMany)
                </h5>
                <a href="{{ route('rooms.create', ['type_id' => $roomType->type_id]) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus-lg"></i> Add New Room
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hotel align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Room ID</th>
                            <th>Room Number</th>
                            <th>Floor</th>
                            <th>Bed Type</th>
                            <th>Current Rate</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roomType->rooms as $r)
                        <tr>
                            <td class="fw-bold text-muted">#{{ $r->room_id }}</td>
                            <td class="fw-bold text-dark">Room {{ $r->room_number }}</td>
                            <td>{{ $r->floor }}</td>
                            <td>{{ $r->bed_type }}</td>
                            <td class="fw-bold text-success">${{ number_format($r->price_per_night, 2) }}</td>
                            <td>
                                @if($r->status == 'Available')
                                    <span class="badge badge-available rounded-pill px-2.5 py-1">Available</span>
                                @elseif($r->status == 'Occupied')
                                    <span class="badge badge-occupied rounded-pill px-2.5 py-1">Occupied</span>
                                @elseif($r->status == 'Reserved')
                                    <span class="badge badge-reserved rounded-pill px-2.5 py-1">Reserved</span>
                                @else
                                    <span class="badge badge-maintenance rounded-pill px-2.5 py-1">Maintenance</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('rooms.show', $r->room_id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('rooms.edit', $r->room_id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                No rooms currently assigned to this category.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
