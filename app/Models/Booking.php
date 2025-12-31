<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'bookable_type', 'bookable_id', 'booking_code',
        'participant_name', 'institution', 'experience_level',
        'payment_method', 'payment_status', 'status',
        'event_date', 'reminder_sent_at', 'reminder_enabled'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'reminder_sent_at' => 'datetime',
        'reminder_enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookable()
    {
        return $this->morphTo();
    }
}
