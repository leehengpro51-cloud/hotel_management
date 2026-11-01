@extends('layouts.app')

@section('title', 'Guest Bookings')

@section('content')
<div class="card card-hotel text-white mb-4 overflow-hidden border-0" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 70%, #152B44 100%);">
    <div class="p-4 p-md-5 text-center">
        <div class="d-inline-flex p-3 rounded-circle bg-warning bg-opacity-20 mb-3 border border-warning border-opacity-40">
            <i class="bi bi-calendar-check-fill fs-2 text-warning"></i>
        </div>
        <h2 class="fw-bold mb-1 font-luxury">Guest Bookings & Stays</h2>
        <p class="text-light opacity-75 mb-4">Manage guest itineraries, check-in registrations, dates, and stay invoicing</p>

        <!-- Stats Badges -->
        <div class="row justify-content-center g-3">
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-15">
                    <div class="display-6 fw-bold text-white">{{ $totalReservations }}</div>
                    <div class="small brand-gold fw-semibold text-uppercase tracking-wider">Total Bookings</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-15">
                    <div class="display-6 fw-bold text-danger">{{ $checkedInCount }}</div>
                    <div class="small brand-gold fw-semibold text-uppercase tracking-wider">Checked In</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-15">
                    <div class="display-6 fw-bold text-warning">{{ $confirmedCount }}</div>
                    <div class="small brand-gold fw-semibold text-uppercase tracking-wider">Upcoming</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter Card -->
<div class="card card-hotel mb-4">
    <div class="card-body p-4">
        <form action="{{ route('reservations.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-lg-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" 
                               value="{{ request('search') }}" 
                               placeholder="Search guest name, email, phone, room #...">
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Checked In" {{ request('status') == 'Checked In' ? 'selected' : '' }}>Checked In</option>
                        <option value="Checked Out" {{ request('status') == 'Checked Out' ? 'selected' : '' }}>Checked Out</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <select name="gender" class="form-select">
                        <option value="">All Genders</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-lg-2 d-flex gap-2">
                    <button type="submit" class="btn btn-navy flex-grow-1">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'gender']))
                        <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">
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
            Showing <span class="text-primary">{{ $reservations->firstItem() ?? 0 }}</span> - <span class="text-primary">{{ $reservations->lastItem() ?? 0 }}</span> of <span class="text-primary">{{ $reservations->total() }}</span> reservations
        </div>
        <a href="{{ route('reservations.create') }}" class="btn btn-gold btn-sm px-3 rounded-pill d-flex align-items-center gap-1.5">
            <i class="bi bi-calendar-plus"></i> New Reservation
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hotel align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>Guest Information</th>
                    <th>Assigned Room</th>
                    <th>Stay Dates</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="text-end" style="min-width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                <tr>
                    <td class="fw-bold text-muted">#{{ $res->booking_id }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $res->guest_name }}</div>
                        <div class="text-muted small">
                            <i class="bi bi-envelope"></i> {{ $res->guest_email }} &bull; <i class="bi bi-telephone"></i> {{ $res->guest_phone }}
                        </div>
                    </td>
                    <td>
                        @if($res->room)
                            <a href="{{ route('rooms.show', $res->room->room_id) }}" class="badge bg-light text-dark border text-decoration-none">
                                <i class="bi bi-door-closed me-1"></i> Room {{ $res->room->room_number }}
                            </a>
                            <div class="text-muted small" style="font-size: 0.75rem;">
                                {{ $res->room->roomType->type_name ?? '' }}
                            </div>
                        @else
                            <span class="text-muted">Unassigned</span>
                        @endif
                    </td>
                    <td>
                        <div class="small fw-semibold text-dark">
                            {{ \Carbon\Carbon::parse($res->check_in_date)->format('M d, Y') }} &rarr; {{ \Carbon\Carbon::parse($res->check_out_date)->format('M d, Y') }}
                        </div>
                        <div class="text-muted small" style="font-size: 0.75rem;">
                            {{ $res->total_nights }} Night(s) Stay
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold text-success fs-6">${{ number_format($res->total_amount, 2) }}</div>
                    </td>
                    <td>
                        @if($res->status == 'Checked In')
                            <span class="badge badge-occupied rounded-pill px-2.5 py-1">Checked In</span>
                        @elseif($res->status == 'Confirmed')
                            <span class="badge badge-reserved rounded-pill px-2.5 py-1">Confirmed</span>
                        @elseif($res->status == 'Checked Out')
                            <span class="badge badge-available rounded-pill px-2.5 py-1">Checked Out</span>
                        @else
                            <span class="badge badge-maintenance rounded-pill px-2.5 py-1">{{ $res->status }}</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('reservations.show', $res->booking_id) }}" class="btn btn-sm btn-outline-info" title="View Voucher">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('reservations.edit', $res->booking_id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delBookingModal{{ $res->booking_id }}" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="delBookingModal{{ $res->booking_id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-danger text-white">
                                        <h6 class="modal-title fw-bold">Cancel / Delete Reservation</h6>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start p-4">
                                        <p class="mb-0">Are you sure you want to cancel and delete the reservation for <strong>{{ $res->guest_name }}</strong> (Booking #{{ $res->booking_id }})?</p>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <form action="{{ route('reservations.destroy', $res->booking_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        No guest bookings found matching the filters.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-white p-3 border-top d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Total {{ $reservations->total() }} bookings recorded
        </div>
        <div>
            {{ $reservations->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
