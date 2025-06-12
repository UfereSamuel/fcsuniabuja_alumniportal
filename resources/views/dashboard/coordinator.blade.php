<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Dashboard - FCS Alumni Portal</title>
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
            background: linear-gradient(135deg, var(--fcs-gold) 0%, var(--fcs-secondary) 100%);
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
                        <h1 class="text-3xl font-bold">{{ $class ? $class->full_name : 'Class' }} Coordinator</h1>
                        <p class="text-orange-100 mt-1">
                            Welcome back, {{ Auth::user()->name }}! Manage your class activities and members.
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-users-cog text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Class Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="fcs-primary text-white p-3 rounded-lg">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Class Members</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['class_members'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="fcs-green text-white p-3 rounded-lg">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Class Activities</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['class_activities'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="fcs-gold text-white p-3 rounded-lg">
                            <i class="fas fa-calendar-check text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Upcoming Events</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['class_events'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="fcs-secondary text-white p-3 rounded-lg">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Class Documents</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['class_documents'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Coordinator Actions</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="#" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <i class="fas fa-calendar-plus text-fcs-primary text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-700">Create Activity</span>
                    </a>
                    <a href="#" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                        <i class="fas fa-user-plus text-fcs-green text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-700">Invite Members</span>
                    </a>
                    <a href="#" class="flex flex-col items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                        <i class="fas fa-envelope text-fcs-gold text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-700">Send Message</span>
                    </a>
                    <a href="#" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                        <i class="fas fa-chart-bar text-fcs-purple text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-700">View Reports</span>
                    </a>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Class Members -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">
                            @if($class)
                                {{ $class->name }} Members
                            @else
                                Class Members
                            @endif
                        </h3>
                        <a href="#" class="text-fcs-primary hover:underline text-sm">Manage All</a>
                    </div>

                    @forelse($classMembers as $member)
                    <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 bg-fcs-primary rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">{{ substr($member->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $member->name }}</p>
                            <p class="text-sm text-gray-500">{{ $member->email }}</p>
                        </div>
                        <div class="flex space-x-2">
                            @if($member->phone)
                                <a href="tel:{{ $member->phone }}" class="text-fcs-green hover:text-green-700">
                                    <i class="fas fa-phone text-sm"></i>
                                </a>
                            @endif
                            <a href="mailto:{{ $member->email }}" class="text-fcs-primary hover:text-blue-700">
                                <i class="fas fa-envelope text-sm"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No class members found</p>
                    </div>
                    @endforelse
                </div>

                <!-- Recent Class Activities -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Class Activities</h3>
                        <a href="#" class="text-fcs-primary hover:underline text-sm">View All</a>
                    </div>

                    @forelse($recentClassActivities as $activity)
                    <div class="border-l-4 border-fcs-gold pl-4 mb-4 last:mb-0">
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
                            <div class="flex space-x-2">
                                <button class="text-fcs-primary hover:text-blue-700">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <button class="text-fcs-secondary hover:text-red-700">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-alt text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No recent activities</p>
                        <button class="mt-4 text-fcs-primary hover:underline text-sm">Create First Activity</button>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Events -->
            @if($upcomingEvents->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Upcoming Class Events</h3>
                    <a href="#" class="text-fcs-primary hover:underline text-sm">Manage Events</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($upcomingEvents as $event)
                    <div class="card-hover bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <span class="text-xs bg-fcs-green text-white px-2 py-1 rounded-full">
                                Event
                            </span>
                            <span class="text-xs text-gray-500 ml-auto">
                                {{ $event->start_date->format('M d, Y') }}
                            </span>
                        </div>
                        <h4 class="font-medium text-gray-900 mb-2">{{ $event->title }}</h4>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($event->description, 80) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-users mr-1"></i>{{ $event->rsvps_count ?? 0 }} RSVPs
                            </span>
                            <div class="flex space-x-2">
                                <button class="text-fcs-primary hover:text-blue-700">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <button class="text-fcs-secondary hover:text-red-700">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Class Information -->
            @if($class)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Class Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">{{ $class->full_name }}</h4>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p><strong>Graduation Year:</strong> {{ $class->graduation_year }}</p>
                            <p><strong>Slogan:</strong> "{{ $class->slogan }}"</p>
                            @if($class->coordinator_id)
                                <p><strong>Coordinator:</strong> {{ $class->coordinator->name ?? 'You' }}</p>
                            @endif
                            @if($class->deputy_coordinator_id)
                                <p><strong>Deputy:</strong> {{ $class->deputyCoordinator->name ?? 'Not Set' }}</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Quick Links</h4>
                        <div class="space-y-2">
                            @if($class->whatsapp_link)
                                <a href="{{ $class->whatsapp_link }}" target="_blank" class="flex items-center text-sm text-fcs-green hover:underline">
                                    <i class="fab fa-whatsapp mr-2"></i>Class WhatsApp Group
                                </a>
                            @endif
                            <a href="#" class="flex items-center text-sm text-fcs-primary hover:underline">
                                <i class="fas fa-cog mr-2"></i>Manage Class Settings
                            </a>
                            <a href="#" class="flex items-center text-sm text-fcs-purple hover:underline">
                                <i class="fas fa-chart-line mr-2"></i>Class Analytics
                            </a>
                        </div>
                    </div>
                </div>

                @if($class->description)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="font-medium text-gray-900 mb-2">About Our Class</h4>
                    <p class="text-sm text-gray-600">{{ $class->description }}</p>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
