<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ZoneRole;

class ZoneRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            // National Executive Roles
            [
                'name' => 'National President',
                'description' => 'Overall leader of the alumni association',
                'permissions' => [
                    'create_events', 'edit_events', 'delete_events',
                    'manage_zone_members', 'view_zone_payments', 'manage_zone_settings',
                    'create_national_events', 'manage_all_zones', 'manage_system_settings',
                    'view_all_payments', 'manage_users', 'manage_roles'
                ],
                'is_national' => true,
                'is_zonal' => false,
                'is_active' => true,
                'priority' => 100,
            ],
            [
                'name' => 'National Vice President',
                'description' => 'Deputy to the National President',
                'permissions' => [
                    'create_events', 'edit_events', 'delete_events',
                    'manage_zone_members', 'view_zone_payments',
                    'create_national_events', 'manage_all_zones',
                    'view_all_payments', 'manage_users'
                ],
                'is_national' => true,
                'is_zonal' => false,
                'is_active' => true,
                'priority' => 90,
            ],
            [
                'name' => 'National Secretary',
                'description' => 'National Secretary of the alumni association',
                'permissions' => [
                    'create_events', 'edit_events',
                    'view_zone_payments', 'create_national_events',
                    'view_all_payments'
                ],
                'is_national' => true,
                'is_zonal' => false,
                'is_active' => true,
                'priority' => 80,
            ],
            [
                'name' => 'National Treasurer',
                'description' => 'National Treasurer of the alumni association',
                'permissions' => [
                    'view_zone_payments', 'view_all_payments', 'manage_zone_settings'
                ],
                'is_national' => true,
                'is_zonal' => false,
                'is_active' => true,
                'priority' => 80,
            ],

            // Zonal Roles
            [
                'name' => 'Coordinator',
                'description' => 'Zone Coordinator - leads the zone',
                'permissions' => [
                    'create_events', 'edit_events', 'delete_events',
                    'manage_zone_members', 'view_zone_payments', 'manage_zone_settings'
                ],
                'is_national' => false,
                'is_zonal' => true,
                'is_active' => true,
                'priority' => 70,
            ],
            [
                'name' => 'Deputy Coordinator',
                'description' => 'Deputy Zone Coordinator',
                'permissions' => [
                    'create_events', 'edit_events',
                    'manage_zone_members', 'view_zone_payments'
                ],
                'is_national' => false,
                'is_zonal' => true,
                'is_active' => true,
                'priority' => 60,
            ],
            [
                'name' => 'Secretary',
                'description' => 'Zone Secretary',
                'permissions' => [
                    'create_events', 'edit_events'
                ],
                'is_national' => false,
                'is_zonal' => true,
                'is_active' => true,
                'priority' => 50,
            ],
            [
                'name' => 'Treasurer',
                'description' => 'Zone Treasurer',
                'permissions' => [
                    'view_zone_payments'
                ],
                'is_national' => false,
                'is_zonal' => true,
                'is_active' => true,
                'priority' => 50,
            ],

            // Other Role
            [
                'name' => 'Member',
                'description' => 'Regular zone member',
                'permissions' => [],
                'is_national' => false,
                'is_zonal' => true,
                'is_active' => true,
                'priority' => 10,
            ],
        ];

        foreach ($roles as $role) {
            ZoneRole::firstOrCreate(['name' => $role['name']], $role);
        }

        $this->command->info('Zone roles seeded successfully!');
    }
}
