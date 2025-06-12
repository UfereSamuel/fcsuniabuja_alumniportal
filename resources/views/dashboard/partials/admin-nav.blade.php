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
                    <span class="ml-3 text-sm bg-red-100 text-red-800 px-2 py-1 rounded-full">Admin</span>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <div class="relative">
                    <button class="p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                    </button>
                </div>

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <div class="w-8 h-8 bg-fcs-primary rounded-full flex items-center justify-center mr-2">
                            <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <span class="hidden md:block text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down ml-2 text-gray-400"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" style="display: none;">
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-home mr-2"></i>View Site
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
