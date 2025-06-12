@extends('layouts.admin')

@section('title', 'Create Executive')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <a href="{{ route('admin.executives.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-fcs-blue">Executives</a>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Create Executive</span>
        </div>
    </li>
@endsection

@section('page-title', 'Create New Executive')
@section('page-description', 'Add a new executive member to the FCS leadership team with their position and contact details.')

@section('page-actions')
    <a href="{{ route('admin.executives.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-arrow-left mr-2"></i>Back to Executives
    </a>
@endsection

@section('styles')
.image-preview {
    max-width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}
@endsection

@section('content')
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

    <!-- Form -->
    <form action="{{ route('admin.executives.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Personal Information -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Personal Information</h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Profile Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Profile Photo</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror"
                           onchange="previewImage(this)">
                    <p class="text-xs text-gray-500 mt-1">Upload a professional headshot. Maximum file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF</p>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Image Preview -->
                    <div id="image-preview-container" class="mt-4 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image Preview</label>
                        <img id="image-preview" class="image-preview border" alt="Profile photo preview">
                    </div>
                </div>

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="Enter the executive's full name">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email and Phone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="Enter email address">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                               placeholder="Enter phone number">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Biography</label>
                    <textarea name="bio" id="bio" rows="4"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bio') border-red-500 @enderror"
                              placeholder="Brief biography highlighting qualifications, experience, and vision for FCS">{{ old('bio') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Include educational background, professional experience, and leadership vision</p>
                    @error('bio')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Position Information -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Position Information</h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Position Title -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Position Title *</label>
                    <select name="position" id="position" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('position') border-red-500 @enderror">
                        <option value="">Select Position</option>
                        <option value="President" {{ old('position') == 'President' ? 'selected' : '' }}>President</option>
                        <option value="Vice President" {{ old('position') == 'Vice President' ? 'selected' : '' }}>Vice President</option>
                        <option value="Secretary" {{ old('position') == 'Secretary' ? 'selected' : '' }}>Secretary</option>
                        <option value="Treasurer" {{ old('position') == 'Treasurer' ? 'selected' : '' }}>Treasurer</option>
                        <option value="Financial Secretary" {{ old('position') == 'Financial Secretary' ? 'selected' : '' }}>Financial Secretary</option>
                        <option value="Public Relations Officer" {{ old('position') == 'Public Relations Officer' ? 'selected' : '' }}>Public Relations Officer</option>
                        <option value="Social Director" {{ old('position') == 'Social Director' ? 'selected' : '' }}>Social Director</option>
                        <option value="Spiritual Director" {{ old('position') == 'Spiritual Director' ? 'selected' : '' }}>Spiritual Director</option>
                        <option value="Sports Director" {{ old('position') == 'Sports Director' ? 'selected' : '' }}>Sports Director</option>
                        <option value="Welfare Director" {{ old('position') == 'Welfare Director' ? 'selected' : '' }}>Welfare Director</option>
                        <option value="Director" {{ old('position') == 'Director' ? 'selected' : '' }}>Director</option>
                        <option value="Coordinator" {{ old('position') == 'Coordinator' ? 'selected' : '' }}>Coordinator</option>
                        <option value="Advisor" {{ old('position') == 'Advisor' ? 'selected' : '' }}>Advisor</option>
                        <option value="Other" {{ old('position') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('position')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Position Description -->
                <div>
                    <label for="position_description" class="block text-sm font-medium text-gray-700 mb-1">Position Description</label>
                    <textarea name="position_description" id="position_description" rows="3"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('position_description') border-red-500 @enderror"
                              placeholder="Brief description of the position's responsibilities and duties">{{ old('position_description') }}</textarea>
                    @error('position_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Term Information -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="term_start" class="block text-sm font-medium text-gray-700 mb-1">Term Start Date *</label>
                        <input type="date" name="term_start" id="term_start" value="{{ old('term_start') }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('term_start') border-red-500 @enderror">
                        @error('term_start')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="term_end" class="block text-sm font-medium text-gray-700 mb-1">Term End Date</label>
                        <input type="date" name="term_end" id="term_end" value="{{ old('term_end') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('term_end') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Leave blank for ongoing term</p>
                        @error('term_end')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="term_year" class="block text-sm font-medium text-gray-700 mb-1">Term Year *</label>
                        <select name="term_year" id="term_year" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('term_year') border-red-500 @enderror">
                            <option value="">Select Year</option>
                            @for($year = date('Y') + 2; $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ old('term_year', date('Y')) == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        @error('term_year')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Order Priority -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Display Order</label>
                    <input type="number" name="order" id="order" value="{{ old('order', 1) }}" min="1"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('order') border-red-500 @enderror"
                           placeholder="1">
                    <p class="text-xs text-gray-500 mt-1">Lower numbers appear first in the executive listing</p>
                    @error('order')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Social Media & Links -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Social Media & Links</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="linkedin_url" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fab fa-linkedin text-blue-600 mr-2"></i>LinkedIn Profile
                    </label>
                    <input type="url" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('linkedin_url') border-red-500 @enderror"
                           placeholder="https://linkedin.com/in/profile">
                    @error('linkedin_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="twitter_url" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fab fa-twitter text-blue-400 mr-2"></i>Twitter Profile
                    </label>
                    <input type="url" name="twitter_url" id="twitter_url" value="{{ old('twitter_url') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('twitter_url') border-red-500 @enderror"
                           placeholder="https://twitter.com/username">
                    @error('twitter_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fab fa-facebook text-blue-800 mr-2"></i>Facebook Profile
                    </label>
                    <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('facebook_url') border-red-500 @enderror"
                           placeholder="https://facebook.com/profile">
                    @error('facebook_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram Profile
                    </label>
                    <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('instagram_url') border-red-500 @enderror"
                           placeholder="https://instagram.com/username">
                    @error('instagram_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Executive Status -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Executive Status</h2>
            </div>
            <div class="p-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Active Executive</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Only active executives will be displayed on the public website</p>
            </div>
        </div>

        <!-- Executive Preview -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">
                <i class="fas fa-eye mr-2"></i>Executive Preview
            </h3>
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center" id="preview-image-container">
                            <i class="fas fa-user text-gray-400 text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-xl font-bold text-gray-900 mb-1" id="preview-name">Executive Name</h4>
                        <p class="text-blue-600 font-medium mb-2" id="preview-position">Position</p>
                        <p class="text-gray-600 text-sm mb-3" id="preview-bio">Biography will appear here...</p>
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <div class="flex items-center" id="preview-email-container" style="display: none;">
                                <i class="fas fa-envelope mr-2"></i>
                                <span id="preview-email">email@example.com</span>
                            </div>
                            <div class="flex items-center" id="preview-phone-container" style="display: none;">
                                <i class="fas fa-phone mr-2"></i>
                                <span id="preview-phone">Phone number</span>
                            </div>
                            <div class="flex items-center" id="preview-term-container" style="display: none;">
                                <i class="fas fa-calendar mr-2"></i>
                                <span id="preview-term">Term period</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between">
            <div></div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                    <i class="fas fa-plus mr-2"></i>Create Executive
                </button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
// Image preview function
function previewImage(input) {
    const file = input.files[0];
    const previewContainer = document.getElementById('image-preview-container');
    const preview = document.getElementById('image-preview');
    const executivePreviewContainer = document.getElementById('preview-image-container');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');

            // Update executive preview
            executivePreviewContainer.innerHTML = `<img src="${e.target.result}" alt="Executive" class="w-20 h-20 object-cover rounded-full">`;
        };
        reader.readAsDataURL(file);
    } else {
        previewContainer.classList.add('hidden');
        executivePreviewContainer.innerHTML = '<i class="fas fa-user text-gray-400 text-2xl"></i>';
    }
}

// Live preview updates
document.addEventListener('DOMContentLoaded', function() {
    // Input elements
    const nameInput = document.getElementById('name');
    const positionInput = document.getElementById('position');
    const bioInput = document.getElementById('bio');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');

    // Preview elements
    const previewName = document.getElementById('preview-name');
    const previewPosition = document.getElementById('preview-position');
    const previewBio = document.getElementById('preview-bio');
    const previewEmail = document.getElementById('preview-email');
    const previewPhone = document.getElementById('preview-phone');

    const previewEmailContainer = document.getElementById('preview-email-container');
    const previewPhoneContainer = document.getElementById('preview-phone-container');

    function updatePreview() {
        // Update name
        previewName.textContent = nameInput.value || 'Executive Name';

        // Update position
        if (positionInput.value) {
            previewPosition.textContent = positionInput.options[positionInput.selectedIndex].text;
        } else {
            previewPosition.textContent = 'Position';
        }

        // Update bio
        previewBio.textContent = bioInput.value || 'Biography will appear here...';

        // Update email
        if (emailInput.value) {
            previewEmail.textContent = emailInput.value;
            previewEmailContainer.style.display = 'flex';
        } else {
            previewEmailContainer.style.display = 'none';
        }

        // Update phone
        if (phoneInput.value) {
            previewPhone.textContent = phoneInput.value;
            previewPhoneContainer.style.display = 'flex';
        } else {
            previewPhoneContainer.style.display = 'none';
        }
    }

    // Add event listeners
    [nameInput, positionInput, bioInput, emailInput, phoneInput].forEach(input => {
        if (input) {
            input.addEventListener('input', updatePreview);
            input.addEventListener('change', updatePreview);
        }
    });

    // Initial preview update
    updatePreview();
});
@endsection
