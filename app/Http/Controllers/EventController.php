<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    /**
     * List all events with pagination.
     */
    public function index() {
        $query = Event::query();

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Filter by country
        if ($request->has('country')) {
            $query->where('country', $request->country);
        }

        // Filter by available capacity
        if ($request->has('has_capacity')) {
            $query->whereRaw('(SELECT COUNT(*) FROM bookings WHERE bookings.event_id = events.id) < capacity');
        }

        return response()->json($query->paginate(10));

        //return response()->json(Event::paginate(10));
    }
    
    /**
     * Show a single event by ID.
     */
    public function show($id) {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }


    /**
     * Update an existing event.
     */
    public function update(Request $request, $id) {
        $event = Event::findOrFail($id);

        if ($event->created_by !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'sometimes|required|date|after:today',
            'capacity' => 'sometimes|required|integer|min:1',
            'country' => 'sometimes|required|string|max:100',
        ]);
        $event->update($validated);

        return response()->json(['message' => 'Event updated successfully', 'event' => $event], 200);
    }


    /**
     * Delete an event.
     */
    public function destroy($id) {
        $event = Event::findOrFail($id);

        if ($event->created_by !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully'], 200);
    }


    public function store(Request $request) {
        try {
       
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date' => 'required|date|after:today',
                'capacity' => 'required|integer|min:1',
                'country' => 'required|string|max:100',
            ]);
            $validated['created_by'] = Auth::id();
            $event = Event::create($validated);
            return response()->json(['message' => 'Event created successfully', 'event' => $event], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create event'], 500);
        }


    }

}
