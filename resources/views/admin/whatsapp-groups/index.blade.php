@extends('layouts.admin')

@section('title', 'WhatsApp Groups')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">WhatsApp Groups</span>
        </div>
    </li>
@endsection

@section('page-title', 'WhatsApp Groups Management')
@section('page-description', 'Manage FCS alumni WhatsApp groups and invite links')

@section('page-actions')
    <a href="{{ route('admin.whatsapp-groups.create') }}" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fab fa-whatsapp mr-2"></i>Add Group
    </a>
@endsection

@section('content')
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                    <i class="fab fa-whatsapp text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $groups->total() }}</h3>
                    <p class="text-gray-600">Total Groups</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\WhatsAppGroup::where('is_public', true)->count() }}</h3>
                    <p class="text-gray-600">Public Groups</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\WhatsAppGroup::where('type', 'zone')->count() }}</h3>
                    <p class="text-gray-600">Zone Groups</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\WhatsAppGroup::sum('member_count') }}</h3>
                    <p class="text-gray-600">Total Members</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('admin.whatsapp-groups.index') }}" class="space-y-4 lg:space-y-0 lg:flex lg:items-end lg:space-x-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue"
                       placeholder="Search groups by name or description...">
            </div>

            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" id="type" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                    <option value="">All Types</option>
                    <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>General</option>
                    <option value="zone" {{ request('type') === 'zone' ? 'selected' : '' }}>Zone</option>
                    <option value="class" {{ request('type') === 'class' ? 'selected' : '' }}>Class</option>
                    <option value="executive" {{ request('type') === 'executive' ? 'selected' : '' }}>Executive</option>
                    <option value="special" {{ request('type') === 'special' ? 'selected' : '' }}>Special</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.whatsapp-groups.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md font-medium transition">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Groups List -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">WhatsApp Groups ({{ $groups->total() }})</h3>
        </div>

        @if($groups->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Group</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Members</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($groups as $group)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                <i class="fab fa-whatsapp text-green-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $group->name }}</div>
                                            @if($group->description)
                                                <div class="text-sm text-gray-500">{{ Str::limit($group->description, 50) }}</div>
                                            @endif
                                            @if($group->zone)
                                                <div class="text-xs text-blue-600">{{ $group->zone->name }}</div>
                                            @endif
                                            @if($group->class)
                                                <div class="text-xs text-purple-600">{{ $group->class->name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $group->type === 'general' ? 'bg-gray-100 text-gray-800' :
                                           ($group->type === 'zone' ? 'bg-blue-100 text-blue-800' :
                                           ($group->type === 'class' ? 'bg-purple-100 text-purple-800' :
                                           ($group->type === 'executive' ? 'bg-yellow-100 text-yellow-800' : 'bg-pink-100 text-pink-800'))) }}">
                                        {{ $group->type_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($group->member_count) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $group->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $group->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        @if($group->is_public)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Public
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $group->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ $group->formatted_invite_link }}" target="_blank"
                                           class="text-green-600 hover:text-green-700" title="Join Group">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <a href="{{ route('admin.whatsapp-groups.show', $group) }}"
                                           class="text-fcs-blue hover:text-blue-700" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.whatsapp-groups.edit', $group) }}"
                                           class="text-yellow-600 hover:text-yellow-700" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.whatsapp-groups.destroy', $group) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this WhatsApp group?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $groups->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fab fa-whatsapp text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No WhatsApp Groups Found</h3>
                <p class="text-gray-500 mb-6">No WhatsApp groups match your current filters.</p>
                @if(request()->anyFilled(['search', 'type', 'status']))
                    <a href="{{ route('admin.whatsapp-groups.index') }}" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">
                        <i class="fas fa-times mr-2"></i>Clear Filters
                    </a>
                @else
                    <a href="{{ route('admin.whatsapp-groups.create') }}" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">
                        <i class="fab fa-whatsapp mr-2"></i>Add First Group
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection

@section('scripts')
// Auto-refresh preview when filters change
document.querySelectorAll('select').forEach(element => {
    element.addEventListener('change', function() {
        this.form.submit();
    });
});

// Search debouncing
const searchInput = document.getElementById('search');
if (searchInput) {
    let timeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            if (this.value.length >= 3 || this.value.length === 0) {
                this.form.submit();
            }
        }, 500);
    });
}
@endsection
