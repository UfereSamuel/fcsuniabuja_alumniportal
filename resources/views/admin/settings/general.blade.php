<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>General Settings - FCS Admin Panel</title>

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
                            <p class="text-xs text-gray-500">General Settings</p>
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
            <h1 class="text-3xl font-bold text-gray-900">General Settings</h1>
            <p class="text-gray-600 mt-2">Configure organization details, contact information, and social media links</p>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.settings.update-general') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Organization Information -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Organization Information</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Organization Name -->
                    <div>
                        <label for="organization_name" class="block text-sm font-medium text-gray-700 mb-1">Organization Name *</label>
                        <input type="text" name="organization_name" id="organization_name"
                               value="{{ old('organization_name', $settings['organization_name'] ?? '') }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('organization_name') border-red-500 @enderror"
                               placeholder="Fellowship of Christian Students">
                        @error('organization_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Organization Tagline -->
                    <div>
                        <label for="organization_tagline" class="block text-sm font-medium text-gray-700 mb-1">Organization Tagline</label>
                        <input type="text" name="organization_tagline" id="organization_tagline"
                               value="{{ old('organization_tagline', $settings['organization_tagline'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('organization_tagline') border-red-500 @enderror"
                               placeholder="Building Tomorrow's Leaders">
                        @error('organization_tagline')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Organization Description -->
                    <div>
                        <label for="organization_description" class="block text-sm font-medium text-gray-700 mb-1">Organization Description</label>
                        <textarea name="organization_description" id="organization_description" rows="4"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('organization_description') border-red-500 @enderror"
                                  placeholder="Brief description of your organization's mission and purpose">{{ old('organization_description', $settings['organization_description'] ?? '') }}</textarea>
                        @error('organization_description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Contact Information</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Contact Email -->
                    <div class="md:col-span-2">
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Contact Email *</label>
                        <input type="email" name="contact_email" id="contact_email"
                               value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('contact_email') border-red-500 @enderror"
                               placeholder="info@fcs.org">
                        @error('contact_email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Phone -->
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                        <input type="tel" name="contact_phone" id="contact_phone"
                               value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('contact_phone') border-red-500 @enderror"
                               placeholder="+234 xxx xxx xxxx">
                        @error('contact_phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Address -->
                    <div class="md:col-span-2">
                        <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-1">Contact Address</label>
                        <textarea name="contact_address" id="contact_address" rows="3"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('contact_address') border-red-500 @enderror"
                                  placeholder="Organization physical address">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
                        @error('contact_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Social Media Links</h2>
                    <p class="text-sm text-gray-500 mt-1">Add your organization's social media profiles</p>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Facebook URL -->
                    <div>
                        <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook URL
                        </label>
                        <input type="url" name="facebook_url" id="facebook_url"
                               value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('facebook_url') border-red-500 @enderror"
                               placeholder="https://facebook.com/yourpage">
                        @error('facebook_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Twitter URL -->
                    <div>
                        <label for="twitter_url" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fab fa-twitter text-blue-400 mr-2"></i>Twitter URL
                        </label>
                        <input type="url" name="twitter_url" id="twitter_url"
                               value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('twitter_url') border-red-500 @enderror"
                               placeholder="https://twitter.com/yourhandle">
                        @error('twitter_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- LinkedIn URL -->
                    <div>
                        <label for="linkedin_url" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fab fa-linkedin text-blue-700 mr-2"></i>LinkedIn URL
                        </label>
                        <input type="url" name="linkedin_url" id="linkedin_url"
                               value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('linkedin_url') border-red-500 @enderror"
                               placeholder="https://linkedin.com/company/yourcompany">
                        @error('linkedin_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instagram URL -->
                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram URL
                        </label>
                        <input type="url" name="instagram_url" id="instagram_url"
                               value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('instagram_url') border-red-500 @enderror"
                               placeholder="https://instagram.com/yourhandle">
                        @error('instagram_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- YouTube URL -->
                    <div class="md:col-span-2">
                        <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fab fa-youtube text-red-600 mr-2"></i>YouTube URL
                        </label>
                        <input type="url" name="youtube_url" id="youtube_url"
                               value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('youtube_url') border-red-500 @enderror"
                               placeholder="https://youtube.com/channel/yourchannel">
                        @error('youtube_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">
                    <i class="fas fa-eye mr-2"></i>Preview
                </h3>
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-900" id="preview-name">Fellowship of Christian Students</h2>
                        <p class="text-gray-600 text-lg" id="preview-tagline">Building Tomorrow's Leaders</p>
                        <p class="text-gray-500 mt-4" id="preview-description">Organization description will appear here...</p>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row items-center justify-center space-y-2 sm:space-y-0 sm:space-x-6">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-envelope mr-2"></i>
                                    <span id="preview-email">info@fcs.org</span>
                                </div>
                                <div class="flex items-center text-gray-600" id="preview-phone-container" style="display: none;">
                                    <i class="fas fa-phone mr-2"></i>
                                    <span id="preview-phone"></span>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-center space-x-4" id="preview-social">
                                <!-- Social links will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-between">
                <div class="flex space-x-4">
                    <form action="{{ route('admin.settings.reset') }}" method="POST" class="inline"
                          onsubmit="return confirm('Are you sure you want to reset all general settings to defaults? This action cannot be undone.')">
                        @csrf
                        <input type="hidden" name="category" value="general">
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
                        <i class="fas fa-save mr-2"></i>Save Settings
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript for preview updates -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preview elements
            const previewName = document.getElementById('preview-name');
            const previewTagline = document.getElementById('preview-tagline');
            const previewDescription = document.getElementById('preview-description');
            const previewEmail = document.getElementById('preview-email');
            const previewPhone = document.getElementById('preview-phone');
            const previewPhoneContainer = document.getElementById('preview-phone-container');
            const previewSocial = document.getElementById('preview-social');

            // Input elements
            const inputs = {
                organization_name: document.getElementById('organization_name'),
                organization_tagline: document.getElementById('organization_tagline'),
                organization_description: document.getElementById('organization_description'),
                contact_email: document.getElementById('contact_email'),
                contact_phone: document.getElementById('contact_phone'),
                facebook_url: document.getElementById('facebook_url'),
                twitter_url: document.getElementById('twitter_url'),
                linkedin_url: document.getElementById('linkedin_url'),
                instagram_url: document.getElementById('instagram_url'),
                youtube_url: document.getElementById('youtube_url')
            };

            // Update preview functions
            function updatePreview() {
                // Update organization info
                previewName.textContent = inputs.organization_name.value || 'Fellowship of Christian Students';
                previewTagline.textContent = inputs.organization_tagline.value || 'Building Tomorrow\'s Leaders';
                previewDescription.textContent = inputs.organization_description.value || 'Organization description will appear here...';
                previewEmail.textContent = inputs.contact_email.value || 'info@fcs.org';

                // Update phone
                if (inputs.contact_phone.value) {
                    previewPhone.textContent = inputs.contact_phone.value;
                    previewPhoneContainer.style.display = 'flex';
                } else {
                    previewPhoneContainer.style.display = 'none';
                }

                // Update social links
                updateSocialLinks();
            }

            function updateSocialLinks() {
                const socialLinks = [
                    { key: 'facebook_url', icon: 'fab fa-facebook', color: 'text-blue-600' },
                    { key: 'twitter_url', icon: 'fab fa-twitter', color: 'text-blue-400' },
                    { key: 'linkedin_url', icon: 'fab fa-linkedin', color: 'text-blue-700' },
                    { key: 'instagram_url', icon: 'fab fa-instagram', color: 'text-pink-600' },
                    { key: 'youtube_url', icon: 'fab fa-youtube', color: 'text-red-600' }
                ];

                previewSocial.innerHTML = '';
                socialLinks.forEach(social => {
                    if (inputs[social.key].value) {
                        const link = document.createElement('a');
                        link.href = inputs[social.key].value;
                        link.target = '_blank';
                        link.className = `${social.color} hover:opacity-75 transition`;
                        link.innerHTML = `<i class="${social.icon} text-xl"></i>`;
                        previewSocial.appendChild(link);
                    }
                });
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
