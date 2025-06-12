<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $activity->title }} - FCS Admin Panel</title>

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
                            <p class="text-xs text-gray-500">Activity Details</p>
                        </div>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.activities.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Activities
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
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

        <!-- Header -->
        <div class="mb-6 flex justify-between items-start">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $activity->title }}</h1>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $activity->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $activity->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <p class="text-gray-600">Activity details and management options</p>
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('admin.activities.edit', $activity) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('admin.activities.toggle-status', $activity) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-{{ $activity->is_active ? 'yellow' : 'green' }}-600 hover:bg-{{ $activity->is_active ? 'yellow' : 'green' }}-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-{{ $activity->is_active ? 'pause' : 'play' }} mr-2"></i>
                        {{ $activity->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
                <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" class="inline"
                      onsubmit="return confirm('Are you sure you want to delete this activity? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-trash mr-2"></i>Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Activity Image -->
                @if($activity->image)
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}"
                             class="w-full h-64 object-cover">
                    </div>
                @endif

                <!-- Description -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Description</h2>
                    </div>
                    <div class="p-6">
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($activity->description)) !!}
                        </div>
                    </div>
                </div>

                <!-- Activity Timeline -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Activity Timeline</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-plus text-blue-600 text-sm"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Activity Created</p>
                                    <p class="text-xs text-gray-500">{{ $activity->created_at->format('F j, Y \a\t g:i A') }}</p>
                                    @if($activity->creator)
                                        <p class="text-xs text-gray-500">by {{ $activity->creator->name }}</p>
                                    @endif
                                </div>
                            </div>

                            @if($activity->updated_at->ne($activity->created_at))
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-edit text-yellow-600 text-sm"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                        <p class="text-xs text-gray-500">{{ $activity->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-{{ $activity->activity_date->isPast() ? 'gray' : 'green' }}-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-calendar text-{{ $activity->activity_date->isPast() ? 'gray' : 'green' }}-600 text-sm"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $activity->activity_date->isPast() ? 'Activity Completed' : 'Scheduled Date' }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $activity->activity_date->format('F j, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $activity->activity_date->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Activity Details -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Activity Details</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Date -->
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Date</p>
                                <p class="text-sm text-gray-600">{{ $activity->activity_date->format('F j, Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $activity->activity_date->format('l') }}</p>
                            </div>
                        </div>

                        <!-- Location -->
                        @if($activity->location)
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Location</p>
                                    <p class="text-sm text-gray-600">{{ $activity->location }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Target Class -->
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-users text-gray-400"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Target Audience</p>
                                <p class="text-sm text-gray-600">
                                    @if($activity->class)
                                        {{ $activity->class->name }}
                                    @else
                                        All Classes (General Activity)
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-{{ $activity->is_active ? 'check-circle' : 'pause-circle' }} text-gray-400"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Status</p>
                                <p class="text-sm text-gray-600">
                                    {{ $activity->is_active ? 'Active & Visible' : 'Inactive & Hidden' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Management Actions -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Quick Actions</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.activities.edit', $activity) }}"
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i>Edit Activity
                        </a>

                        <form action="{{ route('admin.activities.toggle-status', $activity) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full bg-{{ $activity->is_active ? 'yellow' : 'green' }}-600 hover:bg-{{ $activity->is_active ? 'yellow' : 'green' }}-700 text-white px-4 py-2 rounded-lg font-medium transition">
                                <i class="fas fa-{{ $activity->is_active ? 'pause' : 'play' }} mr-2"></i>
                                {{ $activity->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <a href="{{ route('admin.activities.create') }}"
                           class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center">
                            <i class="fas fa-plus mr-2"></i>Create New Activity
                        </a>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                    <h3 class="text-lg font-semibold mb-4">Activity Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span>Days Since Created:</span>
                            <span class="font-semibold">{{ $activity->created_at->diffInDays() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Days Until/Since Event:</span>
                            <span class="font-semibold">{{ abs($activity->activity_date->diffInDays()) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Status:</span>
                            <span class="font-semibold">{{ $activity->activity_date->isPast() ? 'Completed' : 'Upcoming' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
