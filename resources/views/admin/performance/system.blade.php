@extends('layouts.admin')

@section('title', 'System Performance')
@section('page-title', 'System Performance Dashboard')
@section('page-description', 'Comprehensive performance metrics and analytics')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-3"></i>
            <span class="text-sm font-medium text-gray-500">Performance</span>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-3"></i>
            <span class="text-sm font-medium text-gray-500">System</span>
        </div>
    </li>
@endsection

@section('page-actions')
    <div class="flex space-x-3">
        <select id="periodSelect" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue">
            <option value="7" {{ $period == 7 ? 'selected' : '' }}>Last 7 days</option>
            <option value="30" {{ $period == 30 ? 'selected' : '' }}>Last 30 days</option>
            <option value="90" {{ $period == 90 ? 'selected' : '' }}>Last 90 days</option>
        </select>
        <button onclick="refreshData()" class="bg-fcs-blue text-white px-4 py-2 rounded-lg hover:bg-fcs-light-blue transition-colors">
            <i class="fas fa-sync-alt mr-2"></i>Refresh
        </button>
    </div>
@endsection

@section('content')
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($metrics['user_metrics']['total_users']) }}</p>
                    <p class="text-sm text-green-600">+{{ $metrics['user_metrics']['new_users'] }} this period</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-naira-sign text-green-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-semibold text-gray-900">₦{{ number_format($metrics['payment_metrics']['total_revenue'], 2) }}</p>
                    <p class="text-sm text-green-600">₦{{ number_format($metrics['payment_metrics']['period_revenue'], 2) }} this period</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-purple-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Events</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($metrics['event_metrics']['total_events']) }}</p>
                    <p class="text-sm text-green-600">+{{ $metrics['event_metrics']['period_events'] }} this period</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-bell text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Notifications</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($metrics['notification_metrics']['total_notifications']) }}</p>
                    <p class="text-sm text-green-600">+{{ $metrics['notification_metrics']['period_notifications'] }} this period</p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Metrics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">User Growth</h3>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($metrics['user_metrics']['active_users']) }}</p>
                    <p class="text-sm text-gray-500">Active Users</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600">{{ number_format($metrics['user_metrics']['users_with_zones']) }}</p>
                    <p class="text-sm text-gray-500">Users with Zones</p>
                </div>
            </div>
            <!-- Chart placeholder -->
            <div class="h-32 bg-gray-100 rounded flex items-center justify-center">
                <p class="text-gray-500">User Growth Chart (Chart.js integration needed)</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Zone Distribution</h3>
            <div class="space-y-2">
                @foreach($metrics['user_metrics']['zone_distribution'] as $zone)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ $zone['zone'] }}</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $zone['count'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Payment Analytics -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Performance</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="text-center">
                <p class="text-xl font-bold text-green-600">{{ $metrics['payment_metrics']['success_rate'] }}%</p>
                <p class="text-sm text-gray-500">Success Rate</p>
            </div>
            <div class="text-center">
                <p class="text-xl font-bold text-blue-600">{{ number_format($metrics['payment_metrics']['successful_payments']) }}</p>
                <p class="text-sm text-gray-500">Successful</p>
            </div>
            <div class="text-center">
                <p class="text-xl font-bold text-red-600">{{ number_format($metrics['payment_metrics']['failed_payments']) }}</p>
                <p class="text-sm text-gray-500">Failed</p>
            </div>
            <div class="text-center">
                <p class="text-xl font-bold text-yellow-600">{{ number_format($metrics['payment_metrics']['pending_payments']) }}</p>
                <p class="text-sm text-gray-500">Pending</p>
            </div>
        </div>

        <!-- Payment Categories -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($metrics['payment_metrics']['category_breakdown'] as $category)
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-lg font-semibold text-gray-900">{{ ucfirst($category['category']) }}</p>
                    <p class="text-sm text-gray-600">{{ $category['count'] }} payments</p>
                    <p class="text-sm text-green-600">₦{{ number_format($category['total'], 2) }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Event & Notification Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Analytics</h3>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="text-center">
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($metrics['event_metrics']['upcoming_events']) }}</p>
                    <p class="text-sm text-gray-500">Upcoming Events</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($metrics['event_metrics']['national_events']) }}</p>
                    <p class="text-sm text-gray-500">National Events</p>
                </div>
            </div>
            <div class="text-center">
                <p class="text-xl font-semibold text-green-600">{{ number_format($metrics['event_metrics']['zone_events']) }}</p>
                <p class="text-sm text-gray-500">Zone Events</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Statistics</h3>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="text-center">
                    <p class="text-2xl font-bold text-yellow-600">{{ number_format($metrics['notification_metrics']['unread_notifications']) }}</p>
                    <p class="text-sm text-gray-500">Unread</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600">{{ number_format($metrics['notification_metrics']['emails_sent']) }}</p>
                    <p class="text-sm text-gray-500">Emails Sent</p>
                </div>
            </div>

            <!-- Notification by Type -->
            <div class="space-y-2">
                @foreach($metrics['notification_metrics']['notifications_by_type'] as $type)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $type['type'])) }}</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $type['count'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function refreshData() {
        const period = document.getElementById('periodSelect').value;
        window.location.href = `{{ route('admin.performance.system') }}?period=${period}`;
    }

    document.getElementById('periodSelect').addEventListener('change', refreshData);
</script>
@endpush
