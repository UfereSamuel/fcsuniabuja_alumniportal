<nav class="bg-white shadow-sm border-b border-gray-200 fixed w-full top-0 z-50" x-data="{ open: false, userDropdown: false }">
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
                    @if(Auth::user()->role === 'coordinator')
                        <span class="ml-3 text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full">Coordinator</span>
                    @endif
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-fcs-primary text-fcs-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium leading-5 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition">
                        <i class="fas fa-calendar-alt mr-2"></i>Activities
                    </a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium leading-5 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition">
                        <i class="fas fa-pray mr-2"></i>Prayer Requests
                    </a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium leading-5 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition">
                        <i class="fas fa-file-alt mr-2"></i>Documents
                    </a>
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
                <div class="relative">
                    <button @click="userDropdown = !userDropdown" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <div class="w-8 h-8 bg-fcs-primary rounded-full flex items-center justify-center mr-2">
                            <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <span class="hidden md:block text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down ml-2 text-gray-400"></i>
                    </button>

                    <div x-show="userDropdown" @click.away="userDropdown = false" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" style="display: none;">
                        <div class="py-1">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                @if(Auth::user()->class)
                                    <p class="text-xs text-gray-500">{{ Auth::user()->class->name }}</p>
                                @endif
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>My Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-home mr-2"></i>View Public Site
                            </a>
                            @if(Auth::user()->class && Auth::user()->class->whatsapp_link)
                            <a href="{{ Auth::user()->class->whatsapp_link }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fab fa-whatsapp mr-2"></i>Class WhatsApp
                            </a>
                            @endif
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

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" class="md:hidden" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-gray-50">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-fcs-primary hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'text-fcs-primary bg-gray-100' : '' }}">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-fcs-primary hover:bg-gray-100">
                <i class="fas fa-calendar-alt mr-2"></i>Activities
            </a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-fcs-primary hover:bg-gray-100">
                <i class="fas fa-users mr-2"></i>My Class
            </a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-fcs-primary hover:bg-gray-100">
                <i class="fas fa-file-alt mr-2"></i>Resources
            </a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-fcs-primary hover:bg-gray-100">
                <i class="fas fa-pray mr-2"></i>Prayer
            </a>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
