@extends('layouts.admin')

@section('title', 'Add New Document')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <a href="{{ route('admin.documents.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-fcs-blue">Documents</a>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Add New</span>
        </div>
    </li>
@endsection

@section('page-title', 'Add New Document')
@section('page-description', 'Upload and configure a new document for the system.')

@section('page-actions')
    <a href="{{ route('admin.documents.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-arrow-left mr-2"></i>Back to Documents
    </a>
    <button type="submit" form="document-form" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-upload mr-2"></i>Upload Document
    </button>
@endsection

@section('content')
    <form id="document-form" action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Document Information -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Document Information</h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Document Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                           placeholder="Enter document title">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                    <select name="category" id="category" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category') border-red-500 @enderror">
                        <option value="">Select Category</option>
                        <option value="Constitution" {{ old('category') == 'Constitution' ? 'selected' : '' }}>Constitution</option>
                        <option value="By-Laws" {{ old('category') == 'By-Laws' ? 'selected' : '' }}>By-Laws</option>
                        <option value="Policies" {{ old('category') == 'Policies' ? 'selected' : '' }}>Policies</option>
                        <option value="Forms" {{ old('category') == 'Forms' ? 'selected' : '' }}>Forms</option>
                        <option value="Reports" {{ old('category') == 'Reports' ? 'selected' : '' }}>Reports</option>
                        <option value="Minutes" {{ old('category') == 'Minutes' ? 'selected' : '' }}>Minutes</option>
                        <option value="Guidelines" {{ old('category') == 'Guidelines' ? 'selected' : '' }}>Guidelines</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Brief description of the document content and purpose">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- File Upload -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">File Upload</h2>
            </div>
            <div class="p-6">
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Document File *</label>
                    <input type="file" name="file" id="file" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('file') border-red-500 @enderror"
                           onchange="showFileInfo(this)">
                    <p class="text-xs text-gray-500 mt-1">
                        Supported formats: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT. Maximum file size: 10MB
                    </p>
                    @error('file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <!-- File Info Display -->
                    <div id="file-info" class="mt-4 hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">File Information</h4>
                        <div class="space-y-1 text-sm text-blue-800">
                            <div class="flex justify-between">
                                <span>File Name:</span>
                                <span id="file-name"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>File Size:</span>
                                <span id="file-size"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>File Type:</span>
                                <span id="file-type"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Settings -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Document Settings</h2>
            </div>
            <div class="p-6 space-y-4">
                <!-- Public Access -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Public Access</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1">Allow public access to this document without login</p>
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Active Document</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1">Only active documents will be visible to users</p>
                </div>
            </div>
        </div>

        <!-- Document Preview -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">
                <i class="fas fa-eye mr-2"></i>Document Preview
            </h3>
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file text-gray-400 text-2xl" id="preview-icon"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-xl font-bold text-gray-900 mb-1" id="preview-title">Document Title</h4>
                        <p class="text-gray-600 font-medium mb-2" id="preview-category">Category</p>
                        <p class="text-gray-600 text-sm mb-3" id="preview-description">Document description will appear here...</p>
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                <span>{{ auth()->user()->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                <span>{{ date('M j, Y') }}</span>
                            </div>
                            <div class="flex items-center" id="preview-size-container" style="display: none;">
                                <i class="fas fa-hdd mr-2"></i>
                                <span id="preview-size"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    function showFileInfo(input) {
        const file = input.files[0];
        const fileInfo = document.getElementById('file-info');
        const fileName = document.getElementById('file-name');
        const fileSize = document.getElementById('file-size');
        const fileType = document.getElementById('file-type');
        const previewIcon = document.getElementById('preview-icon');
        const previewSize = document.getElementById('preview-size');
        const previewSizeContainer = document.getElementById('preview-size-container');

        if (file) {
            // Show file info
            fileInfo.classList.remove('hidden');
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileType.textContent = file.type || 'Unknown';

            // Update preview
            previewSize.textContent = formatFileSize(file.size);
            previewSizeContainer.style.display = 'flex';

            // Update icon based on file type
            const extension = file.name.split('.').pop().toLowerCase();
            const iconClass = getFileIcon(extension);
            previewIcon.className = `fas ${iconClass} text-gray-400 text-2xl`;
        } else {
            fileInfo.classList.add('hidden');
            previewSizeContainer.style.display = 'none';
            previewIcon.className = 'fas fa-file text-gray-400 text-2xl';
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function getFileIcon(extension) {
        const icons = {
            'pdf': 'fa-file-pdf',
            'doc': 'fa-file-word',
            'docx': 'fa-file-word',
            'xls': 'fa-file-excel',
            'xlsx': 'fa-file-excel',
            'ppt': 'fa-file-powerpoint',
            'pptx': 'fa-file-powerpoint',
            'txt': 'fa-file-alt'
        };
        return icons[extension] || 'fa-file';
    }

    // Live preview updates
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('title');
        const categoryInput = document.getElementById('category');
        const descriptionInput = document.getElementById('description');

        const previewTitle = document.getElementById('preview-title');
        const previewCategory = document.getElementById('preview-category');
        const previewDescription = document.getElementById('preview-description');

        function updatePreview() {
            previewTitle.textContent = titleInput.value || 'Document Title';
            previewCategory.textContent = categoryInput.value || 'Category';
            previewDescription.textContent = descriptionInput.value || 'Document description will appear here...';
        }

        [titleInput, categoryInput, descriptionInput].forEach(input => {
            if (input) {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            }
        });
    });
@endsection
