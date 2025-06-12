<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PerformanceMetricsService;
use Illuminate\Http\Request;
use App\Models\Zone;

class PerformanceController extends Controller
{
    protected $performanceService;

    public function __construct(PerformanceMetricsService $performanceService)
    {
        $this->performanceService = $performanceService;
    }

    /**
     * Show system performance dashboard
     */
    public function systemDashboard(Request $request)
    {
        $period = $request->get('period', 30);

        $metrics = $this->performanceService->getSystemMetrics($period);

        return view('admin.performance.system', compact('metrics', 'period'));
    }

    /**
     * Show zones performance overview
     */
    public function zonesOverview(Request $request)
    {
        $period = $request->get('period', 30);

        $metrics = $this->performanceService->getAllZonesMetrics($period);

        return view('admin.performance.zones', compact('metrics', 'period'));
    }

    /**
     * Show individual zone performance
     */
    public function zoneDetail(Request $request, Zone $zone)
    {
        $period = $request->get('period', 30);

        $metrics = $this->performanceService->getZoneMetrics($zone->id, $period);

        return view('admin.performance.zone-detail', compact('metrics', 'zone', 'period'));
    }

    /**
     * Get system metrics API
     */
    public function getSystemMetrics(Request $request)
    {
        $period = $request->get('period', 30);

        $metrics = $this->performanceService->getSystemMetrics($period);

        return response()->json([
            'success' => true,
            'data' => $metrics
        ]);
    }

    /**
     * Get zones metrics API
     */
    public function getZonesMetrics(Request $request)
    {
        $period = $request->get('period', 30);

        $metrics = $this->performanceService->getAllZonesMetrics($period);

        return response()->json([
            'success' => true,
            'data' => $metrics
        ]);
    }

    /**
     * Get specific zone metrics API
     */
    public function getZoneMetrics(Request $request, Zone $zone)
    {
        $period = $request->get('period', 30);

        $metrics = $this->performanceService->getZoneMetrics($zone->id, $period);

        return response()->json([
            'success' => true,
            'data' => $metrics
        ]);
    }

    /**
     * Export performance report
     */
    public function exportReport(Request $request)
    {
        $request->validate([
            'type' => 'required|in:system,zones,zone',
            'zone_id' => 'required_if:type,zone|exists:zones,id',
            'period' => 'required|integer|min:1|max:365',
            'format' => 'required|in:pdf,excel'
        ]);

        $period = $request->get('period', 30);
        $type = $request->get('type');
        $format = $request->get('format');

        switch ($type) {
            case 'system':
                $metrics = $this->performanceService->getSystemMetrics($period);
                $filename = "system-performance-{$period}days.{$format}";
                break;

            case 'zones':
                $metrics = $this->performanceService->getAllZonesMetrics($period);
                $filename = "zones-performance-{$period}days.{$format}";
                break;

            case 'zone':
                $zoneId = $request->get('zone_id');
                $zone = Zone::findOrFail($zoneId);
                $metrics = $this->performanceService->getZoneMetrics($zoneId, $period);
                $filename = "zone-{$zone->name}-performance-{$period}days.{$format}";
                break;
        }

        // Here you would implement the actual export logic
        // For now, we'll just return the data as JSON
        return response()->json([
            'success' => true,
            'message' => 'Export functionality will be implemented',
            'data' => $metrics,
            'filename' => $filename
        ]);
    }

    /**
     * Performance comparison between zones
     */
    public function compareZones(Request $request)
    {
        $request->validate([
            'zones' => 'required|array|min:2|max:5',
            'zones.*' => 'exists:zones,id',
            'period' => 'integer|min:1|max:365'
        ]);

        $zoneIds = $request->get('zones');
        $period = $request->get('period', 30);

        $comparison = [];
        foreach ($zoneIds as $zoneId) {
            $zone = Zone::find($zoneId);
            $metrics = $this->performanceService->getZoneMetrics($zoneId, $period);

            $comparison[] = [
                'zone' => $zone,
                'metrics' => $metrics
            ];
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $comparison,
                'period' => $period
            ]);
        }

        return view('admin.performance.compare', compact('comparison', 'period'));
    }

    /**
     * Get performance trends
     */
    public function getTrends(Request $request)
    {
        $request->validate([
            'metric' => 'required|in:users,payments,events,notifications',
            'period' => 'integer|min:7|max:365',
            'zone_id' => 'nullable|exists:zones,id'
        ]);

        $metric = $request->get('metric');
        $period = $request->get('period', 30);
        $zoneId = $request->get('zone_id');

        // Get trend data based on metric type
        switch ($metric) {
            case 'users':
                $trends = $this->getUserTrends($period, $zoneId);
                break;
            case 'payments':
                $trends = $this->getPaymentTrends($period, $zoneId);
                break;
            case 'events':
                $trends = $this->getEventTrends($period, $zoneId);
                break;
            case 'notifications':
                $trends = $this->getNotificationTrends($period, $zoneId);
                break;
        }

        return response()->json([
            'success' => true,
            'data' => $trends,
            'metric' => $metric,
            'period' => $period,
            'zone_id' => $zoneId
        ]);
    }

    /**
     * Get performance summary cards
     */
    public function getSummaryCards(Request $request)
    {
        $period = $request->get('period', 30);
        $zoneId = $request->get('zone_id');

        if ($zoneId) {
            $metrics = $this->performanceService->getZoneMetrics($zoneId, $period);
            $cards = $this->formatZoneSummaryCards($metrics);
        } else {
            $metrics = $this->performanceService->getSystemMetrics($period);
            $cards = $this->formatSystemSummaryCards($metrics);
        }

        return response()->json([
            'success' => true,
            'data' => $cards
        ]);
    }

    /**
     * Helper methods for trend calculations
     */
    private function getUserTrends(int $period, ?int $zoneId): array
    {
        // Implementation for user growth trends
        return [];
    }

    private function getPaymentTrends(int $period, ?int $zoneId): array
    {
        // Implementation for payment trends
        return [];
    }

    private function getEventTrends(int $period, ?int $zoneId): array
    {
        // Implementation for event trends
        return [];
    }

    private function getNotificationTrends(int $period, ?int $zoneId): array
    {
        // Implementation for notification trends
        return [];
    }

    private function formatSystemSummaryCards(array $metrics): array
    {
        return [
            [
                'title' => 'Total Users',
                'value' => $metrics['user_metrics']['total_users'],
                'change' => $metrics['user_metrics']['new_users'],
                'change_label' => 'New this period',
                'color' => 'blue',
                'icon' => 'fas fa-users'
            ],
            [
                'title' => 'Total Revenue',
                'value' => '₦' . number_format($metrics['payment_metrics']['total_revenue'], 2),
                'change' => '₦' . number_format($metrics['payment_metrics']['period_revenue'], 2),
                'change_label' => 'This period',
                'color' => 'green',
                'icon' => 'fas fa-naira-sign'
            ],
            [
                'title' => 'Total Events',
                'value' => $metrics['event_metrics']['total_events'],
                'change' => $metrics['event_metrics']['period_events'],
                'change_label' => 'Created this period',
                'color' => 'purple',
                'icon' => 'fas fa-calendar-alt'
            ],
            [
                'title' => 'Notifications Sent',
                'value' => $metrics['notification_metrics']['total_notifications'],
                'change' => $metrics['notification_metrics']['period_notifications'],
                'change_label' => 'This period',
                'color' => 'yellow',
                'icon' => 'fas fa-bell'
            ]
        ];
    }

    private function formatZoneSummaryCards(array $metrics): array
    {
        return [
            [
                'title' => 'Zone Members',
                'value' => $metrics['member_metrics']['total_members'],
                'change' => $metrics['member_metrics']['new_members'],
                'change_label' => 'New this period',
                'color' => 'blue',
                'icon' => 'fas fa-users'
            ],
            [
                'title' => 'Zone Revenue',
                'value' => '₦' . number_format($metrics['payment_metrics']['total_revenue'], 2),
                'change' => '₦' . number_format($metrics['payment_metrics']['period_revenue'], 2),
                'change_label' => 'This period',
                'color' => 'green',
                'icon' => 'fas fa-naira-sign'
            ],
            [
                'title' => 'Zone Events',
                'value' => $metrics['event_metrics']['total_events'],
                'change' => $metrics['event_metrics']['period_events'],
                'change_label' => 'Created this period',
                'color' => 'purple',
                'icon' => 'fas fa-calendar-alt'
            ],
            [
                'title' => 'Payment Participation',
                'value' => $metrics['engagement_metrics']['payment_participation'] . '%',
                'change' => $metrics['engagement_metrics']['notification_read_rate'] . '%',
                'change_label' => 'Read rate',
                'color' => 'yellow',
                'icon' => 'fas fa-chart-line'
            ]
        ];
    }
}
