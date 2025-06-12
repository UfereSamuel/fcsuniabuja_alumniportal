@extends('layouts.admin')

@section('title', 'Create Zone Role')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <a href="{{ route('admin.zone-roles.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-fcs-blue">Zone Roles</a>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Create</span>
        </div>
    </li>
@endsection

@section('page-title', 'Create New Zone Role')
@section('page-description', 'Add a new role for zone member management')

@section('page-actions')
    <a href="{{ route('admin.zone-roles.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-arrow-left mr-2"></i>Back to Zone Roles
    </a>
    <button type="submit" form="zone-role-form" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-save mr-2"></i>Create Role
    </button>
@endsection

@section('content')
    <form id="zone-role-form" action="{{ route('admin.zone-roles.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Basic Information</h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Role Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Role Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="e.g., Zone Coordinator, Zone Secretary">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Brief description of this role and its responsibilities">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority Level *</label>
                    <input type="number" name="priority" id="priority" value="{{ old('priority', 1) }}" required
                           min="1" max="100"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('priority') border-red-500 @enderror"
                           placeholder="1 (highest) to 100 (lowest)">
                    <p class="text-xs text-gray-500 mt-1">Lower numbers indicate higher priority (1 = highest priority)</p>
                    @error('priority')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Role Type -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Role Type</h2>
                <p class="text-sm text-gray-500 mt-1">Define the scope and level of this role</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Role Level Checkboxes -->
                <div class="space-y-4">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_national" value="1" {{ old('is_national') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-fcs-blue shadow-sm focus:border-fcs-blue focus:ring focus:ring-fcs-blue focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">National Role</span>
                        </label>
                        <p class="text-xs text-gray-500 ml-6">Role applies at the national level across all zones</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_zonal" value="1" {{ old('is_zonal', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-fcs-blue shadow-sm focus:border-fcs-blue focus:ring focus:ring-fcs-blue focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Zonal Role</span>
                        </label>
                        <p class="text-xs text-gray-500 ml-6">Role applies at the zone level for specific zones</p>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-fcs-blue shadow-sm focus:border-fcs-blue focus:ring focus:ring-fcs-blue focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Role is active</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Permissions & Responsibilities -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Permissions & Responsibilities</h2>
                <p class="text-sm text-gray-500 mt-1">Define what this role can do within the system</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Permissions Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Zone Management</h4>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="manage_zone_members" {{ in_array('manage_zone_members', old('permissions', [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-fcs-blue shadow-sm focus:border-fcs-blue focus:ring focus:ring-fcs-blue focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Manage Zone Members</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="create_zone_events" {{ in_array('create_zone_events', old('permissions', [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-fcs-blue shadow-sm focus:border-fcs-blue focus:ring focus:ring-fcs-blue focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Create Zone Events</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="manage_zone_finances" {{ in_array('manage_zone_finances', old('permissions', [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-fcs-blue shadow-sm focus:border-fcs-blue focus:ring focus:ring-fcs-blue focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Manage Zone Finances</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Communication</h4>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="send_notifications" {{ in_array('send_notifications', old('permissions', [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-fcs-blue shadow-sm focus:border-fcs-blue focus:ring focus:ring-fcs-blue focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Send Notifications</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="manage_whatsapp_groups" {{ in_array('manage_whatsapp_groups', old('permissions', [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-fcs-blue shadow-sm focus:border-fcs-blue focus:ring focus:ring-fcs-blue focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Manage WhatsApp Groups</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="moderate_content" {{ in_array('moderate_content', old('permissions', [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-fcs-blue shadow-sm focus:border-fcs-blue focus:ring focus:ring-fcs-blue focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Moderate Content</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Additional Notes -->
                <div>
                    <label for="permissions_note" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                    <textarea name="permissions_note" id="permissions_note" rows="2"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent"
                              placeholder="Any additional notes about this role's permissions and responsibilities">{{ old('permissions_note') }}</textarea>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
<script>
// Auto-update role type based on selections
document.addEventListener('DOMContentLoaded', function() {
    const nationalCheckbox = document.querySelector('input[name="is_national"]');
    const zonalCheckbox = document.querySelector('input[name="is_zonal"]');

    // Ensure at least one type is selected
    function validateRoleType() {
        if (!nationalCheckbox.checked && !zonalCheckbox.checked) {
            zonalCheckbox.checked = true;
        }
    }

    nationalCheckbox.addEventListener('change', validateRoleType);
    zonalCheckbox.addEventListener('change', validateRoleType);
});
</script>
@endsection
