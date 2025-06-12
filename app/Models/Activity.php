<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'activity_date',
        'activity_time',
        'location',
        'type',
        'class_id',
        'is_featured',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'activity_time' => 'datetime:H:i',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user who created this activity.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the class this activity belongs to.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    /**
     * Scope for active activities.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured activities.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for upcoming activities.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('activity_date', '>=', now()->toDateString());
    }

    /**
     * Scope for recent activities.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('activity_date', '>=', now()->subDays($days));
    }
}
