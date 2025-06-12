<aside class="fixed left-0 top-16 h-full w-64 bg-white shadow-lg z-40 overflow-y-auto">
    <div class="p-4">
        <div class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-tachometer-alt mr-3 w-5"></i>
                <span>Dashboard</span>
            </a>

            <!-- Members Management -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Members</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.users.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-users mr-3 w-5"></i>
                        <span>All Members</span>
                        @if(isset($stats['total_users']))
                            <span class="ml-auto bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $stats['total_users'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user-plus mr-3 w-5"></i>
                        <span>Add Member</span>
                    </a>
                </div>
            </div>

            <!-- Content Management -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Content</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.sliders.index') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.sliders.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-images mr-3 w-5"></i>
                        <span>Homepage Sliders</span>
                        @if(isset($stats['total_sliders']))
                            <span class="ml-auto bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $stats['total_sliders'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.activities.index') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.activities.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-calendar-alt mr-3 w-5"></i>
                        <span>Activities</span>
                        @if(isset($stats['total_activities']))
                            <span class="ml-auto bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $stats['total_activities'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.activities.create') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-calendar-plus mr-3 w-5"></i>
                        <span>Create Activity</span>
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.events.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-calendar-check mr-3 w-5"></i>
                        <span>Events</span>
                        @if(isset($stats['total_events']))
                            <span class="ml-auto bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $stats['total_events'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.events.create') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-plus mr-3 w-5"></i>
                        <span>Create Event</span>
                    </a>
                </div>
            </div>

            <!-- Leadership Management -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Leadership</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.executives.index') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.executives.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-users-cog mr-3 w-5"></i>
                        <span>Alumni Executives</span>
                        @if(isset($stats['total_executives']))
                            <span class="ml-auto bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $stats['total_executives'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.executives.create') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user-plus mr-3 w-5"></i>
                        <span>Add Executive</span>
                    </a>
                </div>
            </div>

            <!-- Communication -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Communication</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.prayer-requests.index') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.prayer-requests.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-praying-hands mr-3 w-5"></i>
                        <span>Prayer Requests</span>
                        @if(isset($stats['pending_prayer_requests']) && $stats['pending_prayer_requests'] > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $stats['pending_prayer_requests'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.whatsapp-groups.index') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.whatsapp-groups.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fab fa-whatsapp mr-3 w-5"></i>
                        <span>WhatsApp Groups</span>
                        @if(isset($stats['total_whatsapp_groups']) && $stats['total_whatsapp_groups'] > 0)
                            <span class="ml-auto bg-green-500 text-white text-xs px-2 py-1 rounded-full">{{ $stats['total_whatsapp_groups'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.notifications.manage') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.notifications.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-bell mr-3 w-5"></i>
                        <span>Notifications</span>
                        @if(isset($stats['unread_notifications']) && $stats['unread_notifications'] > 0)
                            <span class="ml-auto bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">{{ $stats['unread_notifications'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.notifications.send') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-paper-plane mr-3 w-5"></i>
                        <span>Send Notification</span>
                    </a>
                </div>
            </div>

            <!-- Resources -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Resources</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.documents.index') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.documents.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-file-alt mr-3 w-5"></i>
                        <span>Documents</span>
                        @if(isset($stats['pending_documents']) && $stats['pending_documents'] > 0)
                            <span class="ml-auto bg-orange-500 text-white text-xs px-2 py-1 rounded-full">{{ $stats['pending_documents'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.documents.create') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-upload mr-3 w-5"></i>
                        <span>Upload Document</span>
                    </a>
                </div>
            </div>

            <!-- System -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">System</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.performance.system') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.performance.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-chart-line mr-3 w-5"></i>
                        <span>Performance</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-cog mr-3 w-5"></i>
                        <span>Settings</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.reports.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-chart-bar mr-3 w-5"></i>
                        <span>Reports</span>
                    </a>
                    <a href="{{ route('admin.backup.index') }}" class="sidebar-link flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.backup.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-database mr-3 w-5"></i>
                        <span>Backup</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="pt-8 pb-4 border-t border-gray-200 mt-8">
            <div class="text-center">
                <p class="text-xs text-gray-500">FCS Alumni Portal</p>
                <p class="text-xs text-gray-400">Admin Panel v1.0</p>
            </div>
        </div>
    </div>
</aside>
