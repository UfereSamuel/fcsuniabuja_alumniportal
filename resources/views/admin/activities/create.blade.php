@extends('layouts.admin')

@section('title', 'Create Activity')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <a href="{{ route('admin.activities.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-fcs-blue">Activities</a>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Create Activity</span>
        </div>
    </li>
@endsection

@section('page-title', 'Create New Activity')
@section('page-description', 'Add a new activity to the FCS Alumni Portal.')

@section('page-actions')
    <a href="{{ route('admin.activities.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-arrow-left mr-2"></i>Back to Activities
    </a>
@endsection

@section('content')
    <form action="{{ route('admin.activities.store') }}" method="POST" enctype="multipart/form-data" x-data="activityForm()">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Activity Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" x-model="title" required
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue"
                                   placeholder="Enter activity title">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Activity Type <span class="text-red-500">*</span></label>
                            <select name="type" id="type" x-model="type" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                                <option value="">Select Type</option>
                                <option value="meeting">Meeting</option>
                                <option value="fellowship">Fellowship</option>
                                <option value="outreach">Outreach</option>
                                <option value="conference">Conference</option>
                                <option value="training">Training</option>
                                <option value="social">Social Event</option>
                                <option value="service">Community Service</option>
                                <option value="other">Other</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" x-model="status"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                                <option value="active">Active</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="postponed">Postponed</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Activity Description <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="6" x-model="description" required
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue"
                                  placeholder="Describe the activity in detail..."></textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Date & Time -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Date & Time</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date <span class="text-red-500">*</span></label>
                            <input type="date" name="start_date" id="start_date" x-model="start_date" required
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" name="end_date" id="end_date" x-model="end_date"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Time -->
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                            <input type="time" name="start_time" id="start_time" x-model="start_time"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                            @error('start_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                            <input type="time" name="end_time" id="end_time" x-model="end_time"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                            @error('end_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Location</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Venue</label>
                            <input type="text" name="location" id="location" x-model="location"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue"
                                   placeholder="Enter venue name">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" name="address" id="address" x-model="address"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue"
                                   placeholder="Enter full address">
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Image Upload -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Activity Image</h3>

                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                            <div x-show="!imagePreview">
                                <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                <p class="text-gray-500">Click to upload or drag and drop</p>
                                <p class="text-xs text-gray-400">PNG, JPG, GIF up to 10MB</p>
                            </div>

                            <div x-show="imagePreview" class="relative">
                                <img :src="imagePreview" alt="Preview" class="max-w-full h-48 object-cover rounded mx-auto">
                                <button type="button" @click="clearImage()"
                                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>

                            <input type="file" name="image" id="image" @change="previewImage($event)"
                                   accept="image/*" class="hidden">
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="button" @click="$refs.fileInput.click()"
                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg transition">
                        <i class="fas fa-upload mr-2"></i>Choose Image
                    </button>
                </div>

                <!-- Organization Settings -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Organization</h3>

                    <!-- Class Association -->
                    <div class="mb-4">
                        <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Associated Class</label>
                        <select name="class_id" id="class_id" x-model="class_id"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                            <option value="">All Alumni</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Organizer -->
                    <div>
                        <label for="organizer" class="block text-sm font-medium text-gray-700 mb-1">Organizer</label>
                        <input type="text" name="organizer" id="organizer" x-model="organizer"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue"
                               placeholder="Enter organizer name">
                        @error('organizer')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>

                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-fcs-primary hover:bg-fcs-light-blue text-white py-2 px-4 rounded-lg font-medium transition">
                            <i class="fas fa-save mr-2"></i>Create Activity
                        </button>

                        <button type="button" @click="saveDraft()" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg font-medium transition">
                            <i class="fas fa-file-alt mr-2"></i>Save as Draft
                        </button>

                        <a href="{{ route('admin.activities.index') }}" class="block w-full bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg font-medium transition text-center">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>
                </div>

                <!-- Live Preview -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Live Preview</h3>

                    <div class="border rounded-lg p-4 bg-gray-50">
                        <div x-show="imagePreview" class="mb-3">
                            <img :src="imagePreview" alt="Preview" class="w-full h-32 object-cover rounded">
                        </div>

                        <h4 x-text="title || 'Activity Title'" class="font-semibold text-gray-900 mb-2"></h4>

                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            <i class="fas fa-calendar mr-1"></i>
                            <span x-text="start_date || 'Date not set'"></span>
                        </div>

                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            <span x-text="location || 'Location not set'"></span>
                        </div>

                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-tag mr-1"></i>
                            <span x-text="type || 'Type not set'"></span>
                        </div>

                        <p x-text="description || 'No description provided'" class="text-sm text-gray-600 mt-3 line-clamp-3"></p>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        function activityForm() {
            return {
                title: '',
                type: 'meeting',
                status: 'active',
                description: '',
                start_date: '',
                end_date: '',
                start_time: '',
                end_time: '',
                location: '',
                address: '',
                class_id: '',
                organizer: '',
                imagePreview: null,

                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imagePreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                clearImage() {
                    this.imagePreview = null;
                    document.getElementById('image').value = '';
                },

                saveDraft() {
                    // Add draft functionality
                    alert('Draft functionality coming soon!');
                }
            }
        }

        // File input trigger
        document.addEventListener('DOMContentLoaded', function() {
            const imageDiv = document.querySelector('[x-show="!imagePreview"]').parentElement;
            imageDiv.addEventListener('click', function() {
                document.getElementById('image').click();
            });
        });
    </script>
@endsection
