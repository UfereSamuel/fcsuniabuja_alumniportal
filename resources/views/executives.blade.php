<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meet Our Executives - FCS Alumni Portal</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
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

        .executive-card {
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .executive-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .executive-image {
            transition: all 0.3s ease;
        }

        .executive-card:hover .executive-image {
            transform: scale(1.05);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-bg {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

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
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            top: 40%;
            right: 30%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
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
                @if (Route::has('login'))
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Home</a>
                        <a href="{{ route('home') }}#about" class="text-gray-700 hover:text-blue-600 font-medium transition">About</a>
                        <a href="{{ route('home') }}#features" class="text-gray-700 hover:text-blue-600 font-medium transition">Features</a>
                        <a href="{{ route('home') }}#activities" class="text-gray-700 hover:text-blue-600 font-medium transition">Activities</a>
                        <a href="{{ route('executives') }}" class="text-blue-600 font-medium transition">Meet Executives</a>

                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition shadow-md">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                                Sign In
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition shadow-md">
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
    <section class="hero-bg py-20 pt-32 relative overflow-hidden">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="mb-8">
                <div class="bg-white bg-opacity-20 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-users text-white text-3xl"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">Meet Our Executives</h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-8 max-w-3xl mx-auto">
                    The dedicated leaders who guide our alumni community with wisdom, faith, and unwavering commitment to Christ
                </p>
            </div>
        </div>
    </section>

    <!-- Executives Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($executives->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($executives as $executive)
                        <div class="executive-card bg-white rounded-2xl overflow-hidden shadow-lg fade-in">
                            <!-- Executive Image -->
                            <div class="relative overflow-hidden">
                                @if($executive->image)
                                    <img src="{{ asset('storage/' . $executive->image) }}"
                                         alt="{{ $executive->name }}"
                                         class="executive-image w-full h-80 object-cover">
                                @else
                                    <div class="executive-image w-full h-80 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                        <i class="fas fa-user text-white text-6xl"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Executive Info -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $executive->name }}</h3>
                                <p class="text-blue-600 font-semibold mb-4">{{ $executive->position }}</p>

                                <!-- Contact Info -->
                                <div class="space-y-2 mb-4">
                                    @if($executive->email)
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-envelope mr-3 text-blue-600"></i>
                                            <a href="mailto:{{ $executive->email }}" class="hover:text-blue-600 transition">
                                                {{ $executive->email }}
                                            </a>
                                        </div>
                                    @endif

                                    @if($executive->phone)
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-phone mr-3 text-blue-600"></i>
                                            <a href="tel:{{ $executive->phone }}" class="hover:text-blue-600 transition">
                                                {{ $executive->phone }}
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Bio -->
                                @if($executive->bio)
                                    <div class="mb-4">
                                        <h4 class="font-semibold text-gray-900 mb-2">About</h4>
                                        <p class="text-gray-600 text-sm leading-relaxed">
                                            {{ Str::limit($executive->bio, 150) }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Social Links -->
                                @if($executive->social_links)
                                    <div class="flex space-x-3 mt-4">
                                        @php
                                            $socialLinks = is_string($executive->social_links) ? json_decode($executive->social_links, true) : $executive->social_links;
                                        @endphp
                                        @if($socialLinks)
                                            @foreach($socialLinks as $platform => $url)
                                                @if($url)
                                                    <a href="{{ $url }}" target="_blank" class="text-gray-400 hover:text-blue-600 transition">
                                                        <i class="fab fa-{{ $platform }} text-lg"></i>
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                @endif

                                <!-- Contact Button -->
                                <div class="mt-6">
                                    <button onclick="contactExecutive('{{ $executive->name }}', '{{ $executive->email }}', '{{ $executive->position }}')"
                                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                                        <i class="fas fa-envelope mr-2"></i>Get in Touch
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Executives Found -->
                <div class="text-center py-16">
                    <i class="fas fa-users text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Executives Information Coming Soon!</h3>
                    <p class="text-lg text-gray-600">We're updating our executives' profiles. Check back soon to meet our amazing leaders.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Want to Serve in Leadership?</h2>
            <p class="text-xl mb-8 opacity-90 max-w-3xl mx-auto">
                We're always looking for passionate alumni who want to contribute to our community's growth and impact.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-tachometer-alt mr-2"></i>Access Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-user-plus mr-2"></i>Join Our Community
                    </a>
                @endauth
                <a href="{{ route('home') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-home mr-2"></i>Back to Home
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ asset('images/logos/fcslogo.png') }}" alt="FCS Logo" class="w-8 h-8 mr-3">
                    <div>
                        <p class="font-semibold">FCS Alumni Portal</p>
                        <p class="text-gray-400 text-sm">Fellowship of Christian Students</p>
                    </div>
                </div>
                <div class="text-gray-400 text-sm">
                    © {{ date('Y') }} All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
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

        // Contact Executive Function
        function contactExecutive(name, email, position) {
            if (!email) {
                alert('Contact information not available for this executive.');
                return;
            }

            const subject = encodeURIComponent(`Inquiry for ${name} - ${position}`);
            const body = encodeURIComponent(`Dear ${name},\n\nI hope this message finds you well. I am reaching out as a fellow FCS alumni member.\n\n[Please write your message here]\n\nBest regards,\n[Your Name]`);

            window.location.href = `mailto:${email}?subject=${subject}&body=${body}`;
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initScrollAnimations();
        });

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
    </script>
</body>
</html>
