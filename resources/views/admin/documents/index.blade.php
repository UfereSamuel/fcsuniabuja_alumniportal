@extends('layouts.admin')

@section('title', 'Documents')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Documents</span>
        </div>
    </li>
@endsection

@section('page-title', 'Documents Management')
@section('page-description', 'Manage FCS alumni documents, reports, and resource files')

@section('page-actions')
    <a href="{{ route('admin.documents.create') }}" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-upload mr-2"></i>Upload Document
    </a>
@endsection

@section('content')
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $documents->total() }}</h3>
                    <p class="text-gray-600">Total Documents</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\Document::where('is_public', true)->count() }}</h3>
                    <p class="text-gray-600">Public</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-lock text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\Document::where('is_public', false)->count() }}</h3>
                    <p class="text-gray-600">Private</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-folder text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\Document::distinct('category')->count('category') }}</h3>
                    <p class="text-gray-600">Categories</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('admin.documents.index') }}" class="space-y-4 lg:space-y-0 lg:flex lg:items-end lg:space-x-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue"
                       placeholder="Search documents by title, description, or category...">
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" id="category" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                    <option value="">All Categories</option>
                    <option value="reports" {{ request('category') === 'reports' ? 'selected' : '' }}>Reports</option>
                    <option value="policies" {{ request('category') === 'policies' ? 'selected' : '' }}>Policies</option>
                    <option value="meeting-minutes" {{ request('category') === 'meeting-minutes' ? 'selected' : '' }}>Meeting Minutes</option>
                    <option value="financial" {{ request('category') === 'financial' ? 'selected' : '' }}>Financial</option>
                    <option value="constitution" {{ request('category') === 'constitution' ? 'selected' : '' }}>Constitution</option>
                    <option value="forms" {{ request('category') === 'forms' ? 'selected' : '' }}>Forms</option>
                    <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.documents.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md font-medium transition">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Documents List -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Documents ({{ $documents->total() }})</h3>
        </div>

        @if($documents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($documents as $document)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <!-- Document Icon and Type -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center
                                    {{ $document->file_type === 'pdf' ? 'bg-red-100' :
                                       (in_array($document->file_type, ['doc', 'docx']) ? 'bg-blue-100' :
                                       (in_array($document->file_type, ['xls', 'xlsx']) ? 'bg-green-100' : 'bg-gray-100')) }}">
                                    <i class="fas
                                        {{ $document->file_type === 'pdf' ? 'fa-file-pdf text-red-600' :
                                           (in_array($document->file_type, ['doc', 'docx']) ? 'fa-file-word text-blue-600' :
                                           (in_array($document->file_type, ['xls', 'xlsx']) ? 'fa-file-excel text-green-600' : 'fa-file text-gray-600')) }}"></i>
                                </div>
                                <div class="ml-3">
                                    <span class="text-xs font-medium text-gray-500 uppercase">{{ $document->file_type }}</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                @if($document->is_public)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-eye mr-1"></i>Public
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-lock mr-1"></i>Private
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Document Info -->
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $document->title }}</h4>

                        @if($document->description)
                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($document->description, 100) }}</p>
                        @endif

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-folder mr-2 w-4"></i>
                                <span>{{ ucwords(str_replace('-', ' ', $document->category)) }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-file mr-2 w-4"></i>
                                <span>{{ number_format($document->file_size / 1024, 1) }} KB</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-calendar mr-2 w-4"></i>
                                <span>{{ $document->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.documents.download', $document) }}"
                                   class="text-fcs-blue hover:text-blue-700 text-sm font-medium">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                                <a href="{{ route('admin.documents.show', $document) }}"
                                   class="text-gray-600 hover:text-gray-700 text-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>

                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.documents.edit', $document) }}"
                                   class="text-yellow-600 hover:text-yellow-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.documents.destroy', $document) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700"
                                            onclick="return confirm('Are you sure you want to delete this document?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $documents->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-file-alt text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Documents Found</h3>
                <p class="text-gray-500 mb-6">No documents match your current filters.</p>
                @if(request()->anyFilled(['search', 'category', 'status']))
                    <a href="{{ route('admin.documents.index') }}" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">
                        <i class="fas fa-times mr-2"></i>Clear Filters
                    </a>
                @else
                    <a href="{{ route('admin.documents.create') }}" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">
                        <i class="fas fa-upload mr-2"></i>Upload First Document
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection

@section('scripts')
// Auto-refresh preview when filters change
document.querySelectorAll('select').forEach(element => {
    element.addEventListener('change', function() {
        this.form.submit();
    });
});

// Search debouncing
const searchInput = document.getElementById('search');
if (searchInput) {
    let timeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            if (this.value.length >= 3 || this.value.length === 0) {
                this.form.submit();
            }
        }, 500);
    });
}
@endsection
