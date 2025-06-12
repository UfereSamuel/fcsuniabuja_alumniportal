@extends('layouts.admin')

@section('title', 'Notification Analytics')
@section('page-title', 'Notification Analytics')
@section('page-description', 'Detailed analytics and insights for system notifications')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-3"></i>
            <span class="text-sm font-medium text-gray-500">Notifications</span>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-3"></i>
            <span class="text-sm font-medium text-gray-500">Analytics</span>
        </div>
    </li>
@endsection

@section('page-actions')
    <div class="flex space-x-3">
        <select id="periodSelect" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue">
            <option value="7">Last 7 days</option>
            <option value="30" selected>Last 30 days</option>
            <option value="90">Last 90 days</option>
        </select>
        <button onclick="refreshAnalytics()" class="bg-fcs-blue text-white px-4 py-2 rounded-lg hover:bg-fcs-light-blue transition-colors">
            <i class="fas fa-sync-alt mr-2"></i>Refresh
        </button>
    </div>
@endsection

@section('content')
    <!-- Loading State -->
    <div id="loading" class="text-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-fcs-blue mx-auto"></div>
        <p class="text-gray-500 mt-4">Loading analytics...</p>
    </div>

    <!-- Analytics Content -->
    <div id="analytics-content" style="display: none;">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-bell text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Total Sent</p>
                        <p id="total-notifications" class="text-2xl font-semibold text-gray-900">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-envelope text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Emails Sent</p>
                        <p id="emails-sent" class="text-2xl font-semibold text-gray-900">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Pending Emails</p>
                        <p id="emails-pending" class="text-2xl font-semibold text-gray-900">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-percentage text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Delivery Rate</p>
                        <p id="delivery-rate" class="text-2xl font-semibold text-gray-900">-</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Notifications by Type -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Notifications by Type</h3>
                <div id="type-chart" class="h-64">
                    <canvas id="typeChart"></canvas>
                </div>
            </div>

            <!-- Notifications by Priority -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Notifications by Priority</h3>
                <div id="priority-chart" class="h-64">
                    <canvas id="priorityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Trend Chart -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Trends</h3>
            <div class="h-64">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Zone Activity -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Most Active Zones</h3>
            <div id="zone-activity" class="space-y-3">
                <!-- Zone activity will be populated here -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let typeChart, priorityChart, trendChart;

    async function loadAnalytics() {
        const period = document.getElementById('periodSelect').value;

        try {
            const response = await fetch(`/admin/notifications/analytics?period=${period}`);
            const result = await response.json();

            if (result.success) {
                updateSummaryCards(result.data);
                updateCharts(result.data);
                updateZoneActivity(result.data.zone_activity);
            }
        } catch (error) {
            console.error('Failed to load analytics:', error);
            alert('Failed to load analytics data');
        } finally {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('analytics-content').style.display = 'block';
        }
    }

    function updateSummaryCards(data) {
        document.getElementById('total-notifications').textContent = data.email_stats.total_notifications.toLocaleString();
        document.getElementById('emails-sent').textContent = data.email_stats.emails_sent.toLocaleString();
        document.getElementById('emails-pending').textContent = data.email_stats.emails_pending.toLocaleString();

        const deliveryRate = data.email_stats.total_notifications > 0
            ? ((data.email_stats.emails_sent / data.email_stats.total_notifications) * 100).toFixed(1)
            : 0;
        document.getElementById('delivery-rate').textContent = deliveryRate + '%';
    }

    function updateCharts(data) {
        // Destroy existing charts
        if (typeChart) typeChart.destroy();
        if (priorityChart) priorityChart.destroy();
        if (trendChart) trendChart.destroy();

        // Type Chart
        const typeCtx = document.getElementById('typeChart').getContext('2d');
        typeChart = new Chart(typeCtx, {
            type: 'doughnut',
            data: {
                labels: data.by_type.map(item => item.type.replace('_', ' ').toUpperCase()),
                datasets: [{
                    data: data.by_type.map(item => item.count),
                    backgroundColor: [
                        '#3B82F6', // Blue
                        '#10B981', // Green
                        '#8B5CF6', // Purple
                        '#F59E0B', // Yellow
                        '#EF4444'  // Red
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Priority Chart
        const priorityCtx = document.getElementById('priorityChart').getContext('2d');
        priorityChart = new Chart(priorityCtx, {
            type: 'bar',
            data: {
                labels: data.by_priority.map(item => item.priority.toUpperCase()),
                datasets: [{
                    label: 'Count',
                    data: data.by_priority.map(item => item.count),
                    backgroundColor: '#3B82F6'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        trendChart = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: data.trends.map(item => new Date(item.date).toLocaleDateString()),
                datasets: [{
                    label: 'Notifications Sent',
                    data: data.trends.map(item => item.count),
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function updateZoneActivity(zoneActivity) {
        const container = document.getElementById('zone-activity');

        if (zoneActivity.length === 0) {
            container.innerHTML = '<p class="text-gray-500 text-center py-4">No zone activity data available</p>';
            return;
        }

        const maxCount = Math.max(...zoneActivity.map(zone => zone.notification_count));

        container.innerHTML = zoneActivity.map(zone => `
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-600 rounded-full mr-3"></div>
                    <span class="font-medium text-gray-900">${zone.zone ? zone.zone.name : 'Unknown Zone'}</span>
                </div>
                <div class="flex items-center">
                    <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: ${(zone.notification_count / maxCount) * 100}%"></div>
                    </div>
                    <span class="text-sm font-semibold text-gray-600">${zone.notification_count}</span>
                </div>
            </div>
        `).join('');
    }

    function refreshAnalytics() {
        document.getElementById('loading').style.display = 'block';
        document.getElementById('analytics-content').style.display = 'none';
        loadAnalytics();
    }

    // Load analytics on page load
    document.addEventListener('DOMContentLoaded', loadAnalytics);

    // Refresh on period change
    document.getElementById('periodSelect').addEventListener('change', refreshAnalytics);
</script>
@endpush
