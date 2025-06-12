<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Activity - FCS Admin Panel</title>

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
                            <p class="text-xs text-gray-500">Edit Activity</p>
                        </div>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.activities.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Activities
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Edit Activity</h1>
            <p class="text-gray-600 mt-2">Update the details for "{{ $activity->title }}"</p>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.activities.update', $activity) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Activity Details</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Activity Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $activity->title) }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                               placeholder="Enter a descriptive title for the activity">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea name="description" id="description" rows="6" required
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="Provide a detailed description of the activity, its purpose, and what participants can expect">{{ old('description', $activity->description) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Provide comprehensive details about the activity</p>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Image Display -->
                    @if($activity->image)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}"
                                     class="w-32 h-32 object-cover rounded-lg border">
                                <div class="text-sm text-gray-600">
                                    <p>Current activity image</p>
                                    <p class="text-xs">Upload a new image to replace this one</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Activity Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $activity->image ? 'Replace Activity Image' : 'Activity Image' }}
                        </label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror"
                               onchange="previewImage(this)">
                        <p class="text-xs text-gray-500 mt-1">Upload an image to represent this activity. Maximum file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF</p>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Image Preview -->
                        <div id="image-preview-container" class="mt-4 hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">New Image Preview</label>
                            <img id="image-preview" class="image-preview" alt="New activity image preview">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Date and Location -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Date & Location</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Activity Date -->
                    <div>
                        <label for="activity_date" class="block text-sm font-medium text-gray-700 mb-1">Activity Date *</label>
                        <input type="date" name="activity_date" id="activity_date"
                               value="{{ old('activity_date', $activity->activity_date->format('Y-m-d')) }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('activity_date') border-red-500 @enderror">
                        @error('activity_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $activity->location) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location') border-red-500 @enderror"
                               placeholder="e.g., University of Abuja Main Campus, Online Event, etc.">
                        @error('location')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Class and Settings -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Activity Settings</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Target Class -->
                    <div>
                        <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Target Class</label>
                        <select name="class_id" id="class_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('class_id') border-red-500 @enderror">
                            <option value="">All Classes (General Activity)</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ old('class_id', $activity->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Leave blank for activities open to all classes</p>
                        @error('class_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Activity Status</label>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $activity->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Active Activity</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Only active activities will be visible to members</p>
                    </div>
                </div>
            </div>

            <!-- Activity Info -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-yellow-900 mb-3">
                    <i class="fas fa-info-circle mr-2"></i>Activity Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-yellow-900">Created:</span>
                        <span class="text-yellow-700">{{ $activity->created_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-yellow-900">Last Updated:</span>
                        <span class="text-yellow-700">{{ $activity->updated_at->format('M d, Y') }}</span>
                    </div>
                    @if($activity->creator)
                        <div>
                            <span class="font-medium text-yellow-900">Created by:</span>
                            <span class="text-yellow-700">{{ $activity->creator->name }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-between">
                <div class="flex space-x-4">
                    <a href="{{ route('admin.activities.show', $activity) }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="fas fa-eye mr-2"></i>View Activity
                    </a>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.activities.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="fas fa-save mr-2"></i>Update Activity
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript for preview -->
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
    </script>
</body>
</html>
