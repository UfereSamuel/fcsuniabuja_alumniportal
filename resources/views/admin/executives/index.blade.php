@extends('layouts.admin')

@section('title', 'Executive Management')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Executives</span>
        </div>
    </li>
@endsection

@section('page-title', 'Executive Management')
@section('page-description', 'Manage FCS executive board members and leadership positions.')

@section('page-actions')
    <a href="{{ route('admin.executives.create') }}" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-plus mr-2"></i>Add New Executive
    </a>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ \App\Models\Executive::count() }}</h3>
                    <p class="text-gray-600 text-sm">Total Executives</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-user-check text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ \App\Models\Executive::where('is_active', true)->count() }}</h3>
                    <p class="text-gray-600 text-sm">Active Members</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-crown text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ \App\Models\Executive::distinct('position')->count() }}</h3>
                    <p class="text-gray-600 text-sm">Positions</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <i class="fas fa-calendar-alt text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ now()->year }}</h3>
                    <p class="text-gray-600 text-sm">Current Term</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Filter Executives</h3>
        </div>
        <form method="GET" action="{{ route('admin.executives.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Search by name, position, email..."
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Position -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                    <select name="position" id="position" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Positions</option>
                        <option value="President" {{ request('position') == 'President' ? 'selected' : '' }}>President</option>
                        <option value="Vice President" {{ request('position') == 'Vice President' ? 'selected' : '' }}>Vice President</option>
                        <option value="Secretary" {{ request('position') == 'Secretary' ? 'selected' : '' }}>Secretary</option>
                        <option value="Treasurer" {{ request('position') == 'Treasurer' ? 'selected' : '' }}>Treasurer</option>
                        <option value="Director" {{ request('position') == 'Director' ? 'selected' : '' }}>Director</option>
                        <option value="Coordinator" {{ request('position') == 'Coordinator' ? 'selected' : '' }}>Coordinator</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Year -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Term Year</label>
                    <select name="year" id="year" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Years</option>
                        @for($year = now()->year; $year >= 2020; $year--)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="mt-4 flex justify-between">
                <div class="flex space-x-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.executives.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Executives Grid -->
    @if(isset($executives) && $executives->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach($executives as $executive)
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center space-x-4">
                        <!-- Profile Image -->
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                            @if($executive->image)
                                <img src="{{ asset('storage/' . $executive->image) }}" alt="{{ $executive->name }}"
                                     class="w-16 h-16 rounded-full object-cover">
                            @else
                                <span class="text-gray-400 text-xl font-semibold">
                                    {{ substr($executive->name, 0, 1) }}
                                </span>
                            @endif
                        </div>

                        <!-- Executive Info -->
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $executive->name }}</h3>
                            <p class="text-fcs-primary font-medium">{{ $executive->position }}</p>
                            @if($executive->email)
                                <p class="text-sm text-gray-500">{{ $executive->email }}</p>
                            @endif
                        </div>

                        <!-- Status Badge -->
                        <div class="flex flex-col items-end">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $executive->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $executive->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    @if($executive->bio)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-600">{{ Str::limit($executive->bio, 100) }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-4 pt-4 border-t border-gray-100 flex space-x-3">
                        <a href="{{ route('admin.executives.show', $executive) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-eye mr-1"></i>View
                        </a>
                        <a href="{{ route('admin.executives.edit', $executive) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <form action="{{ route('admin.executives.destroy', $executive) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium"
                                    onclick="return confirm('Are you sure you want to remove this executive?')">
                                <i class="fas fa-trash mr-1"></i>Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $executives->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-users text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Executives Found</h3>
            <p class="text-gray-500 mb-6">There are no executives matching your current filters.</p>
            <div class="flex justify-center space-x-3">
                <a href="{{ route('admin.executives.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    <i class="fas fa-plus mr-2"></i>Add Executive
                </a>
                <a href="{{ route('admin.executives.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    <i class="fas fa-redo mr-2"></i>Clear Filters
                </a>
            </div>
        </div>
    @endif
@endsection
