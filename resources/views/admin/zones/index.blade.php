@extends('layouts.admin')

@section('title', 'Zone Management')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Zones</span>
        </div>
    </li>
@endsection

@section('page-title', 'Zone Management')
@section('page-description', 'Manage geographical zones and their members')

@section('page-actions')
    <a href="{{ route('admin.zones.create') }}" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-plus mr-2"></i>Create Zone
    </a>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-globe-africa text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Zones</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_zones'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Active Zones</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_zones'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Members</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_members'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-times text-red-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Unassigned</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['unassigned_members'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Zones Table -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">All Zones</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Members</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Events</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($zones as $zone)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-globe-africa text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $zone->name }}</div>
                                        @if($zone->description)
                                            <div class="text-sm text-gray-500">{{ Str::limit($zone->description, 50) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $zone->country }}</div>
                                @if($zone->state)
                                    <div class="text-sm text-gray-500">{{ $zone->state }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $zone->users_count }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $zone->events_count }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($zone->contact_person)
                                    <div class="text-sm text-gray-900">{{ $zone->contact_person }}</div>
                                    @if($zone->contact_email)
                                        <div class="text-sm text-gray-500">{{ $zone->contact_email }}</div>
                                    @endif
                                @else
                                    <span class="text-gray-400">No contact</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $zone->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $zone->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.zones.show', $zone) }}" class="text-fcs-blue hover:text-fcs-light-blue">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.zones.edit', $zone) }}" class="text-yellow-600 hover:text-yellow-700">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.zones.members', $zone) }}" class="text-green-600 hover:text-green-700">
                                        <i class="fas fa-users"></i>
                                    </a>
                                    @if($zone->users_count == 0)
                                        <form action="{{ route('admin.zones.destroy', $zone) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this zone?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-globe-africa text-gray-300 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No zones found</h3>
                                    <p class="text-gray-500 mb-4">Get started by creating your first zone.</p>
                                    <a href="{{ route('admin.zones.create') }}" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-4 py-2 rounded-lg transition">
                                        Create Zone
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($zones->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $zones->links() }}
            </div>
        @endif
    </div>
@endsection
