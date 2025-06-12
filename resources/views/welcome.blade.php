<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FCS Alumni Portal - Fellowship of Christian Students</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
        @endif

        <style>
            body { font-family: 'Inter', sans-serif; }
            .gradient-bg {
                background: linear-gradient(135deg, #1e40af 0%, #dc2626 50%, #f59e0b 100%);
            }
            .logo-shadow {
                filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
            }
        </style>
    </head>
    <body class="bg-gray-50">
        <!-- Navigation -->
        <header class="bg-white shadow-sm fixed w-full top-0 z-50">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <img src="{{ asset('images/logos/fcslogo.png') }}" alt="FCS Logo" class="w-10 h-10 mr-3">
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-gray-900">FCS Alumni Portal</span>
                            <span class="text-xs text-gray-500">Fellowship of Christian Students</span>
                        </div>
                    </div>

                    @if (Route::has('login'))
                        <div class="flex items-center space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                        Join Alumni
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <main class="pt-16">
            <div class="gradient-bg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div class="text-center">
                        <!-- Logos Section -->
                        <div class="flex items-center justify-center space-x-8 mb-12">
                            <img src="{{ asset('images/logos/fcslogo.png') }}" alt="FCS Logo" class="w-24 h-24 md:w-32 md:h-32 logo-shadow">
                            <div class="text-white">
                                <i class="fas fa-heart text-4xl md:text-6xl opacity-70"></i>
                            </div>
                            <img src="{{ asset('images/logos/uniabuja.png') }}" alt="University of Abuja Logo" class="w-24 h-24 md:w-32 md:h-32 logo-shadow">
                        </div>

                        <!-- Main Title -->
                        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                            Fellowship of Christian Students
                        </h1>
                        <h2 class="text-2xl md:text-4xl font-semibold text-blue-100 mb-4">
                            Alumni Portal
                        </h2>
                        <p class="text-xl md:text-2xl text-orange-100 mb-8">
                            University of Abuja Chapter
                        </p>

                        <!-- Scripture -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 mb-12 max-w-4xl mx-auto">
                            <p class="text-lg md:text-xl text-white font-medium italic">
                                "But Saul increased all the more in strength, and confounded the Jews who dwelt in Damascus, proving that this Jesus is the Christ."
                            </p>
                            <p class="text-blue-100 mt-2 font-semibold">- Acts 9:22</p>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-lg transition shadow-lg">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-lg transition shadow-lg">
                                    <i class="fas fa-user-plus mr-2"></i>Join Our Alumni Network
                                </a>
                                <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg transition">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            Connect. Grow. Impact.
                        </h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                            Stay connected with your FCS family, participate in activities, and continue growing in faith together.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="text-center p-6 bg-blue-50 rounded-lg">
                            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Alumni Network</h3>
                            <p class="text-gray-600">
                                Connect with fellow FCS alumni across different graduation classes and stay in touch with your spiritual family.
                            </p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="text-center p-6 bg-red-50 rounded-lg">
                            <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-calendar-alt text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Activities & Events</h3>
                            <p class="text-gray-600">
                                Participate in class reunions, spiritual programs, and fellowship activities to strengthen our bond in Christ.
                            </p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="text-center p-6 bg-yellow-50 rounded-lg">
                            <div class="w-16 h-16 bg-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-pray text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Prayer & Support</h3>
                            <p class="text-gray-600">
                                Share prayer requests and testimonies, supporting each other in our spiritual journey and life challenges.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="bg-gray-900 text-white py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">
                        Ready to Reconnect?
                    </h2>
                    <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                        Join our growing alumni community and be part of something greater. Together, we continue to impact lives for Christ.
                    </p>
                    @guest
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition shadow-lg">
                            <i class="fas fa-heart mr-2"></i>Join the FCS Alumni Family
                        </a>
                    @endguest
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ asset('images/logos/fcslogo.png') }}" alt="FCS Logo" class="w-8 h-8 mr-3">
                        <div>
                            <p class="text-gray-900 font-semibold">FCS Alumni Portal</p>
                            <p class="text-gray-500 text-sm">University of Abuja Chapter</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <img src="{{ asset('images/logos/uniabuja.png') }}" alt="University of Abuja Logo" class="w-8 h-8">
                        <p class="text-gray-500 text-sm">© {{ date('Y') }} FCS Alumni Portal</p>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
