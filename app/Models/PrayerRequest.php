<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrayerRequest extends Model
{
    protected $fillable = [
        'title',
        'description',
        'prayer_request',
        'requester_name',
        'requester_email',
        'type',
        'is_anonymous',
        'is_urgent',
        'is_answered',
        'answer_testimony',
        'is_active',
        'status',
        'user_id',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_urgent' => 'boolean',
        'is_answered' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user who created this prayer request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for active prayer requests.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for urgent prayer requests.
     */
    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    /**
     * Scope for answered prayer requests.
     */
    public function scopeAnswered($query)
    {
        return $query->where('is_answered', true);
    }

    /**
     * Scope for public prayer requests (not anonymous).
     */
    public function scopePublic($query)
    {
        return $query->where('is_anonymous', false);
    }

    /**
     * Scope for pending prayer requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved prayer requests.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for denied prayer requests.
     */
    public function scopeDenied($query)
    {
        return $query->where('status', 'denied');
    }
}
