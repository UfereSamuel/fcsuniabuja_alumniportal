@extends('layouts.admin')

@section('title', 'Reports')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Reports</span>
        </div>
    </li>
@endsection

@section('page-title', 'Reports & Analytics')
@section('page-description', 'Generate comprehensive reports and analytics for FCS alumni management')

@section('content')
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</h3>
                    <p class="text-gray-600">Total Members</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">${{ number_format(\App\Models\Payment::where('status', 'success')->sum('amount'), 2) }}</h3>
                    <p class="text-gray-600">Total Revenue</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\Event::count() }}</h3>
                    <p class="text-gray-600">Total Events</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\Zone::count() }}</h3>
                    <p class="text-gray-600">Active Zones</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Membership Reports -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 ml-4">Membership Reports</h3>
            </div>
            <p class="text-gray-600 mb-4">Generate detailed reports on member registration, demographics, and zone distribution.</p>
            <div class="space-y-2">
                <a href="{{ route('admin.reports.membership') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md font-medium transition">
                    <i class="fas fa-chart-line mr-2"></i>View Report
                </a>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.reports.export', 'membership-pdf') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-2 px-4 rounded-md text-sm transition">
                        <i class="fas fa-file-pdf mr-1"></i>PDF
                    </a>
                    <a href="{{ route('admin.reports.export', 'membership-excel') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-2 px-4 rounded-md text-sm transition">
                        <i class="fas fa-file-excel mr-1"></i>Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Financial Reports -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 ml-4">Financial Reports</h3>
            </div>
            <p class="text-gray-600 mb-4">Track payments, dues collection, revenue trends, and financial performance by zone.</p>
            <div class="space-y-2">
                <a href="{{ route('admin.reports.financial') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-md font-medium transition">
                    <i class="fas fa-chart-bar mr-2"></i>View Report
                </a>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.reports.export', 'financial-pdf') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-2 px-4 rounded-md text-sm transition">
                        <i class="fas fa-file-pdf mr-1"></i>PDF
                    </a>
                    <a href="{{ route('admin.reports.export', 'financial-excel') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-2 px-4 rounded-md text-sm transition">
                        <i class="fas fa-file-excel mr-1"></i>Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Activities Reports -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 ml-4">Activities Reports</h3>
            </div>
            <p class="text-gray-600 mb-4">Analyze event attendance, activity engagement, and member participation trends.</p>
            <div class="space-y-2">
                <a href="{{ route('admin.reports.activities') }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-2 px-4 rounded-md font-medium transition">
                    <i class="fas fa-chart-pie mr-2"></i>View Report
                </a>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.reports.export', 'activities-pdf') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-2 px-4 rounded-md text-sm transition">
                        <i class="fas fa-file-pdf mr-1"></i>PDF
                    </a>
                    <a href="{{ route('admin.reports.export', 'activities-excel') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-2 px-4 rounded-md text-sm transition">
                        <i class="fas fa-file-excel mr-1"></i>Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Zones Performance -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-orange-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 ml-4">Zones Performance</h3>
            </div>
            <p class="text-gray-600 mb-4">Compare zone performance, member distribution, and activity levels across regions.</p>
            <div class="space-y-2">
                <a href="{{ route('admin.reports.zones') }}" class="block w-full bg-orange-600 hover:bg-orange-700 text-white text-center py-2 px-4 rounded-md font-medium transition">
                    <i class="fas fa-chart-area mr-2"></i>View Report
                </a>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.reports.export', 'zones-pdf') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-2 px-4 rounded-md text-sm transition">
                        <i class="fas fa-file-pdf mr-1"></i>PDF
                    </a>
                    <a href="{{ route('admin.reports.export', 'zones-excel') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-2 px-4 rounded-md text-sm transition">
                        <i class="fas fa-file-excel mr-1"></i>Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Custom Reports -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cogs text-gray-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 ml-4">Custom Reports</h3>
            </div>
            <p class="text-gray-600 mb-4">Create custom reports with specific date ranges, filters, and data combinations.</p>
            <button onclick="openCustomReportModal()" class="w-full bg-gray-600 hover:bg-gray-700 text-white text-center py-2 px-4 rounded-md font-medium transition">
                <i class="fas fa-plus mr-2"></i>Create Custom Report
            </button>
        </div>

        <!-- Data Export -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-download text-indigo-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 ml-4">Data Export</h3>
            </div>
            <p class="text-gray-600 mb-4">Export all system data for backup, analysis, or migration purposes.</p>
            <div class="space-y-2">
                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center py-2 px-4 rounded-md font-medium transition">
                    <i class="fas fa-database mr-2"></i>Full Data Export
                </button>
                <div class="text-xs text-gray-500 text-center">
                    Last export: Never
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
function openCustomReportModal() {
    alert('Custom report builder coming soon!');
}
@endsection
