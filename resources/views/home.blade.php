<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* FCS Color Scheme */
        :root {
            --fcs-primary: #1e40af; /* Blue */
            --fcs-secondary: #dc2626; /* Red */
            --fcs-gold: #f59e0b; /* Gold */
            --fcs-green: #059669; /* Green */
            --fcs-purple: #7c3aed; /* Purple */
        }

        .fcs-primary { background: var(--fcs-primary); }
        .fcs-secondary { background: var(--fcs-secondary); }
        .fcs-gold { background: var(--fcs-gold); }
        .fcs-green { background: var(--fcs-green); }
        .fcs-purple { background: var(--fcs-purple); }

        .text-fcs-primary { color: var(--fcs-primary); }
        .text-fcs-secondary { color: var(--fcs-secondary); }
        .text-fcs-gold { color: var(--fcs-gold); }
        .text-fcs-green { color: var(--fcs-green); }
        .text-fcs-purple { color: var(--fcs-purple); }

        /* Animated Background */
        .hero-bg {
            background: linear-gradient(135deg, var(--fcs-primary) 0%, var(--fcs-purple) 50%, var(--fcs-secondary) 100%);
            background-size: 300% 300%;
            animation: gradientShift 8s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .floating-shapes div {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .floating-shapes div:nth-child(1) {
            top: 10%;
            left: 20%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }

        .floating-shapes div:nth-child(2) {
            top: 20%;
            right: 20%;
            width: 60px;
            height: 60px;
            animation-delay: 2s;
        }

        .floating-shapes div:nth-child(3) {
            bottom: 20%;
            left: 10%;
            width: 100px;
            height: 100px;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .pulse-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="fcs-primary w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-cross text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">{{ $settings['site_name'] }}</span>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    @guest
                        @if($settings['allow_registration'])
                            <a href="{{ route('register') }}" class="fcs-green text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
                                <i class="fas fa-user-plus mr-2"></i>Join Us
                            </a>
                        @endif
                        <a href="{{ route('login') }}" class="fcs-primary text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="fcs-primary text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="floating-shapes">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="mb-8">
                <div class="fcs-gold w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 pulse-animation">
                    <i class="fas fa-hands-praying text-white text-3xl"></i>
                </div>
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6">
                    Fellowship of<br>
                    <span class="text-yellow-300">Christian Students</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-8 max-w-3xl mx-auto">
                    {{ $settings['site_description'] }}
                </p>
                <p class="text-lg text-gray-300 mb-8 max-w-2xl mx-auto">
                    {{ $settings['welcome_message'] }}
                </p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
                    <div class="text-4xl font-bold text-white">{{ $totalMembers }}</div>
                    <div class="text-gray-300">Alumni Members</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
                    <div class="text-4xl font-bold text-white">{{ $totalClasses }}</div>
                    <div class="text-gray-300">Graduation Classes</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
                    <div class="text-4xl font-bold text-white">{{ now()->year - 2010 }}+</div>
                    <div class="text-gray-300">Years of Faith</div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if($settings['allow_registration'])
                    <a href="{{ route('register') }}" class="fcs-gold text-white px-8 py-4 rounded-lg text-lg font-semibold hover:opacity-90 transition flex items-center">
                        <i class="fas fa-user-plus mr-2"></i>Join Our Alumni Network
                    </a>
                @endif
                <a href="#executives" class="bg-white text-gray-900 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition flex items-center">
                    <i class="fas fa-users mr-2"></i>Meet Our Leaders
                </a>
            </div>
        </div>
    </section>

    <!-- Alumni Executives Section -->
    @if($executives->count() > 0)
    <section id="executives" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Alumni Executive Council</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Meet the dedicated leaders who guide our alumni community with wisdom and faith.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($executives as $executive)
                <div class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="fcs-primary h-32 relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-purple-600 opacity-90"></div>
                    </div>
                    <div class="relative px-6 pb-6">
                        <div class="absolute -top-12 left-6">
                            <div class="w-24 h-24 bg-white rounded-full border-4 border-white flex items-center justify-center">
                                @if($executive->image)
                                    <img src="{{ $executive->image }}" alt="{{ $executive->name }}" class="w-20 h-20 rounded-full object-cover">
                                @else
                                    <i class="fas fa-user text-4xl text-gray-400"></i>
                                @endif
                            </div>
                        </div>
                        <div class="pt-16">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $executive->name }}</h3>
                            <p class="text-fcs-primary font-semibold mb-3">{{ $executive->position }}</p>
                            @if($executive->bio)
                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($executive->bio, 120) }}</p>
                            @endif
                            @if($executive->email || $executive->phone)
                                <div class="flex space-x-3">
                                    @if($executive->email)
                                        <a href="mailto:{{ $executive->email }}" class="text-fcs-green hover:text-green-700">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    @endif
                                    @if($executive->phone)
                                        <a href="tel:{{ $executive->phone }}" class="text-fcs-primary hover:text-blue-700">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- National Board Members Section -->
    @if($boardMembers->count() > 0)
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">National Board Members</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Our national leadership team working tirelessly to advance the Fellowship of Christian Students across Nigeria.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($boardMembers as $member)
                <div class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="fcs-secondary h-24 relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-red-600 to-orange-600 opacity-90"></div>
                    </div>
                    <div class="relative px-6 pb-6">
                        <div class="absolute -top-8 left-6">
                            <div class="w-16 h-16 bg-white rounded-full border-4 border-white flex items-center justify-center">
                                @if($member->image)
                                    <img src="{{ $member->image }}" alt="{{ $member->name }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <i class="fas fa-user text-2xl text-gray-400"></i>
                                @endif
                            </div>
                        </div>
                        <div class="pt-12">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $member->name }}</h3>
                            <p class="text-fcs-secondary font-semibold text-sm mb-2">{{ $member->position }}</p>
                            @if($member->region)
                                <p class="text-gray-500 text-xs mb-3">{{ $member->region }}</p>
                            @endif
                            @if($member->bio)
                                <p class="text-gray-600 text-xs">{{ Str::limit($member->bio, 80) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Recent Activities Section -->
    @if($recentActivities->count() > 0)
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Recent Activities</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Stay updated with the latest activities and events from our fellowship community.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($recentActivities as $activity)
                <div class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                    @if($activity->image)
                        <img src="{{ $activity->image }}" alt="{{ $activity->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="fcs-green h-48 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-6xl text-white"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="fcs-gold text-white text-xs px-2 py-1 rounded-full">
                                {{ $activity->type }}
                            </span>
                            <span class="text-gray-500 text-sm ml-auto">
                                {{ $activity->activity_date->format('M d, Y') }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $activity->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($activity->description, 120) }}</p>
                        @if($activity->location)
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $activity->location }}
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Call to Action -->
    <section class="fcs-primary py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-4">Ready to Connect?</h2>
            <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
                Join our growing community of faith-filled alumni and stay connected with your fellow graduates.
            </p>
            @if($settings['allow_registration'])
                <a href="{{ route('register') }}" class="fcs-gold text-white px-8 py-4 rounded-lg text-lg font-semibold hover:opacity-90 transition inline-flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>Register Now
                </a>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="fcs-primary w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-cross text-white"></i>
                        </div>
                        <span class="text-xl font-bold">{{ $settings['site_name'] }}</span>
                    </div>
                    <p class="text-gray-400">
                        Connecting alumni of the Fellowship of Christian Students, University of Abuja.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#executives" class="text-gray-400 hover:text-white transition">Alumni Executives</a></li>
                        <li><a href="#board" class="text-gray-400 hover:text-white transition">Board Members</a></li>
                        @if($settings['allow_registration'])
                            <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition">Join Us</a></li>
                        @endif
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Login</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect With Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; {{ now()->year }} {{ $settings['site_name'] }}. All rights reserved. | Built with faith and excellence.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
