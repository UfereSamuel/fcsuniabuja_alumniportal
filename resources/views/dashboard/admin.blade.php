<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FCS Alumni Portal</title>
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
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    @include('dashboard.partials.admin-nav')

    <!-- Main Content -->
    <div class="pt-16 flex">
        <!-- Sidebar -->
        @include('dashboard.partials.admin-sidebar')

        <!-- Content Area -->
        <main class="flex-1 ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                <p class="text-gray-600 mt-1">Welcome back! Here's what's happening with your alumni portal.</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="fcs-primary text-white p-3 rounded-lg">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Members</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_members']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="fcs-green text-white p-3 rounded-lg">
                            <i class="fas fa-graduation-cap text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Active Classes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_classes'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="fcs-gold text-white p-3 rounded-lg">
                            <i class="fas fa-calendar-alt text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Activities</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_activities'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="fcs-secondary text-white p-3 rounded-lg">
                            <i class="fas fa-user-plus text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">New This Month</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['new_members_this_month'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="#" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                                <i class="fas fa-user-plus text-fcs-primary text-2xl mb-2"></i>
                                <span class="text-sm font-medium text-gray-700">Add Member</span>
                            </a>
                            <a href="#" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                                <i class="fas fa-calendar-plus text-fcs-green text-2xl mb-2"></i>
                                <span class="text-sm font-medium text-gray-700">Create Activity</span>
                            </a>
                            <a href="#" class="flex flex-col items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                                <i class="fas fa-users-cog text-fcs-gold text-2xl mb-2"></i>
                                <span class="text-sm font-medium text-gray-700">Manage Executives</span>
                            </a>
                            <a href="#" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                                <i class="fas fa-cog text-fcs-purple text-2xl mb-2"></i>
                                <span class="text-sm font-medium text-gray-700">Settings</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pending Actions</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-orange-500 mr-3"></i>
                                <span class="text-sm font-medium">Documents</span>
                            </div>
                            <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-full">{{ $stats['pending_documents'] }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-pray text-blue-500 mr-3"></i>
                                <span class="text-sm font-medium">Prayer Requests</span>
                            </div>
                            <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">{{ $stats['active_prayer_requests'] }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-green-500 mr-3"></i>
                                <span class="text-sm font-medium">Upcoming Events</span>
                            </div>
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">{{ $stats['upcoming_events'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Members and Activities -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Members</h3>
                        <a href="#" class="text-fcs-primary hover:underline text-sm">View All</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentMembers as $member)
                        <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-fcs-primary rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold">{{ substr($member->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $member->name }}</p>
                                <p class="text-sm text-gray-500">{{ $member->class->name ?? 'No Class' }} • {{ $member->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="text-xs text-fcs-green bg-green-100 px-2 py-1 rounded-full">{{ ucfirst($member->role) }}</span>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center py-4">No recent members</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
                        <a href="#" class="text-fcs-primary hover:underline text-sm">View All</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentActivities as $activity)
                        <div class="p-3 hover:bg-gray-50 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $activity->title }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($activity->description, 60) }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $activity->activity_date->format('M d, Y') }}</p>
                                </div>
                                <span class="text-xs bg-fcs-gold text-white px-2 py-1 rounded-full">{{ ucfirst($activity->type) }}</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center py-4">No recent activities</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Class Distribution -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Class Distribution</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($classDistribution as $class)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $class->name }}</p>
                                <p class="text-sm text-gray-500">{{ $class->graduation_year }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-fcs-primary">{{ $class->members_count }}</p>
                                <p class="text-xs text-gray-500">members</p>
                            </div>
                        </div>
                        @if($class->members_count > 0)
                        <div class="mt-3 bg-gray-200 rounded-full h-2">
                            <div class="fcs-primary h-2 rounded-full" style="width: {{ $stats['total_members'] > 0 ? ($class->members_count / $stats['total_members']) * 100 : 0 }}%"></div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Add any JavaScript for interactive features
        document.addEventListener('DOMContentLoaded', function() {
            // You can add chart.js or other interactive features here
        });
    </script>
</body>
</html>
