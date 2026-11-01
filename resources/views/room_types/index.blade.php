@extends('layouts.app')

@section('title', 'Room Categories')

@section('content')
<div class="card card-hotel text-white mb-4 overflow-hidden border-0" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 70%, #152B44 100%);">
    <div class="p-4 p-md-5 text-center">
        <div class="d-inline-flex p-3 rounded-circle bg-warning bg-opacity-20 mb-3 border border-warning border-opacity-40">
            <i class="bi bi-grid-1x2-fill fs-2 text-warning"></i>
        </div>
        <h2 class="fw-bold mb-1 font-luxury">Room Categories & Types</h2>
        <p class="text-light opacity-75 mb-0">Parent relational table managing hotel room classifications, base pricing, and wing allocations</p>
    </div>
</div>

<!-- Search & Actions -->
<div class="card card-hotel mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-md-center">
            <form action="{{ route('room-types.index') }}" method="GET" class="flex-grow-1" style="max-width: 480px;">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" 
                           value="{{ request('search') }}" 
                           placeholder="Search category name, manager, location...">
                    <button type="submit" class="btn btn-navy">Search</button>
                    @if(request('search'))
                        <a href="{{ route('room-types.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x"></i></a>
                    @endif
                </div>
            </form>

            <a href="{{ route('room-types.create') }}" class="btn btn-gold px-3.5 py-2 rounded-pill d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Add New Category
            </a>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card card-hotel mb-4">
    <div class="table-responsive">
        <table class="table table-hotel align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>Category Name</th>
                    <th>Manager In-Charge</th>
                    <th>Hotel Location / Wing</th>
                    <th>Base Price</th>
                    <th>Capacity</th>
                    <th>Rooms Count</th>
                    <th class="text-end" style="min-width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roomTypes as $type)
                <tr>
                    <td class="fw-bold text-muted">#{{ $type->type_id }}</td>
                    <td>
                        <a href="{{ route('room-types.show', $type->type_id) }}" class="fw-bold text-dark text-decoration-none">
                            {{ $type->type_name }}
                        </a>
                        @if($type->description)
                            <div class="text-muted small text-truncate" style="max-width: 250px;">
                                {{ $type->description }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="small text-secondary fw-semibold">
                            <i class="bi bi-person-badge text-primary me-1"></i> {{ $type->manager_id ?: 'Unassigned' }}
                        </span>
                    </td>
                    <td>
                        <span class="small text-secondary">
                            <i class="bi bi-geo-alt text-danger me-1"></i> {{ $type->location_id ?: 'All Towers' }}
                        </span>
                    </td>
                    <td>
                        <span class="fw-bold text-success fs-6">${{ number_format($type->base_price, 2) }}</span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-people-fill text-muted me-1"></i> {{ $type->capacity }} Guests
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5 py-1 fw-bold">
                            {{ $type->rooms_count }} Rooms
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('room-types.show', $type->type_id) }}" class="btn btn-sm btn-outline-info" title="View Rooms">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('room-types.edit', $type->type_id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteTypeModal{{ $type->type_id }}" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteTypeModal{{ $type->type_id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-danger text-white">
                                        <h6 class="modal-title fw-bold">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Delete Room Category
                                        </h6>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start p-4">
                                        <p class="mb-2">Are you sure you want to delete <strong>{{ $type->type_name }}</strong>?</p>
                                        <p class="text-danger small mb-0">
                                            <strong>Warning:</strong> Deleting this category will cascade and remove all <strong>{{ $type->rooms_count }}</strong> rooms assigned to it!
                                        </p>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('room-types.destroy', $type->type_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Delete Category
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
                    <td colspan="8" class="text-center py-5 text-muted">
                        No room categories found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-white p-3 border-top d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Total {{ $roomTypes->total() }} Categories
        </div>
        <div>
            {{ $roomTypes->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
