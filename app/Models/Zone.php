<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'country',
        'state',
        'city',
        'contact_person',
        'contact_phone',
        'contact_email',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all users in this zone
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all events in this zone
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get all payments in this zone
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the zone coordinator
     */
    public function coordinator()
    {
        return $this->users()->whereHas('zoneRole', function ($query) {
            $query->where('name', 'Coordinator');
        })->first();
    }

    /**
     * Get all zone executives (coordinators, deputy, secretary, treasurer)
     */
    public function executives()
    {
        return $this->users()->whereHas('zoneRole', function ($query) {
            $query->whereIn('name', ['Coordinator', 'Deputy Coordinator', 'Secretary', 'Treasurer']);
        });
    }

    /**
     * Get zone members count
     */
    public function getMembersCountAttribute()
    {
        return $this->users()->count();
    }

    /**
     * Get zone events count
     */
    public function getEventsCountAttribute()
    {
        return $this->events()->count();
    }

    /**
     * Get zone payment stats
     */
    public function getPaymentStatsAttribute()
    {
        return [
            'total_amount' => $this->payments()->where('status', 'successful')->sum('amount'),
            'payment_count' => $this->payments()->where('status', 'successful')->count(),
            'pending_payments' => $this->payments()->where('status', 'pending')->count(),
        ];
    }

    /**
     * Scope for active zones
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
