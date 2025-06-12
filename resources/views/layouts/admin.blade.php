<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - FCS Alumni Portal</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'fcs-blue': '#1e40af',
                        'fcs-red': '#dc2626',
                        'fcs-green': '#059669',
                        'fcs-light-blue': '#3b82f6',
                        'fcs-primary': '#1e40af',
                        'fcs-secondary': '#dc2626',
                        'fcs-gold': '#f59e0b',
                        'fcs-purple': '#7c3aed',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .fcs-primary { background: #1e40af; }
        .fcs-secondary { background: #dc2626; }
        .fcs-gold { background: #f59e0b; }
        .fcs-green { background: #059669; }
        .fcs-purple { background: #7c3aed; }

        .text-fcs-primary { color: #1e40af; }
        .text-fcs-secondary { color: #dc2626; }
        .text-fcs-gold { color: #f59e0b; }
        .text-fcs-green { color: #059669; }
        .text-fcs-purple { color: #7c3aed; }

        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.3);
        }
        .sidebar-link {
            transition: all 0.2s ease;
        }
        .sidebar-link:hover {
            background-color: #f3f4f6;
            transform: translateX(4px);
        }
        .sidebar-link.active {
            background-color: #dbeafe;
            color: #1e40af;
            border-right: 3px solid #1e40af;
        }
        @yield('styles')
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Navigation -->
    @include('layouts.partials.admin-nav')

    <div class="pt-16 flex">
        <!-- Sidebar -->
        @include('layouts.partials.admin-sidebar')

        <!-- Main Content Area -->
        <main class="flex-1 ml-64 p-6">
            <!-- Breadcrumb Navigation -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-fcs-blue">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    @yield('breadcrumb')
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="mb-6 flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">@yield('page-title')</h1>
                    <p class="text-gray-600 mt-2">@yield('page-description')</p>
                </div>
                <div class="flex space-x-3">
                    @yield('page-actions')
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button onclick="this.parentElement.remove()" class="ml-auto">
                        <i class="fas fa-times text-green-500 hover:text-green-700"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                    <button onclick="this.parentElement.remove()" class="ml-auto">
                        <i class="fas fa-times text-red-500 hover:text-red-700"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Please correct the following errors:</strong>
                    </div>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-fcs-blue"></div>
                <span class="text-gray-700">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Global admin functions
        function showLoading() {
            document.getElementById('loading-overlay').classList.remove('hidden');
        }

        function hideLoading() {
            document.getElementById('loading-overlay').classList.add('hidden');
        }

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
                alerts.forEach(alert => {
                    if (alert.querySelector('button')) return; // Skip if has close button
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });

        @yield('scripts')
    </script>
</body>
</html>
