@extends('layouts.admin')

@section('title', 'Create Zone')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <a href="{{ route('admin.zones.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-fcs-blue">Zones</a>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Create</span>
        </div>
    </li>
@endsection

@section('page-title', 'Create New Zone')
@section('page-description', 'Add a new geographical zone to organize members')

@section('page-actions')
    <a href="{{ route('admin.zones.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-arrow-left mr-2"></i>Back to Zones
    </a>
    <button type="submit" form="zone-form" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-save mr-2"></i>Create Zone
    </button>
@endsection

@section('content')
    <form id="zone-form" action="{{ route('admin.zones.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Basic Information</h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Zone Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Zone Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="e.g., Lagos Zone, Abuja Zone">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Brief description of this zone">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-fcs-blue shadow-sm focus:border-fcs-blue focus:ring focus:ring-fcs-blue focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Zone is active</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Location Information -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Location Information</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Country -->
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                    <input type="text" name="country" id="country" value="{{ old('country', 'Nigeria') }}" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('country') border-red-500 @enderror"
                           placeholder="e.g., Nigeria">
                    @error('country')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- State -->
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                    <input type="text" name="state" id="state" value="{{ old('state') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('state') border-red-500 @enderror"
                           placeholder="e.g., Lagos">
                    @error('state')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City -->
                <div class="md:col-span-2">
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text" name="city" id="city" value="{{ old('city') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('city') border-red-500 @enderror"
                           placeholder="e.g., Ikeja">
                    @error('city')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Contact Information</h2>
                <p class="text-sm text-gray-500 mt-1">Optional contact details for this zone</p>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Contact Person -->
                <div>
                    <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label>
                    <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('contact_person') border-red-500 @enderror"
                           placeholder="Zone coordinator name">
                    @error('contact_person')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Phone -->
                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                    <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('contact_phone') border-red-500 @enderror"
                           placeholder="+234 xxx xxx xxxx">
                    @error('contact_phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Email -->
                <div class="md:col-span-2">
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                    <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('contact_email') border-red-500 @enderror"
                           placeholder="zone@example.com">
                    @error('contact_email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </form>
@endsection
