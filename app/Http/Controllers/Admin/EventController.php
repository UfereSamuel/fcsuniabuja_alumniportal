<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
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
     * Display a listing of the events.
     */
    public function index(Request $request)
    {
        $query = Event::with(['zone', 'creator']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by zone
        if ($request->has('zone_id') && $request->zone_id) {
            $query->where('zone_id', $request->zone_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->where('start_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->where('start_date', '<=', $request->date_to);
        }

        // Filter by event type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        $events = $query->latest('start_date')->paginate(15);
        $zones = \App\Models\Zone::all();

        return view('admin.events.index', compact('events', 'zones'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $zones = \App\Models\Zone::all();
        return view('admin.events.create', compact('zones'));
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'event_time' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:conference,seminar,workshop,social,spiritual,community'],
            'registration_required' => ['boolean'],
            'max_attendees' => ['nullable', 'integer', 'min:1'],
            'registration_deadline' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'zone_id' => ['nullable', 'exists:zones,id'],
            'is_active' => ['boolean'],
        ]);

        $eventData = $request->all();
        $eventData['created_by'] = auth()->id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $eventData['image'] = $path;
        }

        Event::create($eventData);

        return redirect()->route('admin.events.index')
                        ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        $event->load(['zone', 'creator', 'rsvps.user']);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        $zones = \App\Models\Zone::all();
        return view('admin.events.edit', compact('event', 'zones'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'event_time' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:conference,seminar,workshop,social,spiritual,community'],
            'registration_required' => ['boolean'],
            'max_attendees' => ['nullable', 'integer', 'min:1'],
            'registration_deadline' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'zone_id' => ['nullable', 'exists:zones,id'],
            'is_active' => ['boolean'],
        ]);

        $eventData = $request->except(['image']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $path = $request->file('image')->store('events', 'public');
            $eventData['image'] = $path;
        }

        $event->update($eventData);

        return redirect()->route('admin.events.index')
                        ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        // Delete image if exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
                        ->with('success', 'Event deleted successfully.');
    }

    /**
     * Toggle event status (active/inactive).
     */
    public function toggleStatus(Event $event)
    {
        $event->update(['is_active' => !$event->is_active]);

        $status = $event->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.events.index')
                        ->with('success', "Event {$status} successfully.");
    }
}
