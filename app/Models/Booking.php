<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['event_id', 'attendee_id'];

    /**
     * Relationship: A booking belongs to an event.
     */
    public function event() {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relationship: A booking belongs to an attendee.
     */
    public function attendee() {
        return $this->belongsTo(Attendee::class);
    }

}
