@extends('layouts.admin')

@section('title', 'Manage Notifications')
@section('page-title', 'Notification Management')
@section('page-description', 'View and manage all system notifications')

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
            <span class="text-sm font-medium text-gray-500">Manage</span>
        </div>
    </li>
@endsection

@section('page-actions')
    <a href="{{ route('admin.notifications.send') }}" class="bg-fcs-blue text-white px-4 py-2 rounded-lg hover:bg-fcs-light-blue transition-colors">
        <i class="fas fa-paper-plane mr-2"></i>Send Notification
    </a>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-bell text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Notifications</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_notifications']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Unread</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['unread_notifications']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-paper-plane text-green-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Emails Sent Today</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['emails_sent_today']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Urgent</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['priority_urgent']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search notifications..."
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue focus:border-transparent">
            </div>

            <select name="type" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue">
                <option value="all">All Types</option>
                <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>Payment</option>
                <option value="zone_update" {{ request('type') === 'zone_update' ? 'selected' : '' }}>Zone Update</option>
                <option value="event" {{ request('type') === 'event' ? 'selected' : '' }}>Event</option>
                <option value="system" {{ request('type') === 'system' ? 'selected' : '' }}>System</option>
            </select>

            <select name="priority" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue">
                <option value="all">All Priorities</option>
                <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
            </select>

            <button type="submit" class="bg-fcs-blue text-white px-4 py-2 rounded-lg hover:bg-fcs-light-blue">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
        </form>
    </div>

    <!-- Notifications Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Notification
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Recipient
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type & Priority
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($notifications as $notification)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-{{ $notification->notification_color }}-100">
                                            <i class="{{ $notification->notification_icon }} text-{{ $notification->notification_color }}-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ Str::limit($notification->message, 60) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $notification->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $notification->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $notification->notification_color }}-100 text-{{ $notification->notification_color }}-800">
                                    {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $notification->priority_badge }} ml-1">
                                    {{ ucfirst($notification->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    @if($notification->is_read)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Read
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-circle mr-1"></i>Unread
                                        </span>
                                    @endif

                                    @if($notification->email_sent)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-envelope mr-1"></i>Email Sent
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $notification->created_at->format('M j, Y') }}<br>
                                <span class="text-xs text-gray-400">{{ $notification->created_at->format('g:i A') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-bell-slash text-gray-300 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications found</h3>
                                    <p class="text-gray-500">Try adjusting your search criteria or create a new notification.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection
