<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Executive;
use App\Models\ClassModel;
use App\Models\Event;
use App\Models\Slider;
use App\Models\User;
use App\Models\Notification;
use App\Models\Zone;
use App\Models\Payment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function dashboard()
    {
        // Get comprehensive stats for dashboard and notifications
        $stats = [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'total_revenue' => Payment::where('status', 'success')->sum('amount'),
            'revenue_today' => Payment::where('status', 'success')->whereDate('created_at', today())->sum('amount'),
            'active_events' => Event::where('start_date', '>=', now())->count(),
            'upcoming_events' => Event::where('start_date', '>=', now())->count(),
            'total_payments' => Payment::count(),
            'successful_payments' => Payment::where('status', 'success')->count(),
            'successful_amount' => Payment::where('status', 'success')->sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'pending_amount' => Payment::where('status', 'pending')->sum('amount'),
            'failed_payments' => Payment::where('status', 'failed')->count(),
            'payment_success_rate' => Payment::count() > 0 ? (Payment::where('status', 'success')->count() / Payment::count()) * 100 : 0,
            'total_zones' => Zone::count(),
            'total_activities' => Activity::count(),
            'active_sliders' => Slider::where('is_active', true)->count(),
            'total_executives' => Executive::count(),
            'total_members' => User::where('role', 'member')->count(),
            'total_coordinators' => User::whereIn('role', ['class_coordinator', 'deputy_coordinator'])->count(),
            'pending_prayer_requests' => 0, // PrayerRequest::where('is_active', true)->where('is_answered', false)->count(),
            'pending_documents' => 0, // Placeholder for future document system
            'classes_count' => ClassModel::count(),
            'total_classes' => ClassModel::count(),
            'recent_registrations' => User::where('created_at', '>=', now()->subDays(7))->count(),
            'new_members_this_month' => User::where('created_at', '>=', now()->subMonth())->count(),
            'active_prayer_requests' => 0,
            'popular_classes' => ClassModel::withCount('members')->orderBy('members_count', 'desc')->take(5)->get(),
            'system_health' => [
                'database' => 'operational',
                'storage' => 'operational',
                'notifications' => 'operational'
            ],
            'total_notifications' => Notification::count(),
            'unread_notifications' => Notification::unread()->count(),
            'notifications_today' => Notification::whereDate('created_at', today())->count(),
        ];

        // Get recent activities for timeline
        $recentActivities = Activity::latest()
            ->take(5)
            ->get();

        // Get top zones for overview
        $topZones = Zone::withCount(['users' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('users_count', 'desc')
            ->take(5)
            ->get();

        // Recent notifications
        $recentNotifications = Notification::with(['user', 'zone'])
            ->latest()
            ->take(10)
            ->get();

        // Get recent members for dashboard
        $recentMembers = User::with('class')
            ->where('role', 'member')
            ->latest()
            ->take(5)
            ->get();

        // Get class distribution for dashboard
        $classDistribution = ClassModel::withCount('members')
            ->orderBy('members_count', 'desc')
            ->get();

        return view('dashboard.admin', compact(
            'stats',
            'recentActivities',
            'topZones',
            'recentNotifications',
            'recentMembers',
            'classDistribution'
        ));
    }

    /**
     * Get real-time notifications for admin
     */
    public function getNotifications(Request $request)
    {
        $user = Auth::user();

        // Get notifications for the current user
        $notifications = $this->notificationService->getUserNotifications($user->id, 20);

        // Format notifications for frontend
        $formattedNotifications = $notifications->map(function($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
                'type' => $notification->type,
                'priority' => $notification->priority,
                'icon' => $notification->notification_icon,
                'color' => $notification->notification_color,
                'time' => $notification->time_ago,
                'read' => $notification->is_read,
                'url' => $notification->action_url,
                'zone' => $notification->zone ? $notification->zone->name : null,
            ];
        });

        return response()->json([
            'success' => true,
            'notifications' => $formattedNotifications,
            'unread_count' => $this->notificationService->getUnreadCount($user->id),
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markNotificationRead(Request $request, $id)
    {
        $success = $this->notificationService->markAsRead($id);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Notification marked as read' : 'Notification not found'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();
        $count = $this->notificationService->markAllAsRead($user->id);

        return response()->json([
            'success' => true,
            'message' => "Marked {$count} notifications as read",
            'count' => $count
        ]);
    }

    /**
     * Send bulk notification
     */
    public function sendBulkNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:payment,zone_update,event,system,user_action',
            'priority' => 'required|in:low,normal,high,urgent',
            'target_type' => 'required|in:all_users,zone_members,zone_executives,specific_users',
            'zone_id' => 'required_if:target_type,zone_members,zone_executives|exists:zones,id',
            'user_ids' => 'required_if:target_type,specific_users|array',
            'user_ids.*' => 'exists:users,id',
            'send_email' => 'boolean',
            'action_url' => 'nullable|url',
        ]);

        $userIds = [];

        switch ($request->target_type) {
            case 'all_users':
                $userIds = User::pluck('id')->toArray();
                break;

            case 'zone_members':
                $zone = Zone::findOrFail($request->zone_id);
                $userIds = $zone->users()->pluck('id')->toArray();
                break;

            case 'zone_executives':
                $zone = Zone::findOrFail($request->zone_id);
                $userIds = $zone->executives()->pluck('id')->toArray();
                break;

            case 'specific_users':
                $userIds = $request->user_ids;
                break;
        }

        $notifications = $this->notificationService->sendBulkNotification(
            $userIds,
            $request->title,
            $request->message,
            $request->type,
            $request->priority,
            $request->zone_id,
            $request->action_url,
            null,
            $request->boolean('send_email', false)
        );

        return response()->json([
            'success' => true,
            'message' => 'Bulk notification sent successfully',
            'count' => count($notifications),
            'notifications' => $notifications
        ]);
    }

    /**
     * Get notification analytics
     */
    public function getNotificationAnalytics(Request $request)
    {
        $period = $request->get('period', 30); // days

        // Notifications sent over time
        $notificationTrends = Notification::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($period))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Notifications by type
        $notificationsByType = Notification::selectRaw('type, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($period))
            ->groupBy('type')
            ->get();

        // Notifications by priority
        $notificationsByPriority = Notification::selectRaw('priority, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($period))
            ->groupBy('priority')
            ->get();

        // Email delivery stats
        $emailStats = [
            'total_notifications' => Notification::where('created_at', '>=', now()->subDays($period))->count(),
            'emails_sent' => Notification::where('created_at', '>=', now()->subDays($period))->where('email_sent', true)->count(),
            'emails_pending' => Notification::where('created_at', '>=', now()->subDays($period))->where('email_sent', false)->count(),
        ];

        // Most active zones
        $zoneActivity = Notification::whereNotNull('zone_id')
            ->with('zone')
            ->selectRaw('zone_id, COUNT(*) as notification_count')
            ->where('created_at', '>=', now()->subDays($period))
            ->groupBy('zone_id')
            ->orderBy('notification_count', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'trends' => $notificationTrends,
                'by_type' => $notificationsByType,
                'by_priority' => $notificationsByPriority,
                'email_stats' => $emailStats,
                'zone_activity' => $zoneActivity,
                'period' => $period
            ]
        ]);
    }

    /**
     * Show notification management page
     */
    public function manageNotifications(Request $request)
    {
        $query = Notification::with(['user', 'zone']);

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // Filter by read status
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'read') {
                $query->where('is_read', true);
            } elseif ($request->status === 'unread') {
                $query->where('is_read', false);
            }
        }

        // Filter by zone
        if ($request->has('zone_id') && $request->zone_id !== 'all') {
            $query->where('zone_id', $request->zone_id);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $notifications = $query->latest()->paginate(20);

        $stats = [
            'total_notifications' => Notification::count(),
            'unread_notifications' => Notification::unread()->count(),
            'emails_sent_today' => Notification::where('email_sent', true)
                                              ->whereDate('email_sent_at', today())
                                              ->count(),
            'priority_urgent' => Notification::where('priority', 'urgent')->unread()->count(),
        ];

        $zones = Zone::active()->orderBy('name')->get();

        return view('admin.notifications.manage', compact('notifications', 'stats', 'zones'));
    }

    /**
     * Show send notification form
     */
    public function sendNotificationForm()
    {
        $zones = Zone::active()->orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.notifications.send', compact('zones', 'users'));
    }

    /**
     * Show notification analytics page
     */
    public function notificationAnalyticsPage()
    {
        return view('admin.notifications.analytics');
    }
}
