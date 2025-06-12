<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'profile_image',
        'role',
        'gender',
        'bio',
        'occupation',
        'location',
        'class_id',
        'zone_id',
        'zone_role_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'last_login_at' => 'datetime',
            'zone_joined_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the zone that the user belongs to.
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Get the zone role of the user.
     */
    public function zoneRole(): BelongsTo
    {
        return $this->belongsTo(ZoneRole::class);
    }

    /**
     * Get the payments made by the user.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the notifications for the user.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the class that the user belongs to.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    /**
     * Get the activities created by the user.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'created_by');
    }

    /**
     * Get the prayer requests created by the user.
     */
    public function prayerRequests(): HasMany
    {
        return $this->hasMany(PrayerRequest::class, 'user_id');
    }

    /**
     * Get the events created by the user.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    /**
     * Get the documents uploaded by the user.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    /**
     * Get the event RSVPs for the user.
     */
    public function eventRsvps(): HasMany
    {
        return $this->hasMany(EventRsvp::class, 'user_id');
    }

    /**
     * Get the executives created by the user.
     */
    public function executives(): HasMany
    {
        return $this->hasMany(Executive::class, 'created_by');
    }

    /**
     * Get the board members created by the user.
     */
    public function boardMembers(): HasMany
    {
        return $this->hasMany(BoardMember::class, 'created_by');
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is class coordinator.
     */
    public function isClassCoordinator(): bool
    {
        return $this->role === 'class_coordinator';
    }

    /**
     * Check if user is deputy coordinator.
     */
    public function isDeputyCoordinator(): bool
    {
        return $this->role === 'deputy_coordinator';
    }

    /**
     * Check if user can manage class.
     */
    public function canManageClass(): bool
    {
        return $this->isAdmin() || $this->isClassCoordinator() || $this->isDeputyCoordinator();
    }

    /**
     * Check if user is in a zone.
     */
    public function hasZone(): bool
    {
        return !is_null($this->zone_id);
    }

    /**
     * Check if user has a zone role.
     */
    public function hasZoneRole(): bool
    {
        return !is_null($this->zone_role_id);
    }

    /**
     * Check if user is a zone coordinator.
     */
    public function isZoneCoordinator(): bool
    {
        return $this->zoneRole && $this->zoneRole->name === 'Coordinator';
    }

    /**
     * Check if user is a national executive.
     */
    public function isNationalExecutive(): bool
    {
        return $this->zoneRole && $this->zoneRole->is_national;
    }

    /**
     * Check if user is a zonal executive.
     */
    public function isZonalExecutive(): bool
    {
        return $this->zoneRole && $this->zoneRole->is_zonal &&
               in_array($this->zoneRole->name, ['Coordinator', 'Deputy Coordinator', 'Secretary', 'Treasurer']);
    }

    /**
     * Check if user has a specific zone permission.
     */
    public function hasZonePermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->zoneRole && $this->zoneRole->hasPermission($permission);
    }

    /**
     * Check if user can manage their zone.
     */
    public function canManageZone(): bool
    {
        return $this->isAdmin() || $this->isNationalExecutive() || $this->isZonalExecutive();
    }

    /**
     * Check if user can create events.
     */
    public function canCreateEvents(): bool
    {
        return $this->hasZonePermission('create_events');
    }

    /**
     * Check if user can view zone payments.
     */
    public function canViewZonePayments(): bool
    {
        return $this->hasZonePermission('view_zone_payments') || $this->hasZonePermission('view_all_payments');
    }

    /**
     * Get user's full zone role name.
     */
    public function getZoneRoleNameAttribute(): ?string
    {
        if (!$this->zoneRole) {
            return null;
        }

        if ($this->zoneRole->is_national) {
            return 'National ' . $this->zoneRole->name;
        }

        return $this->zone ? $this->zone->name . ' ' . $this->zoneRole->name : $this->zoneRole->name;
    }
}
