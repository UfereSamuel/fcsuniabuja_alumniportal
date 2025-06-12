<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppGroup extends Model
{
    protected $fillable = [
        'name',
        'description',
        'invite_link',
        'type',
        'zone_id',
        'class_id',
        'member_count',
        'is_active',
        'is_public',
        'rules',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'member_count' => 'integer',
    ];

    /**
     * Get the user who created this group.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the zone this group belongs to.
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Get the class this group belongs to.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    /**
     * Scope for active groups.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for public groups.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for groups by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for zone groups.
     */
    public function scopeZoneGroups($query, $zoneId = null)
    {
        $query = $query->where('type', 'zone');
        if ($zoneId) {
            $query->where('zone_id', $zoneId);
        }
        return $query;
    }

    /**
     * Scope for class groups.
     */
    public function scopeClassGroups($query, $classId = null)
    {
        $query = $query->where('type', 'class');
        if ($classId) {
            $query->where('class_id', $classId);
        }
        return $query;
    }

    /**
     * Get the type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'general' => 'General Group',
            'zone' => 'Zone Group',
            'class' => 'Class Group',
            'executive' => 'Executive Group',
            'special' => 'Special Group',
            default => 'Unknown'
        };
    }

    /**
     * Get the formatted invite link.
     */
    public function getFormattedInviteLinkAttribute(): string
    {
        if (str_starts_with($this->invite_link, 'https://')) {
            return $this->invite_link;
        }
        return 'https://chat.whatsapp.com/' . $this->invite_link;
    }
}
