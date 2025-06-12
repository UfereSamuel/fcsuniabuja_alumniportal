<aside class="fixed left-0 top-16 h-full w-64 bg-white shadow-lg z-40 overflow-y-auto">
    <div class="p-4">
        <div class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-fcs-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>

            <!-- Members Management -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Members</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-users mr-3"></i>
                        All Members
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-user-plus mr-3"></i>
                        Add Member
                    </a>
                </div>
            </div>

            <!-- Content Management -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Content</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.sliders.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-images mr-3"></i>
                        Homepage Sliders
                    </a>
                    <a href="{{ route('admin.activities.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-calendar-alt mr-3"></i>
                        Activities
                    </a>
                    <a href="{{ route('admin.activities.create') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-calendar-plus mr-3"></i>
                        Create Activity
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-calendar-check mr-3"></i>
                        Events
                    </a>
                    <a href="{{ route('admin.events.create') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-plus mr-3"></i>
                        Create Event
                    </a>
                </div>
            </div>

            <!-- Leadership Management -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Leadership</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.executives.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-users-cog mr-3"></i>
                        Alumni Executives
                    </a>
                    <a href="{{ route('admin.executives.create') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-user-plus mr-3"></i>
                        Add Executive
                    </a>
                </div>
            </div>

            <!-- Communication -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Communication</h3>
                <div class="mt-2 space-y-1">
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-praying-hands mr-3"></i>
                        Prayer Requests
                        @if(isset($stats['pending_prayer_requests']) && $stats['pending_prayer_requests'] > 0)
                            <span class="ml-auto bg-blue-500 text-white text-xs px-2 py-1 rounded-full">{{ $stats['pending_prayer_requests'] }}</span>
                        @endif
                    </a>
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fab fa-whatsapp mr-3"></i>
                        WhatsApp Groups
                    </a>
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-envelope mr-3"></i>
                        Send Notifications
                    </a>
                </div>
            </div>

            <!-- Resources -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Resources</h3>
                <div class="mt-2 space-y-1">
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-file-alt mr-3"></i>
                        Documents
                        @if(isset($stats['pending_documents']) && $stats['pending_documents'] > 0)
                            <span class="ml-auto bg-orange-500 text-white text-xs px-2 py-1 rounded-full">{{ $stats['pending_documents'] }}</span>
                        @endif
                    </a>
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-upload mr-3"></i>
                        Upload Document
                    </a>
                </div>
            </div>

            <!-- System -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">System</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-cog mr-3"></i>
                        Settings
                    </a>
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Reports
                    </a>
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-database mr-3"></i>
                        Backup
                    </a>
                </div>
            </div>
        </div>
    </div>
</aside>
