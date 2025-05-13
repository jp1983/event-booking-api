<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $fillable = ['name', 'email', 'phone'];

    /**
     * Get all bookings by this attendee.
     */
    public function bookings() {
        return $this->hasMany(Booking::class);
    }

}
