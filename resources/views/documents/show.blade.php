@extends('layouts.app')

@section('title', $document->title . ' - Documents')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('documents.index') }}" class="text-blue-200 hover:text-white transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Documents
                </a>
            </div>
            <div class="flex items-start space-x-6">
                <div class="w-16 h-16 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas {{ $document->file_type == 'pdf' ? 'fa-file-pdf' : ($document->file_type == 'doc' || $document->file_type == 'docx' ? 'fa-file-word' : 'fa-file') }} text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2">{{ $document->title }}</h1>
                    <div class="flex items-center space-x-4 text-blue-200">
                        <span class="inline-block bg-blue-500 text-white text-sm font-medium px-3 py-1 rounded-full">
                            {{ $document->category }}
                        </span>
                        @if(!$document->is_public)
                            <span class="inline-block bg-yellow-500 text-white text-sm font-medium px-3 py-1 rounded-full">
                                <i class="fas fa-lock mr-1"></i>Members Only
                            </span>
                        @else
                            <span class="inline-block bg-green-500 text-white text-sm font-medium px-3 py-1 rounded-full">
                                <i class="fas fa-globe mr-1"></i>Public Access
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Document Details -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Document Details</h2>

                    @if($document->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $document->description }}</p>
                        </div>
                    @endif

                    <!-- Document Meta Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">File Information</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">File Name:</span>
                                    <span class="font-medium">{{ $document->original_filename }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">File Type:</span>
                                    <span class="font-medium uppercase">{{ $document->file_type }}</span>
                                </div>
                                @if($document->file_size)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">File Size:</span>
                                        <span class="font-medium">
                                            {{ $document->file_size < 1024 ? $document->file_size . ' KB' : round($document->file_size / 1024, 1) . ' MB' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Publication Info</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Published:</span>
                                    <span class="font-medium">{{ $document->created_at->format('M j, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Last Updated:</span>
                                    <span class="font-medium">{{ $document->updated_at->format('M j, Y') }}</span>
                                </div>
                                @if($document->download_count > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Downloads:</span>
                                        <span class="font-medium">{{ $document->download_count }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Download Button -->
                    <div class="border-t pt-6">
                        <a href="{{ route('documents.download', $document) }}"
                           class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
                            <i class="fas fa-download mr-2"></i>
                            Download Document
                        </a>
                        <p class="text-sm text-gray-500 mt-2">
                            Click to download {{ $document->original_filename }}
                        </p>
                    </div>
                </div>

                <!-- Share Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Share Document</h2>
                    <div class="flex items-center space-x-4">
                        <button onclick="copyToClipboard('{{ route('documents.show', $document) }}')"
                                class="flex items-center bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-link mr-2"></i>Copy Link
                        </button>
                        <a href="mailto:?subject={{ urlencode($document->title) }}&body={{ urlencode('Check out this document: ' . route('documents.show', $document)) }}"
                           class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-envelope mr-2"></i>Email
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('documents.download', $document) }}"
                           class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium transition flex items-center justify-center">
                            <i class="fas fa-download mr-2"></i>Download
                        </a>
                        <a href="{{ route('documents.index') }}"
                           class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg font-medium transition flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Documents
                        </a>
                    </div>
                </div>

                <!-- Document Category -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Category</h3>
                    <a href="{{ route('documents.index', ['category' => $document->category]) }}"
                       class="inline-block bg-blue-100 text-blue-800 px-3 py-2 rounded-lg font-medium hover:bg-blue-200 transition">
                        {{ $document->category }}
                    </a>
                    <p class="text-sm text-gray-500 mt-2">
                        View all documents in this category
                    </p>
                </div>

                <!-- Access Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Access Information</h3>
                    @if($document->is_public)
                        <div class="flex items-center text-green-600 mb-2">
                            <i class="fas fa-globe mr-2"></i>
                            <span class="font-medium">Public Access</span>
                        </div>
                        <p class="text-sm text-gray-600">
                            This document is available to everyone, including non-members.
                        </p>
                    @else
                        <div class="flex items-center text-yellow-600 mb-2">
                            <i class="fas fa-lock mr-2"></i>
                            <span class="font-medium">Members Only</span>
                        </div>
                        <p class="text-sm text-gray-600">
                            This document is restricted to FCS members. You must be logged in to access it.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show success message
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check mr-2"></i>Copied!';
            button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
            button.classList.add('bg-green-600');

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('bg-green-600');
                button.classList.add('bg-gray-600', 'hover:bg-gray-700');
            }, 2000);
        }).catch(function() {
            alert('Failed to copy link to clipboard');
        });
    }
</script>
@endsection
