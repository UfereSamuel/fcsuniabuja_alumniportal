@extends('layouts.admin')

@section('title', 'Homepage Sliders')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Homepage Sliders</span>
        </div>
    </li>
@endsection

@section('page-title', 'Homepage Sliders')
@section('page-description', 'Manage homepage slider images and content.')

@section('page-actions')
    <a href="{{ route('admin.sliders.create') }}" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-plus mr-2"></i>Add New Slider
    </a>
@endsection

@section('content')
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-images text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $sliders->total() }}</h3>
                    <p class="text-gray-600">Total Sliders</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $sliders->where('is_active', true)->count() }}</h3>
                    <p class="text-gray-600">Active Sliders</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-pause text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $sliders->where('is_active', false)->count() }}</h3>
                    <p class="text-gray-600">Inactive Sliders</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-sort text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\Slider::max('sort_order') ?? 0 }}</h3>
                    <p class="text-gray-600">Max Order</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow-sm rounded-lg mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.sliders.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Search by title or description..."
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-3">
                    <button type="submit" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.sliders.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if($sliders->count() > 0)
        <!-- Sliders Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach($sliders as $slider)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden card-hover">
                    <!-- Image -->
                    <div class="relative h-48 bg-gray-200">
                        @if($slider->image)
                            <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            @if($slider->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-pause-circle mr-1"></i>Inactive
                                </span>
                            @endif
                        </div>

                        <!-- Display Order Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Order: {{ $slider->sort_order }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $slider->title }}</h3>
                        @if($slider->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $slider->description }}</p>
                        @endif

                        @if($slider->button_text && $slider->button_url)
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-link mr-1"></i>{{ $slider->button_text }}
                                </span>
                            </div>
                        @endif

                        <!-- Meta Info -->
                        <div class="text-xs text-gray-500 mb-4">
                            <div class="flex items-center justify-between">
                                <span>Created: {{ $slider->created_at->format('M d, Y') }}</span>
                                <span>Updated: {{ $slider->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.sliders.show', $slider) }}"
                                   class="text-fcs-blue hover:text-fcs-light-blue text-sm">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <a href="{{ route('admin.sliders.edit', $slider) }}"
                                   class="text-fcs-green hover:text-green-600 text-sm">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                            </div>

                            <div class="flex space-x-2">
                                <!-- Toggle Status -->
                                <form action="{{ route('admin.sliders.toggle-status', $slider) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-yellow-600 hover:text-yellow-800 text-sm">
                                        <i class="fas fa-{{ $slider->is_active ? 'pause' : 'play' }} mr-1"></i>
                                        {{ $slider->is_active ? 'Hide' : 'Show' }}
                                    </button>
                                </form>

                                <!-- Delete -->
                                <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm"
                                            onclick="return confirm('Are you sure you want to delete this slider?')">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            {{ $sliders->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-images text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Sliders Found</h3>
            <p class="text-gray-600 mb-6">Get started by creating your first homepage slider.</p>
            <a href="{{ route('admin.sliders.create') }}"
               class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-6 py-3 rounded-lg font-semibold transition">
                <i class="fas fa-plus mr-2"></i>Create Your First Slider
            </a>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        // Auto-refresh preview when filters change
        document.querySelectorAll('select, input').forEach(element => {
            if (element.name === 'search') {
                let timeout;
                element.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        if (this.value.length >= 3 || this.value.length === 0) {
                            this.form.submit();
                        }
                    }, 500);
                });
            }
        });
    </script>
@endsection
