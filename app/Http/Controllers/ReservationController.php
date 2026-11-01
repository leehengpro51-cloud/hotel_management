<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of guest bookings with search and filters.
     */
    public function index(Request $request)
    {
        $query = Reservation::with('room.roomType');

        // Search by guest name, email, or phone
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhere('guest_email', 'like', "%{$search}%")
                  ->orWhere('guest_phone', 'like', "%{$search}%")
                  ->orWhereHas('room', function ($r) use ($search) {
                      $r->where('room_number', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by Gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        $reservations = $query->orderBy('booking_id', 'desc')->paginate(10)->withQueryString();

        $totalReservations = Reservation::count();
        $checkedInCount = Reservation::where('status', 'Checked In')->count();
        $confirmedCount = Reservation::where('status', 'Confirmed')->count();

        return view('reservations.index', compact(
            'reservations',
            'totalReservations',
            'checkedInCount',
            'confirmedCount'
        ));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create()
    {
        $rooms = Room::with('roomType')->orderBy('room_number', 'asc')->get();

        return view('reservations.create', compact('rooms'));
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,room_id'],
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_email' => ['required', 'email', 'max:255'],
            'guest_phone' => ['required', 'string', 'max:50'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'check_in_date' => ['required', 'date'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'status' => ['required', 'string', 'in:Confirmed,Checked In,Checked Out,Cancelled'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
        ]);

        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $totalNights = max(1, $checkIn->diffInDays($checkOut));

        $room = Room::findOrFail($validated['room_id']);
        $totalAmount = $totalNights * (float)$room->price_per_night;

        $reservation = Reservation::create(array_merge($validated, [
            'total_nights' => $totalNights,
            'total_amount' => $totalAmount,
        ]));

        // If guest checked in, mark room as Occupied
        if ($validated['status'] === 'Checked In') {
            $room->update(['status' => 'Occupied']);
        } elseif ($validated['status'] === 'Confirmed' && $room->status === 'Available') {
            $room->update(['status' => 'Reserved']);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation #' . $reservation->booking_id . ' for ' . $reservation->guest_name . ' has been booked successfully!');
    }

    /**
     * Display the specified reservation voucher.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load('room.roomType');

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified reservation.
     */
    public function edit(Reservation $reservation)
    {
        $rooms = Room::with('roomType')->orderBy('room_number', 'asc')->get();

        return view('reservations.edit', compact('reservation', 'rooms'));
    }

    /**
     * Update the specified reservation in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,room_id'],
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_email' => ['required', 'email', 'max:255'],
            'guest_phone' => ['required', 'string', 'max:50'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'check_in_date' => ['required', 'date'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'status' => ['required', 'string', 'in:Confirmed,Checked In,Checked Out,Cancelled'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
        ]);

        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $totalNights = max(1, $checkIn->diffInDays($checkOut));

        $room = Room::findOrFail($validated['room_id']);
        $totalAmount = $totalNights * (float)$room->price_per_night;

        $reservation->update(array_merge($validated, [
            'total_nights' => $totalNights,
            'total_amount' => $totalAmount,
        ]));

        if ($validated['status'] === 'Checked In') {
            $room->update(['status' => 'Occupied']);
        } elseif ($validated['status'] === 'Checked Out' || $validated['status'] === 'Cancelled') {
            $room->update(['status' => 'Available']);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation #' . $reservation->booking_id . ' has been updated successfully!');
    }

    /**
     * Remove the specified reservation from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $id = $reservation->booking_id;
        $guest = $reservation->guest_name;

        // If room was occupied by this reservation, free it
        if ($reservation->room && $reservation->status === 'Checked In') {
            $reservation->room->update(['status' => 'Available']);
        }

        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation #' . $id . ' (' . $guest . ') has been deleted successfully.');
    }
}
