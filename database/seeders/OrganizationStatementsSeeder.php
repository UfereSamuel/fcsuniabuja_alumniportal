<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class OrganizationStatementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statements = [
            [
                'key' => 'vision_statement',
                'value' => 'Wholistically transformed, Christ-centered and resourceful pupils, students, other youth and families co-existing in a peaceful society.',
                'label' => 'Vision Statement',
                'description' => 'FCS Organization Vision Statement',
                'type' => 'textarea',
                'group' => 'organization',
                'is_public' => true
            ],
            [
                'key' => 'mission_statement',
                'value' => 'To evangelise, disciple, and provide leadership training, livelihood and psychosocial support to pupils, students, other youth and families for wholistic transformation, sustainable response to global trends and peaceful co-existence.',
                'label' => 'Mission Statement',
                'description' => 'FCS Organization Mission Statement',
                'type' => 'textarea',
                'group' => 'organization',
                'is_public' => true
            ],
            [
                'key' => 'identity_statement',
                'value' => 'FCS is an interdenominational Christian organisation reaching out to children, young people and families in schools, churches and communities for wholistic transformation of lives.',
                'label' => 'Identity Statement',
                'description' => 'FCS Organization Identity Statement',
                'type' => 'textarea',
                'group' => 'organization',
                'is_public' => true
            ],
            [
                'key' => 'organization_history',
                'value' => 'The Fellowship of Christian Students (FCS) was established with a vision to impact lives through Christ-centered education and community development. Starting from humble beginnings on university campuses, FCS has grown into a comprehensive organization serving pupils, students, and families across educational institutions and communities.',
                'label' => 'Organization History',
                'description' => 'Brief history of FCS organization',
                'type' => 'textarea',
                'group' => 'organization',
                'is_public' => true
            ],
            [
                'key' => 'core_values',
                'value' => 'Faith-based Excellence, Integrity, Compassion, Community Service, Leadership Development, Wholistic Transformation, Peaceful Co-existence, Global Impact',
                'label' => 'Core Values',
                'description' => 'Core values that guide FCS organization',
                'type' => 'textarea',
                'group' => 'organization',
                'is_public' => true
            ]
        ];

        foreach ($statements as $statement) {
            Setting::updateOrCreate(
                ['key' => $statement['key']],
                $statement
            );
        }
    }
}
