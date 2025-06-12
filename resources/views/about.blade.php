<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>About FCS - Fellowship of Christian Students</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        <!-- Styles / Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'fcs-blue': '#1e40af',
                            'fcs-red': '#dc2626',
                            'fcs-green': '#059669',
                            'fcs-light-blue': '#3b82f6',
                        }
                    }
                }
            }
        </script>

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }

            /* FCS Brand Colors */
            :root {
                --fcs-blue: #1e40af;
                --fcs-red: #dc2626;
                --fcs-white: #ffffff;
                --fcs-green: #059669;
                --fcs-dark: #1f2937;
                --fcs-light-blue: #3b82f6;
            }

            /* Scroll Animations */
            .fade-in {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.6s ease;
            }

            .fade-in.visible {
                opacity: 1;
                transform: translateY(0);
            }

            /* Statement Cards */
            .statement-card {
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
            }

            .statement-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }

            /* Hero Background */
            .hero-bg {
                background: linear-gradient(135deg, var(--fcs-blue) 0%, var(--fcs-light-blue) 100%);
                position: relative;
                overflow: hidden;
            }

            /* Floating shapes */
            .floating-shapes {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: 0;
            }

            .shape {
                position: absolute;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                animation: float 6s ease-in-out infinite;
            }

            .shape:nth-child(1) {
                width: 80px;
                height: 80px;
                top: 20%;
                left: 10%;
                animation-delay: 0s;
            }

            .shape:nth-child(2) {
                width: 60px;
                height: 60px;
                top: 60%;
                left: 80%;
                animation-delay: 2s;
            }

            .shape:nth-child(3) {
                width: 100px;
                height: 100px;
                top: 40%;
                left: 70%;
                animation-delay: 4s;
            }

            @keyframes float {
                0%, 100% {
                    transform: translateY(0px) rotate(0deg);
                    opacity: 0.6;
                }
                50% {
                    transform: translateY(-20px) rotate(180deg);
                    opacity: 0.8;
                }
            }
        </style>
    </head>
    <body class="bg-gray-50">
        <!-- Navigation Header -->
        <header class="bg-white shadow-sm fixed w-full top-0 z-50 border-b-2 border-blue-600">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo Section -->
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('images/logos/fcslogo.png') }}" alt="FCS Logo" class="w-12 h-12">
                        <div class="hidden sm:block w-px h-8 bg-gray-300"></div>
                        <img src="{{ asset('images/logos/uniabuja.png') }}" alt="University of Abuja Logo" class="w-12 h-12">
                        <div class="flex flex-col ml-3">
                            <span class="text-lg font-bold text-gray-900">FCS Alumni Portal</span>
                            <span class="text-xs text-gray-500">Fellowship of Christian Students</span>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Home</a>
                        <a href="{{ route('about') }}" class="text-blue-600 font-medium">About</a>
                        <a href="{{ route('executives') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Leadership</a>

                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition shadow-md">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition shadow-md">
                                Join Alumni
                            </a>
                        @endauth
                    </div>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <section class="hero-bg pt-16 py-20 text-white relative">
            <!-- Floating Shapes -->
            <div class="floating-shapes">
                <div class="shape"></div>
                <div class="shape"></div>
                <div class="shape"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">About FCS</h1>
                <p class="text-xl md:text-2xl opacity-90 max-w-4xl mx-auto">
                    Discover our vision, mission, and identity as we serve Christ and transform lives across generations
                </p>
            </div>
        </section>

        <!-- Quick Navigation -->
        <section class="py-8 bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#vision" class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-6 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-eye mr-2"></i>Vision
                    </a>
                    <a href="#mission" class="bg-red-100 text-red-700 hover:bg-red-200 px-6 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-bullseye mr-2"></i>Mission
                    </a>
                    <a href="#identity" class="bg-green-100 text-green-700 hover:bg-green-200 px-6 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-fingerprint mr-2"></i>Identity
                    </a>
                    <a href="#values" class="bg-purple-100 text-purple-700 hover:bg-purple-200 px-6 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-heart mr-2"></i>Values
                    </a>
                    <a href="#history" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-6 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-history mr-2"></i>History
                    </a>
                </div>
            </div>
        </section>

        <!-- Vision Statement -->
        <section id="vision" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-full mb-6">
                        <i class="fas fa-eye text-white text-2xl"></i>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Vision</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">The future we envision and work towards</p>
                </div>

                <div class="max-w-5xl mx-auto">
                    <div class="statement-card rounded-2xl p-12 bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-600 fade-in">
                        <blockquote class="text-2xl md:text-3xl font-medium text-gray-900 leading-relaxed text-center italic">
                            "{{ $organizationData['vision_statement'] }}"
                        </blockquote>
                        <div class="mt-8 text-center">
                            <div class="inline-flex items-center text-blue-600 font-semibold">
                                <div class="w-12 h-px bg-blue-600 mr-3"></div>
                                FCS Vision
                                <div class="w-12 h-px bg-blue-600 ml-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission Statement -->
        <section id="mission" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-600 rounded-full mb-6">
                        <i class="fas fa-bullseye text-white text-2xl"></i>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Mission</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">What we do and how we serve</p>
                </div>

                <div class="max-w-5xl mx-auto">
                    <div class="statement-card rounded-2xl p-12 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-600 fade-in">
                        <blockquote class="text-xl md:text-2xl font-medium text-gray-900 leading-relaxed text-center">
                            "{{ $organizationData['mission_statement'] }}"
                        </blockquote>
                        <div class="mt-8 text-center">
                            <div class="inline-flex items-center text-red-600 font-semibold">
                                <div class="w-12 h-px bg-red-600 mr-3"></div>
                                FCS Mission
                                <div class="w-12 h-px bg-red-600 ml-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Identity Statement -->
        <section id="identity" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-600 rounded-full mb-6">
                        <i class="fas fa-fingerprint text-white text-2xl"></i>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Identity</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Who we are and what defines us</p>
                </div>

                <div class="max-w-5xl mx-auto">
                    <div class="statement-card rounded-2xl p-12 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-600 fade-in">
                        <blockquote class="text-xl md:text-2xl font-medium text-gray-900 leading-relaxed text-center">
                            "{{ $organizationData['identity_statement'] }}"
                        </blockquote>
                        <div class="mt-8 text-center">
                            <div class="inline-flex items-center text-green-600 font-semibold">
                                <div class="w-12 h-px bg-green-600 mr-3"></div>
                                FCS Identity
                                <div class="w-12 h-px bg-green-600 ml-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Core Values -->
        <section id="values" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-600 rounded-full mb-6">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Core Values</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">The principles that guide everything we do</p>
                </div>

                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @php
                            $values = explode(', ', $organizationData['core_values']);
                            $valueIcons = ['fa-cross', 'fa-handshake', 'fa-heart', 'fa-users', 'fa-graduation-cap', 'fa-sync-alt', 'fa-dove', 'fa-globe'];
                            $valueColors = ['blue', 'red', 'green', 'purple', 'indigo', 'pink', 'yellow', 'gray'];
                        @endphp

                        @foreach($values as $index => $value)
                            @php
                                $icon = $valueIcons[$index % count($valueIcons)];
                                $color = $valueColors[$index % count($valueColors)];
                            @endphp
                            <div class="statement-card rounded-xl p-6 text-center fade-in bg-{{ $color }}-50 border border-{{ $color }}-200">
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-{{ $color }}-600 rounded-full mb-4">
                                    <i class="fas {{ $icon }} text-white"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900 text-sm">{{ trim($value) }}</h3>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Organization History -->
        <section id="history" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-600 rounded-full mb-6">
                        <i class="fas fa-history text-white text-2xl"></i>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Our History</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">The journey that brought us here</p>
                </div>

                <div class="max-w-5xl mx-auto">
                    <div class="statement-card rounded-2xl p-12 bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-600 fade-in">
                        <p class="text-lg md:text-xl text-gray-900 leading-relaxed text-center">
                            {{ $organizationData['organization_history'] }}
                        </p>
                        <div class="mt-8 text-center">
                            <div class="inline-flex items-center text-yellow-600 font-semibold">
                                <div class="w-12 h-px bg-yellow-600 mr-3"></div>
                                FCS Heritage
                                <div class="w-12 h-px bg-yellow-600 ml-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Leadership Preview -->
        @if($executives->count() > 0 || $boardMembers->count() > 0)
            <section class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16 fade-in">
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">Leadership Team</h2>
                        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Meet the dedicated leaders serving our community</p>
                    </div>

                    @if($executives->count() > 0)
                        <div class="mb-16">
                            <h3 class="text-2xl font-bold text-center text-gray-900 mb-8">Executive Committee</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach($executives->take(6) as $executive)
                                    <div class="statement-card rounded-xl p-6 text-center fade-in">
                                        @if($executive->image)
                                            <img src="{{ asset('storage/' . $executive->image) }}" alt="{{ $executive->name }}" class="w-20 h-20 rounded-full mx-auto mb-4 object-cover">
                                        @else
                                            <div class="w-20 h-20 bg-blue-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                                                <i class="fas fa-user text-white text-2xl"></i>
                                            </div>
                                        @endif
                                        <h4 class="font-bold text-gray-900">{{ $executive->name }}</h4>
                                        <p class="text-blue-600 font-semibold text-sm">{{ $executive->position }}</p>
                                        @if($executive->bio)
                                            <p class="text-gray-600 text-sm mt-2">{{ Str::limit($executive->bio, 100) }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="text-center">
                        <a href="{{ route('executives') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition shadow-md">
                            <i class="fas fa-users mr-2"></i>View Full Leadership Team
                        </a>
                    </div>
                </div>
            </section>
        @endif

        <!-- Call to Action -->
        <section class="py-20 bg-blue-600 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-bold mb-6">Join Our Mission</h2>
                <p class="text-xl mb-10 opacity-90 max-w-3xl mx-auto">
                    Be part of our vision to transform lives and build a peaceful, Christ-centered community.
                </p>

                @guest
                    <div class="flex flex-col sm:flex-row gap-6 justify-center">
                        <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-10 py-4 rounded-xl font-bold text-lg transition shadow-xl transform hover:scale-105">
                            <i class="fas fa-user-plus mr-3"></i>Join Our Alumni
                        </a>
                        <a href="{{ route('home') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-600 px-10 py-4 rounded-xl font-bold text-lg transition transform hover:scale-105">
                            <i class="fas fa-home mr-3"></i>Back to Home
                        </a>
                    </div>
                @else
                    <a href="{{ url('/dashboard') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-10 py-4 rounded-xl font-bold text-lg transition shadow-xl transform hover:scale-105">
                        <i class="fas fa-tachometer-alt mr-3"></i>Go to Dashboard
                    </a>
                @endguest
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- About Column -->
                    <div class="col-span-2">
                        <div class="flex items-center mb-4">
                            <img src="{{ asset('images/logos/fcslogo.png') }}" alt="FCS Logo" class="w-10 h-10 mr-3">
                            <div>
                                <h3 class="text-lg font-bold">FCS Alumni Portal</h3>
                                <p class="text-gray-400 text-sm">Fellowship of Christian Students</p>
                            </div>
                        </div>
                        <p class="text-gray-400 leading-relaxed mb-4">
                            Connecting generations of believers from the University of Abuja FCS community, fostering continued spiritual growth and global impact for Christ.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Home</a></li>
                            <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition">About FCS</a></li>
                            <li><a href="{{ route('executives') }}" class="text-gray-400 hover:text-white transition">Leadership</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition">Join Alumni</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Contact</h4>
                        <div class="space-y-2 text-gray-400">
                            <div class="flex items-center">
                                <i class="fas fa-envelope mr-2"></i>
                                <span>fcs@uniabuja.edu.ng</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>University of Abuja, FCT</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 flex items-center justify-between">
                    <p class="text-gray-400 text-sm">© {{ date('Y') }} FCS Alumni Portal. All rights reserved.</p>
                    <img src="{{ asset('images/logos/uniabuja.png') }}" alt="University of Abuja Logo" class="w-8 h-8">
                </div>
            </div>
        </footer>

        <!-- JavaScript for Animations -->
        <script>
            // Scroll Animations
            function initScrollAnimations() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                }, { threshold: 0.1 });

                document.querySelectorAll('.fade-in').forEach(el => {
                    observer.observe(el);
                });
            }

            // Smooth Scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Initialize when DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                initScrollAnimations();
            });
        </script>
    </body>
</html>
