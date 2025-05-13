<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Ticket</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .ticket { border: 2px solid black; padding: 20px; width: 400px; margin: auto; }
        h1 { color: #007bff; }
        .qr-code { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="ticket">
        <h1>Event Ticket</h1>
        <p><strong>Event:</strong> {{ $booking->event->title }}</p>
        <p><strong>Date:</strong> {{ $booking->event->date }}</p>
        <p><strong>Location:</strong> {{ $booking->event->country }}</p>
        <p><strong>Attendee:</strong> {{ $booking->attendee->name }}</p>
        <p><strong>Email:</strong> {{ $booking->attendee->email }}</p>
        <div class="qr-code">
            <img src="{{ 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . url('/verify-ticket/' . $booking->id) }}" />
        </div>
    </div>
</body>
</html>