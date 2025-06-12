@extends('layouts.admin')

@section('title', 'Create Class')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <a href="{{ route('admin.classes.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-fcs-blue">Classes</a>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Create</span>
        </div>
    </li>
@endsection

@section('page-title', 'Create New Class')
@section('page-description', 'Add a new graduation class to organize alumni')

@section('page-actions')
    <a href="{{ route('admin.classes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-arrow-left mr-2"></i>Back to Classes
    </a>
    <button type="submit" form="class-form" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-save mr-2"></i>Create Class
    </button>
@endsection

@section('content')
    <form id="class-form" action="{{ route('admin.classes.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Basic Information</h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Class Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Class Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="e.g., Class 2023 - Champions">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Graduation Year -->
                <div>
                    <label for="graduation_year" class="block text-sm font-medium text-gray-700 mb-1">Graduation Year *</label>
                    <input type="number" name="graduation_year" id="graduation_year" value="{{ old('graduation_year') }}" required
                           min="1950" max="{{ date('Y') + 10 }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('graduation_year') border-red-500 @enderror"
                           placeholder="e.g., 2023">
                    @error('graduation_year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Class Slogan -->
                <div>
                    <label for="slogan" class="block text-sm font-medium text-gray-700 mb-1">Class Slogan</label>
                    <input type="text" name="slogan" id="slogan" value="{{ old('slogan') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('slogan') border-red-500 @enderror"
                           placeholder="e.g., Champions, Overcomers, Faith Warriors">
                    @error('slogan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Brief description of this graduation class">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-fcs-blue shadow-sm focus:border-fcs-blue focus:ring focus:ring-fcs-blue focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Class is active</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Class Leadership</h2>
                <p class="text-sm text-gray-500 mt-1">Optional class coordinator information</p>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- WhatsApp Link -->
                <div class="md:col-span-2">
                    <label for="whatsapp_link" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Group Link</label>
                    <input type="url" name="whatsapp_link" id="whatsapp_link" value="{{ old('whatsapp_link') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue focus:border-transparent @error('whatsapp_link') border-red-500 @enderror"
                           placeholder="https://chat.whatsapp.com/...">
                    @error('whatsapp_link')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </form>
@endsection
