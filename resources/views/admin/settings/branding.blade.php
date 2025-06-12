<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Branding Settings - FCS Admin Panel</title>

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
        .image-preview {
            max-width: 100%;
            height: 120px;
            object-fit: contain;
            border-radius: 8px;
        }
        .color-preview {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
        }
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
                            <p class="text-xs text-gray-500">Branding Settings</p>
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
            <h1 class="text-3xl font-bold text-gray-900">Branding Settings</h1>
            <p class="text-gray-600 mt-2">Customize your organization's visual identity, logos, and color scheme</p>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.settings.update-branding') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Logo Management -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Logo Management</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Site Logo -->
                    <div>
                        <label for="site_logo" class="block text-sm font-medium text-gray-700 mb-1">Site Logo</label>

                        @if(isset($settings['site_logo']) && $settings['site_logo'])
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Current Logo:</p>
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Current Logo"
                                     class="image-preview border">
                            </div>
                        @endif

                        <input type="file" name="site_logo" id="site_logo" accept="image/*"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('site_logo') border-red-500 @enderror"
                               onchange="previewImage(this, 'logo-preview')">
                        <p class="text-xs text-gray-500 mt-1">Upload your organization's logo. Recommended size: 200x60px. Max file size: 2MB.</p>
                        @error('site_logo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Logo Preview -->
                        <div id="logo-preview-container" class="mt-4 hidden">
                            <p class="text-sm text-gray-600 mb-2">New Logo Preview:</p>
                            <img id="logo-preview" class="image-preview border" alt="Logo preview">
                        </div>
                    </div>

                    <!-- Site Favicon -->
                    <div>
                        <label for="site_favicon" class="block text-sm font-medium text-gray-700 mb-1">Site Favicon</label>

                        @if(isset($settings['site_favicon']) && $settings['site_favicon'])
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Current Favicon:</p>
                                <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Current Favicon"
                                     class="w-8 h-8 border rounded">
                            </div>
                        @endif

                        <input type="file" name="site_favicon" id="site_favicon" accept="image/png,image/ico"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('site_favicon') border-red-500 @enderror"
                               onchange="previewImage(this, 'favicon-preview')">
                        <p class="text-xs text-gray-500 mt-1">Upload a favicon for browser tabs. Recommended size: 32x32px. PNG or ICO format.</p>
                        @error('site_favicon')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Favicon Preview -->
                        <div id="favicon-preview-container" class="mt-4 hidden">
                            <p class="text-sm text-gray-600 mb-2">New Favicon Preview:</p>
                            <img id="favicon-preview" class="w-8 h-8 border rounded" alt="Favicon preview">
                        </div>
                    </div>

                    <!-- Hero Background Image -->
                    <div>
                        <label for="hero_background_image" class="block text-sm font-medium text-gray-700 mb-1">Hero Background Image</label>

                        @if(isset($settings['hero_background_image']) && $settings['hero_background_image'])
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Current Hero Background:</p>
                                <img src="{{ asset('storage/' . $settings['hero_background_image']) }}" alt="Current Hero Background"
                                     class="w-full h-32 object-cover rounded border">
                            </div>
                        @endif

                        <input type="file" name="hero_background_image" id="hero_background_image" accept="image/*"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('hero_background_image') border-red-500 @enderror"
                               onchange="previewImage(this, 'hero-preview')">
                        <p class="text-xs text-gray-500 mt-1">Upload a background image for the homepage hero section. Recommended size: 1920x600px. Max file size: 5MB.</p>
                        @error('hero_background_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Hero Preview -->
                        <div id="hero-preview-container" class="mt-4 hidden">
                            <p class="text-sm text-gray-600 mb-2">New Hero Background Preview:</p>
                            <img id="hero-preview" class="w-full h-32 object-cover rounded border" alt="Hero background preview">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Color Scheme -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Color Scheme</h2>
                    <p class="text-sm text-gray-500 mt-1">Define your organization's brand colors</p>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Primary Color -->
                    <div>
                        <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-1">Primary Color</label>
                        <div class="flex items-center space-x-3">
                            <input type="color" name="primary_color" id="primary_color"
                                   value="{{ old('primary_color', $settings['primary_color'] ?? '#1e40af') }}"
                                   class="w-16 h-10 border border-gray-300 rounded cursor-pointer @error('primary_color') border-red-500 @enderror">
                            <input type="text"
                                   value="{{ old('primary_color', $settings['primary_color'] ?? '#1e40af') }}"
                                   class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm font-mono"
                                   readonly id="primary_color_display">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Main brand color used for buttons, links, and accents</p>
                        @error('primary_color')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Secondary Color -->
                    <div>
                        <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-1">Secondary Color</label>
                        <div class="flex items-center space-x-3">
                            <input type="color" name="secondary_color" id="secondary_color"
                                   value="{{ old('secondary_color', $settings['secondary_color'] ?? '#059669') }}"
                                   class="w-16 h-10 border border-gray-300 rounded cursor-pointer @error('secondary_color') border-red-500 @enderror">
                            <input type="text"
                                   value="{{ old('secondary_color', $settings['secondary_color'] ?? '#059669') }}"
                                   class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm font-mono"
                                   readonly id="secondary_color_display">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Supporting color for secondary elements</p>
                        @error('secondary_color')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Accent Color -->
                    <div>
                        <label for="accent_color" class="block text-sm font-medium text-gray-700 mb-1">Accent Color</label>
                        <div class="flex items-center space-x-3">
                            <input type="color" name="accent_color" id="accent_color"
                                   value="{{ old('accent_color', $settings['accent_color'] ?? '#dc2626') }}"
                                   class="w-16 h-10 border border-gray-300 rounded cursor-pointer @error('accent_color') border-red-500 @enderror">
                            <input type="text"
                                   value="{{ old('accent_color', $settings['accent_color'] ?? '#dc2626') }}"
                                   class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm font-mono"
                                   readonly id="accent_color_display">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Highlight color for warnings, alerts, and special elements</p>
                        @error('accent_color')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Brand Preview -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">
                    <i class="fas fa-eye mr-2"></i>Brand Preview
                </h3>
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <!-- Header Preview -->
                    <div class="flex items-center justify-between p-4 border-b" id="preview-header">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-200 rounded mr-3 flex items-center justify-center" id="preview-logo-container">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                            <div>
                                <h1 class="text-lg font-bold">FCS Alumni Portal</h1>
                                <p class="text-xs text-gray-500">Brand Preview</p>
                            </div>
                        </div>
                    </div>

                    <!-- Content Preview -->
                    <div class="p-4 space-y-4">
                        <div class="flex space-x-4">
                            <button class="px-4 py-2 rounded font-medium text-white" id="preview-primary-btn">Primary Button</button>
                            <button class="px-4 py-2 rounded font-medium text-white" id="preview-secondary-btn">Secondary Button</button>
                            <button class="px-4 py-2 rounded font-medium text-white" id="preview-accent-btn">Accent Button</button>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="w-12 h-12 rounded-full mx-auto mb-2" id="preview-primary-circle"></div>
                                <p class="text-sm font-medium">Primary</p>
                                <p class="text-xs text-gray-500" id="preview-primary-code">#1e40af</p>
                            </div>
                            <div class="text-center">
                                <div class="w-12 h-12 rounded-full mx-auto mb-2" id="preview-secondary-circle"></div>
                                <p class="text-sm font-medium">Secondary</p>
                                <p class="text-xs text-gray-500" id="preview-secondary-code">#059669</p>
                            </div>
                            <div class="text-center">
                                <div class="w-12 h-12 rounded-full mx-auto mb-2" id="preview-accent-circle"></div>
                                <p class="text-sm font-medium">Accent</p>
                                <p class="text-xs text-gray-500" id="preview-accent-code">#dc2626</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-between">
                <div class="flex space-x-4">
                    <form action="{{ route('admin.settings.reset') }}" method="POST" class="inline"
                          onsubmit="return confirm('Are you sure you want to reset all branding settings to defaults? This action cannot be undone.')">
                        @csrf
                        <input type="hidden" name="category" value="branding">
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
                        <i class="fas fa-save mr-2"></i>Save Branding
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript for preview and interactions -->
    <script>
        // Image preview function
        function previewImage(input, previewId) {
            const file = input.files[0];
            const previewContainer = document.getElementById(previewId + '-container');
            const preview = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');

                    // Update brand preview logo
                    if (previewId === 'logo-preview') {
                        updateLogoPreview(e.target.result);
                    }
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        // Update logo in brand preview
        function updateLogoPreview(src) {
            const logoContainer = document.getElementById('preview-logo-container');
            logoContainer.innerHTML = `<img src="${src}" alt="Logo" class="w-10 h-10 object-contain">`;
        }

        // Color change handlers
        document.addEventListener('DOMContentLoaded', function() {
            const primaryColor = document.getElementById('primary_color');
            const secondaryColor = document.getElementById('secondary_color');
            const accentColor = document.getElementById('accent_color');

            const primaryDisplay = document.getElementById('primary_color_display');
            const secondaryDisplay = document.getElementById('secondary_color_display');
            const accentDisplay = document.getElementById('accent_color_display');

            // Preview elements
            const primaryBtn = document.getElementById('preview-primary-btn');
            const secondaryBtn = document.getElementById('preview-secondary-btn');
            const accentBtn = document.getElementById('preview-accent-btn');

            const primaryCircle = document.getElementById('preview-primary-circle');
            const secondaryCircle = document.getElementById('preview-secondary-circle');
            const accentCircle = document.getElementById('preview-accent-circle');

            const primaryCode = document.getElementById('preview-primary-code');
            const secondaryCode = document.getElementById('preview-secondary-code');
            const accentCode = document.getElementById('preview-accent-code');

            function updateColorPreviews() {
                // Update displays
                primaryDisplay.value = primaryColor.value;
                secondaryDisplay.value = secondaryColor.value;
                accentDisplay.value = accentColor.value;

                // Update preview buttons
                primaryBtn.style.backgroundColor = primaryColor.value;
                secondaryBtn.style.backgroundColor = secondaryColor.value;
                accentBtn.style.backgroundColor = accentColor.value;

                // Update preview circles
                primaryCircle.style.backgroundColor = primaryColor.value;
                secondaryCircle.style.backgroundColor = secondaryColor.value;
                accentCircle.style.backgroundColor = accentColor.value;

                // Update color codes
                primaryCode.textContent = primaryColor.value;
                secondaryCode.textContent = secondaryColor.value;
                accentCode.textContent = accentColor.value;
            }

            // Add event listeners
            primaryColor.addEventListener('input', updateColorPreviews);
            secondaryColor.addEventListener('input', updateColorPreviews);
            accentColor.addEventListener('input', updateColorPreviews);

            // Initial update
            updateColorPreviews();
        });
    </script>
</body>
</html>
