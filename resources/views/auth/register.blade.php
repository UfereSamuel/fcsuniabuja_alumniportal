<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Join FCS Alumni Portal - Register</title>

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
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .bg-pattern {
            background-image:
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 60% 60%, rgba(147, 197, 253, 0.1) 0%, transparent 50%);
        }
        .register-card {
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
            left: 40px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            transition: all 0.3s ease;
            pointer-events: none;
            background: white;
            padding: 0 4px;
        }
        .form-input {
            padding: 12px 16px 12px 40px;
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
            left: 40px;
            font-size: 12px;
            color: #1e40af;
            font-weight: 500;
        }
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.3s ease;
        }
        .input-group:focus-within .input-icon {
            color: #1e40af;
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
        .step-indicator {
            transition: all 0.3s ease;
        }
        .step-indicator.active {
            background: #1e40af;
            color: white;
        }
        .step-indicator.completed {
            background: #059669;
            color: white;
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
        .progress-bar {
            transition: width 0.5s ease;
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
        <div class="interactive-particle" style="top: 10%; left: 8%; width: 10px; height: 10px; animation-delay: 0s;"></div>
        <div class="interactive-particle" style="top: 20%; right: 12%; width: 14px; height: 14px; animation-delay: 1s;"></div>
        <div class="interactive-particle" style="bottom: 35%; left: 15%; width: 8px; height: 8px; animation-delay: 2s;"></div>
        <div class="interactive-particle" style="top: 35%; right: 20%; width: 12px; height: 12px; animation-delay: 0.5s;"></div>
        <div class="interactive-particle" style="bottom: 50%; right: 8%; width: 6px; height: 6px; animation-delay: 1.5s;"></div>
        <div class="interactive-particle" style="top: 55%; left: 25%; width: 16px; height: 16px; animation-delay: 3s;"></div>
        <div class="interactive-particle" style="bottom: 15%; left: 40%; width: 9px; height: 9px; animation-delay: 2.5s;"></div>
        <div class="interactive-particle" style="top: 75%; right: 35%; width: 11px; height: 11px; animation-delay: 4s;"></div>
        <div class="interactive-particle" style="top: 45%; left: 5%; width: 7px; height: 7px; animation-delay: 3.5s;"></div>
        <div class="interactive-particle" style="bottom: 25%; right: 45%; width: 13px; height: 13px; animation-delay: 0.8s;"></div>
    </div>

    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-10 left-10 w-20 h-20 bg-white bg-opacity-10 rounded-full animate-float"></div>
        <div class="absolute top-40 right-20 w-16 h-16 bg-blue-300 bg-opacity-20 rounded-full animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-20 w-12 h-12 bg-blue-200 bg-opacity-15 rounded-full animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-40 right-10 w-14 h-14 bg-white bg-opacity-10 rounded-full animate-float" style="animation-delay: 0.5s;"></div>
        <div class="absolute top-1/2 left-1/4 w-8 h-8 bg-blue-100 bg-opacity-20 rounded-full animate-float" style="animation-delay: 3s;"></div>
        <div class="absolute top-1/3 right-1/3 w-6 h-6 bg-white bg-opacity-15 rounded-full animate-float" style="animation-delay: 1.5s;"></div>
        <div class="absolute bottom-1/3 left-1/2 w-10 h-10 bg-blue-200 bg-opacity-10 rounded-full animate-float" style="animation-delay: 2.5s;"></div>
    </div>

    <div class="w-full max-w-4xl relative z-10">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center mb-4 relative">
                <div class="absolute w-20 h-20 bg-white bg-opacity-30 rounded-full pulse-ring"></div>
                <div class="relative bg-white rounded-full p-4 shadow-xl">
                    <img src="{{ asset('images/logos/fcslogo.png') }}" alt="FCS Logo" class="w-12 h-12">
                </div>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Join FCS Alumni Portal</h1>
            <p class="text-white text-opacity-90">Connect with fellow graduates and stay part of our community</p>
        </div>

        <!-- Registration Card -->
        <div class="register-card rounded-2xl p-8 shadow-2xl" x-data="registrationForm()">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex space-x-4">
                        <div class="step-indicator w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold"
                             :class="currentStep >= 1 ? 'active' : 'bg-gray-200'">1</div>
                        <div class="step-indicator w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold"
                             :class="currentStep >= 2 ? 'active' : 'bg-gray-200'">2</div>
                        <div class="step-indicator w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold"
                             :class="currentStep >= 3 ? 'active' : 'bg-gray-200'">3</div>
                    </div>
                    <span class="text-sm text-gray-600" x-text="`Step ${currentStep} of 3`"></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="progress-bar bg-fcs-primary h-2 rounded-full" :style="`width: ${(currentStep / 3) * 100}%`"></div>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}" @submit="isLoading = true">
                @csrf

                <!-- Step 1: Personal Information -->
                <div x-show="currentStep === 1" x-transition>
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Personal Information</h2>
                        <p class="text-gray-600">Let's start with your basic details</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="md:col-span-2">
                            <div class="input-group">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                       placeholder=" " class="form-input w-full rounded-lg">
                                <label class="floating-label">Full Name</label>
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <div class="input-group">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       placeholder=" " class="form-input w-full rounded-lg">
                                <label class="floating-label">Email Address</label>
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <div class="input-group">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="tel" name="phone" value="{{ old('phone') }}"
                                       placeholder=" " class="form-input w-full rounded-lg">
                                <label class="floating-label">Phone Number</label>
                            </div>
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <div class="input-group">
                                <i class="fas fa-venus-mars input-icon"></i>
                                <select name="gender" class="form-input w-full rounded-lg pl-10">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            @error('gender')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <div class="input-group">
                                <i class="fas fa-birthday-cake input-icon"></i>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                       class="form-input w-full rounded-lg pl-10">
                            </div>
                            @error('date_of_birth')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Step 2: Academic Information -->
                <div x-show="currentStep === 2" x-transition>
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Academic Information</h2>
                        <p class="text-gray-600">Tell us about your university experience</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Graduation Class -->
                        <div class="md:col-span-2">
                            <div class="input-group">
                                <i class="fas fa-graduation-cap input-icon"></i>
                                <select name="class_id" required class="form-input w-full rounded-lg pl-10">
                                    <option value="">Select your graduation class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('class_id')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Current Occupation -->
                        <div>
                            <div class="input-group">
                                <i class="fas fa-briefcase input-icon"></i>
                                <input type="text" name="occupation" value="{{ old('occupation') }}"
                                       placeholder=" " class="form-input w-full rounded-lg">
                                <label class="floating-label">Current Occupation</label>
                            </div>
                            @error('occupation')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Current Location -->
                        <div>
                            <div class="input-group">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                <input type="text" name="location" value="{{ old('location') }}"
                                       placeholder=" " class="form-input w-full rounded-lg">
                                <label class="floating-label">Current Location</label>
                            </div>
                            @error('location')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Zone Selection -->
                        <div class="md:col-span-2">
                            <div class="input-group">
                                <i class="fas fa-globe-africa input-icon"></i>
                                <select name="zone_id" required class="form-input w-full rounded-lg pl-10">
                                    <option value="">Select your zone</option>
                                    @foreach($zones as $zone)
                                        <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                            {{ $zone->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('zone_id')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>Choose the zone closest to your current location. You can change this later in your profile.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Security & Preferences -->
                <div x-show="currentStep === 3" x-transition>
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Security & Preferences</h2>
                        <p class="text-gray-600">Set up your password and preferences</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <div class="input-group" x-data="{ showPassword: false }">
                                <i class="fas fa-lock input-icon"></i>
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                       placeholder=" " class="form-input w-full rounded-lg pr-12">
                                <label class="floating-label">Password</label>
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

                        <!-- Confirm Password -->
                        <div>
                            <div class="input-group" x-data="{ showPassword: false }">
                                <i class="fas fa-lock input-icon"></i>
                                <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" required
                                       placeholder=" " class="form-input w-full rounded-lg pr-12">
                                <label class="floating-label">Confirm Password</label>
                                <button type="button" @click="showPassword = !showPassword"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Interests -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-heart mr-2"></i>Interests (Select all that apply)
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @php
                                    $interests = ['Fellowship', 'Bible Study', 'Outreach', 'Prayer', 'Leadership', 'Music & Worship', 'Community Service', 'Youth Ministry', 'Discipleship'];
                                @endphp
                                @foreach($interests as $interest)
                                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                        <input type="checkbox" name="interests[]" value="{{ strtolower(str_replace(' ', '_', $interest)) }}"
                                               class="w-4 h-4 text-fcs-blue border-gray-300 rounded focus:ring-fcs-blue">
                                        <span class="ml-2 text-sm text-gray-700">{{ $interest }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="md:col-span-2">
                            <label class="flex items-start">
                                <input type="checkbox" name="terms" required
                                       class="w-4 h-4 text-fcs-blue border-gray-300 rounded focus:ring-fcs-blue mt-1">
                                <span class="ml-3 text-sm text-gray-700">
                                    I agree to the <a href="#" class="text-fcs-blue hover:text-fcs-light-blue font-medium">Terms of Service</a>
                                    and <a href="#" class="text-fcs-blue hover:text-fcs-light-blue font-medium">Privacy Policy</a>
                                </span>
                            </label>
                            @error('terms')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center mt-8">
                    <button type="button" @click="previousStep()" x-show="currentStep > 1"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-3 px-6 rounded-lg font-medium transition">
                        <i class="fas fa-arrow-left mr-2"></i>Previous
                    </button>
                    <div x-show="currentStep === 1"></div>

                    <button type="button" @click="nextStep()" x-show="currentStep < 3"
                            class="btn-primary text-white py-3 px-6 rounded-lg font-medium">
                        Next<i class="fas fa-arrow-right ml-2"></i>
                    </button>

                    <button type="submit" x-show="currentStep === 3" :disabled="isLoading"
                            class="btn-primary text-white py-3 px-6 rounded-lg font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!isLoading" class="flex items-center">
                            <i class="fas fa-user-plus mr-2"></i>Create Account
                        </span>
                        <span x-show="isLoading" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Creating Account...
                        </span>
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="mt-8 text-center border-t border-gray-200 pt-6">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-fcs-blue hover:text-fcs-light-blue font-medium">
                        Sign in here
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
                Alumni Portal v1.0 • Building Community Since Day One
            </p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function registrationForm() {
            return {
                currentStep: 1,
                isLoading: false,

                nextStep() {
                    if (this.currentStep < 3) {
                        this.currentStep++;
                    }
                },

                previousStep() {
                    if (this.currentStep > 1) {
                        this.currentStep--;
                    }
                }
            }
        }
    </script>
</body>
</html>
