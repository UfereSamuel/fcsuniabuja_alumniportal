<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Content Settings - FCS Admin Panel</title>

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
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                        <img src="{{ asset('images/logos/fcslogo.png') }}" alt="FCS Logo" class="w-10 h-10 mr-3">
                        <div>
                            <h1 class="text-lg font-bold text-gray-900">FCS Admin Panel</h1>
                            <p class="text-xs text-gray-500">Content Settings</p>
                        </div>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.settings.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Settings
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Content Settings</h1>
            <p class="text-gray-600 mt-2">Manage homepage content, about pages, and static text across the website</p>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.settings.update-content') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Homepage Content -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Homepage Content</h2>
                    <p class="text-sm text-gray-500 mt-1">Customize the main homepage sections</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Hero Title -->
                    <div>
                        <label for="hero_title" class="block text-sm font-medium text-gray-700 mb-1">Hero Section Title</label>
                        <input type="text" name="hero_title" id="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('hero_title') border-red-500 @enderror"
                               placeholder="Welcome to FCS Alumni Portal">
                        @error('hero_title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hero Subtitle -->
                    <div>
                        <label for="hero_subtitle" class="block text-sm font-medium text-gray-700 mb-1">Hero Section Subtitle</label>
                        <input type="text" name="hero_subtitle" id="hero_subtitle" value="{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('hero_subtitle') border-red-500 @enderror"
                               placeholder="Connecting Alumni, Building Community">
                        @error('hero_subtitle')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hero Description -->
                    <div>
                        <label for="hero_description" class="block text-sm font-medium text-gray-700 mb-1">Hero Section Description</label>
                        <textarea name="hero_description" id="hero_description" rows="4"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('hero_description') border-red-500 @enderror"
                                  placeholder="Join our vibrant community of FCS alumni. Stay connected, attend exclusive events, and grow your professional network.">{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
                        @error('hero_description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Call to Action Button Text -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="cta_primary_text" class="block text-sm font-medium text-gray-700 mb-1">Primary CTA Button Text</label>
                            <input type="text" name="cta_primary_text" id="cta_primary_text" value="{{ old('cta_primary_text', $settings['cta_primary_text'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cta_primary_text') border-red-500 @enderror"
                                   placeholder="Join Now">
                            @error('cta_primary_text')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cta_secondary_text" class="block text-sm font-medium text-gray-700 mb-1">Secondary CTA Button Text</label>
                            <input type="text" name="cta_secondary_text" id="cta_secondary_text" value="{{ old('cta_secondary_text', $settings['cta_secondary_text'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cta_secondary_text') border-red-500 @enderror"
                                   placeholder="Learn More">
                            @error('cta_secondary_text')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">About Section</h2>
                    <p class="text-sm text-gray-500 mt-1">Customize the about section content</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- About Title -->
                    <div>
                        <label for="about_title" class="block text-sm font-medium text-gray-700 mb-1">About Section Title</label>
                        <input type="text" name="about_title" id="about_title" value="{{ old('about_title', $settings['about_title'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('about_title') border-red-500 @enderror"
                               placeholder="About FCS">
                        @error('about_title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- About Content -->
                    <div>
                        <label for="about_content" class="block text-sm font-medium text-gray-700 mb-1">About Content</label>
                        <textarea name="about_content" id="about_content" rows="6"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('about_content') border-red-500 @enderror"
                                  placeholder="The Fellowship of Christian Students (FCS) is a vibrant community of faith-based students and alumni...">{{ old('about_content', $settings['about_content'] ?? '') }}</textarea>
                        @error('about_content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mission Statement -->
                    <div>
                        <label for="mission_statement" class="block text-sm font-medium text-gray-700 mb-1">Mission Statement</label>
                        <textarea name="mission_statement" id="mission_statement" rows="4"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mission_statement') border-red-500 @enderror"
                                  placeholder="Our mission is to build a community of Christian leaders who impact their communities and the world for Christ.">{{ old('mission_statement', $settings['mission_statement'] ?? '') }}</textarea>
                        @error('mission_statement')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vision Statement -->
                    <div>
                        <label for="vision_statement" class="block text-sm font-medium text-gray-700 mb-1">Vision Statement</label>
                        <textarea name="vision_statement" id="vision_statement" rows="4"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('vision_statement') border-red-500 @enderror"
                                  placeholder="To see a generation of Christian leaders transforming society through their influence and impact.">{{ old('vision_statement', $settings['vision_statement'] ?? '') }}</textarea>
                        @error('vision_statement')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Features Section</h2>
                    <p class="text-sm text-gray-500 mt-1">Highlight key features and benefits</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Feature 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="feature_1_title" class="block text-sm font-medium text-gray-700 mb-1">Feature 1 Title</label>
                            <input type="text" name="feature_1_title" id="feature_1_title" value="{{ old('feature_1_title', $settings['feature_1_title'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('feature_1_title') border-red-500 @enderror"
                                   placeholder="Networking">
                            @error('feature_1_title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="feature_1_description" class="block text-sm font-medium text-gray-700 mb-1">Feature 1 Description</label>
                            <textarea name="feature_1_description" id="feature_1_description" rows="2"
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('feature_1_description') border-red-500 @enderror"
                                      placeholder="Connect with fellow alumni and expand your professional network">{{ old('feature_1_description', $settings['feature_1_description'] ?? '') }}</textarea>
                            @error('feature_1_description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="feature_2_title" class="block text-sm font-medium text-gray-700 mb-1">Feature 2 Title</label>
                            <input type="text" name="feature_2_title" id="feature_2_title" value="{{ old('feature_2_title', $settings['feature_2_title'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('feature_2_title') border-red-500 @enderror"
                                   placeholder="Events">
                            @error('feature_2_title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="feature_2_description" class="block text-sm font-medium text-gray-700 mb-1">Feature 2 Description</label>
                            <textarea name="feature_2_description" id="feature_2_description" rows="2"
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('feature_2_description') border-red-500 @enderror"
                                      placeholder="Attend exclusive alumni events, conferences, and gatherings">{{ old('feature_2_description', $settings['feature_2_description'] ?? '') }}</textarea>
                            @error('feature_2_description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="feature_3_title" class="block text-sm font-medium text-gray-700 mb-1">Feature 3 Title</label>
                            <input type="text" name="feature_3_title" id="feature_3_title" value="{{ old('feature_3_title', $settings['feature_3_title'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('feature_3_title') border-red-500 @enderror"
                                   placeholder="Community">
                            @error('feature_3_title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="feature_3_description" class="block text-sm font-medium text-gray-700 mb-1">Feature 3 Description</label>
                            <textarea name="feature_3_description" id="feature_3_description" rows="2"
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('feature_3_description') border-red-500 @enderror"
                                      placeholder="Join a supportive community of like-minded Christian professionals">{{ old('feature_3_description', $settings['feature_3_description'] ?? '') }}</textarea>
                            @error('feature_3_description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Content -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Footer Content</h2>
                    <p class="text-sm text-gray-500 mt-1">Customize footer text and links</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Footer About -->
                    <div>
                        <label for="footer_about" class="block text-sm font-medium text-gray-700 mb-1">Footer About Text</label>
                        <textarea name="footer_about" id="footer_about" rows="3"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('footer_about') border-red-500 @enderror"
                                  placeholder="Brief description about FCS for the footer section">{{ old('footer_about', $settings['footer_about'] ?? '') }}</textarea>
                        @error('footer_about')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Copyright Text -->
                    <div>
                        <label for="copyright_text" class="block text-sm font-medium text-gray-700 mb-1">Copyright Text</label>
                        <input type="text" name="copyright_text" id="copyright_text" value="{{ old('copyright_text', $settings['copyright_text'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('copyright_text') border-red-500 @enderror"
                               placeholder="© 2024 Fellowship of Christian Students. All rights reserved.">
                        @error('copyright_text')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Maintenance Mode -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Maintenance Mode</h2>
                    <p class="text-sm text-gray-500 mt-1">Control site availability and maintenance messages</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Maintenance Toggle -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Enable Maintenance Mode</h3>
                            <p class="text-sm text-gray-500">Put the site in maintenance mode for updates</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="maintenance_mode" value="1"
                                   {{ old('maintenance_mode', $settings['maintenance_mode'] ?? false) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Maintenance Message -->
                    <div>
                        <label for="maintenance_message" class="block text-sm font-medium text-gray-700 mb-1">Maintenance Message</label>
                        <textarea name="maintenance_message" id="maintenance_message" rows="3"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('maintenance_message') border-red-500 @enderror"
                                  placeholder="We are currently performing scheduled maintenance. Please check back soon.">{{ old('maintenance_message', $settings['maintenance_message'] ?? '') }}</textarea>
                        @error('maintenance_message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Content Preview -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">
                    <i class="fas fa-eye mr-2"></i>Content Preview
                </h3>
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <!-- Hero Preview -->
                    <div class="text-center mb-8 pb-8 border-b">
                        <h1 class="text-4xl font-bold text-gray-900 mb-4" id="preview-hero-title">Welcome to FCS Alumni Portal</h1>
                        <h2 class="text-xl text-blue-600 mb-4" id="preview-hero-subtitle">Connecting Alumni, Building Community</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto mb-6" id="preview-hero-description">Join our vibrant community of FCS alumni. Stay connected, attend exclusive events, and grow your professional network.</p>
                        <div class="space-x-4">
                            <button class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium" id="preview-cta-primary">Join Now</button>
                            <button class="border border-blue-600 text-blue-600 px-6 py-3 rounded-lg font-medium" id="preview-cta-secondary">Learn More</button>
                        </div>
                    </div>

                    <!-- About Preview -->
                    <div class="mb-8 pb-8 border-b">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4" id="preview-about-title">About FCS</h2>
                        <p class="text-gray-600 mb-4" id="preview-about-content">The Fellowship of Christian Students (FCS) is a vibrant community of faith-based students and alumni...</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Mission</h3>
                                <p class="text-gray-600" id="preview-mission">Our mission is to build a community of Christian leaders who impact their communities and the world for Christ.</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Vision</h3>
                                <p class="text-gray-600" id="preview-vision">To see a generation of Christian leaders transforming society through their influence and impact.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Features Preview -->
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Key Features</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2" id="preview-feature-1-title">Networking</h3>
                                <p class="text-gray-600" id="preview-feature-1-desc">Connect with fellow alumni and expand your professional network</p>
                            </div>
                            <div class="text-center">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2" id="preview-feature-2-title">Events</h3>
                                <p class="text-gray-600" id="preview-feature-2-desc">Attend exclusive alumni events, conferences, and gatherings</p>
                            </div>
                            <div class="text-center">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2" id="preview-feature-3-title">Community</h3>
                                <p class="text-gray-600" id="preview-feature-3-desc">Join a supportive community of like-minded Christian professionals</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-between">
                <div class="flex space-x-4">
                    <form action="{{ route('admin.settings.reset') }}" method="POST" class="inline"
                          onsubmit="return confirm('Are you sure you want to reset all content settings to defaults? This action cannot be undone.')">
                        @csrf
                        <input type="hidden" name="category" value="content">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition">
                            <i class="fas fa-undo mr-2"></i>Reset to Defaults
                        </button>
                    </form>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.settings.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="fas fa-save mr-2"></i>Save Content Settings
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript for preview updates -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Input elements
            const inputs = {
                hero_title: document.getElementById('hero_title'),
                hero_subtitle: document.getElementById('hero_subtitle'),
                hero_description: document.getElementById('hero_description'),
                cta_primary_text: document.getElementById('cta_primary_text'),
                cta_secondary_text: document.getElementById('cta_secondary_text'),
                about_title: document.getElementById('about_title'),
                about_content: document.getElementById('about_content'),
                mission_statement: document.getElementById('mission_statement'),
                vision_statement: document.getElementById('vision_statement'),
                feature_1_title: document.getElementById('feature_1_title'),
                feature_1_description: document.getElementById('feature_1_description'),
                feature_2_title: document.getElementById('feature_2_title'),
                feature_2_description: document.getElementById('feature_2_description'),
                feature_3_title: document.getElementById('feature_3_title'),
                feature_3_description: document.getElementById('feature_3_description')
            };

            // Preview elements
            const previews = {
                hero_title: document.getElementById('preview-hero-title'),
                hero_subtitle: document.getElementById('preview-hero-subtitle'),
                hero_description: document.getElementById('preview-hero-description'),
                cta_primary: document.getElementById('preview-cta-primary'),
                cta_secondary: document.getElementById('preview-cta-secondary'),
                about_title: document.getElementById('preview-about-title'),
                about_content: document.getElementById('preview-about-content'),
                mission: document.getElementById('preview-mission'),
                vision: document.getElementById('preview-vision'),
                feature_1_title: document.getElementById('preview-feature-1-title'),
                feature_1_desc: document.getElementById('preview-feature-1-desc'),
                feature_2_title: document.getElementById('preview-feature-2-title'),
                feature_2_desc: document.getElementById('preview-feature-2-desc'),
                feature_3_title: document.getElementById('preview-feature-3-title'),
                feature_3_desc: document.getElementById('preview-feature-3-desc')
            };

            function updatePreview() {
                // Update hero section
                previews.hero_title.textContent = inputs.hero_title.value || 'Welcome to FCS Alumni Portal';
                previews.hero_subtitle.textContent = inputs.hero_subtitle.value || 'Connecting Alumni, Building Community';
                previews.hero_description.textContent = inputs.hero_description.value || 'Join our vibrant community of FCS alumni. Stay connected, attend exclusive events, and grow your professional network.';
                previews.cta_primary.textContent = inputs.cta_primary_text.value || 'Join Now';
                previews.cta_secondary.textContent = inputs.cta_secondary_text.value || 'Learn More';

                // Update about section
                previews.about_title.textContent = inputs.about_title.value || 'About FCS';
                previews.about_content.textContent = inputs.about_content.value || 'The Fellowship of Christian Students (FCS) is a vibrant community of faith-based students and alumni...';
                previews.mission.textContent = inputs.mission_statement.value || 'Our mission is to build a community of Christian leaders who impact their communities and the world for Christ.';
                previews.vision.textContent = inputs.vision_statement.value || 'To see a generation of Christian leaders transforming society through their influence and impact.';

                // Update features section
                previews.feature_1_title.textContent = inputs.feature_1_title.value || 'Networking';
                previews.feature_1_desc.textContent = inputs.feature_1_description.value || 'Connect with fellow alumni and expand your professional network';
                previews.feature_2_title.textContent = inputs.feature_2_title.value || 'Events';
                previews.feature_2_desc.textContent = inputs.feature_2_description.value || 'Attend exclusive alumni events, conferences, and gatherings';
                previews.feature_3_title.textContent = inputs.feature_3_title.value || 'Community';
                previews.feature_3_desc.textContent = inputs.feature_3_description.value || 'Join a supportive community of like-minded Christian professionals';
            }

            // Add event listeners
            Object.values(inputs).forEach(input => {
                if (input) {
                    input.addEventListener('input', updatePreview);
                }
            });

            // Initial preview update
            updatePreview();
        });
    </script>
</body>
</html>
