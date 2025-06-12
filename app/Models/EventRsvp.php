<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRsvp extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'guests_count',
        'notes',
    ];

    protected $casts = [
        'guests_count' => 'integer',
    ];

    /**
     * Get the event this RSVP belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the user who made this RSVP.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for attending RSVPs.
     */
    public function scopeAttending($query)
    {
        return $query->where('status', 'attending');
    }
}
