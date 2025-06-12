<nav class="bg-white shadow-sm border-b border-gray-200 fixed w-full top-0 z-50">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <!-- FCS Logo -->
                    <img src="{{ asset('images/logos/fcslogo.png') }}" alt="FCS Logo" class="w-10 h-10 mr-2">

                    <!-- University of Abuja Logo -->
                    <img src="{{ asset('images/logos/uniabuja.png') }}" alt="University of Abuja Logo" class="w-10 h-10 mr-3">

                    <div class="flex flex-col">
                        <span class="text-lg font-bold text-gray-900">FCS Alumni Portal</span>
                        <span class="text-xs text-gray-500">Fellowship of Christian Students</span>
                    </div>
                    <span class="ml-3 text-sm bg-red-100 text-red-800 px-2 py-1 rounded-full font-medium">Admin</span>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Quick Actions -->
                <div class="hidden md:flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-fcs-blue transition-colors duration-200 flex items-center" target="_blank">
                        <i class="fas fa-external-link-alt text-sm mr-1"></i>
                        <span class="text-sm">View Site</span>
                    </a>
                </div>

                <!-- Notifications -->
                <div class="relative" x-data="notificationCenter()" x-init="init()">
                    <button @click="open = !open; if(open) fetchNotifications()"
                            class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition-colors duration-200">
                        <i class="fas fa-bell text-lg"></i>
                        <span x-show="unreadCount > 0"
                              x-text="unreadCount > 99 ? '99+' : unreadCount"
                              class="absolute -top-1 -right-1 h-5 w-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center animate-pulse">
                        </span>
                    </button>

                    <!-- Notifications Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition
                         class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 max-h-96 overflow-hidden"
                         style="display: none;">

                        <!-- Header -->
                        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                <div class="flex items-center space-x-2">
                                    <span x-show="unreadCount > 0" class="text-xs text-gray-500" x-text="`${unreadCount} new`"></span>
                                    <button @click="markAllAsRead()" class="text-xs text-fcs-blue hover:text-fcs-light-blue">
                                        Mark all read
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Notifications List -->
                        <div class="max-h-64 overflow-y-auto">
                            <template x-if="loading">
                                <div class="px-4 py-8 text-center">
                                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-fcs-blue mx-auto"></div>
                                    <p class="text-sm text-gray-500 mt-2">Loading notifications...</p>
                                </div>
                            </template>

                            <template x-if="!loading && notifications.length === 0">
                                <div class="px-4 py-8 text-center">
                                    <i class="fas fa-bell-slash text-gray-300 text-2xl mb-2"></i>
                                    <p class="text-sm text-gray-500">No new notifications</p>
                                </div>
                            </template>

                            <template x-for="notification in notifications" :key="notification.id">
                                <div class="border-b border-gray-100 hover:bg-gray-50 transition-colors cursor-pointer"
                                     @click="handleNotificationClick(notification)">
                                    <div class="px-4 py-3">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center"
                                                     :class="`bg-${notification.color}-100 text-${notification.color}-600`">
                                                    <i :class="notification.icon" class="text-sm"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3 flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900" x-text="notification.title"></p>
                                                <p class="text-sm text-gray-500 mt-1" x-text="notification.message"></p>
                                                <p class="text-xs text-gray-400 mt-1" x-text="notification.time"></p>
                                            </div>
                                            <div class="ml-2 flex-shrink-0">
                                                <span class="w-2 h-2 bg-blue-500 rounded-full"
                                                      x-show="!notification.read"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Footer -->
                        <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                            <div class="text-center">
                                <a href="#" class="text-sm text-fcs-blue hover:text-fcs-light-blue font-medium">
                                    View all notifications
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fcs-blue transition-all duration-200">
                        <div class="w-8 h-8 bg-fcs-primary rounded-full flex items-center justify-center mr-2">
                            <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <span class="hidden md:block text-gray-700 font-medium mr-1">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" style="display: none;">
                        <div class="py-1">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ ucwords(str_replace('_', ' ', Auth::user()->role)) }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                <i class="fas fa-user mr-2"></i>Profile Settings
                            </a>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                <i class="fas fa-user-circle mr-2"></i>My Dashboard
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Scripts -->
<script>
    function notificationCenter() {
        return {
            open: false,
            loading: false,
            notifications: [],
            unreadCount: 0,

            init() {
                this.fetchNotifications();
                // Poll for new notifications every 30 seconds
                setInterval(() => {
                    this.fetchNotifications();
                }, 30000);
            },

            async fetchNotifications() {
                this.loading = true;
                try {
                    const response = await fetch('/admin/notifications');
                    const data = await response.json();
                    this.notifications = data.notifications;
                    this.unreadCount = data.count;
                } catch (error) {
                    console.error('Failed to fetch notifications:', error);
                } finally {
                    this.loading = false;
                }
            },

            handleNotificationClick(notification) {
                // Mark as read and navigate
                this.markAsRead(notification.id);
                if (notification.url) {
                    window.location.href = notification.url;
                }
            },

            async markAsRead(notificationId) {
                try {
                    await fetch(`/admin/notifications/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        }
                    });
                    this.fetchNotifications();
                } catch (error) {
                    console.error('Failed to mark notification as read:', error);
                }
            },

            async markAllAsRead() {
                try {
                    await fetch('/admin/notifications/mark-all-read', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        }
                    });
                    this.fetchNotifications();
                } catch (error) {
                    console.error('Failed to mark all notifications as read:', error);
                }
            }
        }
    }
</script>
