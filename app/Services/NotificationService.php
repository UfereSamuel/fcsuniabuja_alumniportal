<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Zone;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\NotificationMail;

class NotificationService
{
    /**
     * Send a notification to a user
     */
    public function sendNotification(
        int $userId,
        string $title,
        string $message,
        string $type = 'system',
        string $priority = 'normal',
        ?int $zoneId = null,
        ?string $actionUrl = null,
        ?array $data = null,
        bool $sendEmail = false
    ): Notification {
        $notification = Notification::createNotification(
            $userId,
            $title,
            $message,
            $type,
            $priority,
            $zoneId,
            $actionUrl,
            $data
        );

        if ($sendEmail) {
            $this->sendEmailNotification($notification);
        }

        return $notification;
    }

    /**
     * Send payment notification
     */
    public function sendPaymentNotification(Payment $payment, bool $sendEmail = true): Notification
    {
        $notification = Notification::createPaymentNotification(
            $payment->user_id,
            $payment->status,
            $payment->amount,
            $payment->category,
            $payment->zone_id,
            $payment->payment_reference
        );

        if ($sendEmail) {
            $this->sendEmailNotification($notification);
        }

        return $notification;
    }

    /**
     * Send zone update notification
     */
    public function sendZoneUpdateNotification(
        int $userId,
        string $updateType,
        string $details,
        int $zoneId,
        ?string $actionUrl = null,
        bool $sendEmail = false
    ): Notification {
        $notification = Notification::createZoneUpdateNotification(
            $userId,
            $updateType,
            $details,
            $zoneId,
            $actionUrl
        );

        if ($sendEmail) {
            $this->sendEmailNotification($notification);
        }

        return $notification;
    }

    /**
     * Send bulk notification to multiple users
     */
    public function sendBulkNotification(
        array $userIds,
        string $title,
        string $message,
        string $type = 'system',
        string $priority = 'normal',
        ?int $zoneId = null,
        ?string $actionUrl = null,
        ?array $data = null,
        bool $sendEmail = false
    ): array {
        $notifications = [];

        foreach ($userIds as $userId) {
            $notifications[] = $this->sendNotification(
                $userId,
                $title,
                $message,
                $type,
                $priority,
                $zoneId,
                $actionUrl,
                $data,
                $sendEmail
            );
        }

        return $notifications;
    }

    /**
     * Send notification to all zone members
     */
    public function sendZoneNotification(
        int $zoneId,
        string $title,
        string $message,
        string $type = 'zone_update',
        string $priority = 'normal',
        ?string $actionUrl = null,
        ?array $data = null,
        bool $sendEmail = false,
        array $excludeUserIds = []
    ): array {
        $zone = Zone::findOrFail($zoneId);
        $userIds = $zone->users()
            ->whereNotIn('id', $excludeUserIds)
            ->pluck('id')
            ->toArray();

        return $this->sendBulkNotification(
            $userIds,
            $title,
            $message,
            $type,
            $priority,
            $zoneId,
            $actionUrl,
            $data,
            $sendEmail
        );
    }

    /**
     * Send notification to zone executives
     */
    public function sendZoneExecutiveNotification(
        int $zoneId,
        string $title,
        string $message,
        string $type = 'zone_update',
        string $priority = 'normal',
        ?string $actionUrl = null,
        ?array $data = null,
        bool $sendEmail = true
    ): array {
        $zone = Zone::findOrFail($zoneId);
        $executiveIds = $zone->executives()->pluck('id')->toArray();

        return $this->sendBulkNotification(
            $executiveIds,
            $title,
            $message,
            $type,
            $priority,
            $zoneId,
            $actionUrl,
            $data,
            $sendEmail
        );
    }

    /**
     * Send email notification
     */
    public function sendEmailNotification(Notification $notification): bool
    {
        try {
            $user = $notification->user;

            if (!$user || !$user->email) {
                Log::warning('Cannot send email notification: User not found or no email', [
                    'notification_id' => $notification->id,
                    'user_id' => $notification->user_id
                ]);
                return false;
            }

            Mail::to($user->email)->send(new NotificationMail($notification));

            $notification->markEmailAsSent();

            Log::info('Email notification sent successfully', [
                'notification_id' => $notification->id,
                'user_email' => $user->email,
                'type' => $notification->type
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send email notification', [
                'notification_id' => $notification->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }

    /**
     * Get user notifications with pagination
     */
    public function getUserNotifications(int $userId, int $limit = 20, bool $unreadOnly = false)
    {
        $query = Notification::where('user_id', $userId);

        if ($unreadOnly) {
            $query->unread();
        }

        return $query->with(['zone'])
            ->latest()
            ->paginate($limit);
    }

    /**
     * Get unread notifications count for user
     */
    public function getUnreadCount(int $userId): int
    {
        return Notification::where('user_id', $userId)->unread()->count();
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $notificationId): bool
    {
        $notification = Notification::find($notificationId);

        if (!$notification) {
            return false;
        }

        $notification->markAsRead();
        return true;
    }

    /**
     * Mark all user notifications as read
     */
    public function markAllAsRead(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
    }

    /**
     * Delete old notifications (cleanup)
     */
    public function cleanupOldNotifications(int $daysOld = 90): int
    {
        return Notification::where('created_at', '<', now()->subDays($daysOld))
            ->delete();
    }

    /**
     * Get notification statistics
     */
    public function getNotificationStats(int $userId): array
    {
        $total = Notification::where('user_id', $userId)->count();
        $unread = $this->getUnreadCount($userId);
        $read = $total - $unread;

        $byType = Notification::where('user_id', $userId)
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        return [
            'total' => $total,
            'unread' => $unread,
            'read' => $read,
            'by_type' => $byType,
        ];
    }

    /**
     * Send welcome notification to new user
     */
    public function sendWelcomeNotification(User $user): Notification
    {
        $title = "Welcome to FCS Alumni Portal!";
        $message = "Welcome {$user->name}! Your account has been successfully created. You have been assigned to {$user->zone->name} zone.";

        return $this->sendNotification(
            $user->id,
            $title,
            $message,
            'system',
            'normal',
            $user->zone_id,
            route('dashboard'),
            ['welcome' => true],
            true
        );
    }

    /**
     * Send zone transfer notification
     */
    public function sendZoneTransferNotification(User $user, Zone $oldZone, Zone $newZone): array
    {
        $notifications = [];

        // Notify the user
        $notifications[] = $this->sendZoneUpdateNotification(
            $user->id,
            'zone_updated',
            "You have been transferred from {$oldZone->name} to {$newZone->name}.",
            $newZone->id,
            null,
            true
        );

        // Notify new zone executives
        $newZoneNotifications = $this->sendZoneExecutiveNotification(
            $newZone->id,
            'New Member Joined',
            "{$user->name} has joined {$newZone->name} zone.",
            'zone_update',
            'normal',
            route('admin.zones.show', $newZone->id)
        );

        return array_merge($notifications, $newZoneNotifications);
    }

    /**
     * Send event notification to zone members
     */
    public function sendEventNotification(
        $event,
        string $eventAction = 'created'
    ): array {
        $title = match($eventAction) {
            'created' => 'New Event Created',
            'updated' => 'Event Updated',
            'cancelled' => 'Event Cancelled',
            default => 'Event Notification'
        };

        $message = match($eventAction) {
            'created' => "A new event '{$event->title}' has been created in your zone.",
            'updated' => "The event '{$event->title}' has been updated.",
            'cancelled' => "The event '{$event->title}' has been cancelled.",
            default => "Event '{$event->title}' notification."
        };

        // Send to zone members for zone events
        if ($event->zone_id && in_array($event->visibility, ['zone_public', 'zone_private'])) {
            return $this->sendZoneNotification(
                $event->zone_id,
                $title,
                $message,
                'event',
                'normal',
                route('events.show', $event->id),
                ['event_id' => $event->id, 'action' => $eventAction],
                false, // Don't send email for event notifications by default
                [$event->created_by] // Exclude event creator
            );
        }

        return [];
    }
}
