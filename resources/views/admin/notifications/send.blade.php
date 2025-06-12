@extends('layouts.admin')

@section('title', 'Send Notification')
@section('page-title', 'Send Notification')
@section('page-description', 'Send notifications to users, zones, or groups')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-3"></i>
            <span class="text-sm font-medium text-gray-500">Notifications</span>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-3"></i>
            <span class="text-sm font-medium text-gray-500">Send</span>
        </div>
    </li>
@endsection

@section('page-actions')
    <a href="{{ route('admin.notifications.manage') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
        <i class="fas fa-list mr-2"></i>View All Notifications
    </a>
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form id="sendNotificationForm" method="POST" action="{{ route('admin.notifications.send-bulk') }}">
            @csrf

            <!-- Basic Information -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                        <input type="text" name="title" id="title" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue focus:border-transparent"
                               placeholder="Enter notification title">
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                        <select name="type" id="type" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue">
                            <option value="">Select notification type</option>
                            <option value="system">System</option>
                            <option value="zone_update">Zone Update</option>
                            <option value="event">Event</option>
                            <option value="payment">Payment</option>
                            <option value="user_action">User Action</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                    <textarea name="message" id="message" rows="4" required
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue focus:border-transparent"
                              placeholder="Enter your notification message"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority *</label>
                        <select name="priority" id="priority" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue">
                            <option value="normal">Normal</option>
                            <option value="low">Low</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>

                    <div>
                        <label for="action_url" class="block text-sm font-medium text-gray-700 mb-2">Action URL (Optional)</label>
                        <input type="url" name="action_url" id="action_url"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue focus:border-transparent"
                               placeholder="https://...">
                    </div>
                </div>
            </div>

            <!-- Recipients -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recipients</h3>

                <div class="mb-4">
                    <label for="target_type" class="block text-sm font-medium text-gray-700 mb-2">Send To *</label>
                    <select name="target_type" id="target_type" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue"
                            onchange="toggleRecipientOptions()">
                        <option value="">Select recipient type</option>
                        <option value="all_users">All Users</option>
                        <option value="zone_members">Zone Members</option>
                        <option value="zone_executives">Zone Executives</option>
                        <option value="specific_users">Specific Users</option>
                    </select>
                </div>

                <!-- Zone Selection (hidden by default) -->
                <div id="zone_selection" class="mb-4" style="display: none;">
                    <label for="zone_id" class="block text-sm font-medium text-gray-700 mb-2">Select Zone</label>
                    <select name="zone_id" id="zone_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue">
                        <option value="">Select a zone</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- User Selection (hidden by default) -->
                <div id="user_selection" class="mb-4" style="display: none;">
                    <label for="user_ids" class="block text-sm font-medium text-gray-700 mb-2">Select Users</label>
                    <select name="user_ids[]" id="user_ids" multiple
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fcs-blue"
                            size="6">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple users</p>
                </div>
            </div>

            <!-- Email Options -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Email Options</h3>

                <div class="flex items-center">
                    <input type="checkbox" name="send_email" id="send_email" value="1"
                           class="h-4 w-4 text-fcs-blue focus:ring-fcs-blue border-gray-300 rounded">
                    <label for="send_email" class="ml-2 block text-sm text-gray-700">
                        Send email notifications to recipients
                    </label>
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    If unchecked, notifications will only appear in the user's notification center
                </p>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="previewNotification()"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-eye mr-2"></i>Preview
                </button>
                <button type="submit"
                        class="bg-fcs-blue text-white px-6 py-2 rounded-lg hover:bg-fcs-light-blue transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>Send Notification
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Preview</h3>
                    <div id="previewContent" class="border rounded-lg p-4 bg-gray-50">
                        <!-- Preview content will be inserted here -->
                    </div>
                    <div class="mt-4 flex justify-end space-x-3">
                        <button onclick="closePreview()"
                                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function toggleRecipientOptions() {
        const targetType = document.getElementById('target_type').value;
        const zoneSelection = document.getElementById('zone_selection');
        const userSelection = document.getElementById('user_selection');

        // Hide all options first
        zoneSelection.style.display = 'none';
        userSelection.style.display = 'none';

        // Show relevant options
        if (targetType === 'zone_members' || targetType === 'zone_executives') {
            zoneSelection.style.display = 'block';
            document.getElementById('zone_id').required = true;
        } else if (targetType === 'specific_users') {
            userSelection.style.display = 'block';
        } else {
            document.getElementById('zone_id').required = false;
        }
    }

    function previewNotification() {
        const title = document.getElementById('title').value;
        const message = document.getElementById('message').value;
        const type = document.getElementById('type').value;
        const priority = document.getElementById('priority').value;

        if (!title || !message || !type) {
            alert('Please fill in the required fields first');
            return;
        }

        const previewContent = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-bell text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">${title}</p>
                    <p class="text-sm text-gray-500 mt-1">${message}</p>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            ${type.replace('_', ' ')}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 ml-1">
                            ${priority}
                        </span>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('previewContent').innerHTML = previewContent;
        document.getElementById('previewModal').classList.remove('hidden');
    }

    function closePreview() {
        document.getElementById('previewModal').classList.add('hidden');
    }

    // Form submission with loading state
    document.getElementById('sendNotificationForm').addEventListener('submit', function(e) {
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
        submitButton.disabled = true;
    });
</script>
@endpush
