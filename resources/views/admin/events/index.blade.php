@extends('layouts.admin')

@section('title', 'Events Management')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Events</span>
        </div>
    </li>
@endsection

@section('page-title', 'Events Management')
@section('page-description', 'Manage FCS fellowship events, conferences, and special gatherings.')

@section('page-actions')
    <a href="{{ route('admin.events.create') }}" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-plus mr-2"></i>Create New Event
    </a>
@endsection

@section('content')
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $events->total() }}</h3>
                    <p class="text-gray-600">Total Events</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\Event::where('start_date', '>=', now())->count() }}</h3>
                    <p class="text-gray-600">Upcoming</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-play text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\Event::where('is_active', true)->count() }}</h3>
                    <p class="text-gray-600">Active</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-day text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\Event::whereDate('start_date', today())->count() }}</h3>
                    <p class="text-gray-600">Today</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white shadow-sm rounded-lg mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.events.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Events</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Search by title, description, or location..."
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label for="date_range" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                    <select name="date_range" id="date_range" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                        <option value="">All Dates</option>
                        <option value="upcoming" {{ request('date_range') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="this_week" {{ request('date_range') === 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="this_month" {{ request('date_range') === 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="past" {{ request('date_range') === 'past' ? 'selected' : '' }}>Past Events</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-3">
                    <button type="submit" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if($events->count() > 0)
        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach($events as $event)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden card-hover">
                    <!-- Event Image -->
                    <div class="relative h-48 bg-gray-200">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-fcs-blue to-fcs-purple">
                                <i class="fas fa-calendar-alt text-white text-4xl"></i>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $event->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas fa-{{ $event->is_active ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                {{ $event->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <!-- Date Badge -->
                        <div class="absolute top-3 left-3">
                            <div class="bg-white bg-opacity-90 backdrop-blur-sm rounded-lg p-2 text-center">
                                <div class="text-fcs-primary font-bold text-sm">{{ $event->start_date->format('M') }}</div>
                                <div class="text-gray-900 font-bold text-lg leading-none">{{ $event->start_date->format('d') }}</div>
                            </div>
                        </div>

                        <!-- Time Indicator -->
                        @if($event->start_date->isToday())
                            <div class="absolute bottom-3 left-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500 text-white animate-pulse">
                                    <i class="fas fa-dot-circle mr-1"></i>Today
                                </span>
                            </div>
                        @elseif($event->start_date->isTomorrow())
                            <div class="absolute bottom-3 left-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-500 text-white">
                                    <i class="fas fa-clock mr-1"></i>Tomorrow
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Event Details -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $event->title }}</h3>

                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <!-- Date & Time -->
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt w-4 text-fcs-blue mr-2"></i>
                                <span>{{ $event->start_date->format('M d, Y') }}</span>
                            </div>

                            <!-- Location -->
                            @if($event->location)
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt w-4 text-fcs-green mr-2"></i>
                                    <span class="truncate">{{ $event->location }}</span>
                                </div>
                            @endif

                            <!-- Event Type -->
                            @if($event->type)
                                <div class="flex items-center">
                                    <i class="fas fa-tag w-4 text-fcs-purple mr-2"></i>
                                    <span class="truncate">{{ ucfirst($event->type) }}</span>
                                </div>
                            @endif
                        </div>

                        @if($event->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $event->description }}</p>
                        @endif

                        <!-- Meta Info -->
                        <div class="text-xs text-gray-500 mb-4 flex justify-between">
                            <span>Created: {{ $event->created_at->format('M d') }}</span>
                            <span>{{ $event->start_date->diffForHumans() }}</span>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.events.show', $event) }}"
                                   class="text-fcs-blue hover:text-fcs-light-blue text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <a href="{{ route('admin.events.edit', $event) }}"
                                   class="text-fcs-green hover:text-green-600 text-sm font-medium">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                            </div>

                            <div class="flex space-x-2">
                                <!-- Duplicate Event -->
                                <form action="{{ route('admin.events.duplicate', $event) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-600 hover:text-yellow-800 text-sm">
                                        <i class="fas fa-copy mr-1"></i>Copy
                                    </button>
                                </form>

                                <!-- Delete -->
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm"
                                            onclick="return confirm('Are you sure you want to delete this event?')">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            {{ $events->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-calendar-alt text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Events Found</h3>
            <p class="text-gray-600 mb-6">Get started by creating your first fellowship event.</p>
            <a href="{{ route('admin.events.create') }}"
               class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-6 py-3 rounded-lg font-semibold transition">
                <i class="fas fa-plus mr-2"></i>Create Your First Event
            </a>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
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
    </script>
@endsection
