<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{   

    /**
     * List bookings for an event.
     */
    public function index($event_id) {
        $bookings = Booking::where('event_id', $event_id)->with('attendee')->paginate(10);
        return response()->json($bookings);
    }

    /**
     * Book an attendee for an event.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'attendee_id' => 'required|exists:attendees,id',
        ]);

        $event = Event::findOrFail($validated['event_id']);

        // Check if event capacity allows more attendees
        if (!$event->hasCapacity()) {
            return response()->json(['error' => 'Event is fully booked'], 400);
        }

        // Prevent duplicate bookings
        $alreadyBooked = Booking::where('event_id', $validated['event_id'])
                                ->where('attendee_id', $validated['attendee_id'])
                                ->exists();

        if ($alreadyBooked) {
            return response()->json(['error' => 'Attendee has already booked this event'], 400);
        }

        $booking = Booking::create($validated);


        // Generate PDF Ticket
        $pdf = $this->generatePDF($booking);

        // Send confirmation email
        $this->sendBookingEmail($booking, $pdf);


        return response()->json(['message' => 'Booking successful', 'booking' => $booking, 'ticket' => url('/tickets/'.$booking->id.'.pdf')], 201);
    }

    /**
     * Cancel a booking.
     */
    public function destroy($id) {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return response()->json(['message' => 'Booking canceled successfully'], 200);
    }

    private function sendBookingEmail($booking, $pdf) {
        Mail::to($booking->attendee->email)->send(new BookingMail($booking, $pdf));
    }

    private function generatePDF($booking) {
        $pdf = PDF::loadView('pdf.ticket', ['booking' => $booking]);

        // Define the ticket path
        $path = public_path('tickets/'.$booking->id.'.pdf');
        
        // Save the PDF file
        $pdf->save($path);

        return $path;
    }



}
