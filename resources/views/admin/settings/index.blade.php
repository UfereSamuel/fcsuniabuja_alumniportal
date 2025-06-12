@extends('layouts.admin')

@section('title', 'System Settings')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Settings</span>
        </div>
    </li>
@endsection

@section('page-title', 'System Settings')
@section('page-description', 'Manage your FCS Alumni Portal configuration and preferences')

@section('page-actions')
    <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
    </a>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
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
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">System Settings</h1>
            <p class="text-gray-600 mt-2">Manage your FCS Alumni Portal configuration and preferences</p>
        </div>

        <!-- Settings Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- General Settings -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cog text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">General Settings</h3>
                    <p class="text-gray-600 text-sm mb-4">Organization details, contact information, and social media links</p>
                    <a href="{{ route('admin.settings.general') }}"
                       class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                        Configure <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Branding Settings -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-palette text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Branding & Logos</h3>
                    <p class="text-gray-600 text-sm mb-4">Upload logos, set colors, and customize the visual appearance</p>
                    <a href="{{ route('admin.settings.branding') }}"
                       class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                        Configure <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Email Settings -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-envelope text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Email Configuration</h3>
                    <p class="text-gray-600 text-sm mb-4">SMTP settings and email notification preferences</p>
                    <a href="{{ route('admin.settings.email') }}"
                       class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                        Configure <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Content Management -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-alt text-orange-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Content Management</h3>
                    <p class="text-gray-600 text-sm mb-4">Manage site content, messages, and organizational statements</p>
                    <a href="{{ route('admin.settings.content') }}"
                       class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                        Configure <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Settings Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Current Settings Summary -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Settings Overview</h3>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($settings as $category => $categorySettings)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                    @switch($category)
                                        @case('general')
                                            <i class="fas fa-cog text-gray-600"></i>
                                            @break
                                        @case('branding')
                                            <i class="fas fa-palette text-gray-600"></i>
                                            @break
                                        @case('email')
                                            <i class="fas fa-envelope text-gray-600"></i>
                                            @break
                                        @case('content')
                                            <i class="fas fa-file-alt text-gray-600"></i>
                                            @break
                                        @default
                                            <i class="fas fa-cog text-gray-600"></i>
                                    @endswitch
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ ucfirst($category) }} Settings</p>
                                    <p class="text-sm text-gray-500">{{ $categorySettings->count() }} configuration(s)</p>
                                </div>
                            </div>
                            <span class="text-green-600 text-sm font-medium">
                                <i class="fas fa-check-circle mr-1"></i>Configured
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-cog text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500">No settings configured yet</p>
                            <p class="text-gray-400 text-sm">Configure your first settings using the options above</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Export Settings -->
                    <a href="{{ route('admin.settings.export') }}"
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium transition flex items-center justify-center">
                        <i class="fas fa-download mr-2"></i>Export Settings
                    </a>

                    <!-- Import Settings -->
                    <form action="{{ route('admin.settings.import') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <input type="file" name="settings_file" accept=".json"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium transition">
                            <i class="fas fa-upload mr-2"></i>Import Settings
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-4"></div>

                    <!-- Test Email -->
                    <div class="space-y-3">
                        <input type="email" id="test-email" placeholder="Enter email to test configuration"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button onclick="testEmail()" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-lg font-medium transition">
                            <i class="fas fa-paper-plane mr-2"></i>Test Email Configuration
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold mb-4">System Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold">{{ $settings->flatten()->count() }}</div>
                    <div class="text-blue-100">Total Settings</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold">{{ $settings->count() }}</div>
                    <div class="text-blue-100">Categories</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold">{{ now()->format('M Y') }}</div>
                    <div class="text-blue-100">Last Update</div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function testEmail() {
            const email = document.getElementById('test-email').value;
            if (!email) {
                alert('Please enter an email address');
                return;
            }

            fetch('{{ route("admin.settings.test-email") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ test_email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                } else {
                    alert('❌ ' + data.message);
                }
            })
            .catch(error => {
                alert('❌ Error: ' + error.message);
            });
        }
    </script>
@endsection
