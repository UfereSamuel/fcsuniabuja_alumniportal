<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'zone_id',
        'amount',
        'category',
        'payment_reference',
        'paystack_reference',
        'status',
        'paystack_response',
        'description',
        'payment_method',
        'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paystack_response' => 'array',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the user who made the payment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the zone this payment belongs to
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Generate unique payment reference
     */
    public static function generateReference(): string
    {
        return 'FCS_' . strtoupper(uniqid()) . '_' . time();
    }

    /**
     * Mark payment as successful
     */
    public function markAsSuccessful(array $paystackResponse = []): void
    {
        $this->update([
            'status' => 'successful',
            'paystack_response' => $paystackResponse,
            'paid_at' => now(),
        ]);
    }

    /**
     * Mark payment as failed
     */
    public function markAsFailed(array $paystackResponse = []): void
    {
        $this->update([
            'status' => 'failed',
            'paystack_response' => $paystackResponse,
        ]);
    }

    /**
     * Check if payment is successful
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'successful';
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute(): string
    {
        return '₦' . number_format($this->amount, 2);
    }

    /**
     * Scope for successful payments
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'successful');
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for membership payments
     */
    public function scopeMembership($query)
    {
        return $query->where('category', 'membership');
    }

    /**
     * Scope for event payments
     */
    public function scopeEvent($query)
    {
        return $query->where('category', 'event');
    }

    /**
     * Scope for donations
     */
    public function scopeDonation($query)
    {
        return $query->where('category', 'donation');
    }
}
