<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Executive;
use App\Models\BoardMember;
use App\Models\Activity;
use App\Models\PrayerRequest;
use App\Models\Event;
use App\Models\Document;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                // Redirect admin users to the dedicated admin panel
                return redirect()->route('admin.dashboard');
            case 'coordinator':
                return $this->coordinatorDashboard();
            default:
                return $this->memberDashboard();
        }
    }

    private function adminDashboard()
    {
        $stats = [
            'total_members' => User::where('role', '!=', 'admin')->count(),
            'total_classes' => ClassModel::where('is_active', true)->count(),
            'total_executives' => Executive::where('is_active', true)->count(),
            'total_activities' => Activity::where('is_active', true)->count(),
            'pending_documents' => Document::where('requires_approval', true)->where('is_approved', false)->count(),
            'active_prayer_requests' => PrayerRequest::where('is_active', true)->count(),
            'upcoming_events' => Event::where('start_date', '>=', now())->count(),
            'new_members_this_month' => User::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        $recentMembers = User::where('role', '!=', 'admin')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentActivities = Activity::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $classDistribution = ClassModel::withCount('members')
            ->where('is_active', true)
            ->orderBy('graduation_year', 'desc')
            ->get();

        return view('dashboard.admin', compact('stats', 'recentMembers', 'recentActivities', 'classDistribution'));
    }

    private function coordinatorDashboard()
    {
        $user = Auth::user();
        $class = $user->class;

        $stats = [
            'class_members' => $class ? $class->members()->count() : 0,
            'class_activities' => Activity::where('class_id', $user->class_id)->where('is_active', true)->count(),
            'class_events' => Event::where('start_date', '>=', now())->count(),
            'class_documents' => Document::where('is_approved', true)->count(),
        ];

        $classMembers = $class ? $class->members()->orderBy('name')->take(10)->get() : collect();

        $recentClassActivities = Activity::where('class_id', $user->class_id)
            ->where('is_active', true)
            ->orderBy('activity_date', 'desc')
            ->take(5)
            ->get();

        $upcomingEvents = Event::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(5)
            ->get();

        return view('dashboard.coordinator', compact('stats', 'classMembers', 'recentClassActivities', 'upcomingEvents', 'class'));
    }

    private function memberDashboard()
    {
        $user = Auth::user();
        $class = $user->class;

        $upcomingActivities = Activity::where(function($query) use ($user) {
                $query->whereNull('class_id')
                      ->orWhere('class_id', $user->class_id);
            })
            ->where('is_active', true)
            ->where('activity_date', '>=', now())
            ->orderBy('activity_date')
            ->take(5)
            ->get();

        $recentActivities = Activity::where(function($query) use ($user) {
                $query->whereNull('class_id')
                      ->orWhere('class_id', $user->class_id);
            })
            ->where('is_active', true)
            ->where('activity_date', '<', now())
            ->orderBy('activity_date', 'desc')
            ->take(3)
            ->get();

        $upcomingEvents = Event::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(5)
            ->get();

        $activePrayerRequests = PrayerRequest::where('is_active', true)
            ->where('is_anonymous', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $classmates = $class ? $class->members()
            ->where('id', '!=', $user->id)
            ->orderBy('name')
            ->take(8)
            ->get() : collect();

        $stats = [
            'my_class_members' => $class ? $class->members()->count() : 0,
            'upcoming_activities' => $upcomingActivities->count(),
            'my_events_rsvp' => Event::whereHas('rsvps', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('start_date', '>=', now())->count(),
            'documents_available' => Document::where('is_approved', true)
                ->whereIn('access_level', ['public', 'members_only'])
                ->count(),
        ];

        return view('dashboard.member', compact(
            'upcomingActivities',
            'recentActivities',
            'upcomingEvents',
            'activePrayerRequests',
            'classmates',
            'class',
            'stats'
        ));
    }
}
