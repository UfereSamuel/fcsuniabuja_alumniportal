<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'title',
        'description',
        'filename',
        'original_filename',
        'file_path',
        'file_type',
        'file_size',
        'category',
        'access_level',
        'requires_approval',
        'is_approved',
        'download_count',
        'is_active',
        'is_public',
        'uploaded_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'requires_approval' => 'boolean',
        'is_approved' => 'boolean',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'approved_at' => 'datetime',
        'file_size' => 'integer',
        'download_count' => 'integer',
    ];

    /**
     * Get the user who uploaded this document.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the user who approved this document.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope for approved documents.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for pending approval documents.
     */
    public function scopePending($query)
    {
        return $query->where('requires_approval', true)->where('is_approved', false);
    }

    /**
     * Scope for active documents.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for public documents.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}
