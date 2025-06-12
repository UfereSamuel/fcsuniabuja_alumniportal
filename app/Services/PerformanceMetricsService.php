<?php

namespace App\Services;

use App\Models\Zone;
use App\Models\User;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PerformanceMetricsService
{
    /**
     * Get overall system performance metrics
     */
    public function getSystemMetrics(int $period = 30): array
    {
        $startDate = now()->subDays($period);

        return [
            'user_metrics' => $this->getUserMetrics($startDate),
            'payment_metrics' => $this->getPaymentMetrics($startDate),
            'event_metrics' => $this->getEventMetrics($startDate),
            'notification_metrics' => $this->getNotificationMetrics($startDate),
            'period' => $period,
            'date_range' => [
                'from' => $startDate->format('Y-m-d'),
                'to' => now()->format('Y-m-d')
            ]
        ];
    }

    /**
     * Get zone performance metrics
     */
    public function getZoneMetrics(int $zoneId, int $period = 30): array
    {
        $zone = Zone::findOrFail($zoneId);
        $startDate = now()->subDays($period);

        return [
            'zone' => $zone,
            'member_metrics' => $this->getZoneMemberMetrics($zoneId, $startDate),
            'payment_metrics' => $this->getZonePaymentMetrics($zoneId, $startDate),
            'event_metrics' => $this->getZoneEventMetrics($zoneId, $startDate),
            'engagement_metrics' => $this->getZoneEngagementMetrics($zoneId, $startDate),
            'period' => $period,
            'date_range' => [
                'from' => $startDate->format('Y-m-d'),
                'to' => now()->format('Y-m-d')
            ]
        ];
    }

    /**
     * Get all zones performance summary
     */
    public function getAllZonesMetrics(int $period = 30): array
    {
        $startDate = now()->subDays($period);
        $zones = Zone::active()->with(['users', 'events', 'payments'])->get();

        $zoneMetrics = $zones->map(function($zone) use ($startDate) {
            return [
                'zone' => $zone,
                'members_count' => $zone->users()->count(),
                'new_members' => $zone->users()->where('zone_joined_at', '>=', $startDate)->count(),
                'total_payments' => $zone->payments()->where('status', 'successful')->sum('amount'),
                'payment_count' => $zone->payments()->where('status', 'successful')->count(),
                'events_count' => $zone->events()->where('created_at', '>=', $startDate)->count(),
                'notifications_sent' => Notification::where('zone_id', $zone->id)
                                                  ->where('created_at', '>=', $startDate)
                                                  ->count(),
            ];
        });

        return [
            'zones' => $zoneMetrics,
            'summary' => $this->calculateZonesSummary($zoneMetrics),
            'period' => $period
        ];
    }

    /**
     * Get user growth metrics
     */
    private function getUserMetrics(Carbon $startDate): array
    {
        return [
            'total_users' => User::count(),
            'new_users' => User::where('created_at', '>=', $startDate)->count(),
            'active_users' => User::where('is_active', true)->count(),
            'users_with_zones' => User::whereNotNull('zone_id')->count(),
            'users_without_zones' => User::whereNull('zone_id')->count(),
            'growth_trend' => $this->getUserGrowthTrend($startDate),
            'zone_distribution' => $this->getUserZoneDistribution(),
        ];
    }

    /**
     * Get payment performance metrics
     */
    private function getPaymentMetrics(Carbon $startDate): array
    {
        $payments = Payment::where('created_at', '>=', $startDate);

        return [
            'total_revenue' => Payment::where('status', 'successful')->sum('amount'),
            'period_revenue' => $payments->where('status', 'successful')->sum('amount'),
            'period_payments' => $payments->count(),
            'successful_payments' => $payments->where('status', 'successful')->count(),
            'failed_payments' => $payments->where('status', 'failed')->count(),
            'pending_payments' => $payments->where('status', 'pending')->count(),
            'success_rate' => $this->calculateSuccessRate($payments),
            'category_breakdown' => $this->getPaymentCategoryBreakdown($startDate),
            'daily_trends' => $this->getPaymentDailyTrends($startDate),
        ];
    }

    /**
     * Get event performance metrics
     */
    private function getEventMetrics(Carbon $startDate): array
    {
        $events = Event::where('created_at', '>=', $startDate);

        return [
            'total_events' => Event::count(),
            'period_events' => $events->count(),
            'upcoming_events' => Event::where('start_date', '>=', now())->count(),
            'national_events' => $events->where('visibility', 'national')->count(),
            'zone_events' => $events->whereIn('visibility', ['zone_public', 'zone_private'])->count(),
            'events_by_zone' => $this->getEventsByZone($startDate),
            'events_by_type' => $this->getEventsByType($startDate),
        ];
    }

    /**
     * Get notification metrics
     */
    private function getNotificationMetrics(Carbon $startDate): array
    {
        $notifications = Notification::where('created_at', '>=', $startDate);

        return [
            'total_notifications' => Notification::count(),
            'period_notifications' => $notifications->count(),
            'unread_notifications' => Notification::unread()->count(),
            'emails_sent' => $notifications->where('email_sent', true)->count(),
            'notifications_by_type' => $this->getNotificationsByType($startDate),
            'notifications_by_priority' => $this->getNotificationsByPriority($startDate),
        ];
    }

    /**
     * Get zone member metrics
     */
    private function getZoneMemberMetrics(int $zoneId, Carbon $startDate): array
    {
        $zone = Zone::find($zoneId);

        return [
            'total_members' => $zone->users()->count(),
            'new_members' => $zone->users()->where('zone_joined_at', '>=', $startDate)->count(),
            'executives_count' => $zone->executives()->count(),
            'member_growth' => $this->getZoneMemberGrowth($zoneId, $startDate),
            'role_distribution' => $this->getZoneRoleDistribution($zoneId),
        ];
    }

    /**
     * Get zone payment metrics
     */
    private function getZonePaymentMetrics(int $zoneId, Carbon $startDate): array
    {
        $payments = Payment::where('zone_id', $zoneId);
        $periodPayments = $payments->where('created_at', '>=', $startDate);

        return [
            'total_revenue' => $payments->where('status', 'successful')->sum('amount'),
            'period_revenue' => $periodPayments->where('status', 'successful')->sum('amount'),
            'period_payments' => $periodPayments->count(),
            'success_rate' => $this->calculateSuccessRate($periodPayments),
            'category_breakdown' => $this->getZonePaymentCategoryBreakdown($zoneId, $startDate),
            'average_payment' => $this->getAveragePaymentAmount($zoneId, $startDate),
        ];
    }

    /**
     * Get zone event metrics
     */
    private function getZoneEventMetrics(int $zoneId, Carbon $startDate): array
    {
        $events = Event::where('zone_id', $zoneId);
        $periodEvents = $events->where('created_at', '>=', $startDate);

        return [
            'total_events' => $events->count(),
            'period_events' => $periodEvents->count(),
            'upcoming_events' => $events->where('start_date', '>=', now())->count(),
            'public_events' => $periodEvents->where('visibility', 'zone_public')->count(),
            'private_events' => $periodEvents->where('visibility', 'zone_private')->count(),
            'events_by_type' => $this->getZoneEventsByType($zoneId, $startDate),
        ];
    }

    /**
     * Get zone engagement metrics
     */
    private function getZoneEngagementMetrics(int $zoneId, Carbon $startDate): array
    {
        return [
            'notifications_received' => Notification::where('zone_id', $zoneId)
                                                  ->where('created_at', '>=', $startDate)
                                                  ->count(),
            'notification_read_rate' => $this->getZoneNotificationReadRate($zoneId, $startDate),
            'payment_participation' => $this->getZonePaymentParticipation($zoneId, $startDate),
            'event_creation_rate' => $this->getZoneEventCreationRate($zoneId, $startDate),
        ];
    }

    /**
     * Helper methods for calculations
     */
    private function getUserGrowthTrend(Carbon $startDate): array
    {
        return User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                   ->where('created_at', '>=', $startDate)
                   ->groupBy('date')
                   ->orderBy('date')
                   ->get()
                   ->toArray();
    }

    private function getUserZoneDistribution(): array
    {
        return Zone::withCount('users')
                   ->orderBy('users_count', 'desc')
                   ->get()
                   ->map(function($zone) {
                       return [
                           'zone' => $zone->name,
                           'count' => $zone->users_count
                       ];
                   })
                   ->toArray();
    }

    private function calculateSuccessRate($paymentsQuery): float
    {
        $total = $paymentsQuery->count();
        if ($total === 0) return 0;

        $successful = $paymentsQuery->where('status', 'successful')->count();
        return round(($successful / $total) * 100, 2);
    }

    private function getPaymentCategoryBreakdown(Carbon $startDate): array
    {
        return Payment::selectRaw('category, COUNT(*) as count, SUM(amount) as total')
                      ->where('created_at', '>=', $startDate)
                      ->where('status', 'successful')
                      ->groupBy('category')
                      ->get()
                      ->toArray();
    }

    private function getPaymentDailyTrends(Carbon $startDate): array
    {
        return Payment::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(amount) as total')
                      ->where('created_at', '>=', $startDate)
                      ->where('status', 'successful')
                      ->groupBy('date')
                      ->orderBy('date')
                      ->get()
                      ->toArray();
    }

    private function getEventsByZone(Carbon $startDate): array
    {
        return Event::with('zone')
                    ->selectRaw('zone_id, COUNT(*) as count')
                    ->where('created_at', '>=', $startDate)
                    ->whereNotNull('zone_id')
                    ->groupBy('zone_id')
                    ->get()
                    ->map(function($item) {
                        return [
                            'zone' => $item->zone ? $item->zone->name : 'Unknown',
                            'count' => $item->count
                        ];
                    })
                    ->toArray();
    }

    private function getEventsByType(Carbon $startDate): array
    {
        return Event::selectRaw('type, COUNT(*) as count')
                    ->where('created_at', '>=', $startDate)
                    ->groupBy('type')
                    ->get()
                    ->toArray();
    }

    private function getNotificationsByType(Carbon $startDate): array
    {
        return Notification::selectRaw('type, COUNT(*) as count')
                           ->where('created_at', '>=', $startDate)
                           ->groupBy('type')
                           ->get()
                           ->toArray();
    }

    private function getNotificationsByPriority(Carbon $startDate): array
    {
        return Notification::selectRaw('priority, COUNT(*) as count')
                           ->where('created_at', '>=', $startDate)
                           ->groupBy('priority')
                           ->get()
                           ->toArray();
    }

    private function getZoneMemberGrowth(int $zoneId, Carbon $startDate): array
    {
        return User::selectRaw('DATE(zone_joined_at) as date, COUNT(*) as count')
                   ->where('zone_id', $zoneId)
                   ->where('zone_joined_at', '>=', $startDate)
                   ->groupBy('date')
                   ->orderBy('date')
                   ->get()
                   ->toArray();
    }

    private function getZoneRoleDistribution(int $zoneId): array
    {
        return User::with('zoneRole')
                   ->where('zone_id', $zoneId)
                   ->whereNotNull('zone_role_id')
                   ->get()
                   ->groupBy('zoneRole.name')
                   ->map(function($users, $roleName) {
                       return [
                           'role' => $roleName,
                           'count' => $users->count()
                       ];
                   })
                   ->values()
                   ->toArray();
    }

    private function getZonePaymentCategoryBreakdown(int $zoneId, Carbon $startDate): array
    {
        return Payment::selectRaw('category, COUNT(*) as count, SUM(amount) as total')
                      ->where('zone_id', $zoneId)
                      ->where('created_at', '>=', $startDate)
                      ->where('status', 'successful')
                      ->groupBy('category')
                      ->get()
                      ->toArray();
    }

    private function getAveragePaymentAmount(int $zoneId, Carbon $startDate): float
    {
        return Payment::where('zone_id', $zoneId)
                      ->where('created_at', '>=', $startDate)
                      ->where('status', 'successful')
                      ->avg('amount') ?? 0;
    }

    private function getZoneEventsByType(int $zoneId, Carbon $startDate): array
    {
        return Event::selectRaw('type, COUNT(*) as count')
                    ->where('zone_id', $zoneId)
                    ->where('created_at', '>=', $startDate)
                    ->groupBy('type')
                    ->get()
                    ->toArray();
    }

    private function getZoneNotificationReadRate(int $zoneId, Carbon $startDate): float
    {
        $total = Notification::where('zone_id', $zoneId)
                             ->where('created_at', '>=', $startDate)
                             ->count();

        if ($total === 0) return 0;

        $read = Notification::where('zone_id', $zoneId)
                           ->where('created_at', '>=', $startDate)
                           ->where('is_read', true)
                           ->count();

        return round(($read / $total) * 100, 2);
    }

    private function getZonePaymentParticipation(int $zoneId, Carbon $startDate): float
    {
        $zone = Zone::find($zoneId);
        $totalMembers = $zone->users()->count();

        if ($totalMembers === 0) return 0;

        $payingMembers = Payment::where('zone_id', $zoneId)
                               ->where('created_at', '>=', $startDate)
                               ->where('status', 'successful')
                               ->distinct('user_id')
                               ->count();

        return round(($payingMembers / $totalMembers) * 100, 2);
    }

    private function getZoneEventCreationRate(int $zoneId, Carbon $startDate): float
    {
        $zone = Zone::find($zoneId);
        $executives = $zone->executives()->count();

        if ($executives === 0) return 0;

        $events = Event::where('zone_id', $zoneId)
                       ->where('created_at', '>=', $startDate)
                       ->count();

        return round($events / $executives, 2);
    }

    private function calculateZonesSummary($zoneMetrics): array
    {
        $totalMembers = $zoneMetrics->sum('members_count');
        $totalRevenue = $zoneMetrics->sum('total_payments');
        $totalEvents = $zoneMetrics->sum('events_count');

        return [
            'total_zones' => $zoneMetrics->count(),
            'total_members' => $totalMembers,
            'total_revenue' => $totalRevenue,
            'total_events' => $totalEvents,
            'average_members_per_zone' => $zoneMetrics->count() > 0 ? round($totalMembers / $zoneMetrics->count(), 1) : 0,
            'average_revenue_per_zone' => $zoneMetrics->count() > 0 ? round($totalRevenue / $zoneMetrics->count(), 2) : 0,
            'most_active_zone' => $zoneMetrics->sortByDesc('events_count')->first(),
            'highest_revenue_zone' => $zoneMetrics->sortByDesc('total_payments')->first(),
        ];
    }
}
