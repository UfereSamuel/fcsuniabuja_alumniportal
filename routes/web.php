<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ExecutiveController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Admin\ZoneRoleController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PerformanceController;
use App\Http\Controllers\Admin\PrayerRequestController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\WhatsAppGroupController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/about/vision', [AboutController::class, 'vision'])->name('about.vision');
Route::get('/about/mission', [AboutController::class, 'mission'])->name('about.mission');
Route::get('/about/identity', [AboutController::class, 'identity'])->name('about.identity');
Route::get('/executives', [HomeController::class, 'executives'])->name('executives');
Route::get('/board-members', [HomeController::class, 'boardMembers'])->name('board-members');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Payment Routes
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/create', [PaymentController::class, 'create'])->name('create');
        Route::post('/initialize', [PaymentController::class, 'initialize'])->name('initialize');
        Route::get('/callback', [PaymentController::class, 'callback'])->name('callback');
        Route::get('/success', [PaymentController::class, 'success'])->name('success');
        Route::get('/failed', [PaymentController::class, 'failed'])->name('failed');
        Route::get('/history', [PaymentController::class, 'history'])->name('history');
        Route::get('/{payment}/receipt', [PaymentController::class, 'receipt'])->name('receipt');
        Route::get('/{payment}/download-receipt', [PaymentController::class, 'downloadReceipt'])->name('download-receipt');
    });
});

// Webhook route (no auth middleware)
Route::post('/payments/webhook', [PaymentController::class, 'webhook'])->name('payments.webhook');

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Executive Management
    Route::resource('executives', ExecutiveController::class);
    Route::patch('executives/{executive}/toggle-status', [ExecutiveController::class, 'toggleStatus'])->name('executives.toggle-status');

    // Activity Management
    Route::resource('activities', ActivityController::class);
    Route::patch('activities/{activity}/toggle-status', [ActivityController::class, 'toggleStatus'])->name('activities.toggle-status');

    // Event Management
    Route::resource('events', EventController::class);
    Route::patch('events/{event}/toggle-status', [EventController::class, 'toggleStatus'])->name('events.toggle-status');

    // Settings Management
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::post('/general', [SettingsController::class, 'updateGeneral'])->name('update-general');
        Route::get('/branding', [SettingsController::class, 'branding'])->name('branding');
        Route::post('/branding', [SettingsController::class, 'updateBranding'])->name('update-branding');
        Route::get('/email', [SettingsController::class, 'email'])->name('email');
        Route::post('/email', [SettingsController::class, 'updateEmail'])->name('update-email');
        Route::get('/content', [SettingsController::class, 'content'])->name('content');
        Route::post('/content', [SettingsController::class, 'updateContent'])->name('update-content');
        Route::post('/reset', [SettingsController::class, 'reset'])->name('reset');
        Route::post('/test-email', [SettingsController::class, 'testEmail'])->name('test-email');
        Route::get('/export', [SettingsController::class, 'export'])->name('export');
        Route::post('/import', [SettingsController::class, 'import'])->name('import');
    });

    // Slider Management
    Route::resource('sliders', SliderController::class);
    Route::patch('sliders/{slider}/toggle-status', [SliderController::class, 'toggleStatus'])->name('sliders.toggle-status');

    // Zone Management
    Route::resource('zones', ZoneController::class);
    Route::get('zones/{zone}/members', [ZoneController::class, 'members'])->name('zones.members');
    Route::post('zones/{zone}/assign-user', [ZoneController::class, 'assignUser'])->name('zones.assign-user');
    Route::delete('zones/{zone}/remove-user', [ZoneController::class, 'removeUser'])->name('zones.remove-user');

    // Zone Role Management
    Route::resource('zone-roles', ZoneRoleController::class);
    Route::patch('zone-roles/{zoneRole}/toggle-status', [ZoneRoleController::class, 'toggleStatus'])->name('zone-roles.toggle-status');

    // Payment Management
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [AdminPaymentController::class, 'index'])->name('index');
        Route::get('/analytics', [AdminPaymentController::class, 'analytics'])->name('analytics');
        Route::get('/export', [AdminPaymentController::class, 'export'])->name('export');
        Route::get('/zone-summary', [AdminPaymentController::class, 'zoneSummary'])->name('zone-summary');
        Route::get('/{payment}', [AdminPaymentController::class, 'show'])->name('show');
        Route::post('/{payment}/refund', [AdminPaymentController::class, 'refund'])->name('refund');
        Route::post('/{payment}/verify', [AdminPaymentController::class, 'verify'])->name('verify');
    });

    // Notification System
    Route::get('notifications', [AdminController::class, 'getNotifications'])->name('notifications');
    Route::post('notifications/{id}/read', [AdminController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('notifications/mark-all-read', [AdminController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::post('notifications/send-bulk', [AdminController::class, 'sendBulkNotification'])->name('notifications.send-bulk');
    Route::get('notifications/analytics', [AdminController::class, 'getNotificationAnalytics'])->name('notifications.analytics');

    // Notification Management Pages
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/manage', [AdminController::class, 'manageNotifications'])->name('manage');
        Route::get('/send', [AdminController::class, 'sendNotificationForm'])->name('send');
        Route::get('/analytics-page', [AdminController::class, 'notificationAnalyticsPage'])->name('analytics-page');
    });

    // Performance Metrics
    Route::prefix('performance')->name('performance.')->group(function () {
        Route::get('/system', [PerformanceController::class, 'systemDashboard'])->name('system');
        Route::get('/zones', [PerformanceController::class, 'zonesOverview'])->name('zones');
        Route::get('/zones/{zone}', [PerformanceController::class, 'zoneDetail'])->name('zone-detail');
        Route::get('/compare', [PerformanceController::class, 'compareZones'])->name('compare');
        Route::post('/export', [PerformanceController::class, 'exportReport'])->name('export');

        // API endpoints
        Route::get('/api/system', [PerformanceController::class, 'getSystemMetrics'])->name('api.system');
        Route::get('/api/zones', [PerformanceController::class, 'getZonesMetrics'])->name('api.zones');
        Route::get('/api/zones/{zone}', [PerformanceController::class, 'getZoneMetrics'])->name('api.zone');
        Route::get('/api/trends', [PerformanceController::class, 'getTrends'])->name('api.trends');
        Route::get('/api/summary', [PerformanceController::class, 'getSummaryCards'])->name('api.summary');
    });

    // Prayer Requests Management
    Route::resource('prayer-requests', PrayerRequestController::class);

    // Documents Management
    Route::resource('documents', DocumentController::class);
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // WhatsApp Groups Management
    Route::resource('whatsapp-groups', WhatsAppGroupController::class);

    // Reports Management
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/membership', [ReportController::class, 'membershipReport'])->name('membership');
        Route::get('/financial', [ReportController::class, 'financialReport'])->name('financial');
        Route::get('/activities', [ReportController::class, 'activitiesReport'])->name('activities');
        Route::get('/zones', [ReportController::class, 'zonesReport'])->name('zones');
        Route::post('/generate', [ReportController::class, 'generateReport'])->name('generate');
        Route::get('/export/{type}', [ReportController::class, 'exportReport'])->name('export');
    });

    // Backup Management
    Route::prefix('backup')->name('backup.')->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('index');
        Route::post('/create', [BackupController::class, 'createBackup'])->name('create');
        Route::get('/download/{filename}', [BackupController::class, 'downloadBackup'])->name('download');
        Route::delete('/delete/{filename}', [BackupController::class, 'deleteBackup'])->name('delete');
        Route::post('/restore', [BackupController::class, 'restoreBackup'])->name('restore');
    });
});

require __DIR__.'/auth.php';
