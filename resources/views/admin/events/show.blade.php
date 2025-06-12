<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->title }} - FCS Admin Panel</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'fcs-blue': '#1e40af',
                        'fcs-red': '#dc2626',
                        'fcs-green': '#059669',
                        'fcs-light-blue': '#3b82f6',
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                        <img src="{{ asset('images/logos/fcslogo.png') }}" alt="FCS Logo" class="w-10 h-10 mr-3">
                        <div>
                            <h1 class="text-lg font-bold text-gray-900">FCS Admin Panel</h1>
                            <p class="text-xs text-gray-500">Event Details</p>
                        </div>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.events.edit', $event) }}" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-edit mr-1"></i>Edit Event
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Events
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Event Header -->
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <!-- Event Image -->
                    @if($event->image)
                        <div class="w-full h-64 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $event->image) }}')"></div>
                    @else
                        <div class="w-full h-64 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-6xl"></i>
                        </div>
                    @endif

                    <div class="p-6">
                        <!-- Event Title and Status -->
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $event->title }}</h1>
                                <div class="flex items-center space-x-3">
                                    <!-- Event Type Badge -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @switch($event->event_type)
                                            @case('conference') bg-purple-100 text-purple-800 @break
                                            @case('seminar') bg-blue-100 text-blue-800 @break
                                            @case('workshop') bg-green-100 text-green-800 @break
                                            @case('social') bg-yellow-100 text-yellow-800 @break
                                            @case('spiritual') bg-indigo-100 text-indigo-800 @break
                                            @case('community') bg-pink-100 text-pink-800 @break
                                            @default bg-gray-100 text-gray-800
                                        @endswitch">
                                        {{ ucfirst($event->event_type) }}
                                    </span>

                                    <!-- Status Badge -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $event->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $event->is_active ? 'Active' : 'Inactive' }}
                                    </span>

                                    <!-- Date Status Badge -->
                                    @if($event->event_date)
                                        @if($event->event_date->isFuture())
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                Upcoming
                                            </span>
                                        @elseif($event->event_date->isToday())
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                                Today
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                Completed
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Event Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Date & Time -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Date & Time</h3>
                                <div class="space-y-2">
                                    @if($event->event_date)
                                        <div class="flex items-center text-gray-900">
                                            <i class="fas fa-calendar-alt mr-3 text-blue-500"></i>
                                            <span class="font-medium">{{ $event->event_date->format('l, F j, Y') }}</span>
                                        </div>
                                    @endif

                                    @if($event->event_time)
                                        <div class="flex items-center text-gray-900">
                                            <i class="fas fa-clock mr-3 text-green-500"></i>
                                            <span>{{ $event->event_time->format('g:i A') }}</span>
                                            @if($event->duration)
                                                <span class="text-gray-500 ml-2">({{ $event->duration }} hour{{ $event->duration != 1 ? 's' : '' }})</span>
                                            @endif
                                        </div>
                                    @endif

                                    @if($event->event_date && $event->event_date->isFuture())
                                        <div class="flex items-center text-blue-600">
                                            <i class="fas fa-hourglass-half mr-3"></i>
                                            <span class="text-sm">{{ $event->event_date->diffForHumans() }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Location & Capacity -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Location & Capacity</h3>
                                <div class="space-y-2">
                                    @if($event->location)
                                        <div class="flex items-center text-gray-900">
                                            <i class="fas fa-map-marker-alt mr-3 text-red-500"></i>
                                            <span>{{ $event->location }}</span>
                                        </div>
                                    @endif

                                    @if($event->max_attendees)
                                        <div class="flex items-center text-gray-900">
                                            <i class="fas fa-users mr-3 text-purple-500"></i>
                                            <span>Maximum {{ number_format($event->max_attendees) }} attendees</span>
                                        </div>
                                    @else
                                        <div class="flex items-center text-gray-900">
                                            <i class="fas fa-infinity mr-3 text-purple-500"></i>
                                            <span>Unlimited attendees</span>
                                        </div>
                                    @endif

                                    @if($event->registration_required)
                                        <div class="flex items-center text-amber-600">
                                            <i class="fas fa-clipboard-check mr-3"></i>
                                            <span>Registration required</span>
                                        </div>
                                        @if($event->registration_deadline)
                                            <div class="flex items-center text-gray-600 ml-6">
                                                <i class="fas fa-calendar-times mr-3"></i>
                                                <span class="text-sm">Deadline: {{ $event->registration_deadline->format('M j, Y') }}</span>
                                            </div>
                                        @endif
                                    @else
                                        <div class="flex items-center text-green-600">
                                            <i class="fas fa-door-open mr-3"></i>
                                            <span>Open to all</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Target Class -->
                        @if($event->class_id && $event->class)
                            <div class="mb-6">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Target Audience</h3>
                                <div class="flex items-center text-gray-900">
                                    <i class="fas fa-graduation-cap mr-3 text-indigo-500"></i>
                                    <span>{{ $event->class->name }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Description -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Event Description</h3>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Timeline -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-history mr-2"></i>Event Timeline
                    </h3>
                    <div class="space-y-4">
                        <!-- Created -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-plus text-blue-600 text-sm"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Event Created</p>
                                <p class="text-sm text-gray-500">{{ $event->created_at->format('M j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>

                        <!-- Last Updated -->
                        @if($event->updated_at->gt($event->created_at))
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-edit text-yellow-600 text-sm"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                    <p class="text-sm text-gray-500">{{ $event->updated_at->format('M j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Registration Deadline -->
                        @if($event->registration_deadline)
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-amber-600 text-sm"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Registration Deadline</p>
                                    <p class="text-sm text-gray-500">{{ $event->registration_deadline->format('M j, Y') }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Event Date -->
                        @if($event->event_date)
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 {{ $event->event_date->isFuture() ? 'bg-green-100' : 'bg-gray-100' }} rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar-day {{ $event->event_date->isFuture() ? 'text-green-600' : 'text-gray-600' }} text-sm"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Event Date</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $event->event_date->format('M j, Y') }}
                                        @if($event->event_time)
                                            at {{ $event->event_time->format('g:i A') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-cogs mr-2"></i>Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.events.edit', $event) }}"
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i>Edit Event
                        </a>

                        <form action="{{ route('admin.events.toggle-status', $event) }}" method="POST" class="w-full">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full {{ $event->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center">
                                <i class="fas fa-{{ $event->is_active ? 'pause' : 'play' }} mr-2"></i>
                                {{ $event->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <button onclick="copyEventLink()" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center">
                            <i class="fas fa-link mr-2"></i>Copy Link
                        </button>

                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center">
                                <i class="fas fa-trash mr-2"></i>Delete Event
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Event Statistics -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-chart-bar mr-2"></i>Event Statistics
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Views</span>
                            <span class="font-semibold text-gray-900">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Registrations</span>
                            <span class="font-semibold text-gray-900">0</span>
                        </div>
                        @if($event->max_attendees)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Capacity</span>
                                <span class="font-semibold text-gray-900">{{ number_format($event->max_attendees) }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                            </div>
                            <p class="text-xs text-gray-500 text-center">0% capacity filled</p>
                        @endif
                    </div>
                </div>

                <!-- Event Details -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-info-circle mr-2"></i>Event Information
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Event ID</span>
                            <span class="font-mono text-gray-900">#{{ $event->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Created</span>
                            <span class="text-gray-900">{{ $event->created_at->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Updated</span>
                            <span class="text-gray-900">{{ $event->updated_at->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status</span>
                            <span class="font-medium {{ $event->is_active ? 'text-green-600' : 'text-red-600' }}">
                                {{ $event->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        @if($event->class_id && $event->class)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Target Class</span>
                                <span class="text-gray-900">{{ $event->class->name }}</span>
                            </div>
                        @endif
                        @if($event->duration)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration</span>
                                <span class="text-gray-900">{{ $event->duration }} hour{{ $event->duration != 1 ? 's' : '' }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Related Events -->
                @if($relatedEvents->count() > 0)
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-calendar-plus mr-2"></i>Related Events
                        </h3>
                        <div class="space-y-3">
                            @foreach($relatedEvents as $relatedEvent)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('admin.events.show', $relatedEvent) }}"
                                           class="text-sm font-medium text-blue-600 hover:text-blue-700 truncate">
                                            {{ $relatedEvent->title }}
                                        </a>
                                        <p class="text-xs text-gray-500">{{ $relatedEvent->event_date?->format('M j') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript for interactions -->
    <script>
        function copyEventLink() {
            // Create a temporary input element
            const tempInput = document.createElement('input');
            tempInput.value = window.location.href;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

            // Show feedback
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check mr-2"></i>Copied!';
            button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
            button.classList.add('bg-green-600');

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('bg-green-600');
                button.classList.add('bg-gray-600', 'hover:bg-gray-700');
            }, 2000);
        }
    </script>
</body>
</html>
