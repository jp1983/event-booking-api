<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

    protected $fillable = ['title', 'description', 'date', 'capacity', 'country', 'created_by'];

    /**
     * Get the user who created the event.
     */
    public function organizer() {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all bookings for this event.
     */
    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if an event has available slots.
     */
    public function hasCapacity() {
        return $this->bookings()->count() < $this->capacity;
    }


}