<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'type',
        'priority',
        'user_id',
        'zone_id',
        'icon',
        'color',
        'data',
        'action_url',
        'is_read',
        'email_sent',
        'read_at',
        'email_sent_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'email_sent' => 'boolean',
        'read_at' => 'datetime',
        'email_sent_at' => 'datetime',
    ];

    /**
     * Get the user who receives this notification
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the zone this notification is related to
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for read notifications
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope for specific type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for specific priority
     */
    public function scopeOfPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope for zone-related notifications
     */
    public function scopeForZone($query, int $zoneId)
    {
        return $query->where('zone_id', $zoneId);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Mark email as sent
     */
    public function markEmailAsSent(): void
    {
        $this->update([
            'email_sent' => true,
            'email_sent_at' => now(),
        ]);
    }

    /**
     * Get formatted time ago
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get notification icon with default fallbacks
     */
    public function getNotificationIconAttribute(): string
    {
        $icons = [
            'payment' => 'fas fa-credit-card',
            'zone_update' => 'fas fa-globe-africa',
            'event' => 'fas fa-calendar-alt',
            'system' => 'fas fa-cog',
            'user_action' => 'fas fa-user',
        ];

        return $icons[$this->type] ?? $this->icon ?? 'fas fa-bell';
    }

    /**
     * Get notification color with default fallbacks
     */
    public function getNotificationColorAttribute(): string
    {
        $colors = [
            'payment' => 'green',
            'zone_update' => 'blue',
            'event' => 'purple',
            'system' => 'gray',
            'user_action' => 'yellow',
        ];

        return $colors[$this->type] ?? $this->color ?? 'blue';
    }

    /**
     * Get priority badge class
     */
    public function getPriorityBadgeAttribute(): string
    {
        $badges = [
            'low' => 'bg-gray-100 text-gray-800',
            'normal' => 'bg-blue-100 text-blue-800',
            'high' => 'bg-yellow-100 text-yellow-800',
            'urgent' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->priority] ?? 'bg-blue-100 text-blue-800';
    }

    /**
     * Static method to create notifications easily
     */
    public static function createNotification(
        int $userId,
        string $title,
        string $message,
        string $type = 'system',
        string $priority = 'normal',
        ?int $zoneId = null,
        ?string $actionUrl = null,
        ?array $data = null
    ): self {
        return self::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'priority' => $priority,
            'zone_id' => $zoneId,
            'action_url' => $actionUrl,
            'data' => $data,
        ]);
    }

    /**
     * Create payment notification
     */
    public static function createPaymentNotification(
        int $userId,
        string $status,
        float $amount,
        string $category,
        ?int $zoneId = null,
        ?string $paymentReference = null
    ): self {
        $statusMessages = [
            'successful' => [
                'title' => 'Payment Successful',
                'message' => "Your {$category} payment of ₦" . number_format($amount, 2) . " has been successfully processed.",
                'priority' => 'normal',
                'color' => 'green',
            ],
            'failed' => [
                'title' => 'Payment Failed',
                'message' => "Your {$category} payment of ₦" . number_format($amount, 2) . " could not be processed. Please try again.",
                'priority' => 'high',
                'color' => 'red',
            ],
            'pending' => [
                'title' => 'Payment Pending',
                'message' => "Your {$category} payment of ₦" . number_format($amount, 2) . " is being processed.",
                'priority' => 'normal',
                'color' => 'yellow',
            ],
        ];

        $config = $statusMessages[$status] ?? $statusMessages['pending'];

        return self::create([
            'user_id' => $userId,
            'title' => $config['title'],
            'message' => $config['message'],
            'type' => 'payment',
            'priority' => $config['priority'],
            'zone_id' => $zoneId,
            'color' => $config['color'],
            'icon' => 'fas fa-credit-card',
            'action_url' => route('payments.history'),
            'data' => [
                'payment_status' => $status,
                'amount' => $amount,
                'category' => $category,
                'payment_reference' => $paymentReference,
            ],
        ]);
    }

    /**
     * Create zone update notification
     */
    public static function createZoneUpdateNotification(
        int $userId,
        string $updateType,
        string $details,
        int $zoneId,
        ?string $actionUrl = null
    ): self {
        $updateMessages = [
            'member_joined' => 'A new member has joined your zone',
            'member_left' => 'A member has left your zone',
            'event_created' => 'A new event has been created in your zone',
            'role_changed' => 'Your zone role has been updated',
            'zone_updated' => 'Your zone information has been updated',
        ];

        $title = $updateMessages[$updateType] ?? 'Zone Update';

        return self::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $details,
            'type' => 'zone_update',
            'priority' => 'normal',
            'zone_id' => $zoneId,
            'color' => 'blue',
            'icon' => 'fas fa-globe-africa',
            'action_url' => $actionUrl,
            'data' => [
                'update_type' => $updateType,
            ],
        ]);
    }
}
