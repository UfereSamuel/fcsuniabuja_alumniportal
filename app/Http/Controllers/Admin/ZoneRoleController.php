<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ZoneRole;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ZoneRoleController extends Controller
{
    /**
     * Display a listing of zone roles.
     */
    public function index()
    {
        $zoneRoles = ZoneRole::withCount('users')
                           ->orderByDesc('priority')
                           ->orderBy('name')
                           ->paginate(15);

        $stats = [
            'total_roles' => ZoneRole::count(),
            'national_roles' => ZoneRole::national()->count(),
            'zonal_roles' => ZoneRole::zonal()->count(),
            'active_roles' => ZoneRole::active()->count(),
        ];

        return view('admin.zone-roles.index', compact('zoneRoles', 'stats'));
    }

    /**
     * Show the form for creating a new zone role.
     */
    public function create()
    {
        $permissions = ZoneRole::getAllPermissions();
        return view('admin.zone-roles.create', compact('permissions'));
    }

    /**
     * Store a newly created zone role.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:zone_roles',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', ZoneRole::getAllPermissions()),
            'is_national' => 'boolean',
            'is_zonal' => 'boolean',
            'is_active' => 'boolean',
            'priority' => 'nullable|integer|min:0|max:100',
        ]);

        // Ensure at least one of is_national or is_zonal is true
        if (!$request->is_national && !$request->is_zonal) {
            throw ValidationException::withMessages([
                'is_zonal' => 'Role must be either national or zonal (or both).'
            ]);
        }

        ZoneRole::create([
            'name' => $request->name,
            'description' => $request->description,
            'permissions' => $request->permissions ?? [],
            'is_national' => $request->boolean('is_national'),
            'is_zonal' => $request->boolean('is_zonal'),
            'is_active' => $request->boolean('is_active', true),
            'priority' => $request->priority ?? 0,
        ]);

        return redirect()->route('admin.zone-roles.index')
                        ->with('success', 'Zone role created successfully.');
    }

    /**
     * Display the specified zone role.
     */
    public function show(ZoneRole $zoneRole)
    {
        $zoneRole->load(['users.zone']);

        $statistics = [
            'users_count' => $zoneRole->users()->count(),
            'national_users' => $zoneRole->users()->whereHas('zoneRole', function($q) {
                $q->where('is_national', true);
            })->count(),
            'zonal_users' => $zoneRole->users()->whereHas('zoneRole', function($q) {
                $q->where('is_zonal', true);
            })->count(),
        ];

        return view('admin.zone-roles.show', compact('zoneRole', 'statistics'));
    }

    /**
     * Show the form for editing the specified zone role.
     */
    public function edit(ZoneRole $zoneRole)
    {
        $permissions = ZoneRole::getAllPermissions();
        return view('admin.zone-roles.edit', compact('zoneRole', 'permissions'));
    }

    /**
     * Update the specified zone role.
     */
    public function update(Request $request, ZoneRole $zoneRole)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:zone_roles,name,' . $zoneRole->id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', ZoneRole::getAllPermissions()),
            'is_national' => 'boolean',
            'is_zonal' => 'boolean',
            'is_active' => 'boolean',
            'priority' => 'nullable|integer|min:0|max:100',
        ]);

        // Ensure at least one of is_national or is_zonal is true
        if (!$request->is_national && !$request->is_zonal) {
            throw ValidationException::withMessages([
                'is_zonal' => 'Role must be either national or zonal (or both).'
            ]);
        }

        $zoneRole->update([
            'name' => $request->name,
            'description' => $request->description,
            'permissions' => $request->permissions ?? [],
            'is_national' => $request->boolean('is_national'),
            'is_zonal' => $request->boolean('is_zonal'),
            'is_active' => $request->boolean('is_active'),
            'priority' => $request->priority ?? 0,
        ]);

        return redirect()->route('admin.zone-roles.index')
                        ->with('success', 'Zone role updated successfully.');
    }

    /**
     * Remove the specified zone role.
     */
    public function destroy(ZoneRole $zoneRole)
    {
        // Check if role has users
        if ($zoneRole->users()->count() > 0) {
            throw ValidationException::withMessages([
                'role' => 'Cannot delete role with active users. Please reassign users first.'
            ]);
        }

        $zoneRole->delete();

        return redirect()->route('admin.zone-roles.index')
                        ->with('success', 'Zone role deleted successfully.');
    }

    /**
     * Toggle zone role status
     */
    public function toggleStatus(ZoneRole $zoneRole)
    {
        $zoneRole->update(['is_active' => !$zoneRole->is_active]);

        $status = $zoneRole->is_active ? 'activated' : 'deactivated';

        return redirect()->back()
                        ->with('success', "Zone role {$status} successfully.");
    }
}
