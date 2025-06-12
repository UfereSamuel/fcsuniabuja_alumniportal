<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Slider - FCS Admin Panel</title>

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
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
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
                            <p class="text-xs text-gray-500">Create New Slider</p>
                        </div>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.sliders.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Sliders
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Create New Slider</h1>
            <p class="text-gray-600 mt-2">Add a new slide to the homepage carousel to engage visitors.</p>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Slider Content</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Slider Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                               placeholder="Enter a compelling title for your slide">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="Enter a description that will appear on the slide">{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Maximum 1000 characters. This text will appear as subtitle on the slide.</p>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Slider Image *</label>
                        <input type="file" name="image" id="image" accept="image/*" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror"
                               onchange="previewImage(this)">
                        <p class="text-xs text-gray-500 mt-1">Recommended size: 1920x800px. Maximum file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF</p>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Image Preview -->
                        <div id="image-preview-container" class="mt-4 hidden">
                            <img id="image-preview" class="image-preview" alt="Image preview">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Call to Action Button (Optional)</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Button Text -->
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
                        <input type="text" name="button_text" id="button_text" value="{{ old('button_text') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('button_text') border-red-500 @enderror"
                               placeholder="e.g., Learn More, Join Now, Get Started">
                        <p class="text-xs text-gray-500 mt-1">Maximum 50 characters</p>
                        @error('button_text')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Button URL -->
                    <div>
                        <label for="button_url" class="block text-sm font-medium text-gray-700 mb-1">Button URL</label>
                        <input type="url" name="button_url" id="button_url" value="{{ old('button_url') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('button_url') border-red-500 @enderror"
                               placeholder="https://example.com">
                        <p class="text-xs text-gray-500 mt-1">Full URL including http:// or https://</p>
                        @error('button_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Slider Settings</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order *</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 1) }}" required min="0"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sort_order') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Lower numbers appear first in the carousel</p>
                        @error('sort_order')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Status</label>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Active Slider</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Only active sliders will be displayed on the homepage</p>
                    </div>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">
                    <i class="fas fa-eye mr-2"></i>How your slider will look
                </h3>
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="text-center">
                        <h4 class="text-2xl font-bold text-gray-900 mb-2" id="preview-title">Your Title Will Appear Here</h4>
                        <p class="text-gray-600 mb-4" id="preview-description">Your description will appear here as a subtitle</p>
                        <div id="preview-button" class="hidden">
                            <span class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-medium">
                                <span id="preview-button-text">Button Text</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.sliders.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                    <i class="fas fa-save mr-2"></i>Create Slider
                </button>
            </div>
        </form>
    </div>

    <!-- JavaScript for preview and interactions -->
    <script>
        // Image preview function
        function previewImage(input) {
            const file = input.files[0];
            const previewContainer = document.getElementById('image-preview-container');
            const preview = document.getElementById('image-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        // Live preview updates
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('title');
            const descriptionInput = document.getElementById('description');
            const buttonTextInput = document.getElementById('button_text');

            const previewTitle = document.getElementById('preview-title');
            const previewDescription = document.getElementById('preview-description');
            const previewButton = document.getElementById('preview-button');
            const previewButtonText = document.getElementById('preview-button-text');

            // Update title preview
            titleInput.addEventListener('input', function() {
                previewTitle.textContent = this.value || 'Your Title Will Appear Here';
            });

            // Update description preview
            descriptionInput.addEventListener('input', function() {
                previewDescription.textContent = this.value || 'Your description will appear here as a subtitle';
            });

            // Update button preview
            buttonTextInput.addEventListener('input', function() {
                if (this.value) {
                    previewButtonText.textContent = this.value;
                    previewButton.classList.remove('hidden');
                } else {
                    previewButton.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
