@extends('layouts.admin')

@section('title', $executive->name . ' - Executive Details')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <a href="{{ route('admin.executives.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-fcs-blue">Executives</a>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">{{ $executive->name }}</span>
        </div>
    </li>
@endsection

@section('page-title', $executive->name)
@section('page-description', 'View and manage executive details, position information, and contact details.')

@section('page-actions')
    <a href="{{ route('admin.executives.edit', $executive) }}" class="bg-fcs-primary hover:bg-fcs-light-blue text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-edit mr-2"></i>Edit Executive
    </a>
    <button onclick="copyExecutiveProfile()" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-link mr-2"></i>Copy Link
    </button>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Executive Profile -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8">
                    <div class="flex items-center space-x-6">
                        <!-- Profile Photo -->
                        <div class="flex-shrink-0">
                            @if($executive->image)
                                <img src="{{ asset('storage/' . $executive->image) }}" alt="{{ $executive->name }}"
                                     class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                            @else
                                <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-white flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Profile Info -->
                        <div class="flex-1 text-white">
                            <h1 class="text-3xl font-bold mb-2">{{ $executive->name }}</h1>
                            <p class="text-xl text-blue-100 mb-3">{{ $executive->position }}</p>

                            <!-- Status Badges -->
                            <div class="flex items-center space-x-3 mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $executive->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $executive->is_active ? 'Active' : 'Inactive' }}
                                </span>

                                @if($executive->term_start)
                                    @if($executive->term_end && $executive->term_end->isPast())
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            Former Executive
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            Current Term
                                        </span>
                                    @endif
                                @endif
                            </div>

                            <!-- Contact Info -->
                            <div class="flex items-center space-x-6 text-blue-100">
                                @if($executive->email)
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope mr-2"></i>
                                        <a href="mailto:{{ $executive->email }}" class="hover:text-white transition">{{ $executive->email }}</a>
                                    </div>
                                @endif

                                @if($executive->phone)
                                    <div class="flex items-center">
                                        <i class="fas fa-phone mr-2"></i>
                                        <a href="tel:{{ $executive->phone }}" class="hover:text-white transition">{{ $executive->phone }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biography Section -->
                @if($executive->bio)
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-3">Biography</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($executive->bio)) !!}
                        </div>
                    </div>
                @endif

                <!-- Position Details -->
                @if($executive->position_description)
                    <div class="px-6 pb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-3">Position Description</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($executive->position_description)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Executive Timeline -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-history mr-2"></i>Executive Timeline
                </h3>
                <div class="space-y-4">
                    <!-- Record Created -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-blue-600 text-sm"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Executive Record Created</p>
                            <p class="text-sm text-gray-500">{{ $executive->created_at->format('M j, Y \a\t g:i A') }}</p>
                        </div>
                    </div>

                    <!-- Term Start -->
                    @if($executive->term_start)
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-play text-green-600 text-sm"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Term Started</p>
                                <p class="text-sm text-gray-500">{{ $executive->term_start->format('M j, Y') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Last Updated -->
                    @if($executive->updated_at->gt($executive->created_at))
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-edit text-yellow-600 text-sm"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Profile Last Updated</p>
                                <p class="text-sm text-gray-500">{{ $executive->updated_at->format('M j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Term End -->
                    @if($executive->term_end)
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 {{ $executive->term_end->isFuture() ? 'bg-orange-100' : 'bg-gray-100' }} rounded-full flex items-center justify-center">
                                <i class="fas fa-stop {{ $executive->term_end->isFuture() ? 'text-orange-600' : 'text-gray-600' }} text-sm"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $executive->term_end->isFuture() ? 'Term Ends' : 'Term Ended' }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $executive->term_end->format('M j, Y') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-cogs mr-2"></i>Quick Actions
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.executives.edit', $executive) }}"
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>Edit Executive
                    </a>

                    <form action="{{ route('admin.executives.toggle-status', $executive) }}" method="POST" class="w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full {{ $executive->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center">
                            <i class="fas fa-{{ $executive->is_active ? 'pause' : 'play' }} mr-2"></i>
                            {{ $executive->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    <button onclick="copyExecutiveProfile()" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center">
                        <i class="fas fa-copy mr-2"></i>Copy Profile Link
                    </button>

                    <form action="{{ route('admin.executives.destroy', $executive) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this executive record? This action cannot be undone.')" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center">
                            <i class="fas fa-trash mr-2"></i>Delete Executive
                        </button>
                    </form>
                </div>
            </div>

            <!-- Executive Details -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>Executive Information
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Executive ID</span>
                        <span class="font-mono text-gray-900">#{{ $executive->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Position</span>
                        <span class="text-gray-900 font-medium">{{ $executive->position }}</span>
                    </div>
                    @if($executive->term_year)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Term Year</span>
                            <span class="text-gray-900">{{ $executive->term_year }}</span>
                        </div>
                    @endif
                    @if($executive->order)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Display Order</span>
                            <span class="text-gray-900">{{ $executive->order }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Created</span>
                        <span class="text-gray-900">{{ $executive->created_at->format('M j, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Updated</span>
                        <span class="text-gray-900">{{ $executive->updated_at->format('M j, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status</span>
                        <span class="font-medium {{ $executive->is_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $executive->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Term Information -->
            @if($executive->term_start || $executive->term_end)
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-calendar-alt mr-2"></i>Term Information
                    </h3>
                    <div class="space-y-3 text-sm">
                        @if($executive->term_start)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Term Start</span>
                                <span class="text-gray-900">{{ $executive->term_start->format('M j, Y') }}</span>
                            </div>
                        @endif

                        @if($executive->term_end)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Term End</span>
                                <span class="text-gray-900">{{ $executive->term_end->format('M j, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration</span>
                                <span class="text-gray-900">{{ $executive->term_start->diffInMonths($executive->term_end) }} months</span>
                            </div>
                        @else
                            <div class="flex justify-between">
                                <span class="text-gray-600">Term End</span>
                                <span class="text-green-600 font-medium">Ongoing</span>
                            </div>
                            @if($executive->term_start)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Service Duration</span>
                                    <span class="text-gray-900">{{ $executive->term_start->diffForHumans() }}</span>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endif

            <!-- Social Media Links -->
            @if($executive->linkedin_url || $executive->twitter_url || $executive->facebook_url || $executive->instagram_url)
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-share-alt mr-2"></i>Social Media
                    </h3>
                    <div class="space-y-3">
                        @if($executive->linkedin_url)
                            <a href="{{ $executive->linkedin_url }}" target="_blank" class="flex items-center text-blue-600 hover:text-blue-700 transition">
                                <i class="fab fa-linkedin text-lg mr-3"></i>
                                <span>LinkedIn Profile</span>
                                <i class="fas fa-external-link-alt ml-auto text-xs"></i>
                            </a>
                        @endif

                        @if($executive->twitter_url)
                            <a href="{{ $executive->twitter_url }}" target="_blank" class="flex items-center text-blue-400 hover:text-blue-500 transition">
                                <i class="fab fa-twitter text-lg mr-3"></i>
                                <span>Twitter Profile</span>
                                <i class="fas fa-external-link-alt ml-auto text-xs"></i>
                            </a>
                        @endif

                        @if($executive->facebook_url)
                            <a href="{{ $executive->facebook_url }}" target="_blank" class="flex items-center text-blue-800 hover:text-blue-900 transition">
                                <i class="fab fa-facebook text-lg mr-3"></i>
                                <span>Facebook Profile</span>
                                <i class="fas fa-external-link-alt ml-auto text-xs"></i>
                            </a>
                        @endif

                        @if($executive->instagram_url)
                            <a href="{{ $executive->instagram_url }}" target="_blank" class="flex items-center text-pink-600 hover:text-pink-700 transition">
                                <i class="fab fa-instagram text-lg mr-3"></i>
                                <span>Instagram Profile</span>
                                <i class="fas fa-external-link-alt ml-auto text-xs"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Other Executives -->
            @if($otherExecutives->count() > 0)
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-users mr-2"></i>Other Executives
                    </h3>
                    <div class="space-y-3">
                        @foreach($otherExecutives as $otherExec)
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($otherExec->image)
                                        <img src="{{ asset('storage/' . $otherExec->image) }}" alt="{{ $otherExec->name }}"
                                             class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-400 text-xs"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('admin.executives.show', $otherExec) }}"
                                       class="text-sm font-medium text-blue-600 hover:text-blue-700 truncate">
                                        {{ $otherExec->name }}
                                    </a>
                                    <p class="text-xs text-gray-500">{{ $otherExec->position }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    function copyExecutiveProfile() {
        // Create a temporary input element
        const tempInput = document.createElement('input');
        tempInput.value = window.location.href;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        // Show feedback
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
    }
@endsection
