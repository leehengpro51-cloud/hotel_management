@extends('layouts.app')

@section('title', 'Booking Voucher #' . $reservation->booking_id)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Action Buttons -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Bookings
            </a>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-outline-dark">
                    <i class="bi bi-printer me-1"></i> Print Voucher
                </button>
                <a href="{{ route('reservations.edit', $reservation->booking_id) }}" class="btn btn-navy">
                    <i class="bi bi-pencil-square text-warning me-1"></i> Edit
                </a>
            </div>
        </div>

        <!-- Voucher Card -->
        <div class="card card-hotel shadow border-0 overflow-hidden mb-5">
            <!-- Luxury Hotel Header -->
            <div class="p-4 p-md-5 text-white" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 60%, #152B44 100%); border-bottom: 3px solid #D4AF37;">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="hotel-logo-wrapper" style="padding: 2px;">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Angkor Hotel Logo" class="hotel-logo-img" style="width: 60px; height: 60px;">
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-white font-luxury">ANGKOR HOTEL</h3>
                            <div class="text-uppercase small tracking-wider brand-gold">Official Reservation Voucher</div>
                        </div>
                    </div>
                    <div class="text-md-end">
                        <div class="badge bg-white bg-opacity-15 border border-white border-opacity-25 px-3 py-2 fs-6">
                            Booking Reference: <strong>#AH-{{ str_pad($reservation->booking_id, 5, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                        <div class="small text-light opacity-75 mt-1">Issued: {{ $reservation->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <!-- Guest & Room details -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="text-muted small fw-bold text-uppercase mb-2">Guest Profile</div>
                        <h5 class="fw-bold text-dark mb-1">{{ $reservation->guest_name }}</h5>
                        <div class="text-secondary small mb-1"><i class="bi bi-envelope me-1"></i> {{ $reservation->guest_email }}</div>
                        <div class="text-secondary small mb-1"><i class="bi bi-telephone me-1"></i> {{ $reservation->guest_phone }}</div>
                        <div class="text-secondary small"><i class="bi bi-gender-ambiguous me-1"></i> Gender: {{ $reservation->gender }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small fw-bold text-uppercase mb-2">Room & Accommodation</div>
                        @if($reservation->room)
                            <h5 class="fw-bold text-dark mb-1">Room #{{ $reservation->room->room_number }}</h5>
                            <div class="text-secondary small mb-1">
                                <i class="bi bi-tag me-1"></i> Category: <strong>{{ $reservation->room->roomType->type_name ?? 'Standard' }}</strong>
                            </div>
                            <div class="text-secondary small mb-1">
                                <i class="bi bi-layers me-1"></i> Floor: {{ $reservation->room->floor }} &bull; {{ $reservation->room->bed_type }}
                            </div>
                            <div class="text-secondary small">
                                <i class="bi bi-geo-alt me-1"></i> {{ $reservation->room->roomType->location_id ?? 'Main Tower' }}
                            </div>
                        @else
                            <div class="text-muted">Unassigned Room</div>
                        @endif
                    </div>
                </div>

                <!-- Stay Details Box -->
                <div class="p-4 rounded-3 bg-light border mb-4">
                    <div class="row text-center g-3">
                        <div class="col-md-4">
                            <div class="text-muted small fw-bold">CHECK-IN</div>
                            <div class="fs-5 fw-bold text-dark">{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}</div>
                            <div class="text-muted small">From 2:00 PM</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small fw-bold">CHECK-OUT</div>
                            <div class="fs-5 fw-bold text-dark">{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}</div>
                            <div class="text-muted small">Until 12:00 PM</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small fw-bold">DURATION</div>
                            <div class="fs-5 fw-bold text-primary">{{ $reservation->total_nights }} Night(s)</div>
                            <div class="text-muted small">Status: <span class="badge bg-secondary">{{ $reservation->status }}</span></div>
                        </div>
                    </div>
                </div>

                <!-- Financial Breakdown -->
                <div class="table-responsive mb-4">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item Description</th>
                                <th class="text-center">Rate</th>
                                <th class="text-center">Nights</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark">
                                        Room {{ $reservation->room->room_number ?? '' }} ({{ $reservation->room->roomType->type_name ?? 'Room' }})
                                    </div>
                                    <div class="text-muted small">Nightly accommodation stay</div>
                                </td>
                                <td class="text-center">${{ number_format($reservation->room->price_per_night ?? 0, 2) }}</td>
                                <td class="text-center">{{ $reservation->total_nights }}</td>
                                <td class="text-end fw-bold">${{ number_format($reservation->total_amount, 2) }}</td>
                            </tr>
                            <tr class="table-light">
                                <td colspan="3" class="text-end fw-bold fs-6">Grand Total:</td>
                                <td class="text-end fw-extrabold text-success fs-5">${{ number_format($reservation->total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if($reservation->special_requests)
                <div class="p-3 rounded-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 mb-4">
                    <div class="fw-bold small text-dark mb-1">
                        <i class="bi bi-chat-quote-fill text-warning me-1"></i> Concierge & Special Guest Notes:
                    </div>
                    <div class="text-secondary small">{{ $reservation->special_requests }}</div>
                </div>
                @endif

                <div class="text-center text-muted small pt-3 border-top">
                    Thank you for choosing Angkor Hotel & Luxury Suites. For assistance, contact our 24/7 concierge at <a href="mailto:concierge@angkorhotel.com" class="text-decoration-none">concierge@angkorhotel.com</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
