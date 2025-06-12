@extends('layouts.admin')

@section('title', 'Zones Performance')
@section('page-title', 'Zones Performance Overview')
@section('page-description', 'Performance metrics and analytics for all zones')

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
            <span class="text-sm font-medium text-gray-500">Zones</span>
        </div>
    </li>
@endsection

@section('page-actions')
    <div class="flex space-x-3">
        <a href="{{ route('admin.performance.system') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-chart-line mr-2"></i>System Metrics
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
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-globe-africa text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Zones</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $metrics['summary']['total_zones'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-green-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Members</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($metrics['summary']['total_members']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-naira-sign text-purple-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-semibold text-gray-900">₦{{ number_format($metrics['summary']['total_revenue'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Events</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($metrics['summary']['total_events']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performers -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Most Active Zone -->
        @if($metrics['summary']['most_active_zone'])
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Most Active Zone</h3>
            <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-trophy text-white"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h4 class="text-lg font-semibold text-gray-900">{{ $metrics['summary']['most_active_zone']['zone']['name'] ?? 'Unknown' }}</h4>
                    <p class="text-sm text-gray-600">{{ $metrics['summary']['most_active_zone']['events_count'] }} events created</p>
                    <p class="text-sm text-gray-600">{{ $metrics['summary']['most_active_zone']['members_count'] }} members</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Highest Revenue Zone -->
        @if($metrics['summary']['highest_revenue_zone'])
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Highest Revenue Zone</h3>
            <div class="flex items-center p-4 bg-green-50 rounded-lg">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-naira-sign text-white"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h4 class="text-lg font-semibold text-gray-900">{{ $metrics['summary']['highest_revenue_zone']['zone']['name'] ?? 'Unknown' }}</h4>
                    <p class="text-sm text-gray-600">₦{{ number_format($metrics['summary']['highest_revenue_zone']['total_payments'], 2) }} revenue</p>
                    <p class="text-sm text-gray-600">{{ $metrics['summary']['highest_revenue_zone']['payment_count'] }} payments</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Zones Performance Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Zone Performance Breakdown</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Zone
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Members
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            New Members
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Revenue
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Events
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Notifications
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($metrics['zones'] as $zoneMetric)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-globe-africa text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $zoneMetric['zone']['name'] }}</div>
                                        <div class="text-sm text-gray-500">{{ $zoneMetric['zone']['country'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($zoneMetric['members_count']) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    +{{ number_format($zoneMetric['new_members']) }}
                                    @if($zoneMetric['new_members'] > 0)
                                        <i class="fas fa-arrow-up text-green-500 ml-1"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">₦{{ number_format($zoneMetric['total_payments'], 2) }}</div>
                                <div class="text-sm text-gray-500">{{ $zoneMetric['payment_count'] }} payments</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($zoneMetric['events_count']) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($zoneMetric['notifications_sent']) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.performance.zone-detail', $zoneMetric['zone']['id']) }}"
                                   class="text-fcs-blue hover:text-fcs-light-blue">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-globe-africa text-gray-300 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No zones found</h3>
                                    <p class="text-gray-500">Create some zones to see performance metrics.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Statistics</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <p class="text-2xl font-bold text-blue-600">{{ number_format($metrics['summary']['average_members_per_zone'], 1) }}</p>
                <p class="text-sm text-gray-500">Average Members per Zone</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-green-600">₦{{ number_format($metrics['summary']['average_revenue_per_zone'], 2) }}</p>
                <p class="text-sm text-gray-500">Average Revenue per Zone</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-purple-600">{{ $period }} days</p>
                <p class="text-sm text-gray-500">Analysis Period</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function refreshData() {
        const period = document.getElementById('periodSelect').value;
        window.location.href = `{{ route('admin.performance.zones') }}?period=${period}`;
    }

    document.getElementById('periodSelect').addEventListener('change', refreshData);
</script>
@endpush
