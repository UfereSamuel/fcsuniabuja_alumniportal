@extends('layouts.admin')

@section('title', 'Add WhatsApp Group')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <a href="{{ route('admin.whatsapp-groups.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-fcs-blue">WhatsApp Groups</a>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Add Group</span>
        </div>
    </li>
@endsection

@section('page-title', 'Add WhatsApp Group')
@section('page-description', 'Add a new WhatsApp group for FCS alumni communication')

@section('page-actions')
    <a href="{{ route('admin.whatsapp-groups.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-arrow-left mr-2"></i>Back to Groups
    </a>
@endsection

@section('content')
    <form action="{{ route('admin.whatsapp-groups.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Group Information</h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Group Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Group Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="Enter WhatsApp group name">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Brief description of the group purpose">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Invite Link -->
                <div>
                    <label for="invite_link" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Invite Link *</label>
                    <input type="url" name="invite_link" id="invite_link" value="{{ old('invite_link') }}" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('invite_link') border-red-500 @enderror"
                           placeholder="https://chat.whatsapp.com/...">
                    <p class="text-xs text-gray-500 mt-1">Full WhatsApp group invite link</p>
                    @error('invite_link')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type and Member Count -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Group Type *</label>
                        <select name="type" id="type" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror">
                            <option value="">Select Type</option>
                            <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
                            <option value="zone" {{ old('type') == 'zone' ? 'selected' : '' }}>Zone</option>
                            <option value="class" {{ old('type') == 'class' ? 'selected' : '' }}>Class</option>
                            <option value="executive" {{ old('type') == 'executive' ? 'selected' : '' }}>Executive</option>
                            <option value="special" {{ old('type') == 'special' ? 'selected' : '' }}>Special</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="member_count" class="block text-sm font-medium text-gray-700 mb-1">Member Count</label>
                        <input type="number" name="member_count" id="member_count" value="{{ old('member_count', 0) }}" min="0"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('member_count') border-red-500 @enderror"
                               placeholder="0">
                        @error('member_count')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Group Settings</h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Status Checkboxes -->
                <div class="space-y-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Active Group</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Public Group (visible to all members)</span>
                    </label>
                </div>

                <!-- Group Rules -->
                <div>
                    <label for="rules" class="block text-sm font-medium text-gray-700 mb-1">Group Rules</label>
                    <textarea name="rules" id="rules" rows="4"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('rules') border-red-500 @enderror"
                              placeholder="Group rules and guidelines for members">{{ old('rules') }}</textarea>
                    @error('rules')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between">
            <div></div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                    <i class="fab fa-whatsapp mr-2"></i>Add Group
                </button>
            </div>
        </div>
    </form>
@endsection
