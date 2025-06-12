<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - FCS Alumni Portal</title>

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
                        'fcs-primary': '#1e40af',
                        'fcs-secondary': '#dc2626',
                        'fcs-gold': '#f59e0b',
                        'fcs-purple': '#7c3aed',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #1e40af; /* Fallback color */
            background-image:
                linear-gradient(135deg, rgba(30, 64, 175, 0.85) 0%, rgba(59, 130, 246, 0.75) 50%, rgba(147, 197, 253, 0.65) 100%),
                url('/images/gallery/uni_bkgd.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        /* Additional background fallbacks */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/images/gallery/uni_bkgd.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -2;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.85) 0%, rgba(59, 130, 246, 0.75) 50%, rgba(147, 197, 253, 0.65) 100%);
            z-index: -1;
        }

        .bg-pattern {
            background-image:
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 60% 60%, rgba(147, 197, 253, 0.1) 0%, transparent 50%);
        }
        .login-card {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .input-group {
            position: relative;
        }
        .floating-label {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            transition: all 0.3s ease;
            pointer-events: none;
            background: white;
            padding: 0 4px;
        }
        .form-input {
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
        }
        .form-input:focus {
            border-color: #1e40af;
            outline: none;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            background: rgba(255, 255, 255, 1);
        }
        .form-input:focus + .floating-label,
        .form-input:not(:placeholder-shown) + .floating-label {
            top: -6px;
            left: 12px;
            font-size: 12px;
            color: #1e40af;
            font-weight: 500;
        }
        .btn-primary {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            transform: translateY(0);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 64, 175, 0.3);
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .pulse-ring {
            animation: pulse-ring 2s infinite;
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.33); }
            80%, 100% { transform: scale(1); opacity: 0; }
        }
        /* Interactive overlay effects */
        .interactive-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        .interactive-particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: particle-float 4s ease-in-out infinite;
        }
        @keyframes particle-float {
            0%, 100% { transform: translateY(0px) translateX(0px); opacity: 0.3; }
            25% { transform: translateY(-20px) translateX(10px); opacity: 0.7; }
            50% { transform: translateY(-10px) translateX(-5px); opacity: 0.5; }
            75% { transform: translateY(-30px) translateX(15px); opacity: 0.8; }
        }
        .blue-waves {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(0deg, rgba(30, 64, 175, 0.2) 0%, transparent 100%);
            animation: wave-animation 3s ease-in-out infinite;
        }
        @keyframes wave-animation {
            0%, 100% { transform: scaleY(1); }
            50% { transform: scaleY(1.1); }
        }
    </style>
</head>
<body class="min-h-screen bg-pattern flex items-center justify-center p-4">
    <!-- Enhanced Interactive Background Overlay -->
    <div class="interactive-overlay">
        <!-- Blue wave effect at bottom -->
        <div class="blue-waves"></div>

        <!-- Interactive particles -->
        <div class="interactive-particle" style="top: 15%; left: 10%; width: 8px; height: 8px; animation-delay: 0s;"></div>
        <div class="interactive-particle" style="top: 25%; right: 15%; width: 12px; height: 12px; animation-delay: 1s;"></div>
        <div class="interactive-particle" style="bottom: 30%; left: 20%; width: 6px; height: 6px; animation-delay: 2s;"></div>
        <div class="interactive-particle" style="top: 40%; right: 25%; width: 10px; height: 10px; animation-delay: 0.5s;"></div>
        <div class="interactive-particle" style="bottom: 45%; right: 10%; width: 8px; height: 8px; animation-delay: 1.5s;"></div>
        <div class="interactive-particle" style="top: 60%; left: 30%; width: 14px; height: 14px; animation-delay: 3s;"></div>
        <div class="interactive-particle" style="bottom: 20%; left: 45%; width: 7px; height: 7px; animation-delay: 2.5s;"></div>
        <div class="interactive-particle" style="top: 70%; right: 40%; width: 9px; height: 9px; animation-delay: 4s;"></div>
    </div>

    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-10 left-10 w-20 h-20 bg-white bg-opacity-10 rounded-full animate-float"></div>
        <div class="absolute top-40 right-20 w-16 h-16 bg-blue-300 bg-opacity-20 rounded-full animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-20 w-12 h-12 bg-blue-200 bg-opacity-15 rounded-full animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-40 right-10 w-14 h-14 bg-white bg-opacity-10 rounded-full animate-float" style="animation-delay: 0.5s;"></div>
        <div class="absolute top-1/2 left-1/4 w-8 h-8 bg-blue-100 bg-opacity-20 rounded-full animate-float" style="animation-delay: 3s;"></div>
        <div class="absolute top-1/3 right-1/3 w-6 h-6 bg-white bg-opacity-15 rounded-full animate-float" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center mb-4 relative">
                <div class="absolute w-20 h-20 bg-white bg-opacity-30 rounded-full pulse-ring"></div>
                <div class="relative bg-white rounded-full p-4 shadow-xl">
                    <img src="{{ asset('images/logos/fcslogo.png') }}" alt="FCS Logo" class="w-12 h-12">
                </div>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Welcome Back</h1>
            <p class="text-white text-opacity-90">Sign in to your FCS Alumni Portal account</p>
        </div>

        <!-- Login Card -->
        <div class="login-card rounded-2xl p-8 shadow-2xl">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" x-data="{ isLoading: false }" @submit="isLoading = true">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <div class="input-group">
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder=" "
                               class="form-input w-full rounded-lg">
                        <label for="email" class="floating-label">
                            <i class="fas fa-envelope mr-2"></i>Email Address
                        </label>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <div class="input-group" x-data="{ showPassword: false }">
                        <input id="password"
                               :type="showPassword ? 'text' : 'password'"
                               name="password"
                               required autocomplete="current-password"
                               placeholder=" "
                               class="form-input w-full rounded-lg pr-12">
                        <label for="password" class="floating-label">
                            <i class="fas fa-lock mr-2"></i>Password
                        </label>
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember"
                               class="w-4 h-4 text-fcs-blue border-gray-300 rounded focus:ring-fcs-blue focus:ring-2">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-fcs-blue hover:text-fcs-light-blue font-medium">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit"
                        :disabled="isLoading"
                        class="btn-primary w-full text-white font-semibold py-3 px-4 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!isLoading" class="flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </span>
                    <span x-show="isLoading" class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Signing in...
                    </span>
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-fcs-blue hover:text-fcs-light-blue font-medium">
                        Create account
                    </a>
                </p>
            </div>
        </div>

        <!-- Back to Website Link -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center text-white text-opacity-90 hover:text-white transition-colors duration-300 text-sm font-medium">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Website
            </a>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-white text-opacity-75 text-sm">
                Fellowship of Christian Students • University of Abuja
            </p>
            <p class="text-white text-opacity-60 text-xs mt-1">
                Alumni Portal v1.0 • Made with ❤️ for FCS Community
            </p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
