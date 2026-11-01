@extends('layouts.app')

@section('title', 'Room Directory')

@section('content')
<!-- Directory Header & Stats Banner (Slide 7 Style) -->
<div class="card card-hotel text-white mb-4 overflow-hidden border-0" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 70%, #152B44 100%);">
    <div class="p-4 p-md-5 text-center">
        <div class="d-inline-flex p-3 rounded-circle bg-warning bg-opacity-20 mb-3 border border-warning border-opacity-40">
            <i class="bi bi-door-closed-fill fs-2 text-warning"></i>
        </div>
        <h2 class="fw-bold mb-1 font-luxury">Room Directory</h2>
        <p class="text-light opacity-75 mb-4">Browse and manage all registered hotel rooms, suites, and classifications</p>

        <!-- Stats Badges -->
        <div class="row justify-content-center g-3">
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-15">
                    <div class="display-6 fw-bold text-white">{{ $totalRooms }}</div>
                    <div class="small brand-gold fw-semibold text-uppercase tracking-wider">Total Rooms</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-15">
                    <div class="display-6 fw-bold text-success">{{ $availableCount }}</div>
                    <div class="small brand-gold fw-semibold text-uppercase tracking-wider">Available</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="display-6 fw-bold text-danger p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-15">
                    <div>{{ $occupiedCount }}</div>
                    <div class="small brand-gold fw-semibold text-uppercase tracking-wider">Occupied</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-15">
                    <div class="display-6 fw-bold text-white">${{ number_format($avgPrice, 0) }}</div>
                    <div class="small brand-gold fw-semibold text-uppercase tracking-wider">Avg. Nightly Rate</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search & Multi-Filter Form -->
<div class="card card-hotel mb-4">
    <div class="card-body p-4">
        <form action="{{ route('rooms.index') }}" method="GET">
            <div class="row g-3">
                <!-- Search Keyword -->
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" 
                               value="{{ request('search') }}" 
                               placeholder="Search room #, description, bed type...">
                    </div>
                </div>

                <!-- Filter by Room Type -->
                <div class="col-sm-6 col-lg-2">
                    <select name="type_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->type_id }}" {{ request('type_id') == $type->type_id ? 'selected' : '' }}>
                                {{ $type->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by Status -->
                <div class="col-sm-6 col-lg-2">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Occupied" {{ request('status') == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="Reserved" {{ request('status') == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                        <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>

                <!-- Filter by Floor -->
                <div class="col-sm-6 col-lg-2">
                    <select name="floor" class="form-select">
                        <option value="">All Floors</option>
                        @foreach($floors as $fl)
                            <option value="{{ $fl }}" {{ request('floor') == $fl ? 'selected' : '' }}>
                                {{ $fl }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter & Reset Buttons -->
                <div class="col-sm-6 col-lg-2 d-flex gap-2">
                    <button type="submit" class="btn btn-navy flex-grow-1">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'type_id', 'status', 'floor', 'sort']))
                        <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary" title="Reset Filters">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Table Card -->
<div class="card card-hotel mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="fw-bold text-dark">
            Showing <span class="text-primary">{{ $rooms->firstItem() ?? 0 }}</span> - <span class="text-primary">{{ $rooms->lastItem() ?? 0 }}</span> of <span class="text-primary">{{ $rooms->total() }}</span> rooms
        </div>
        <a href="{{ route('rooms.create') }}" class="btn btn-gold btn-sm px-3 rounded-pill d-flex align-items-center gap-1.5">
            <i class="bi bi-plus-lg"></i> Add New Room
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hotel align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>Room Number</th>
                    <th>Category (Relational)</th>
                    <th>Floor & Bedding</th>
                    <th>Nightly Rate</th>
                    <th>Status</th>
                    <th class="text-end" style="min-width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                <tr>
                    <td class="fw-bold text-muted">#{{ $room->room_id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="p-2 rounded bg-light border text-dark fw-bold" style="min-width: 52px; text-align: center;">
                                {{ $room->room_number }}
                            </div>
                            <div>
                                <a href="{{ route('rooms.show', $room->room_id) }}" class="fw-bold text-dark text-decoration-none">
                                    Room {{ $room->room_number }}
                                </a>
                                @if($room->description)
                                    <div class="text-muted small text-truncate" style="max-width: 220px;">
                                        {{ $room->description }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($room->roomType)
                            <a href="{{ route('room-types.show', $room->roomType->type_id) }}" class="badge rounded-pill text-decoration-none px-3 py-1.5" style="background-color: var(--brand-gold-soft); color: #8A6805; border: 1px solid rgba(212, 175, 55, 0.4);">
                                <i class="bi bi-tag-fill me-1"></i> {{ $room->roomType->type_name }}
                            </a>
                        @else
                            <span class="text-muted small">None</span>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold small text-dark"><i class="bi bi-layers me-1 text-secondary"></i> {{ $room->floor }}</div>
                        <div class="text-muted small"><i class="bi bi-moon-stars me-1"></i> {{ $room->bed_type }}</div>
                    </td>
                    <td>
                        <div class="fw-bold text-dark fs-6">${{ number_format($room->price_per_night, 2) }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">per night</div>
                    </td>
                    <td>
                        @if($room->status == 'Available')
                            <span class="badge badge-available rounded-pill px-3 py-1.5">
                                <i class="bi bi-check-circle me-1"></i> Available
                            </span>
                        @elseif($room->status == 'Occupied')
                            <span class="badge badge-occupied rounded-pill px-3 py-1.5">
                                <i class="bi bi-person-fill-lock me-1"></i> Occupied
                            </span>
                        @elseif($room->status == 'Reserved')
                            <span class="badge badge-reserved rounded-pill px-3 py-1.5">
                                <i class="bi bi-bookmark-fill me-1"></i> Reserved
                            </span>
                        @else
                            <span class="badge badge-maintenance rounded-pill px-3 py-1.5">
                                <i class="bi bi-tools me-1"></i> Maintenance
                            </span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('rooms.show', $room->room_id) }}" class="btn btn-sm btn-outline-info" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('rooms.edit', $room->room_id) }}" class="btn btn-sm btn-outline-primary" title="Edit Room">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $room->room_id }}" title="Delete Room">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal{{ $room->room_id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-danger text-white">
                                        <h6 class="modal-title fw-bold">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Room Deletion
                                        </h6>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start p-4">
                                        <p class="mb-2">Are you sure you want to delete <strong>Room #{{ $room->room_number }}</strong>?</p>
                                        <p class="text-muted small mb-0">This room will be permanently removed from hotel records and all associated bookings.</p>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('rooms.destroy', $room->room_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Delete Room
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
                        <h6 class="fw-bold text-dark">No rooms found matching your criteria</h6>
                        <p class="text-muted small mb-3">Try adjusting your search terms or clearing active filters.</p>
                        <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-outline-secondary">Reset Filters</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination & Bottom Action Bar -->
    <div class="card-footer bg-white p-3 border-top d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div class="text-muted small">
            Showing {{ $rooms->firstItem() ?? 0 }} to {{ $rooms->lastItem() ?? 0 }} of {{ $rooms->total() }} entries
        </div>
        <div>
            {{ $rooms->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Back to Registration Button (Matching Slide 7 Footer) -->
<div class="text-center mb-4">
    <a href="{{ route('rooms.create') }}" class="btn btn-navy px-4 py-2.5 rounded-pill shadow-sm">
        <i class="bi bi-person-plus-fill me-1 text-warning"></i> + Back to Room Form
    </a>
</div>
@endsection
