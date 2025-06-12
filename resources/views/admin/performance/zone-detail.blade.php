@extends('layouts.admin')

@section('title', $zone->name . ' Performance')
@section('page-title', $zone->name . ' Performance')
@section('page-description', 'Detailed performance metrics for ' . $zone->name . ' zone')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-3"></i>
            <a href="{{ route('admin.performance.system') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Performance</a>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-3"></i>
            <a href="{{ route('admin.performance.zones') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Zones</a>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-3"></i>
            <span class="text-sm font-medium text-gray-500">{{ $zone->name }}</span>
        </div>
    </li>
@endsection

@section('page-actions')
    <div class="flex space-x-3">
        <a href="{{ route('admin.performance.zones') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Zones
        </a>
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
    <!-- Zone Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-globe-africa text-white text-2xl"></i>
                </div>
            </div>
            <div class="ml-6">
                <h2 class="text-2xl font-bold text-gray-900">{{ $zone->name }}</h2>
                <p class="text-sm text-gray-600">{{ $zone->country }}{{ $zone->state ? ', ' . $zone->state : '' }}</p>
                @if($zone->description)
                    <p class="text-sm text-gray-500 mt-1">{{ $zone->description }}</p>
                @endif
            </div>
            <div class="ml-auto">
                <div class="text-right">
                    <p class="text-sm text-gray-500">Status</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $zone->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $zone->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Members</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($metrics['member_metrics']['total_members']) }}</p>
                    <p class="text-sm text-green-600">+{{ $metrics['member_metrics']['new_members'] }} this period</p>
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
                        <i class="fas fa-chart-line text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Payment Participation</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $metrics['engagement_metrics']['payment_participation'] }}%</p>
                    <p class="text-sm text-gray-600">{{ $metrics['engagement_metrics']['notification_read_rate'] }}% read rate</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Member Growth -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Member Metrics</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Members</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format($metrics['member_metrics']['total_members']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">New Members ({{ $period }} days)</span>
                    <span class="text-sm font-semibold text-green-600">+{{ number_format($metrics['member_metrics']['new_members']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Executives</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format($metrics['member_metrics']['executives_count']) }}</span>
                </div>
            </div>

            @if(count($metrics['member_metrics']['role_distribution']) > 0)
                <div class="mt-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Role Distribution</h4>
                    <div class="space-y-2">
                        @foreach($metrics['member_metrics']['role_distribution'] as $role)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ $role['role'] }}</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $role['count'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Payment Analytics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Performance</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Revenue</span>
                    <span class="text-sm font-semibold text-gray-900">₦{{ number_format($metrics['payment_metrics']['total_revenue'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Period Revenue</span>
                    <span class="text-sm font-semibold text-green-600">₦{{ number_format($metrics['payment_metrics']['period_revenue'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Success Rate</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $metrics['payment_metrics']['success_rate'] }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Average Payment</span>
                    <span class="text-sm font-semibold text-gray-900">₦{{ number_format($metrics['payment_metrics']['average_payment'], 2) }}</span>
                </div>
            </div>

            @if(count($metrics['payment_metrics']['category_breakdown']) > 0)
                <div class="mt-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Payment Categories</h4>
                    <div class="space-y-2">
                        @foreach($metrics['payment_metrics']['category_breakdown'] as $category)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ ucfirst($category['category']) }}</span>
                                <span class="text-sm font-semibold text-gray-900">₦{{ number_format($category['total'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Event & Engagement Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Event Metrics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Analytics</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Events</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format($metrics['event_metrics']['total_events']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Events This Period</span>
                    <span class="text-sm font-semibold text-green-600">+{{ number_format($metrics['event_metrics']['period_events']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Upcoming Events</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format($metrics['event_metrics']['upcoming_events']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Public Events</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format($metrics['event_metrics']['public_events']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Private Events</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format($metrics['event_metrics']['private_events']) }}</span>
                </div>
            </div>

            @if(count($metrics['event_metrics']['events_by_type']) > 0)
                <div class="mt-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Events by Type</h4>
                    <div class="space-y-2">
                        @foreach($metrics['event_metrics']['events_by_type'] as $type)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ ucfirst($type['type']) }}</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $type['count'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Engagement Metrics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Engagement Metrics</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Notifications Received</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format($metrics['engagement_metrics']['notifications_received']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Notification Read Rate</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $metrics['engagement_metrics']['notification_read_rate'] }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Payment Participation</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $metrics['engagement_metrics']['payment_participation'] }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Event Creation Rate</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $metrics['engagement_metrics']['event_creation_rate'] }}</span>
                </div>
            </div>

            <!-- Engagement Progress Bars -->
            <div class="mt-6 space-y-3">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Payment Participation</span>
                        <span class="font-semibold">{{ $metrics['engagement_metrics']['payment_participation'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $metrics['engagement_metrics']['payment_participation'] }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Notification Read Rate</span>
                        <span class="font-semibold">{{ $metrics['engagement_metrics']['notification_read_rate'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $metrics['engagement_metrics']['notification_read_rate'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.zones.members', $zone->id) }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Manage Members</p>
                    <p class="text-sm text-gray-500">View and manage zone members</p>
                </div>
            </a>

            <a href="{{ route('admin.notifications.send') }}?zone_id={{ $zone->id }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-paper-plane text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Send Notification</p>
                    <p class="text-sm text-gray-500">Notify zone members</p>
                </div>
            </a>

            <a href="{{ route('admin.zones.show', $zone->id) }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-cog text-green-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Zone Settings</p>
                    <p class="text-sm text-gray-500">Configure zone details</p>
                </div>
            </a>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function refreshData() {
        const period = document.getElementById('periodSelect').value;
        window.location.href = `{{ route('admin.performance.zone-detail', $zone->id) }}?period=${period}`;
    }

    document.getElementById('periodSelect').addEventListener('change', refreshData);
</script>
@endpush
