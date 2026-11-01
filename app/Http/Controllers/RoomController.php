<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of rooms with multi-parameter search and filters.
     */
    public function index(Request $request)
    {
        $query = Room::with('roomType');

        // Search by room number, description, or bed type
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('bed_type', 'like', "%{$search}%")
                  ->orWhereHas('roomType', function ($t) use ($search) {
                      $t->where('type_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Room Type (type_id)
        if ($request->filled('type_id')) {
            $query->where('type_id', $request->input('type_id'));
        }

        // Filter by Status (Available, Occupied, Reserved, Maintenance)
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by Floor
        if ($request->filled('floor')) {
            $query->where('floor', $request->input('floor'));
        }

        // Sorting
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'room_asc':
                $query->orderBy('room_number', 'asc');
                break;
            case 'price_asc':
                $query->orderBy('price_per_night', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_night', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('room_id', 'desc');
                break;
        }

        $rooms = $query->paginate(10)->withQueryString();

        // Data for dropdown filters and stats cards
        $roomTypes = RoomType::orderBy('type_name', 'asc')->get();
        $floors = Room::select('floor')->distinct()->orderBy('floor', 'asc')->pluck('floor');

        $totalRooms = Room::count();
        $availableCount = Room::where('status', 'Available')->count();
        $occupiedCount = Room::where('status', 'Occupied')->count();
        $avgPrice = Room::avg('price_per_night') ?? 0;

        return view('rooms.index', compact(
            'rooms',
            'roomTypes',
            'floors',
            'totalRooms',
            'availableCount',
            'occupiedCount',
            'avgPrice'
        ));
    }

    /**
     * Show the form for creating a new room.
     */
    public function create()
    {
        $roomTypes = RoomType::orderBy('type_name', 'asc')->get();
        $floors = ['Ground Floor', 'Floor 1', 'Floor 2', 'Floor 3', 'Floor 4', 'Floor 5', 'Floor 6', 'Penthouse'];
        $bedTypes = ['1 Single Bed', '1 Queen Bed', '1 King Bed', '1 California King', '2 Twin Beds', '2 Queen Beds', '1 King + 2 Bunk Beds'];

        return view('rooms.create', compact('roomTypes', 'floors', 'bedTypes'));
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => ['required', 'string', 'max:50', 'unique:rooms,room_number'],
            'type_id' => ['required', 'exists:room_types,type_id'],
            'floor' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'in:Available,Occupied,Reserved,Maintenance'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'bed_type' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $room = Room::create($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Room #' . $room->room_number . ' has been registered successfully!');
    }

    /**
     * Display the specified room.
     */
    public function show(Room $room)
    {
        $room->load(['roomType', 'reservations' => function ($q) {
            $q->orderBy('check_in_date', 'desc');
        }]);

        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Room $room)
    {
        $roomTypes = RoomType::orderBy('type_name', 'asc')->get();
        $floors = ['Ground Floor', 'Floor 1', 'Floor 2', 'Floor 3', 'Floor 4', 'Floor 5', 'Floor 6', 'Penthouse'];
        $bedTypes = ['1 Single Bed', '1 Queen Bed', '1 King Bed', '1 California King', '2 Twin Beds', '2 Queen Beds', '1 King + 2 Bunk Beds'];

        return view('rooms.edit', compact('room', 'roomTypes', 'floors', 'bedTypes'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => ['required', 'string', 'max:50', 'unique:rooms,room_number,' . $room->room_id . ',room_id'],
            'type_id' => ['required', 'exists:room_types,type_id'],
            'floor' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'in:Available,Occupied,Reserved,Maintenance'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'bed_type' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Room #' . $room->room_number . ' details updated successfully!');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Room $room)
    {
        $roomNumber = $room->room_number;
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Room #' . $roomNumber . ' has been deleted from hotel records.');
    }
}
