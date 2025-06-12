<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'start_date',
        'end_date',
        'location',
        'venue_address',
        'type',
        'is_free',
        'ticket_price',
        'max_attendees',
        'requires_rsvp',
        'requirements',
        'zone_id',
        'visibility',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_free' => 'boolean',
        'requires_rsvp' => 'boolean',
        'is_active' => 'boolean',
        'ticket_price' => 'decimal:2',
        'max_attendees' => 'integer',
    ];

    /**
     * Get the zone this event belongs to.
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Get the user who created this event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all RSVPs for this event.
     */
    public function rsvps(): HasMany
    {
        return $this->hasMany(EventRsvp::class);
    }

    /**
     * Scope for active events.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now());
    }

    /**
     * Scope for national events (visible to everyone).
     */
    public function scopeNational($query)
    {
        return $query->where('visibility', 'national');
    }

    /**
     * Scope for zone public events.
     */
    public function scopeZonePublic($query)
    {
        return $query->where('visibility', 'zone_public');
    }

    /**
     * Scope for zone private events.
     */
    public function scopeZonePrivate($query)
    {
        return $query->where('visibility', 'zone_private');
    }

    /**
     * Scope for events visible to a specific user.
     */
    public function scopeVisibleToUser($query, User $user)
    {
        // Admin and National Executives see everything
        if ($user->isAdmin() || $user->isNationalExecutive()) {
            return $query;
        }

        // Class Coordinators see their class events regardless of zone
        if ($user->isClassCoordinator()) {
            return $query->where(function ($q) use ($user) {
                $q->where('visibility', 'national')
                  ->orWhere('visibility', 'zone_public')
                  ->orWhere(function ($zq) use ($user) {
                      $zq->where('visibility', 'zone_private')
                         ->where('zone_id', $user->zone_id);
                  });
            });
        }

        // Regular users see national, zone public, and their zone private events
        return $query->where(function ($q) use ($user) {
            $q->where('visibility', 'national')
              ->orWhere('visibility', 'zone_public')
              ->orWhere(function ($zq) use ($user) {
                  $zq->where('visibility', 'zone_private')
                     ->where('zone_id', $user->zone_id);
              });
        });
    }

    /**
     * Check if event is visible to user.
     */
    public function isVisibleToUser(User $user): bool
    {
        // Admin and National Executives see everything
        if ($user->isAdmin() || $user->isNationalExecutive()) {
            return true;
        }

        // National events are visible to everyone
        if ($this->visibility === 'national') {
            return true;
        }

        // Zone public events are visible to everyone
        if ($this->visibility === 'zone_public') {
            return true;
        }

        // Zone private events are only visible to zone members
        if ($this->visibility === 'zone_private') {
            return $this->zone_id === $user->zone_id;
        }

        return false;
    }

    /**
     * Get event visibility label.
     */
    public function getVisibilityLabelAttribute(): string
    {
        return match($this->visibility) {
            'national' => 'National Event',
            'zone_public' => 'Zone Public Event',
            'zone_private' => 'Zone Private Event',
            default => 'Unknown'
        };
    }
}
