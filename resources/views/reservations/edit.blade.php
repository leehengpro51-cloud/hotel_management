@extends('layouts.app')

@section('title', 'Edit Reservation #' . $reservation->booking_id)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}" class="text-decoration-none">Bookings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit #{{ $reservation->booking_id }}</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0 text-dark font-luxury">Update Booking #{{ $reservation->booking_id }}</h3>
            </div>
            <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Bookings
            </a>
        </div>

        <div class="card card-hotel shadow-sm overflow-hidden mb-5">
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 60%, #152B44 100%); border-bottom: 2px solid #D4AF37;">
                <div class="d-inline-flex p-3 rounded-circle bg-warning bg-opacity-20 mb-2 border border-warning border-opacity-40">
                    <i class="bi bi-pencil-square fs-2 text-warning"></i>
                </div>
                <h4 class="fw-bold mb-1">Modify Reservation</h4>
                <p class="mb-0 text-light small opacity-75">Update guest stay dates, allocated room, or check-in status</p>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('reservations.update', $reservation->booking_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- SECTION 1: Guest Personal Info -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <i class="bi bi-person-circle text-primary"></i>
                        <h6 class="fw-bold text-dark mb-0">Guest Details</h6>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-5">
                            <label for="guest_name" class="form-label fw-semibold small text-secondary">
                                Guest Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="guest_name" id="guest_name" 
                                   class="form-control @error('guest_name') is-invalid @enderror" 
                                   value="{{ old('guest_name', $reservation->guest_name) }}" required>
                            @error('guest_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="guest_email" class="form-label fw-semibold small text-secondary">
                                Email Address <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="guest_email" id="guest_email" 
                                   class="form-control @error('guest_email') is-invalid @enderror" 
                                   value="{{ old('guest_email', $reservation->guest_email) }}" required>
                            @error('guest_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="gender" class="form-label fw-semibold small text-secondary">
                                Gender <span class="text-danger">*</span>
                            </label>
                            <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="Male" {{ old('gender', $reservation->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $reservation->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender', $reservation->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="guest_phone" class="form-label fw-semibold small text-secondary">
                                Contact Telephone <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="guest_phone" id="guest_phone" 
                                   class="form-control @error('guest_phone') is-invalid @enderror" 
                                   value="{{ old('guest_phone', $reservation->guest_phone) }}" required>
                            @error('guest_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="room_id" class="form-label fw-semibold small text-secondary">
                                Assigned Room <span class="text-danger">*</span>
                            </label>
                            <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                                @foreach($rooms as $r)
                                    <option value="{{ $r->room_id }}" {{ old('room_id', $reservation->room_id) == $r->room_id ? 'selected' : '' }}>
                                        Room {{ $r->room_number }} ({{ $r->roomType->type_name ?? 'Standard' }} - ${{ number_format($r->price_per_night, 2) }}/night)
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SECTION 2: Dates & Status -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <i class="bi bi-calendar3 text-warning"></i>
                        <h6 class="fw-bold text-dark mb-0">Stay Itinerary & Status</h6>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="check_in_date" class="form-label fw-semibold small text-secondary">
                                Check-In Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="check_in_date" id="check_in_date" 
                                   class="form-control @error('check_in_date') is-invalid @enderror" 
                                   value="{{ old('check_in_date', $reservation->check_in_date->format('Y-m-d')) }}" required>
                            @error('check_in_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="check_out_date" class="form-label fw-semibold small text-secondary">
                                Check-Out Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="check_out_date" id="check_out_date" 
                                   class="form-control @error('check_out_date') is-invalid @enderror" 
                                   value="{{ old('check_out_date', $reservation->check_out_date->format('Y-m-d')) }}" required>
                            @error('check_out_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="status" class="form-label fw-semibold small text-secondary">
                                Reservation Status <span class="text-danger">*</span>
                            </label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Confirmed" {{ old('status', $reservation->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="Checked In" {{ old('status', $reservation->status) == 'Checked In' ? 'selected' : '' }}>Checked In</option>
                                <option value="Checked Out" {{ old('status', $reservation->status) == 'Checked Out' ? 'selected' : '' }}>Checked Out</option>
                                <option value="Cancelled" {{ old('status', $reservation->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SECTION 3: Special Requests -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <i class="bi bi-chat-square-quote text-secondary"></i>
                        <h6 class="fw-bold text-dark mb-0">Special Requests / Concierge Notes</h6>
                    </div>

                    <div class="mb-4">
                        <textarea name="special_requests" id="special_requests" rows="3" 
                                  class="form-control @error('special_requests') is-invalid @enderror">{{ old('special_requests', $reservation->special_requests) }}</textarea>
                        @error('special_requests')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-navy px-4 py-2.5 fw-semibold d-flex align-items-center gap-2">
                            <i class="bi bi-check2-circle text-warning"></i> Update Reservation
                        </button>
                        <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary px-4 py-2.5">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
