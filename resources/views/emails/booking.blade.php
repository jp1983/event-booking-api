<h1>Booking Confirmation</h1>
<p>Dear Attendee,</p>
<p>Thank you for booking the event "<strong>{{ $booking->event->title }}</strong>".</p>
<p>Event Date: {{ $booking->event->date }}</p>
<p>Location: {{ $booking->event->country }}</p>
<p>See you at the event!</p>