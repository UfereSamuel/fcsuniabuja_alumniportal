<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Access denied. Admin privileges required.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the activities.
     */
    public function index(Request $request)
    {
        $query = Activity::with(['class', 'creator']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by class
        if ($request->has('class_id') && $request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->where('activity_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->where('activity_date', '<=', $request->date_to);
        }

        $activities = $query->latest('activity_date')->paginate(15);
        $classes = ClassModel::all();

        return view('admin.activities.index', compact('activities', 'classes'));
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create()
    {
        $classes = ClassModel::all();
        return view('admin.activities.create', compact('classes'));
    }

    /**
     * Store a newly created activity in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'activity_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'class_id' => ['nullable', 'exists:classes,id'],
            'is_active' => ['boolean'],
        ]);

        $activityData = $request->all();
        $activityData['created_by'] = auth()->id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('activities', 'public');
            $activityData['image'] = $path;
        }

        Activity::create($activityData);

        return redirect()->route('admin.activities.index')
                        ->with('success', 'Activity created successfully.');
    }

    /**
     * Display the specified activity.
     */
    public function show(Activity $activity)
    {
        $activity->load(['class', 'creator']);
        return view('admin.activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit(Activity $activity)
    {
        $classes = ClassModel::all();
        return view('admin.activities.edit', compact('activity', 'classes'));
    }

    /**
     * Update the specified activity in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'activity_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'class_id' => ['nullable', 'exists:classes,id'],
            'is_active' => ['boolean'],
        ]);

        $activityData = $request->except(['image']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($activity->image) {
                Storage::disk('public')->delete($activity->image);
            }
            $path = $request->file('image')->store('activities', 'public');
            $activityData['image'] = $path;
        }

        $activity->update($activityData);

        return redirect()->route('admin.activities.index')
                        ->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified activity from storage.
     */
    public function destroy(Activity $activity)
    {
        // Delete image if exists
        if ($activity->image) {
            Storage::disk('public')->delete($activity->image);
        }

        $activity->delete();

        return redirect()->route('admin.activities.index')
                        ->with('success', 'Activity deleted successfully.');
    }

    /**
     * Toggle activity status (active/inactive).
     */
    public function toggleStatus(Activity $activity)
    {
        $activity->update(['is_active' => !$activity->is_active]);

        $status = $activity->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.activities.index')
                        ->with('success', "Activity {$status} successfully.");
    }
}
