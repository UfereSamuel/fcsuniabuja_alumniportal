@extends('layouts.admin')

@section('title', 'Prayer Requests')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Prayer Requests</span>
        </div>
    </li>
@endsection

@section('page-title', 'Prayer Requests Management')
@section('page-description', 'Manage and respond to prayer requests from FCS alumni community members')

@section('page-actions')
    <a href="{{ route('admin.prayer-requests.create') }}" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-plus mr-2"></i>Add Prayer Request
    </a>
@endsection

@section('content')
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-praying-hands text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $prayerRequests->total() }}</h3>
                    <p class="text-gray-600">Total Requests</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\PrayerRequest::where('status', 'pending')->count() }}</h3>
                    <p class="text-gray-600">Pending</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\PrayerRequest::where('status', 'approved')->count() }}</h3>
                    <p class="text-gray-600">Approved</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ \App\Models\PrayerRequest::where('is_urgent', true)->count() }}</h3>
                    <p class="text-gray-600">Urgent</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('admin.prayer-requests.index') }}" class="space-y-4 lg:space-y-0 lg:flex lg:items-end lg:space-x-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue"
                       placeholder="Search prayer requests or requester names...">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fcs-blue">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="denied" {{ request('status') === 'denied' ? 'selected' : '' }}>Denied</option>
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.prayer-requests.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md font-medium transition">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Prayer Requests List -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Prayer Requests ({{ $prayerRequests->total() }})</h3>
        </div>

        @if($prayerRequests->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requester</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($prayerRequests as $prayerRequest)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-400"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $prayerRequest->is_anonymous ? 'Anonymous' : $prayerRequest->requester_name }}
                                                @if($prayerRequest->is_urgent)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">
                                                        Urgent
                                                    </span>
                                                @endif
                                            </div>
                                            @if(!$prayerRequest->is_anonymous && $prayerRequest->requester_email)
                                                <div class="text-sm text-gray-500">{{ $prayerRequest->requester_email }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ Str::limit($prayerRequest->prayer_request, 100) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $prayerRequest->status === 'approved' ? 'bg-green-100 text-green-800' :
                                           ($prayerRequest->status === 'denied' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($prayerRequest->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $prayerRequest->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.prayer-requests.show', $prayerRequest) }}"
                                           class="text-fcs-blue hover:text-blue-700">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($prayerRequest->status === 'pending')
                                            <form method="POST" action="{{ route('admin.prayer-requests.update', $prayerRequest) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="text-green-600 hover:text-green-700"
                                                        onclick="return confirm('Approve this prayer request?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.prayer-requests.update', $prayerRequest) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="denied">
                                                <button type="submit" class="text-red-600 hover:text-red-700"
                                                        onclick="return confirm('Deny this prayer request?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.prayer-requests.destroy', $prayerRequest) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700"
                                                    onclick="return confirm('Are you sure you want to delete this prayer request?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $prayerRequests->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-praying-hands text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Prayer Requests Found</h3>
                <p class="text-gray-500 mb-6">No prayer requests match your current filters.</p>
                @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('admin.prayer-requests.index') }}" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">
                        <i class="fas fa-times mr-2"></i>Clear Filters
                    </a>
                @else
                    <a href="{{ route('admin.prayer-requests.create') }}" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">
                        <i class="fas fa-plus mr-2"></i>Add First Prayer Request
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
