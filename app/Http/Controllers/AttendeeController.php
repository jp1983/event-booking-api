<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{   

    /**
     * List all attendees with pagination.
     */
    public function index() {
        return response()->json(Attendee::paginate(10));
    }

    /**
     * Show details of a specific attendee.
     */
    public function show($id) {
        $attendee = Attendee::findOrFail($id);
        return response()->json($attendee);
    }

    /**
     * Register a new attendee.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:attendees,email',
            'phone' => 'nullable|string|max:15',
        ]);

        $attendee = Attendee::create($validated);
        return response()->json(['message' => 'Attendee registered successfully', 'attendee' => $attendee], 201);
    }    

    /**
     * Update attendee information.
     */
    public function update(Request $request, $id) {
        $attendee = Attendee::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:attendees,email,' . $id,
            'phone' => 'nullable|string|max:15',
        ]);

        $attendee->update($validated);
        return response()->json(['message' => 'Attendee updated successfully', 'attendee' => $attendee], 200);
    }

    /**
     * Delete an attendee.
     */
    public function destroy($id) {
        $attendee = Attendee::findOrFail($id);
        $attendee->delete();
        return response()->json(['message' => 'Attendee deleted successfully'], 200);
    }


}
