@extends('layouts.admin')

@section('title', 'Backup Management')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mr-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Backup</span>
        </div>
    </li>
@endsection

@section('page-title', 'Backup Management')
@section('page-description', 'Create, manage, and restore system backups')

@section('page-actions')
    <button onclick="createBackup()" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-md">
        <i class="fas fa-plus mr-2"></i>Create Backup
    </button>
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="text-center py-12">
            <i class="fas fa-database text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Backup Management</h3>
            <p class="text-gray-500 mb-6">Backup functionality is coming soon. This feature will allow you to create, download, and restore system backups.</p>
            <button onclick="createBackup()" class="bg-fcs-blue hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">
                <i class="fas fa-plus mr-2"></i>Create First Backup
            </button>
        </div>
    </div>
@endsection

@section('scripts')
function createBackup() {
    alert('Backup creation feature coming soon!');
}
@endsection
