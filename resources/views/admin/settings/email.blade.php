<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Settings - FCS Admin Panel</title>

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
        .test-email-result {
            display: none;
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
                            <p class="text-xs text-gray-500">Email Settings</p>
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
            <h1 class="text-3xl font-bold text-gray-900">Email Settings</h1>
            <p class="text-gray-600 mt-2">Configure SMTP settings, email templates, and notification preferences</p>
        </div>

        <!-- Test Email Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-blue-900">Test Email Configuration</h3>
                    <p class="text-blue-700 text-sm mt-1">Send a test email to verify your configuration</p>
                </div>
                <button type="button" onclick="testEmailConfiguration()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    <i class="fas fa-paper-plane mr-2"></i>Send Test Email
                </button>
            </div>

            <!-- Test Result -->
            <div id="test-email-result" class="test-email-result mt-4 p-4 rounded-lg">
                <div class="flex items-center">
                    <i id="test-result-icon" class="mr-2"></i>
                    <span id="test-result-message"></span>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.settings.update-email') }}" method="POST" class="space-y-6">
            @csrf

            <!-- SMTP Configuration -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">SMTP Configuration</h2>
                    <p class="text-sm text-gray-500 mt-1">Configure your email server settings</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Mail Driver -->
                    <div>
                        <label for="mail_driver" class="block text-sm font-medium text-gray-700 mb-1">Mail Driver *</label>
                        <select name="mail_driver" id="mail_driver" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mail_driver') border-red-500 @enderror"
                                onchange="toggleSMTPFields()">
                            <option value="smtp" {{ old('mail_driver', $settings['mail_driver'] ?? 'smtp') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="sendmail" {{ old('mail_driver', $settings['mail_driver'] ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                            <option value="log" {{ old('mail_driver', $settings['mail_driver'] ?? '') == 'log' ? 'selected' : '' }}>Log (Development)</option>
                        </select>
                        @error('mail_driver')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="smtp-fields" class="space-y-6">
                        <!-- SMTP Host -->
                        <div>
                            <label for="mail_host" class="block text-sm font-medium text-gray-700 mb-1">SMTP Host *</label>
                            <input type="text" name="mail_host" id="mail_host" value="{{ old('mail_host', $settings['mail_host'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mail_host') border-red-500 @enderror"
                                   placeholder="smtp.gmail.com">
                            @error('mail_host')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SMTP Port -->
                        <div>
                            <label for="mail_port" class="block text-sm font-medium text-gray-700 mb-1">SMTP Port *</label>
                            <input type="number" name="mail_port" id="mail_port" value="{{ old('mail_port', $settings['mail_port'] ?? '587') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mail_port') border-red-500 @enderror"
                                   placeholder="587">
                            <p class="text-xs text-gray-500 mt-1">Common ports: 587 (TLS), 465 (SSL), 25 (unsecured)</p>
                            @error('mail_port')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SMTP Username -->
                        <div>
                            <label for="mail_username" class="block text-sm font-medium text-gray-700 mb-1">SMTP Username</label>
                            <input type="text" name="mail_username" id="mail_username" value="{{ old('mail_username', $settings['mail_username'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mail_username') border-red-500 @enderror"
                                   placeholder="your-email@domain.com">
                            @error('mail_username')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SMTP Password -->
                        <div>
                            <label for="mail_password" class="block text-sm font-medium text-gray-700 mb-1">SMTP Password</label>
                            <input type="password" name="mail_password" id="mail_password" value="{{ old('mail_password', $settings['mail_password'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mail_password') border-red-500 @enderror"
                                   placeholder="Your SMTP password or app password">
                            @error('mail_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SMTP Encryption -->
                        <div>
                            <label for="mail_encryption" class="block text-sm font-medium text-gray-700 mb-1">Encryption *</label>
                            <select name="mail_encryption" id="mail_encryption"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mail_encryption') border-red-500 @enderror">
                                <option value="tls" {{ old('mail_encryption', $settings['mail_encryption'] ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ old('mail_encryption', $settings['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="" {{ old('mail_encryption', $settings['mail_encryption'] ?? '') == '' ? 'selected' : '' }}>None</option>
                            </select>
                            @error('mail_encryption')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Defaults -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Email Defaults</h2>
                    <p class="text-sm text-gray-500 mt-1">Default settings for outgoing emails</p>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- From Email -->
                    <div>
                        <label for="mail_from_address" class="block text-sm font-medium text-gray-700 mb-1">From Email Address *</label>
                        <input type="email" name="mail_from_address" id="mail_from_address" value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mail_from_address') border-red-500 @enderror"
                               placeholder="noreply@fcs.org">
                        @error('mail_from_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- From Name -->
                    <div>
                        <label for="mail_from_name" class="block text-sm font-medium text-gray-700 mb-1">From Name *</label>
                        <input type="text" name="mail_from_name" id="mail_from_name" value="{{ old('mail_from_name', $settings['mail_from_name'] ?? '') }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mail_from_name') border-red-500 @enderror"
                               placeholder="FCS Alumni Portal">
                        @error('mail_from_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reply To Email -->
                    <div>
                        <label for="mail_reply_to_address" class="block text-sm font-medium text-gray-700 mb-1">Reply-To Email</label>
                        <input type="email" name="mail_reply_to_address" id="mail_reply_to_address" value="{{ old('mail_reply_to_address', $settings['mail_reply_to_address'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mail_reply_to_address') border-red-500 @enderror"
                               placeholder="support@fcs.org">
                        @error('mail_reply_to_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reply To Name -->
                    <div>
                        <label for="mail_reply_to_name" class="block text-sm font-medium text-gray-700 mb-1">Reply-To Name</label>
                        <input type="text" name="mail_reply_to_name" id="mail_reply_to_name" value="{{ old('mail_reply_to_name', $settings['mail_reply_to_name'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mail_reply_to_name') border-red-500 @enderror"
                               placeholder="FCS Support Team">
                        @error('mail_reply_to_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Email Notifications -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Email Notifications</h2>
                    <p class="text-sm text-gray-500 mt-1">Configure automatic email notifications</p>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Welcome Email -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Welcome Email</h3>
                            <p class="text-sm text-gray-500">Send welcome email to new users upon registration</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="send_welcome_email" value="1"
                                   {{ old('send_welcome_email', $settings['send_welcome_email'] ?? true) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Event Notifications -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Event Notifications</h3>
                            <p class="text-sm text-gray-500">Send notifications for new events and updates</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="send_event_notifications" value="1"
                                   {{ old('send_event_notifications', $settings['send_event_notifications'] ?? true) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Password Reset -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Password Reset</h3>
                            <p class="text-sm text-gray-500">Send password reset emails when requested</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="send_password_reset" value="1"
                                   {{ old('send_password_reset', $settings['send_password_reset'] ?? true) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Admin Notifications -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Admin Notifications</h3>
                            <p class="text-sm text-gray-500">Notify administrators of new registrations and activities</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="send_admin_notifications" value="1"
                                   {{ old('send_admin_notifications', $settings['send_admin_notifications'] ?? true) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Email Templates -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Email Templates</h2>
                    <p class="text-sm text-gray-500 mt-1">Customize email content and formatting</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Email Footer -->
                    <div>
                        <label for="email_footer" class="block text-sm font-medium text-gray-700 mb-1">Email Footer</label>
                        <textarea name="email_footer" id="email_footer" rows="4"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email_footer') border-red-500 @enderror"
                                  placeholder="Footer text that appears at the bottom of all emails">{{ old('email_footer', $settings['email_footer'] ?? '') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">This text will appear at the bottom of all outgoing emails</p>
                        @error('email_footer')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Signature -->
                    <div>
                        <label for="email_signature" class="block text-sm font-medium text-gray-700 mb-1">Email Signature</label>
                        <textarea name="email_signature" id="email_signature" rows="3"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email_signature') border-red-500 @enderror"
                                  placeholder="Best regards,&#10;FCS Alumni Portal Team">{{ old('email_signature', $settings['email_signature'] ?? '') }}</textarea>
                        @error('email_signature')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Email Preview -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">
                    <i class="fas fa-eye mr-2"></i>Email Preview
                </h3>
                <div class="bg-white rounded-lg p-6 shadow-sm border">
                    <div class="border-b pb-4 mb-4">
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-500">From:</span>
                                <span id="preview-from-name">FCS Alumni Portal</span> &lt;<span id="preview-from-email">noreply@fcs.org</span>&gt;
                            </div>
                            <div>
                                <span class="font-medium text-gray-500">Reply-To:</span>
                                <span id="preview-reply-name">FCS Support Team</span> &lt;<span id="preview-reply-email">support@fcs.org</span>&gt;
                            </div>
                            <div>
                                <span class="font-medium text-gray-500">Subject:</span>
                                <span>Welcome to FCS Alumni Portal</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <p class="text-gray-900">Hello [User Name],</p>
                        <p class="text-gray-700">Welcome to the FCS Alumni Portal! We're excited to have you as part of our community.</p>
                        <p class="text-gray-700">You can now access exclusive events, connect with fellow alumni, and stay updated with the latest news.</p>

                        <div class="pt-4 border-t">
                            <div id="preview-signature" class="text-gray-600 whitespace-pre-line">Best regards,
FCS Alumni Portal Team</div>
                        </div>

                        <div class="pt-4 border-t">
                            <div id="preview-footer" class="text-gray-500 text-sm">
                                This email was sent from the FCS Alumni Portal. If you have any questions, please contact our support team.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-between">
                <div class="flex space-x-4">
                    <form action="{{ route('admin.settings.reset') }}" method="POST" class="inline"
                          onsubmit="return confirm('Are you sure you want to reset all email settings to defaults? This action cannot be undone.')">
                        @csrf
                        <input type="hidden" name="category" value="email">
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
                        <i class="fas fa-save mr-2"></i>Save Email Settings
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript for interactions -->
    <script>
        // Toggle SMTP fields based on mail driver
        function toggleSMTPFields() {
            const driver = document.getElementById('mail_driver').value;
            const smtpFields = document.getElementById('smtp-fields');

            if (driver === 'smtp') {
                smtpFields.style.display = 'block';
            } else {
                smtpFields.style.display = 'none';
            }
        }

        // Test email configuration
        function testEmailConfiguration() {
            const button = document.querySelector('button[onclick="testEmailConfiguration()"]');
            const resultDiv = document.getElementById('test-email-result');
            const resultIcon = document.getElementById('test-result-icon');
            const resultMessage = document.getElementById('test-result-message');

            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
            button.disabled = true;

            // Make AJAX request to test email
            fetch('{{ route("admin.settings.test-email") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    mail_driver: document.getElementById('mail_driver').value,
                    mail_host: document.getElementById('mail_host').value,
                    mail_port: document.getElementById('mail_port').value,
                    mail_username: document.getElementById('mail_username').value,
                    mail_password: document.getElementById('mail_password').value,
                    mail_encryption: document.getElementById('mail_encryption').value,
                    mail_from_address: document.getElementById('mail_from_address').value,
                    mail_from_name: document.getElementById('mail_from_name').value
                })
            })
            .then(response => response.json())
            .then(data => {
                resultDiv.style.display = 'block';
                if (data.success) {
                    resultDiv.className = 'test-email-result mt-4 p-4 rounded-lg bg-green-100 border border-green-300';
                    resultIcon.className = 'fas fa-check-circle text-green-600 mr-2';
                    resultMessage.textContent = data.message;
                } else {
                    resultDiv.className = 'test-email-result mt-4 p-4 rounded-lg bg-red-100 border border-red-300';
                    resultIcon.className = 'fas fa-exclamation-circle text-red-600 mr-2';
                    resultMessage.textContent = data.message;
                }
            })
            .catch(error => {
                resultDiv.style.display = 'block';
                resultDiv.className = 'test-email-result mt-4 p-4 rounded-lg bg-red-100 border border-red-300';
                resultIcon.className = 'fas fa-exclamation-circle text-red-600 mr-2';
                resultMessage.textContent = 'Error testing email configuration. Please try again.';
            })
            .finally(() => {
                // Reset button
                button.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Send Test Email';
                button.disabled = false;
            });
        }

        // Update email preview
        document.addEventListener('DOMContentLoaded', function() {
            const fromName = document.getElementById('mail_from_name');
            const fromEmail = document.getElementById('mail_from_address');
            const replyName = document.getElementById('mail_reply_to_name');
            const replyEmail = document.getElementById('mail_reply_to_address');
            const signature = document.getElementById('email_signature');
            const footer = document.getElementById('email_footer');

            const previewFromName = document.getElementById('preview-from-name');
            const previewFromEmail = document.getElementById('preview-from-email');
            const previewReplyName = document.getElementById('preview-reply-name');
            const previewReplyEmail = document.getElementById('preview-reply-email');
            const previewSignature = document.getElementById('preview-signature');
            const previewFooter = document.getElementById('preview-footer');

            function updatePreview() {
                previewFromName.textContent = fromName.value || 'FCS Alumni Portal';
                previewFromEmail.textContent = fromEmail.value || 'noreply@fcs.org';
                previewReplyName.textContent = replyName.value || 'FCS Support Team';
                previewReplyEmail.textContent = replyEmail.value || 'support@fcs.org';
                previewSignature.textContent = signature.value || 'Best regards,\nFCS Alumni Portal Team';
                previewFooter.textContent = footer.value || 'This email was sent from the FCS Alumni Portal. If you have any questions, please contact our support team.';
            }

            // Add event listeners
            [fromName, fromEmail, replyName, replyEmail, signature, footer].forEach(input => {
                if (input) {
                    input.addEventListener('input', updatePreview);
                }
            });

            // Initial preview update
            updatePreview();

            // Initial SMTP fields toggle
            toggleSMTPFields();
        });
    </script>
</body>
</html>
