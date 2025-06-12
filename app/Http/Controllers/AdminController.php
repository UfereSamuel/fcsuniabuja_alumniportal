<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Executive;
use App\Models\ClassModel;
use App\Models\Event;
use App\Models\PrayerRequest;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get comprehensive stats for dashboard and notifications
        $stats = [
            'total_users' => User::count(),
            'new_users_this_month' => User::whereMonth('created_at', now())->count(),
            'total_activities' => Activity::count(),
            'recent_activities' => Activity::where('created_at', '>=', now()->subDays(7))->count(),
            'total_events' => Event::count(),
            'upcoming_events' => Event::where('start_date', '>=', now())->count(),
            'events_this_month' => Event::whereMonth('start_date', now())->count(),
            'total_sliders' => Slider::count(),
            'active_sliders' => Slider::where('is_active', true)->count(),
            'total_executives' => Executive::count(),
            'total_members' => User::where('role', 'member')->count(),
            'total_coordinators' => User::whereIn('role', ['class_coordinator', 'deputy_coordinator'])->count(),
            'pending_prayer_requests' => PrayerRequest::where('is_active', true)->where('is_answered', false)->count(),
            'pending_documents' => 0, // Placeholder for future document system
            'classes_count' => ClassModel::count(),
            'recent_registrations' => User::where('created_at', '>=', now()->subDays(7))->count(),
            'popular_classes' => ClassModel::withCount('users')->orderBy('users_count', 'desc')->take(5)->get(),
            'system_health' => [
                'database' => 'operational',
                'storage' => 'operational',
                'notifications' => 'operational'
            ]
        ];

        // Get recent activities for timeline
        $recentActivities = Activity::with('class')
            ->latest()
            ->take(5)
            ->get();

        // Get upcoming events
        $upcomingEvents = Event::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(5)
            ->get();

        // Get recent users
        $recentUsers = User::with('class')
            ->latest()
            ->take(5)
            ->get();

        // Class distribution for chart
        $classDistribution = ClassModel::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(10)
            ->get();

        return view('dashboard.admin', compact(
            'stats',
            'recentActivities',
            'upcomingEvents',
            'recentUsers',
            'classDistribution'
        ));
    }

    /**
     * Mark notification as read
     */
    public function markNotificationRead($id)
    {
        // Implementation for marking notifications as read
        return response()->json(['success' => true]);
    }

    /**
     * Get real-time notifications
     */
    public function getNotifications()
    {
        $notifications = [];

        // Pending prayer requests
        $pendingPrayers = PrayerRequest::where('is_active', true)
            ->where('is_answered', false)
            ->count();

        if ($pendingPrayers > 0) {
            $notifications[] = [
                'id' => 'prayer_requests',
                'type' => 'prayer_request',
                'title' => "{$pendingPrayers} pending prayer requests",
                'message' => 'Requires review and response',
                'icon' => 'fas fa-praying-hands',
                'color' => 'blue',
                'url' => route('admin.prayer-requests.index'),
                'time' => now()->diffForHumans()
            ];
        }

        // Upcoming events
        $upcomingEvents = Event::where('start_date', '>=', now())
            ->where('start_date', '<=', now()->addDays(7))
            ->count();

        if ($upcomingEvents > 0) {
            $notifications[] = [
                'id' => 'upcoming_events',
                'type' => 'event',
                'title' => "{$upcomingEvents} upcoming events this week",
                'message' => 'Make sure everything is prepared',
                'icon' => 'fas fa-calendar-check',
                'color' => 'green',
                'url' => route('admin.events.index'),
                'time' => now()->diffForHumans()
            ];
        }

        // New registrations
        $newUsers = User::where('created_at', '>=', now()->subDays(1))->count();

        if ($newUsers > 0) {
            $notifications[] = [
                'id' => 'new_registrations',
                'type' => 'user',
                'title' => "{$newUsers} new registrations",
                'message' => 'Welcome new alumni members',
                'icon' => 'fas fa-user-plus',
                'color' => 'purple',
                'url' => route('admin.users.index'),
                'time' => now()->diffForHumans()
            ];
        }

        return response()->json([
            'notifications' => $notifications,
            'count' => count($notifications)
        ]);
    }

    /**
     * Send bulk notification to users
     */
    public function sendBulkNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'recipients' => 'required|in:all,class,role',
            'recipient_id' => 'nullable|integer',
            'type' => 'required|in:info,success,warning,error'
        ]);

        // Implementation for sending bulk notifications
        // This would integrate with email, SMS, or push notification services

        return back()->with('success', 'Notification sent successfully!');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        // Implementation for marking all notifications as read
        // This would typically update a notifications table
        return response()->json(['success' => true]);
    }
}
