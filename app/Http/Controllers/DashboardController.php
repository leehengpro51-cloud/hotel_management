<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the hotel executive dashboard.
     */
    public function index()
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'Available')->count();
        $occupiedRooms = Room::where('status', 'Occupied')->count();
        $maintenanceRooms = Room::where('status', 'Maintenance')->count();
        $reservedRooms = Room::where('status', 'Reserved')->count();

        $totalRoomTypes = RoomType::count();
        $totalBookings = Reservation::count();
        $checkedInGuests = Reservation::where('status', 'Checked In')->count();
        $totalRevenue = Reservation::whereIn('status', ['Confirmed', 'Checked In', 'Checked Out'])->sum('total_amount');

        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0;

        $recentBookings = Reservation::with('room.roomType')
            ->orderBy('booking_id', 'desc')
            ->take(6)
            ->get();

        $roomTypesWithCount = RoomType::withCount('rooms')->get();

        return view('dashboard', compact(
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'reservedRooms',
            'totalRoomTypes',
            'totalBookings',
            'checkedInGuests',
            'totalRevenue',
            'occupancyRate',
            'recentBookings',
            'roomTypesWithCount'
        ));
    }
}
