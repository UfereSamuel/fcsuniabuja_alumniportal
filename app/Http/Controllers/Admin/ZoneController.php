<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ZoneController extends Controller
{
    /**
     * Display a listing of the zones.
     */
    public function index()
    {
        $zones = Zone::with(['users', 'events', 'payments'])
                    ->withCount(['users', 'events'])
                    ->orderBy('name')
                    ->paginate(15);

        $stats = [
            'total_zones' => Zone::count(),
            'active_zones' => Zone::active()->count(),
            'total_members' => User::whereNotNull('zone_id')->count(),
            'unassigned_members' => User::whereNull('zone_id')->count(),
        ];

        return view('admin.zones.index', compact('zones', 'stats'));
    }

    /**
     * Show the form for creating a new zone.
     */
    public function create()
    {
        return view('admin.zones.create');
    }

    /**
     * Store a newly created zone in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:zones',
            'description' => 'nullable|string',
            'country' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);

        Zone::create($request->all());

        return redirect()->route('admin.zones.index')
                        ->with('success', 'Zone created successfully.');
    }

    /**
     * Display the specified zone.
     */
    public function show(Zone $zone)
    {
        $zone->load(['users.zoneRole', 'events', 'payments']);

        $statistics = [
            'members_count' => $zone->users()->count(),
            'coordinators_count' => $zone->users()->whereHas('zoneRole', function($q) {
                $q->where('name', 'Coordinator');
            })->count(),
            'events_count' => $zone->events()->count(),
            'total_payments' => $zone->payments()->where('status', 'successful')->sum('amount'),
            'pending_payments' => $zone->payments()->where('status', 'pending')->count(),
        ];

        return view('admin.zones.show', compact('zone', 'statistics'));
    }

    /**
     * Show the form for editing the specified zone.
     */
    public function edit(Zone $zone)
    {
        return view('admin.zones.edit', compact('zone'));
    }

    /**
     * Update the specified zone in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:zones,name,' . $zone->id,
            'description' => 'nullable|string',
            'country' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);

        $zone->update($request->all());

        return redirect()->route('admin.zones.index')
                        ->with('success', 'Zone updated successfully.');
    }

    /**
     * Remove the specified zone from storage.
     */
    public function destroy(Zone $zone)
    {
        // Check if zone has members
        if ($zone->users()->count() > 0) {
            throw ValidationException::withMessages([
                'zone' => 'Cannot delete zone with active members. Please reassign members first.'
            ]);
        }

        $zone->delete();

        return redirect()->route('admin.zones.index')
                        ->with('success', 'Zone deleted successfully.');
    }

    /**
     * Get zone members
     */
    public function members(Zone $zone)
    {
        $members = $zone->users()
                       ->with(['zoneRole', 'class'])
                       ->orderBy('name')
                       ->paginate(20);

        return view('admin.zones.members', compact('zone', 'members'));
    }

    /**
     * Assign user to zone
     */
    public function assignUser(Request $request, Zone $zone)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'zone_role_id' => 'nullable|exists:zone_roles,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $oldZone = $user->zone;

        $user->update([
            'zone_id' => $zone->id,
            'zone_role_id' => $request->zone_role_id,
            'zone_joined_at' => now(),
        ]);

        // Send notifications
        $notificationService = app(\App\Services\NotificationService::class);

        // Notify the user
        $notificationService->sendZoneUpdateNotification(
            $user->id,
            'zone_updated',
            "You have been assigned to {$zone->name} zone" . ($oldZone ? " (transferred from {$oldZone->name})" : ""),
            $zone->id,
            route('admin.zones.show', $zone->id),
            true
        );

        // Notify zone executives
        $notificationService->sendZoneExecutiveNotification(
            $zone->id,
            'New Member Assigned',
            "{$user->name} has been assigned to {$zone->name} zone.",
            'zone_update',
            'normal',
            route('admin.zones.show', $zone->id)
        );

        return redirect()->back()
                        ->with('success', 'User assigned to zone successfully.');
    }

    /**
     * Remove user from zone
     */
    public function removeUser(Request $request, Zone $zone)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        $user->update([
            'zone_id' => null,
            'zone_role_id' => null,
            'zone_joined_at' => null,
        ]);

        // Send notifications
        $notificationService = app(\App\Services\NotificationService::class);

        // Notify the user
        $notificationService->sendZoneUpdateNotification(
            $user->id,
            'zone_updated',
            "You have been removed from {$zone->name} zone.",
            $zone->id,
            null,
            true
        );

        // Notify zone executives
        $notificationService->sendZoneExecutiveNotification(
            $zone->id,
            'Member Removed',
            "{$user->name} has been removed from {$zone->name} zone.",
            'zone_update',
            'normal',
            route('admin.zones.show', $zone->id)
        );

        return redirect()->back()
                        ->with('success', 'User removed from zone successfully.');
    }
}
