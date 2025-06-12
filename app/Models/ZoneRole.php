<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ZoneRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'permissions',
        'is_national',
        'is_zonal',
        'is_active',
        'priority'
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_national' => 'boolean',
        'is_zonal' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get all users with this role
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        if (!$this->permissions) {
            return false;
        }

        return in_array($permission, $this->permissions);
    }

    /**
     * Get all available permissions
     */
    public static function getAllPermissions(): array
    {
        return [
            'create_events',
            'edit_events',
            'delete_events',
            'manage_zone_members',
            'view_zone_payments',
            'manage_zone_settings',
            'create_national_events',
            'manage_all_zones',
            'manage_system_settings',
            'view_all_payments',
            'manage_users',
            'manage_roles',
        ];
    }

    /**
     * Get national roles
     */
    public function scopeNational($query)
    {
        return $query->where('is_national', true);
    }

    /**
     * Get zonal roles
     */
    public function scopeZonal($query)
    {
        return $query->where('is_zonal', true);
    }

    /**
     * Get active roles
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Order by priority
     */
    public function scopeOrderByPriority($query)
    {
        return $query->orderBy('priority', 'desc');
    }
}
