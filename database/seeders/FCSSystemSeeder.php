<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FCSSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create system settings
        $settings = [
            // Registration settings
            [
                'key' => 'allow_registration',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'registration',
                'label' => 'Allow Self Registration',
                'description' => 'Allow users to register themselves',
                'is_public' => false,
            ],
            [
                'key' => 'require_email_verification',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'registration',
                'label' => 'Require Email Verification',
                'description' => 'Require users to verify their email before accessing the system',
                'is_public' => false,
            ],

            // WhatsApp settings
            [
                'key' => 'general_whatsapp_link',
                'value' => 'https://chat.whatsapp.com/your-general-group-link',
                'type' => 'text',
                'group' => 'whatsapp',
                'label' => 'General WhatsApp Group',
                'description' => 'WhatsApp group link for all members',
                'is_public' => true,
            ],

            // General settings
            [
                'key' => 'site_name',
                'value' => 'FCS Alumni Portal',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Name',
                'description' => 'Name of the portal',
                'is_public' => true,
            ],
            [
                'key' => 'site_description',
                'value' => 'Fellowship of Christian Students - University of Abuja Alumni Portal',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Description',
                'description' => 'Description of the portal',
                'is_public' => true,
            ],
            [
                'key' => 'welcome_message',
                'value' => 'Welcome to the FCS University of Abuja Alumni Portal! Stay connected with your fellow alumni and keep up with the latest activities.',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Welcome Message',
                'description' => 'Welcome message for new members',
                'is_public' => true,
            ],

            // Email settings
            [
                'key' => 'admin_email',
                'value' => 'admin@fcsalumni.com',
                'type' => 'text',
                'group' => 'email',
                'label' => 'Admin Email',
                'description' => 'Main admin email address',
                'is_public' => false,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Create sample classes
        $classes = [
            [
                'graduation_year' => 2010,
                'slogan' => 'Pioneers',
                'description' => 'The founding class of FCS University of Abuja',
                'is_active' => true,
            ],
            [
                'graduation_year' => 2013,
                'slogan' => 'Trailblazers',
                'description' => 'Setting the path for others to follow',
                'is_active' => true,
            ],
            [
                'graduation_year' => 2015,
                'slogan' => 'Excellence',
                'description' => 'Striving for excellence in all things',
                'is_active' => true,
            ],
            [
                'graduation_year' => 2018,
                'slogan' => 'Achievers',
                'description' => 'Achieving greatness through faith',
                'is_active' => true,
            ],
            [
                'graduation_year' => 2020,
                'slogan' => 'Resilient',
                'description' => 'Overcoming challenges with faith',
                'is_active' => true,
            ],
            [
                'graduation_year' => 2021,
                'slogan' => 'Faith Warriors',
                'description' => 'Fighting the good fight of faith',
                'is_active' => true,
            ],
            [
                'graduation_year' => 2022,
                'slogan' => 'Overcomers',
                'description' => 'More than conquerors through Christ',
                'is_active' => true,
            ],
            [
                'graduation_year' => 2023,
                'slogan' => 'Champions',
                'description' => 'Champions of faith and excellence',
                'is_active' => true,
            ],
        ];

        foreach ($classes as $class) {
            ClassModel::firstOrCreate(
                ['graduation_year' => $class['graduation_year']],
                $class
            );
        }

        // Create admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@fcsalumni.com'],
            [
                'name' => 'FCS Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '+234-XXX-XXX-XXXX',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('FCS System seeded successfully!');
        $this->command->info('Admin Login: admin@fcsalumni.com | Password: password123');
    }
}
