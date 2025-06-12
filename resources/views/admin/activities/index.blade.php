@extends('layouts.admin')

@section('title', 'Activity Management')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Activities</span>
        </div>
    </li>
@endsection

@section('page-title', 'Activity Management')
@section('page-description', 'Manage FCS activities, events, and programs.')

@section('page-actions')
    <a href="{{ route('admin.activities.create') }}" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-plus mr-2"></i>Add New Activity
    </a>
@endsection

@section('content')
    <!-- Filters and Search -->
    <div class="bg-white shadow-sm rounded-lg mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.activities.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Search by title, description, or location..."
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Class Filter -->
                <div>
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                    <select name="class_id" id="class_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Classes</option>
                        @if(isset($classes))
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Date To -->
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Buttons -->
                <div class="md:col-span-6 flex space-x-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.activities.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Activities Grid -->
    @if(isset($activities) && $activities->count() > 0)
        <div class="mb-6">
            <p class="text-sm text-gray-600">Showing {{ $activities->count() }} of {{ $activities->total() }} activities</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach($activities as $activity)
                <div class="bg-white shadow-sm rounded-lg overflow-hidden hover:shadow-md transition">
                    <!-- Activity Image -->
                    @if($activity->image)
                        <div class="h-48 bg-gray-200 overflow-hidden">
                            <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-gray-400 text-4xl"></i>
                        </div>
                    @endif

                    <!-- Activity Content -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-2">
                                <!-- Status Badge -->
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $activity->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $activity->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <!-- Class Badge -->
                                @if($activity->class)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $activity->class->name }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $activity->title }}</h3>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($activity->description, 100) }}</p>

                        <!-- Activity Details -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-calendar mr-2"></i>
                                {{ $activity->activity_date->format('M d, Y') }}
                            </div>
                            @if($activity->location)
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ Str::limit($activity->location, 30) }}
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.activities.show', $activity) }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <a href="{{ route('admin.activities.edit', $activity) }}"
                                   class="text-green-600 hover:text-green-800 text-sm font-medium">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                            </div>
                            <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium"
                                        onclick="return confirm('Are you sure you want to delete this activity?')">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $activities->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-calendar-alt text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Activities Found</h3>
            <p class="text-gray-500 mb-6">There are no activities matching your current filters.</p>
            <div class="flex justify-center space-x-3">
                <a href="{{ route('admin.activities.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    <i class="fas fa-plus mr-2"></i>Create Activity
                </a>
                <a href="{{ route('admin.activities.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    <i class="fas fa-redo mr-2"></i>Clear Filters
                </a>
            </div>
        </div>
    @endif
@endsection
