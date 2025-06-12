<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard - FCS Alumni Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --fcs-primary: #1e40af;
            --fcs-secondary: #dc2626;
            --fcs-gold: #f59e0b;
            --fcs-green: #059669;
            --fcs-purple: #7c3aed;
        }

        .fcs-primary { background: var(--fcs-primary); }
        .fcs-secondary { background: var(--fcs-secondary); }
        .fcs-gold { background: var(--fcs-gold); }
        .fcs-green { background: var(--fcs-green); }
        .fcs-purple { background: var(--fcs-purple); }

        .text-fcs-primary { color: var(--fcs-primary); }
        .text-fcs-secondary { color: var(--fcs-secondary); }
        .text-fcs-gold { color: var(--fcs-gold); }
        .text-fcs-green { color: var(--fcs-green); }
        .text-fcs-purple { color: var(--fcs-purple); }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.3);
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--fcs-primary) 0%, var(--fcs-purple) 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    @include('dashboard.partials.member-nav')

    <!-- Main Content -->
    <div class="pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Welcome Section -->
            <div class="gradient-bg rounded-lg p-6 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Welcome back, {{ Auth::user()->name }}!</h1>
                        <p class="text-blue-100 mt-1">
                            @if($class)
                                {{ $class->full_name }} • Member since {{ Auth::user()->created_at->format('M Y') }}
                            @else
                                FCS Alumni Member since {{ Auth::user()->created_at->format('M Y') }}
                            @endif
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-hands-praying text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="fcs-primary text-white p-3 rounded-lg">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">My Class</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['my_class_members'] }}</p>
                            <p class="text-xs text-gray-500">members</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="fcs-green text-white p-3 rounded-lg">
                            <i class="fas fa-calendar text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Upcoming</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['upcoming_activities'] }}</p>
                            <p class="text-xs text-gray-500">activities</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="fcs-gold text-white p-3 rounded-lg">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">My RSVPs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['my_events_rsvp'] }}</p>
                            <p class="text-xs text-gray-500">events</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="fcs-secondary text-white p-3 rounded-lg">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Resources</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['documents_available'] }}</p>
                            <p class="text-xs text-gray-500">documents</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Upcoming Activities -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Upcoming Activities</h3>
                        <a href="#" class="text-fcs-primary hover:underline text-sm">View All</a>
                    </div>

                    @forelse($upcomingActivities as $activity)
                    <div class="border-l-4 border-fcs-primary pl-4 mb-4 last:mb-0">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $activity->title }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($activity->description, 80) }}</p>
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-2"></i>
                                    {{ $activity->activity_date->format('M d, Y') }}
                                    @if($activity->location)
                                        <i class="fas fa-map-marker-alt ml-4 mr-2"></i>
                                        {{ $activity->location }}
                                    @endif
                                </div>
                            </div>
                            <span class="text-xs bg-fcs-gold text-white px-2 py-1 rounded-full">
                                {{ ucfirst($activity->type) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-alt text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No upcoming activities</p>
                    </div>
                    @endforelse
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="#" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <div class="fcs-primary text-white p-2 rounded-lg mr-3">
                                <i class="fas fa-pray"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Submit Prayer Request</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <div class="fcs-green text-white p-2 rounded-lg mr-3">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Create Event</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                            <div class="fcs-gold text-white p-2 rounded-lg mr-3">
                                <i class="fas fa-file-upload"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Upload Document</span>
                        </a>
                        @if($class && $class->whatsapp_link)
                        <a href="{{ $class->whatsapp_link }}" target="_blank" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <div class="fcs-green text-white p-2 rounded-lg mr-3">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Join Class WhatsApp</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Additional Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- My Classmates -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">
                            @if($class)
                                {{ $class->name }} Classmates
                            @else
                                FCS Members
                            @endif
                        </h3>
                        <a href="#" class="text-fcs-primary hover:underline text-sm">View All</a>
                    </div>

                    @forelse($classmates as $classmate)
                    <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 bg-fcs-primary rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">{{ substr($classmate->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $classmate->name }}</p>
                            <p class="text-sm text-gray-500">{{ $classmate->occupation ?: 'Alumni Member' }}</p>
                        </div>
                        @if($classmate->role === 'coordinator')
                            <span class="text-xs text-fcs-gold bg-yellow-100 px-2 py-1 rounded-full">Coordinator</span>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No classmates found</p>
                    </div>
                    @endforelse
                </div>

                <!-- Prayer Requests -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Prayer Requests</h3>
                        <a href="#" class="text-fcs-primary hover:underline text-sm">View All</a>
                    </div>

                    @forelse($activePrayerRequests as $request)
                    <div class="border-l-4 border-fcs-green pl-4 mb-4 last:mb-0">
                        <p class="font-medium text-gray-900">{{ $request->title }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($request->description, 80) }}</p>
                        <p class="text-xs text-gray-500 mt-2">{{ $request->created_at->diffForHumans() }}</p>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-pray text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No active prayer requests</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activities -->
            @if($recentActivities->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Activities</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($recentActivities as $activity)
                    <div class="card-hover bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <span class="text-xs bg-fcs-secondary text-white px-2 py-1 rounded-full">
                                {{ ucfirst($activity->type) }}
                            </span>
                            <span class="text-xs text-gray-500 ml-auto">
                                {{ $activity->activity_date->format('M d') }}
                            </span>
                        </div>
                        <h4 class="font-medium text-gray-900 mb-2">{{ $activity->title }}</h4>
                        <p class="text-sm text-gray-600">{{ Str::limit($activity->description, 100) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
