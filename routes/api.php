<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::middleware('auth:api')->group(function () {
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
});
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);

/*

// Event API Call endpoints

1. Create an Event - Authenticated
curl -X POST http://localhost:8000/api/events \
     -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
     -d "title=Tech Conference&date=2025-06-20&capacity=200&country=India"

2. Get List of Events
curl -X GET http://localhost:8000/api/events
curl -X GET "http://localhost:8000/api/events?start_date=2025-06-01&end_date=2025-06-3

3. Get Event Details
curl -X GET http://localhost:8000/api/events/1

4. Update an Event - Authenticated
curl -X PUT http://localhost:8000/api/events/1 \
     -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
     -d "title=Updated Tech Conference&capacity=250"

5. Delete an Event - Authenticated
curl -X DELETE http://localhost:8000/api/events/1 \
     -H "Authorization: Bearer YOUR_ACCESS_TOKEN"

*/

Route::get('/attendees', [AttendeeController::class, 'index']);
Route::post('/attendees', [AttendeeController::class, 'store']);
Route::get('/attendees/{id}', [AttendeeController::class, 'show']);
Route::put('/attendees/{id}', [AttendeeController::class, 'update']);
Route::delete('/attendees/{id}', [AttendeeController::class, 'destroy']);

/*

// Attendee API Call endpoints
1. Register Attendee
curl -X POST http://localhost:8000/api/attendees \
     -d "name=Isha Patil&email=isha.patil@example.com&phone=9876543210"

2. Get Attendee List
curl -X GET http://localhost:8000/api/attendees

3. Update Attendee
curl -X PUT http://localhost:8000/api/attendees/1 \
     -d "name=Trisha Patil&email=trisha.patil@example.com"

4. Delete Attendee
curl -X DELETE http://localhost:8000/api/attendees/1

*/

Route::post('/bookings', [BookingController::class, 'store']);
Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
Route::get('/bookings/{event_id}', [BookingController::class, 'index']);

/*

// Booking API Call endpoints

1. Book an Attendee for an Event
curl -X POST http://localhost:8000/api/bookings \
     -d "event_id=1&attendee_id=2"

2. Get All Bookings for an Event
curl -X GET http://localhost:8000/api/bookings/1

3. Cancel a Booking
curl -X DELETE http://localhost:8000/api/bookings/5

*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

/*

// User API Call endpoints

1. Register a User
curl -X POST http://localhost:8000/api/register \
     -d "username=jagadish&email=jagadish@example.com&password=password123"

2. Login
curl -X POST http://localhost:8000/api/login \
     -d "email=jagadish@example.com&password=password123"

3. Logout - Authenticated
curl -X POST http://localhost/api/logout \
     -H "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI..."

*/

Route::get('/tickets/{id}.pdf', function ($id) {
    $path = public_path("tickets/$id.pdf");

    if (!file_exists($path)) {
        return response()->json(['error' => 'Ticket not found'], 404);
    }

    return response()->file($path);
});
