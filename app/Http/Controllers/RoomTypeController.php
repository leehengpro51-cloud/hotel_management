<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of room types with search and room counts.
     */
    public function index(Request $request)
    {
        $query = RoomType::withCount('rooms');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('type_name', 'like', "%{$search}%")
                  ->orWhere('manager_id', 'like', "%{$search}%")
                  ->orWhere('location_id', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $roomTypes = $query->orderBy('type_id', 'asc')->paginate(10)->withQueryString();

        return view('room_types.index', compact('roomTypes'));
    }

    /**
     * Show the form for creating a new room type.
     */
    public function create()
    {
        return view('room_types.create');
    }

    /**
     * Store a newly created room type in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_name' => ['required', 'string', 'max:255', 'unique:room_types,type_name'],
            'manager_id' => ['nullable', 'string', 'max:150'],
            'location_id' => ['nullable', 'string', 'max:150'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1', 'max:20'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $roomType = RoomType::create($validated);

        return redirect()->route('room-types.index')
            ->with('success', 'Room category "' . $roomType->type_name . '" has been created successfully!');
    }

    /**
     * Display the specified room type.
     */
    public function show(RoomType $roomType)
    {
        $roomType->load(['rooms' => function ($q) {
            $q->orderBy('room_number', 'asc');
        }]);

        return view('room_types.show', compact('roomType'));
    }

    /**
     * Show the form for editing the specified room type.
     */
    public function edit(RoomType $roomType)
    {
        return view('room_types.edit', compact('roomType'));
    }

    /**
     * Update the specified room type in storage.
     */
    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'type_name' => ['required', 'string', 'max:255', 'unique:room_types,type_name,' . $roomType->type_id . ',type_id'],
            'manager_id' => ['nullable', 'string', 'max:150'],
            'location_id' => ['nullable', 'string', 'max:150'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1', 'max:20'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $roomType->update($validated);

        return redirect()->route('room-types.index')
            ->with('success', 'Room category "' . $roomType->type_name . '" has been updated successfully!');
    }

    /**
     * Remove the specified room type from storage.
     */
    public function destroy(RoomType $roomType)
    {
        $name = $roomType->type_name;
        $roomCount = $roomType->rooms()->count();

        $roomType->delete();

        return redirect()->route('room-types.index')
            ->with('success', 'Room category "' . $name . '" (' . $roomCount . ' rooms removed) has been deleted successfully!');
    }
}
