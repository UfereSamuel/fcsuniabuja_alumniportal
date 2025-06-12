@extends('layouts.app')

@section('title', 'Documents')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">FCS Documents</h1>
                <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                    Access important FCS documents, resources, and guidelines for members and the public.
                </p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="GET" action="{{ route('documents.index') }}" class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Documents</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Search by title, description, or content...">
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" id="category"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center mt-4">
                <div class="text-sm text-gray-600">
                    Showing {{ $documents->count() }} of {{ $documents->total() }} documents
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('documents.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition">
                        Clear Filters
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Documents Grid -->
        @if($documents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($documents as $document)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <!-- Document Header -->
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas {{ $document->file_type == 'pdf' ? 'fa-file-pdf text-red-600' : ($document->file_type == 'doc' || $document->file_type == 'docx' ? 'fa-file-word text-blue-600' : 'fa-file text-gray-600') }} text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                            {{ $document->category }}
                                        </span>
                                    </div>
                                </div>
                                @if(!$document->is_public)
                                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">
                                        <i class="fas fa-lock mr-1"></i>Members Only
                                    </span>
                                @else
                                    <span class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                        <i class="fas fa-globe mr-1"></i>Public
                                    </span>
                                @endif
                            </div>

                            <!-- Document Info -->
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                {{ $document->title }}
                            </h3>

                            @if($document->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ $document->description }}
                                </p>
                            @endif

                            <!-- Document Meta -->
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                <div class="flex items-center space-x-3">
                                    <span>
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $document->created_at->format('M j, Y') }}
                                    </span>
                                    @if($document->file_size)
                                        <span>
                                            <i class="fas fa-hdd mr-1"></i>
                                            {{ $document->file_size < 1024 ? $document->file_size . ' KB' : round($document->file_size / 1024, 1) . ' MB' }}
                                        </span>
                                    @endif
                                </div>
                                @if($document->download_count > 0)
                                    <span>
                                        <i class="fas fa-download mr-1"></i>
                                        {{ $document->download_count }} downloads
                                    </span>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('documents.show', $document) }}"
                                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-center transition">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </a>
                                <a href="{{ route('documents.download', $document) }}"
                                   class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-center transition">
                                    <i class="fas fa-download mr-2"></i>Download
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $documents->appends(request()->query())->links() }}
            </div>
        @else
            <!-- No Documents Found -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-file-alt text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Documents Found</h3>
                <p class="text-gray-600 max-w-md mx-auto">
                    @if(request('search') || request('category'))
                        No documents match your search criteria. Try adjusting your filters or search terms.
                    @else
                        There are currently no documents available.
                    @endif
                </p>
                @if(request('search') || request('category'))
                    <a href="{{ route('documents.index') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition">
                        View All Documents
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
