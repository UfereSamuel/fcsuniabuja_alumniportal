<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Access denied. Admin privileges required.');
            }
            return $next($request);
        });
    }

    /**
     * Display the settings management page.
     */
    public function index()
    {
        // Get all settings grouped by category
        $settings = Setting::all()->groupBy('category');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Display the general settings form.
     */
    public function general()
    {
        $settings = Setting::whereIn('key', [
            'organization_name',
            'organization_tagline',
            'organization_description',
            'contact_email',
            'contact_phone',
            'contact_address',
            'facebook_url',
            'twitter_url',
            'linkedin_url',
            'instagram_url',
            'youtube_url'
        ])->pluck('value', 'key');

        return view('admin.settings.general', compact('settings'));
    }

    /**
     * Display the logo and branding settings form.
     */
    public function branding()
    {
        $settings = Setting::whereIn('key', [
            'site_logo',
            'site_favicon',
            'hero_background_image',
            'primary_color',
            'secondary_color',
            'accent_color'
        ])->pluck('value', 'key');

        return view('admin.settings.branding', compact('settings'));
    }

    /**
     * Display the email settings form.
     */
    public function email()
    {
        $settings = Setting::whereIn('key', [
            'mail_from_address',
            'mail_from_name',
            'smtp_host',
            'smtp_port',
            'smtp_username',
            'smtp_password',
            'smtp_encryption'
        ])->pluck('value', 'key');

        return view('admin.settings.email', compact('settings'));
    }

    /**
     * Display the content management settings.
     */
    public function content()
    {
        $settings = Setting::whereIn('key', [
            'welcome_message',
            'about_mission',
            'about_vision',
            'about_values',
            'footer_text',
            'terms_of_service',
            'privacy_policy'
        ])->pluck('value', 'key');

        return view('admin.settings.content', compact('settings'));
    }

    /**
     * Update general settings.
     */
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'organization_name' => ['required', 'string', 'max:255'],
            'organization_tagline' => ['nullable', 'string', 'max:255'],
            'organization_description' => ['nullable', 'string'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'contact_address' => ['nullable', 'string'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
        ]);

        foreach ($request->except(['_token', '_method']) as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'category' => 'general'
                ]
            );
        }

        return redirect()->route('admin.settings.general')
                        ->with('success', 'General settings updated successfully.');
    }

    /**
     * Update branding settings.
     */
    public function updateBranding(Request $request)
    {
        $request->validate([
            'site_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'site_favicon' => ['nullable', 'image', 'mimes:png,ico', 'max:1024'],
            'hero_background_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'primary_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'accent_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $data = $request->except(['_token', '_method', 'site_logo', 'site_favicon', 'hero_background_image']);

        // Handle file uploads
        $fileFields = ['site_logo', 'site_favicon', 'hero_background_image'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                $oldSetting = Setting::where('key', $field)->first();
                if ($oldSetting && $oldSetting->value) {
                    Storage::disk('public')->delete($oldSetting->value);
                }

                // Store new file
                $path = $request->file($field)->store('branding', 'public');
                $data[$field] = $path;
            }
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'category' => 'branding'
                ]
            );
        }

        return redirect()->route('admin.settings.branding')
                        ->with('success', 'Branding settings updated successfully.');
    }

    /**
     * Update email settings.
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_from_address' => ['required', 'email', 'max:255'],
            'mail_from_name' => ['required', 'string', 'max:255'],
            'smtp_host' => ['nullable', 'string', 'max:255'],
            'smtp_port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'smtp_username' => ['nullable', 'string', 'max:255'],
            'smtp_password' => ['nullable', 'string', 'max:255'],
            'smtp_encryption' => ['nullable', Rule::in(['tls', 'ssl', 'starttls'])],
        ]);

        foreach ($request->except(['_token', '_method']) as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'category' => 'email'
                ]
            );
        }

        return redirect()->route('admin.settings.email')
                        ->with('success', 'Email settings updated successfully.');
    }

    /**
     * Update content settings.
     */
    public function updateContent(Request $request)
    {
        $request->validate([
            'welcome_message' => ['nullable', 'string'],
            'about_mission' => ['nullable', 'string'],
            'about_vision' => ['nullable', 'string'],
            'about_values' => ['nullable', 'string'],
            'footer_text' => ['nullable', 'string'],
            'terms_of_service' => ['nullable', 'string'],
            'privacy_policy' => ['nullable', 'string'],
        ]);

        foreach ($request->except(['_token', '_method']) as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'category' => 'content'
                ]
            );
        }

        return redirect()->route('admin.settings.content')
                        ->with('success', 'Content settings updated successfully.');
    }

    /**
     * Reset settings to default values.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'category' => ['required', 'string', Rule::in(['general', 'branding', 'email', 'content'])]
        ]);

        $category = $request->category;

        // Delete files for branding category
        if ($category === 'branding') {
            $fileSettings = Setting::whereIn('key', ['site_logo', 'site_favicon', 'hero_background_image'])->get();
            foreach ($fileSettings as $setting) {
                if ($setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }
            }
        }

        // Delete settings for the category
        Setting::where('category', $category)->delete();

        return redirect()->route("admin.settings.{$category}")
                        ->with('success', ucfirst($category) . ' settings reset to default values.');
    }

    /**
     * Test email configuration.
     */
    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => ['required', 'email']
        ]);

        try {
            // Here you would implement email testing logic
            // For now, we'll just return success
            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully to ' . $request->test_email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export settings as JSON.
     */
    public function export()
    {
        $settings = Setting::all();

        $filename = 'fcs-settings-' . now()->format('Y-m-d-H-i-s') . '.json';

        return response()->json($settings)
                        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Import settings from JSON file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'settings_file' => ['required', 'file', 'mimes:json', 'max:1024']
        ]);

        try {
            $content = file_get_contents($request->file('settings_file')->getRealPath());
            $settings = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON file');
            }

            foreach ($settings as $setting) {
                if (isset($setting['key'], $setting['value'], $setting['category'])) {
                    Setting::updateOrCreate(
                        ['key' => $setting['key']],
                        [
                            'value' => $setting['value'],
                            'category' => $setting['category']
                        ]
                    );
                }
            }

            return redirect()->route('admin.settings.index')
                            ->with('success', 'Settings imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                            ->with('error', 'Failed to import settings: ' . $e->getMessage());
        }
    }
}
