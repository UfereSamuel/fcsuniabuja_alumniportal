<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Event - FCS Admin Panel</title>

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
                            <p class="text-xs text-gray-500">Edit Event</p>
                        </div>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.events.show', $event) }}" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-eye mr-1"></i>View Event
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Events
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

        <div class="flex justify-between items-start mb-6">
            <!-- Header -->
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Event</h1>
                <p class="text-gray-600 mt-2">Update event details, date, location, and settings.</p>
            </div>

            <!-- Event Info Panel -->
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200 min-w-64">
                <h3 class="text-sm font-semibold text-blue-900 mb-2">Event Information</h3>
                <div class="space-y-1 text-sm text-blue-800">
                    <div class="flex justify-between">
                        <span>Created:</span>
                        <span>{{ $event->created_at->format('M j, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Updated:</span>
                        <span>{{ $event->updated_at->format('M j, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Status:</span>
                        <span class="px-2 py-1 rounded text-xs font-medium {{ $event->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $event->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @if($event->event_date)
                        <div class="flex justify-between">
                            <span>Date:</span>
                            <span>{{ $event->event_date->format('M j, Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Event Details</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Event Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                               placeholder="Enter a descriptive title for the event">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea name="description" id="description" rows="6" required
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="Provide a comprehensive description of the event, agenda, speakers, and what attendees can expect">{{ old('description', $event->description) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Include event agenda, speakers, objectives, and other relevant details</p>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Image Display -->
                    @if($event->image)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Event Image</label>
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $event->image) }}" alt="Current Event Image"
                                     class="image-preview border">
                            </div>
                        </div>
                    @endif

                    <!-- Event Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $event->image ? 'Replace Event Image' : 'Event Image' }}
                        </label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror"
                               onchange="previewImage(this)">
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $event->image ? 'Upload a new image to replace the current one.' : 'Upload an image for the event banner.' }}
                            Maximum file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF
                        </p>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!-- New Image Preview -->
                        <div id="image-preview-container" class="mt-4 hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Image Preview</label>
                            <img id="image-preview" class="image-preview border" alt="New event image preview">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Type and Category -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Event Category</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Event Type -->
                    <div>
                        <label for="event_type" class="block text-sm font-medium text-gray-700 mb-1">Event Type *</label>
                        <select name="event_type" id="event_type" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('event_type') border-red-500 @enderror">
                            <option value="">Select Event Type</option>
                            <option value="conference" {{ old('event_type', $event->event_type) == 'conference' ? 'selected' : '' }}>Conference</option>
                            <option value="seminar" {{ old('event_type', $event->event_type) == 'seminar' ? 'selected' : '' }}>Seminar</option>
                            <option value="workshop" {{ old('event_type', $event->event_type) == 'workshop' ? 'selected' : '' }}>Workshop</option>
                            <option value="social" {{ old('event_type', $event->event_type) == 'social' ? 'selected' : '' }}>Social Event</option>
                            <option value="spiritual" {{ old('event_type', $event->event_type) == 'spiritual' ? 'selected' : '' }}>Spiritual</option>
                            <option value="community" {{ old('event_type', $event->event_type) == 'community' ? 'selected' : '' }}>Community Service</option>
                        </select>
                        @error('event_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Target Class -->
                    <div>
                        <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Target Class</label>
                        <select name="class_id" id="class_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('class_id') border-red-500 @enderror">
                            <option value="">All Classes (General Event)</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $event->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Leave blank for events open to all classes</p>
                        @error('class_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Date, Time & Location -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Date, Time & Location</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Event Date -->
                    <div>
                        <label for="event_date" class="block text-sm font-medium text-gray-700 mb-1">Event Date *</label>
                        <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('event_date') border-red-500 @enderror">
                        @error('event_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Event Time -->
                    <div>
                        <label for="event_time" class="block text-sm font-medium text-gray-700 mb-1">Event Time</label>
                        <input type="time" name="event_time" id="event_time" value="{{ old('event_time', $event->event_time?->format('H:i')) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('event_time') border-red-500 @enderror">
                        @error('event_time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration (hours)</label>
                        <input type="number" name="duration" id="duration" value="{{ old('duration', $event->duration) }}" min="0.5" step="0.5"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('duration') border-red-500 @enderror"
                               placeholder="e.g., 2">
                        @error('duration')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="md:col-span-3">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location') border-red-500 @enderror"
                               placeholder="e.g., University of Abuja Main Campus, Online via Zoom, etc.">
                        @error('location')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Registration Settings -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Registration Settings</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Registration Required -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Registration Required</label>
                        <label class="flex items-center">
                            <input type="checkbox" name="registration_required" value="1" {{ old('registration_required', $event->registration_required) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Require registration to attend</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Check if attendees need to register in advance</p>
                    </div>

                    <!-- Max Attendees -->
                    <div>
                        <label for="max_attendees" class="block text-sm font-medium text-gray-700 mb-1">Max Attendees</label>
                        <input type="number" name="max_attendees" id="max_attendees" value="{{ old('max_attendees', $event->max_attendees) }}" min="1"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('max_attendees') border-red-500 @enderror"
                               placeholder="e.g., 100">
                        <p class="text-xs text-gray-500 mt-1">Leave blank for unlimited attendees</p>
                        @error('max_attendees')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Registration Deadline -->
                    <div>
                        <label for="registration_deadline" class="block text-sm font-medium text-gray-700 mb-1">Registration Deadline</label>
                        <input type="date" name="registration_deadline" id="registration_deadline" value="{{ old('registration_deadline', $event->registration_deadline?->format('Y-m-d')) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('registration_deadline') border-red-500 @enderror">
                        @error('registration_deadline')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Event Status -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Event Status</h2>
                </div>
                <div class="p-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $event->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Active Event</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1">Only active events will be visible to members</p>
                </div>
            </div>

            <!-- Event Preview -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">
                    <i class="fas fa-eye mr-2"></i>Event Preview
                </h3>
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-20 h-20 bg-blue-100 rounded-lg flex items-center justify-center" id="preview-image-container">
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="Event" class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xl font-bold text-gray-900 mb-2" id="preview-title">{{ $event->title }}</h4>
                            <p class="text-gray-600 mb-3" id="preview-description">{{ Str::limit($event->description, 150) }}</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar mr-2"></i>
                                        <span id="preview-date">{{ $event->event_date?->format('M j, Y') ?? 'Date will appear here' }}</span>
                                    </div>
                                    <div class="flex items-center" id="preview-time-container" style="{{ $event->event_time ? 'display: flex;' : 'display: none;' }}">
                                        <i class="fas fa-clock mr-2"></i>
                                        <span id="preview-time">{{ $event->event_time?->format('g:i A') ?? 'Time will appear here' }}</span>
                                    </div>
                                    <div class="flex items-center" id="preview-location-container" style="{{ $event->location ? 'display: flex;' : 'display: none;' }}">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        <span id="preview-location">{{ $event->location ?? 'Location will appear here' }}</span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center" id="preview-type-container" style="{{ $event->event_type ? 'display: flex;' : 'display: none;' }}">
                                        <i class="fas fa-tag mr-2"></i>
                                        <span id="preview-type">{{ ucfirst($event->event_type) ?? 'Event type' }}</span>
                                    </div>
                                    <div class="flex items-center" id="preview-attendees-container" style="{{ $event->max_attendees ? 'display: flex;' : 'display: none;' }}">
                                        <i class="fas fa-users mr-2"></i>
                                        <span id="preview-attendees">{{ $event->max_attendees ? 'Max ' . $event->max_attendees . ' attendees' : 'Max attendees' }}</span>
                                    </div>
                                    <div class="flex items-center" id="preview-duration-container" style="{{ $event->duration ? 'display: flex;' : 'display: none;' }}">
                                        <i class="fas fa-hourglass-half mr-2"></i>
                                        <span id="preview-duration">{{ $event->duration ? $event->duration . ' hour' . ($event->duration != 1 ? 's' : '') : 'Duration' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-between">
                <div class="flex space-x-4">
                    <a href="{{ route('admin.events.show', $event) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="fas fa-eye mr-2"></i>View Event
                    </a>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.events.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="fas fa-save mr-2"></i>Update Event
                    </button>
                </div>
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
            const eventPreviewContainer = document.getElementById('preview-image-container');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');

                    // Update event preview
                    eventPreviewContainer.innerHTML = `<img src="${e.target.result}" alt="Event" class="w-20 h-20 object-cover rounded-lg">`;
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        // Live preview updates
        document.addEventListener('DOMContentLoaded', function() {
            // Input elements
            const titleInput = document.getElementById('title');
            const descriptionInput = document.getElementById('description');
            const dateInput = document.getElementById('event_date');
            const timeInput = document.getElementById('event_time');
            const locationInput = document.getElementById('location');
            const typeInput = document.getElementById('event_type');
            const attendeesInput = document.getElementById('max_attendees');
            const durationInput = document.getElementById('duration');

            // Preview elements
            const previewTitle = document.getElementById('preview-title');
            const previewDescription = document.getElementById('preview-description');
            const previewDate = document.getElementById('preview-date');
            const previewTime = document.getElementById('preview-time');
            const previewLocation = document.getElementById('preview-location');
            const previewType = document.getElementById('preview-type');
            const previewAttendees = document.getElementById('preview-attendees');
            const previewDuration = document.getElementById('preview-duration');

            const previewTimeContainer = document.getElementById('preview-time-container');
            const previewLocationContainer = document.getElementById('preview-location-container');
            const previewTypeContainer = document.getElementById('preview-type-container');
            const previewAttendeesContainer = document.getElementById('preview-attendees-container');
            const previewDurationContainer = document.getElementById('preview-duration-container');

            function updatePreview() {
                // Update title
                previewTitle.textContent = titleInput.value || '{{ $event->title }}';

                // Update description
                const text = descriptionInput.value || '{{ Str::limit($event->description, 150) }}';
                previewDescription.textContent = text.length > 150 ? text.substring(0, 150) + '...' : text;

                // Update date
                if (dateInput.value) {
                    const date = new Date(dateInput.value);
                    previewDate.textContent = date.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                } else {
                    previewDate.textContent = '{{ $event->event_date?->format("M j, Y") ?? "Date will appear here" }}';
                }

                // Update time
                if (timeInput.value) {
                    const time = new Date('2000-01-01 ' + timeInput.value);
                    previewTime.textContent = time.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });
                    previewTimeContainer.style.display = 'flex';
                } else {
                    if ('{{ $event->event_time }}') {
                        previewTime.textContent = '{{ $event->event_time?->format("g:i A") }}';
                        previewTimeContainer.style.display = 'flex';
                    } else {
                        previewTimeContainer.style.display = 'none';
                    }
                }

                // Update location
                if (locationInput.value) {
                    previewLocation.textContent = locationInput.value;
                    previewLocationContainer.style.display = 'flex';
                } else {
                    if ('{{ $event->location }}') {
                        previewLocation.textContent = '{{ $event->location }}';
                        previewLocationContainer.style.display = 'flex';
                    } else {
                        previewLocationContainer.style.display = 'none';
                    }
                }

                // Update type
                if (typeInput.value) {
                    previewType.textContent = typeInput.options[typeInput.selectedIndex].text;
                    previewTypeContainer.style.display = 'flex';
                } else {
                    if ('{{ $event->event_type }}') {
                        previewType.textContent = '{{ ucfirst($event->event_type) }}';
                        previewTypeContainer.style.display = 'flex';
                    } else {
                        previewTypeContainer.style.display = 'none';
                    }
                }

                // Update attendees
                if (attendeesInput.value) {
                    previewAttendees.textContent = `Max ${attendeesInput.value} attendees`;
                    previewAttendeesContainer.style.display = 'flex';
                } else {
                    if ('{{ $event->max_attendees }}') {
                        previewAttendees.textContent = 'Max {{ $event->max_attendees }} attendees';
                        previewAttendeesContainer.style.display = 'flex';
                    } else {
                        previewAttendeesContainer.style.display = 'none';
                    }
                }

                // Update duration
                if (durationInput.value) {
                    previewDuration.textContent = `${durationInput.value} hour${durationInput.value != 1 ? 's' : ''}`;
                    previewDurationContainer.style.display = 'flex';
                } else {
                    if ('{{ $event->duration }}') {
                        previewDuration.textContent = '{{ $event->duration }} hour{{ $event->duration != 1 ? "s" : "" }}';
                        previewDurationContainer.style.display = 'flex';
                    } else {
                        previewDurationContainer.style.display = 'none';
                    }
                }
            }

            // Add event listeners
            [titleInput, descriptionInput, dateInput, timeInput, locationInput, typeInput, attendeesInput, durationInput].forEach(input => {
                if (input) {
                    input.addEventListener('input', updatePreview);
                    input.addEventListener('change', updatePreview);
                }
            });

            // Initial preview update
            updatePreview();
        });
    </script>
</body>
</html>
