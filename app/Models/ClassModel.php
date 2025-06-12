<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'graduation_year',
        'slogan',
        'description',
        'coordinator_id',
        'deputy_coordinator_id',
        'whatsapp_link',
        'class_image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the members of this class.
     */
    public function members(): HasMany
    {
        return $this->hasMany(User::class, 'class_id');
    }

    /**
     * Get the coordinator of this class.
     */
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    /**
     * Get the deputy coordinator of this class.
     */
    public function deputyCoordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deputy_coordinator_id');
    }

    /**
     * Get the activities specific to this class.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'class_id');
    }

    /**
     * Get the class name with year and slogan.
     */
    public function getFullNameAttribute(): string
    {
        return $this->slogan
            ? "Class {$this->graduation_year} ({$this->slogan})"
            : "Class {$this->graduation_year}";
    }

    /**
     * Get the class name (alias for full_name for compatibility).
     */
    public function getNameAttribute(): string
    {
        return $this->full_name;
    }
}
