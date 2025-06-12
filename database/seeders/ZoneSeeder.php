<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Zone;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            [
                'name' => 'Abuja Zone',
                'description' => 'Federal Capital Territory and surrounding areas',
                'country' => 'Nigeria',
                'state' => 'FCT',
                'city' => 'Abuja',
                'contact_person' => 'Zone Coordinator',
                'contact_email' => 'abuja.zone@fcsalumni.com',
                'is_active' => true,
            ],
            [
                'name' => 'Lagos Zone',
                'description' => 'Lagos State and surrounding areas',
                'country' => 'Nigeria',
                'state' => 'Lagos',
                'city' => 'Lagos',
                'contact_person' => 'Zone Coordinator',
                'contact_email' => 'lagos.zone@fcsalumni.com',
                'is_active' => true,
            ],
            [
                'name' => 'Port Harcourt Zone',
                'description' => 'Rivers State and South-South region',
                'country' => 'Nigeria',
                'state' => 'Rivers',
                'city' => 'Port Harcourt',
                'contact_person' => 'Zone Coordinator',
                'contact_email' => 'phc.zone@fcsalumni.com',
                'is_active' => true,
            ],
            [
                'name' => 'Kano Zone',
                'description' => 'Kano State and Northern region',
                'country' => 'Nigeria',
                'state' => 'Kano',
                'city' => 'Kano',
                'contact_person' => 'Zone Coordinator',
                'contact_email' => 'kano.zone@fcsalumni.com',
                'is_active' => true,
            ],
            [
                'name' => 'Ibadan Zone',
                'description' => 'Oyo State and South-West region',
                'country' => 'Nigeria',
                'state' => 'Oyo',
                'city' => 'Ibadan',
                'contact_person' => 'Zone Coordinator',
                'contact_email' => 'ibadan.zone@fcsalumni.com',
                'is_active' => true,
            ],
            [
                'name' => 'Enugu Zone',
                'description' => 'Enugu State and South-East region',
                'country' => 'Nigeria',
                'state' => 'Enugu',
                'city' => 'Enugu',
                'contact_person' => 'Zone Coordinator',
                'contact_email' => 'enugu.zone@fcsalumni.com',
                'is_active' => true,
            ],
            [
                'name' => 'Jos Zone',
                'description' => 'Plateau State and Middle Belt region',
                'country' => 'Nigeria',
                'state' => 'Plateau',
                'city' => 'Jos',
                'contact_person' => 'Zone Coordinator',
                'contact_email' => 'jos.zone@fcsalumni.com',
                'is_active' => true,
            ],
            [
                'name' => 'International Zone',
                'description' => 'Alumni residing outside Nigeria',
                'country' => 'Various',
                'state' => null,
                'city' => null,
                'contact_person' => 'Zone Coordinator',
                'contact_email' => 'international.zone@fcsalumni.com',
                'is_active' => true,
            ],
        ];

        foreach ($zones as $zone) {
            Zone::firstOrCreate(['name' => $zone['name']], $zone);
        }

        $this->command->info('Zones seeded successfully!');
    }
}
