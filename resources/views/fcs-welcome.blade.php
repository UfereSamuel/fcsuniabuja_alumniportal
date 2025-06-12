<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FCS Alumni Portal - Fellowship of Christian Students</title>

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
                overflow-x: hidden;
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

            /* Animated Background */
            .animated-bg {
                position: relative;
                background: linear-gradient(135deg, var(--fcs-blue) 0%, var(--fcs-light-blue) 100%);
                overflow: hidden;
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

            .shape:nth-child(4) {
                width: 40px;
                height: 40px;
                top: 80%;
                left: 20%;
                animation-delay: 1s;
            }

            .shape:nth-child(5) {
                width: 120px;
                height: 120px;
                top: 10%;
                left: 60%;
                animation-delay: 3s;
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

            /* Particle System */
            .particles {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
            }

            .particle {
                position: absolute;
                width: 3px;
                height: 3px;
                background: white;
                border-radius: 50%;
                opacity: 0.7;
                animation: particle-float 8s infinite linear;
            }

            @keyframes particle-float {
                0% {
                    transform: translateY(100vh) translateX(0);
                    opacity: 0;
                }
                10% {
                    opacity: 1;
                }
                90% {
                    opacity: 1;
                }
                100% {
                    transform: translateY(-100px) translateX(100px);
                    opacity: 0;
                }
            }

            /* Interactive Cards */
            .info-card {
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
            }

            .info-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }

            /* Counter Animation */
            .counter {
                font-size: 2rem;
                font-weight: 700;
                color: var(--fcs-blue);
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

            /* Testimonial Slider */
            .testimonial-slider {
                display: flex;
                transition: transform 0.5s ease;
            }

            .testimonial-slide {
                min-width: 100%;
                padding: 2rem;
            }

            /* Slider Styles */
            .hero-slider {
                position: relative;
                width: 100%;
                height: 100vh;
                overflow: hidden;
            }

            .slide {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
                transition: opacity 1s ease-in-out;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }

            .slide.active {
                opacity: 1;
            }

            .slide-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, rgba(30, 64, 175, 0.8) 0%, rgba(59, 130, 246, 0.6) 100%);
                z-index: 1;
            }

            .slide-content {
                position: relative;
                z-index: 2;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100%;
                text-align: center;
                color: white;
            }

            /* Slider Navigation */
            .slider-nav {
                position: absolute;
                bottom: 30px;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                gap: 12px;
                z-index: 10;
            }

            .nav-dot {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.5);
                cursor: pointer;
                transition: all 0.3s ease;
                border: 2px solid transparent;
            }

            .nav-dot.active {
                background: white;
                transform: scale(1.2);
                border-color: rgba(59, 130, 246, 0.8);
            }

            .nav-dot:hover {
                background: rgba(255, 255, 255, 0.8);
                transform: scale(1.1);
            }

            /* Slider Arrows */
            .slider-arrow {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                z-index: 10;
                background: rgba(255, 255, 255, 0.2);
                border: 2px solid rgba(255, 255, 255, 0.3);
                color: white;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
            }

            .slider-arrow:hover {
                background: rgba(255, 255, 255, 0.3);
                border-color: rgba(255, 255, 255, 0.5);
                transform: translateY(-50%) scale(1.1);
            }

            .slider-arrow.prev {
                left: 30px;
            }

            .slider-arrow.next {
                right: 30px;
            }

            /* Interactive Blue Overlay Effects */
            .blue-interactive-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 1;
            }

            .blue-particle {
                position: absolute;
                width: 4px;
                height: 4px;
                background: rgba(59, 130, 246, 0.7);
                border-radius: 50%;
                animation: blueParticleFloat 8s infinite linear;
            }

            @keyframes blueParticleFloat {
                0% {
                    transform: translateY(100vh) translateX(0) scale(0);
                    opacity: 0;
                }
                10% {
                    opacity: 1;
                    transform: scale(1);
                }
                90% {
                    opacity: 1;
                    transform: scale(1);
                }
                100% {
                    transform: translateY(-100px) translateX(50px) scale(0);
                    opacity: 0;
                }
            }

            .blue-wave {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 100px;
                background: linear-gradient(180deg, transparent 0%, rgba(30, 64, 175, 0.3) 100%);
                animation: waveMove 6s ease-in-out infinite;
            }

            @keyframes waveMove {
                0%, 100% {
                    transform: translateX(0);
                }
                50% {
                    transform: translateX(20px);
                }
            }

            .pulse-animation {
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            /* Activity Card Styles */
            .activity-card {
                transition: all 0.3s ease;
            }

            .activity-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }

            .activity-card:hover .info-card {
                background: rgba(255, 255, 255, 1);
            }

            /* Modal Animation */
            #activityModal {
                animation: fadeIn 0.3s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            #activityModal > div {
                animation: slideIn 0.3s ease-out;
            }

            @keyframes slideIn {
                from {
                    transform: scale(0.95) translateY(-20px);
                    opacity: 0;
                }
                to {
                    transform: scale(1) translateY(0);
                    opacity: 1;
                }
            }
        </style>
    </head>
    <body class="bg-gray-50">
        <!-- Navigation Header with Logos -->
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
                            <a href="#about" class="text-gray-700 hover:text-blue-600 font-medium transition">About</a>
                            <a href="#features" class="text-gray-700 hover:text-blue-600 font-medium transition">Features</a>
                            <a href="#activities" class="text-gray-700 hover:text-blue-600 font-medium transition">Activities</a>
                            <a href="{{ route('executives') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Meet Executives</a>

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

        <!-- Hero Section with Dynamic Slider -->
        <section class="hero-slider pt-16 relative">
            @if($sliders && $sliders->count() > 0)
                @foreach($sliders as $index => $slider)
                    <div class="slide {{ $index === 0 ? 'active' : '' }}"
                         style="background-image: url('{{ $slider->image ? asset('storage/' . $slider->image) : asset('images/logos/fcslogo.png') }}');"
                         data-slide="{{ $index }}">

                        <!-- Blue Interactive Overlay -->
                        <div class="slide-overlay"></div>
                        <div class="blue-interactive-overlay" id="blueOverlay{{ $index }}"></div>
                        <div class="blue-wave"></div>

                        <!-- Floating Shapes -->
                        <div class="floating-shapes">
                            <div class="shape"></div>
                            <div class="shape"></div>
                            <div class="shape"></div>
                            <div class="shape"></div>
                            <div class="shape"></div>
                        </div>

                        <!-- Slide Content -->
                        <div class="slide-content">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
                                <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-pulse">
                                    {{ $slider->title }}
                                </h1>
                                @if($slider->description)
                                    <p class="text-xl md:text-2xl mb-8 opacity-80 max-w-4xl mx-auto">
                                        {{ $slider->description }}
                                    </p>
                                @endif

                                <!-- Scripture Verse (Show only on first slide) -->
                                @if($index === 0)
                                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 mb-12 max-w-5xl mx-auto border border-white/20">
                                        <p class="text-lg md:text-xl font-medium italic mb-3">
                                            "But Saul increased all the more in strength, and confounded the Jews who dwelt in Damascus, proving that this Jesus is the Christ."
                                        </p>
                                        <p class="text-blue-200 font-semibold">- Acts 9:22</p>
                                    </div>
                                @endif

                                <!-- CTA Buttons -->
                                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                                    @if($slider->button_text && $slider->button_url)
                                        <a href="{{ $slider->button_url }}" class="bg-white text-blue-600 hover:bg-gray-100 px-10 py-4 rounded-xl font-bold text-lg transition shadow-xl transform hover:scale-105">
                                            <i class="fas fa-users mr-3"></i>{{ $slider->button_text }}
                                        </a>
                                    @endif

                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-600 px-10 py-4 rounded-xl font-bold text-lg transition transform hover:scale-105">
                                            <i class="fas fa-tachometer-alt mr-3"></i>Access Dashboard
                                        </a>
                                    @else
                                        @if(!($slider->button_url === '/register'))
                                            <a href="{{ route('register') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-600 px-10 py-4 rounded-xl font-bold text-lg transition transform hover:scale-105">
                                                <i class="fas fa-user-plus mr-3"></i>Join Alumni
                                            </a>
                                        @endif
                                        <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-600 px-10 py-4 rounded-xl font-bold text-lg transition transform hover:scale-105">
                                            <i class="fas fa-sign-in-alt mr-3"></i>Member Login
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Slider Navigation -->
                @if($sliders->count() > 1)
                    <!-- Navigation Dots -->
                    <div class="slider-nav">
                        @foreach($sliders as $index => $slider)
                            <div class="nav-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></div>
                        @endforeach
                    </div>

                    <!-- Navigation Arrows -->
                    <button class="slider-arrow prev" id="prevSlide">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="slider-arrow next" id="nextSlide">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                @endif
            @else
                <!-- Fallback Hero Section -->
                <div class="slide active" style="background: linear-gradient(135deg, var(--fcs-blue) 0%, var(--fcs-light-blue) 100%);">
                    <div class="slide-overlay"></div>
                    <div class="blue-interactive-overlay" id="fallbackOverlay"></div>

                    <!-- Floating Shapes -->
                    <div class="floating-shapes">
                        <div class="shape"></div>
                        <div class="shape"></div>
                        <div class="shape"></div>
                        <div class="shape"></div>
                        <div class="shape"></div>
                    </div>

                    <div class="slide-content">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
                            <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-pulse">
                                Fellowship of Christian Students
                            </h1>
                            <h2 class="text-2xl md:text-4xl font-light mb-6 opacity-90">
                                University of Abuja Alumni Network
                            </h2>
                            <p class="text-xl md:text-2xl mb-8 opacity-80 max-w-4xl mx-auto">
                                Connecting generations of believers, strengthening faith, and impacting lives for Christ across the globe
                            </p>

                            <!-- Scripture Verse -->
                            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 mb-12 max-w-5xl mx-auto border border-white/20">
                                <p class="text-lg md:text-xl font-medium italic mb-3">
                                    "But Saul increased all the more in strength, and confounded the Jews who dwelt in Damascus, proving that this Jesus is the Christ."
                                </p>
                                <p class="text-blue-200 font-semibold">- Acts 9:22</p>
                            </div>

                            <!-- CTA Buttons -->
                            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-10 py-4 rounded-xl font-bold text-lg transition shadow-xl transform hover:scale-105">
                                        <i class="fas fa-tachometer-alt mr-3"></i>Access Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-10 py-4 rounded-xl font-bold text-lg transition shadow-xl transform hover:scale-105">
                                        <i class="fas fa-users mr-3"></i>Join Our Community
                                    </a>
                                    <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-600 px-10 py-4 rounded-xl font-bold text-lg transition transform hover:scale-105">
                                        <i class="fas fa-sign-in-alt mr-3"></i>Member Login
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>

        <!-- Statistics Section -->
        <section class="py-20 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                    <div class="fade-in">
                        <div class="counter" data-target="{{ $totalMembers ?? 500 }}">0</div>
                        <p class="text-gray-600 font-semibold mt-2">Alumni Members</p>
                    </div>
                    <div class="fade-in">
                        <div class="counter" data-target="{{ $totalClasses ?? 25 }}">0</div>
                        <p class="text-gray-600 font-semibold mt-2">Graduation Classes</p>
                    </div>
                    <div class="fade-in">
                        <div class="counter" data-target="15">0</div>
                        <p class="text-gray-600 font-semibold mt-2">Years of Impact</p>
                    </div>
                    <div class="fade-in">
                        <div class="counter" data-target="50">0</div>
                        <p class="text-gray-600 font-semibold mt-2">Countries Reached</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="fade-in">
                        <h2 class="text-4xl font-bold text-gray-900 mb-6">About FCS Alumni Network</h2>
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                            The Fellowship of Christian Students (FCS) Alumni Network represents over two decades of faithful ministry at the University of Abuja. Our community spans across continents, connecting believers who were transformed during their university years and continue to impact the world for Christ.
                        </p>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            From humble beginnings in campus fellowship halls to a global network of professionals, ministers, and leaders, we remain united by our shared faith and commitment to advancing God's kingdom.
                        </p>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center p-4 bg-blue-50 rounded-lg">
                                <i class="fas fa-bible text-2xl text-blue-600 mb-2"></i>
                                <h4 class="font-semibold text-gray-900">Biblical Foundation</h4>
                            </div>
                            <div class="text-center p-4 bg-red-50 rounded-lg">
                                <i class="fas fa-globe text-2xl text-red-600 mb-2"></i>
                                <h4 class="font-semibold text-gray-900">Global Impact</h4>
                            </div>
                        </div>
                    </div>
                    <div class="fade-in">
                        <div class="bg-blue-600 rounded-2xl p-8 text-white">
                            <h3 class="text-2xl font-bold mb-6">Our Mission</h3>
                            <ul class="space-y-4">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                                    <span>Maintain lifelong fellowship among FCS alumni</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                                    <span>Support current FCS ministry and students</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                                    <span>Foster spiritual growth and accountability</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                                    <span>Create opportunities for ministry and service</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                                    <span>Build a legacy of faith for future generations</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Alumni Portal Features</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Discover how our platform helps you stay connected, grow spiritually, and make an impact
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="info-card rounded-2xl p-8 fade-in">
                        <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Class Networks</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Connect with your graduation class and other FCS alumni. Find old friends, make new connections, and build lasting relationships.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="info-card rounded-2xl p-8 fade-in">
                        <div class="w-16 h-16 bg-red-600 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-calendar-alt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Events & Reunions</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Stay updated on alumni events, class reunions, spiritual conferences, and fellowship gatherings worldwide.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="info-card rounded-2xl p-8 fade-in">
                        <div class="w-16 h-16 bg-green-600 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-pray text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Prayer Network</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Share prayer requests, celebrate answered prayers, and support each other through life's challenges and victories.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="info-card rounded-2xl p-8 fade-in">
                        <div class="w-16 h-16 bg-purple-600 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-briefcase text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Professional Network</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Leverage our alumni network for career opportunities, mentorship, and professional development in various fields.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="info-card rounded-2xl p-8 fade-in">
                        <div class="w-16 h-16 bg-indigo-600 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-book text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Resource Library</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Access spiritual resources, ministry materials, and alumni publications to support your continued growth.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="info-card rounded-2xl p-8 fade-in">
                        <div class="w-16 h-16 bg-pink-600 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-heart text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Ministry Support</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Support current FCS ministry through mentorship, financial contributions, and prayer partnership.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recent Activities Section -->
        <section id="activities" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Recent Alumni Activities</h2>
                    <p class="text-xl text-gray-600">Stay connected with what's happening in our community</p>
                </div>

                @if($recentActivities && $recentActivities->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($recentActivities->take(6) as $activity)
                            <div class="info-card rounded-2xl overflow-hidden fade-in cursor-pointer activity-card"
                                 onclick="openActivityModal({{ $activity->id }})"
                                 data-activity-id="{{ $activity->id }}"
                                 data-activity-title="{{ $activity->title }}"
                                 data-activity-description="{{ $activity->description }}"
                                 data-activity-date="{{ $activity->activity_date->format('F d, Y') }}"
                                 data-activity-time="{{ $activity->activity_date->format('g:i A') }}"
                                 data-activity-location="{{ $activity->location ?? 'Location TBA' }}"
                                 data-activity-image="{{ $activity->image ? asset('storage/' . $activity->image) : '' }}">
                                @if($activity->image)
                                    <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-blue-600 flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-white text-4xl"></i>
                                    </div>
                                @endif
                                <div class="p-6">
                                    <div class="text-sm text-blue-600 font-semibold mb-2">{{ $activity->activity_date->format('M d, Y') }}</div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-3">{{ $activity->title }}</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">{{ Str::limit($activity->description, 120) }}</p>
                                    <div class="mt-4 text-blue-600 font-medium text-sm">
                                        <i class="fas fa-info-circle mr-1"></i>Click for full details
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <i class="fas fa-calendar-alt text-6xl text-gray-300 mb-6"></i>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Exciting Activities Coming Soon!</h3>
                        <p class="text-lg text-gray-600">Stay tuned for upcoming alumni events and activities.</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- Call to Action -->
        <section class="py-20 bg-blue-600 text-white relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="grid grid-cols-8 gap-4 h-full">
                    @for($i = 0; $i < 32; $i++)
                        <div class="bg-white rounded-full animate-pulse" style="animation-delay: {{ $i * 0.1 }}s;"></div>
                    @endfor
                </div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Reconnect?</h2>
                <p class="text-xl md:text-2xl mb-10 opacity-90 max-w-3xl mx-auto">
                    Join thousands of FCS alumni worldwide in a community that continues to grow in faith and make an eternal impact.
                </p>

                @guest
                    <div class="flex flex-col sm:flex-row gap-6 justify-center">
                        <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-10 py-4 rounded-xl font-bold text-lg transition shadow-xl transform hover:scale-105">
                            <i class="fas fa-user-plus mr-3"></i>Join Our Family
                        </a>
                        <a href="#about" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-600 px-10 py-4 rounded-xl font-bold text-lg transition transform hover:scale-105">
                            <i class="fas fa-info-circle mr-3"></i>Learn More
                        </a>
                    </div>
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
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-facebook-f text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-youtube text-xl"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="#about" class="text-gray-400 hover:text-white transition">About FCS</a></li>
                            <li><a href="#features" class="text-gray-400 hover:text-white transition">Features</a></li>
                            <li><a href="#activities" class="text-gray-400 hover:text-white transition">Activities</a></li>
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

        <!-- Activity Details Modal -->
        <div id="activityModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h2 id="modalTitle" class="text-2xl font-bold text-gray-900">Activity Details</h2>
                    <button onclick="closeActivityModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <!-- Activity Image -->
                    <div id="modalImageContainer" class="mb-6 hidden">
                        <img id="modalImage" src="" alt="" class="w-full h-64 object-cover rounded-lg">
                    </div>

                    <!-- Activity Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-blue-600 mr-3 text-lg"></i>
                            <div>
                                <div class="text-sm text-gray-500">Date</div>
                                <div id="modalDate" class="font-semibold">-</div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock text-blue-600 mr-3 text-lg"></i>
                            <div>
                                <div class="text-sm text-gray-500">Time</div>
                                <div id="modalTime" class="font-semibold">-</div>
                            </div>
                        </div>
                        <div class="flex items-center md:col-span-2">
                            <i class="fas fa-map-marker-alt text-blue-600 mr-3 text-lg"></i>
                            <div>
                                <div class="text-sm text-gray-500">Location</div>
                                <div id="modalLocation" class="font-semibold">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                        <div id="modalDescription" class="text-gray-600 leading-relaxed whitespace-pre-line">-</div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                        <button onclick="shareActivity()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                            <i class="fas fa-share mr-2"></i>Share Activity
                        </button>
                        <button onclick="closeActivityModal()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition">
                            <i class="fas fa-times mr-2"></i>Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript for Animations -->
        <script>
            // Slider Variables
            let currentSlide = 0;
            let totalSlides = 0;
            let sliderInterval;

            // Blue Particle System for Interactive Overlay
            function createBlueParticles(containerId) {
                const container = document.getElementById(containerId);
                if (!container) return;

                for (let i = 0; i < 30; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'blue-particle';
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.animationDuration = (Math.random() * 5 + 4) + 's';
                    particle.style.animationDelay = Math.random() * 3 + 's';
                    container.appendChild(particle);
                }
            }

            // Slider Functions
            function initSlider() {
                const slides = document.querySelectorAll('.slide');
                const dots = document.querySelectorAll('.nav-dot');
                totalSlides = slides.length;

                if (totalSlides <= 1) return;

                // Create blue particles for each slide
                slides.forEach((slide, index) => {
                    const overlayId = 'blueOverlay' + index;
                    createBlueParticles(overlayId);
                });

                // Navigation dot clicks
                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => goToSlide(index));
                });

                // Arrow clicks
                const prevBtn = document.getElementById('prevSlide');
                const nextBtn = document.getElementById('nextSlide');

                if (prevBtn) prevBtn.addEventListener('click', prevSlide);
                if (nextBtn) nextBtn.addEventListener('click', nextSlide);

                // Auto-play
                startAutoPlay();

                // Pause auto-play on hover
                const slider = document.querySelector('.hero-slider');
                if (slider) {
                    slider.addEventListener('mouseenter', stopAutoPlay);
                    slider.addEventListener('mouseleave', startAutoPlay);
                }
            }

            function goToSlide(index) {
                const slides = document.querySelectorAll('.slide');
                const dots = document.querySelectorAll('.nav-dot');

                // Remove active class from current slide and dot
                slides[currentSlide].classList.remove('active');
                if (dots[currentSlide]) dots[currentSlide].classList.remove('active');

                // Add active class to new slide and dot
                currentSlide = index;
                slides[currentSlide].classList.add('active');
                if (dots[currentSlide]) dots[currentSlide].classList.add('active');
            }

            function nextSlide() {
                const nextIndex = (currentSlide + 1) % totalSlides;
                goToSlide(nextIndex);
            }

            function prevSlide() {
                const prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
                goToSlide(prevIndex);
            }

            function startAutoPlay() {
                if (totalSlides > 1) {
                    sliderInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
                }
            }

            function stopAutoPlay() {
                clearInterval(sliderInterval);
            }

            // Legacy Particle System (for fallback)
            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                if (!particlesContainer) return;

                for (let i = 0; i < 50; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.animationDuration = (Math.random() * 5 + 3) + 's';
                    particle.style.animationDelay = Math.random() * 2 + 's';
                    particlesContainer.appendChild(particle);
                }
            }

            // Counter Animation
            function animateCounters() {
                const counters = document.querySelectorAll('.counter');
                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-target'));
                    let current = 0;
                    const increment = target / 100;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        counter.textContent = Math.floor(current) + '+';
                    }, 20);
                });
            }

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

            // Initialize everything when DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize slider
                initSlider();

                // Create blue particles for fallback overlay
                createBlueParticles('fallbackOverlay');

                // Legacy particles for compatibility
                createParticles();

                // Initialize scroll animations
                initScrollAnimations();

                // Animate counters when they come into view
                const countersSection = document.querySelector('.counter');
                if (countersSection) {
                    const countersContainer = countersSection.closest('section');
                    const countersObserver = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                animateCounters();
                                countersObserver.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.5 });

                    if (countersContainer) {
                        countersObserver.observe(countersContainer);
                    }
                }
            });

            // Keyboard Navigation
            document.addEventListener('keydown', function(e) {
                if (totalSlides > 1) {
                    if (e.key === 'ArrowLeft') {
                        prevSlide();
                    } else if (e.key === 'ArrowRight') {
                        nextSlide();
                    }
                }
            });

            // Touch/Swipe Support
            let touchStartX = 0;
            let touchEndX = 0;

            document.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            });

            document.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                if (totalSlides <= 1) return;

                const swipeThreshold = 50;
                const diff = touchStartX - touchEndX;

                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        nextSlide(); // Swipe left - next slide
                    } else {
                        prevSlide(); // Swipe right - previous slide
                    }
                }
            }

            // Activity Modal Functions
            function openActivityModal(activityId) {
                const activityCard = document.querySelector(`[data-activity-id="${activityId}"]`);
                if (!activityCard) return;

                const modal = document.getElementById('activityModal');
                const title = activityCard.dataset.activityTitle;
                const description = activityCard.dataset.activityDescription;
                const date = activityCard.dataset.activityDate;
                const time = activityCard.dataset.activityTime;
                const location = activityCard.dataset.activityLocation;
                const image = activityCard.dataset.activityImage;

                // Update modal content
                document.getElementById('modalTitle').textContent = title;
                document.getElementById('modalDescription').textContent = description;
                document.getElementById('modalDate').textContent = date;
                document.getElementById('modalTime').textContent = time;
                document.getElementById('modalLocation').textContent = location;

                // Handle image
                const imageContainer = document.getElementById('modalImageContainer');
                const imageElement = document.getElementById('modalImage');

                if (image && image.trim() !== '') {
                    imageElement.src = image;
                    imageElement.alt = title;
                    imageContainer.classList.remove('hidden');
                } else {
                    imageContainer.classList.add('hidden');
                }

                // Show modal
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                // Add click outside to close
                modal.addEventListener('click', handleModalClick);
            }

            function closeActivityModal() {
                const modal = document.getElementById('activityModal');
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                modal.removeEventListener('click', handleModalClick);
            }

            function handleModalClick(event) {
                if (event.target === event.currentTarget) {
                    closeActivityModal();
                }
            }

            function shareActivity() {
                const title = document.getElementById('modalTitle').textContent;
                const description = document.getElementById('modalDescription').textContent;
                const date = document.getElementById('modalDate').textContent;

                const shareText = `${title}\n\nDate: ${date}\n\n${description}\n\nJoin us at FCS Alumni Portal!`;

                if (navigator.share) {
                    navigator.share({
                        title: title,
                        text: shareText,
                        url: window.location.href
                    });
                } else {
                    // Fallback - copy to clipboard
                    navigator.clipboard.writeText(shareText).then(() => {
                        alert('Activity details copied to clipboard!');
                    }).catch(() => {
                        // Final fallback
                        prompt('Copy this text:', shareText);
                    });
                }
            }

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeActivityModal();
                }
            });
        </script>
    </body>
</html>
