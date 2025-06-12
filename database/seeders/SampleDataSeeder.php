<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Executive;
use App\Models\BoardMember;
use App\Models\Activity;
use App\Models\User;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@fcsalumni.com')->first();

        if (!$adminUser) {
            $this->command->error('Admin user not found. Please run FCSSystemSeeder first.');
            return;
        }

        // Create Alumni Executives
        $executives = [
            [
                'name' => 'Dr. Samuel Adebayo',
                'position' => 'Alumni President',
                'bio' => 'Distinguished academic and spiritual leader with over 15 years of experience in Christian ministry and education.',
                'ministry_focus' => 'Leadership Development and Discipleship',
                'years_of_service' => 15,
                'social_links' => json_encode([
                    'linkedin' => 'https://linkedin.com/in/samuel-adebayo',
                    'facebook' => 'https://facebook.com/samuel.adebayo'
                ]),
                'email' => 'president@fcsalumni.com',
                'phone' => '+234-803-123-4567',
                'sort_order' => 1,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Mrs. Grace Okoye',
                'position' => 'Vice President',
                'bio' => 'Experienced administrator and passionate advocate for Christian education and youth development.',
                'ministry_focus' => 'Women\'s Ministry and Youth Development',
                'years_of_service' => 12,
                'social_links' => json_encode([
                    'linkedin' => 'https://linkedin.com/in/grace-okoye',
                    'twitter' => 'https://twitter.com/grace_okoye'
                ]),
                'email' => 'vp@fcsalumni.com',
                'phone' => '+234-803-234-5678',
                'sort_order' => 2,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Pastor David Uche',
                'position' => 'General Secretary',
                'bio' => 'Ordained minister and skilled administrator committed to maintaining excellence in fellowship operations.',
                'ministry_focus' => 'Church Administration and Pastoral Care',
                'years_of_service' => 10,
                'social_links' => json_encode([
                    'facebook' => 'https://facebook.com/pastor.david.uche',
                    'instagram' => 'https://instagram.com/pastor_david_uche'
                ]),
                'email' => 'secretary@fcsalumni.com',
                'phone' => '+234-803-345-6789',
                'sort_order' => 3,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Mrs. Blessing Emeka',
                'position' => 'Financial Secretary',
                'bio' => 'Certified accountant with expertise in non-profit financial management and transparency.',
                'ministry_focus' => 'Financial Stewardship and Resource Management',
                'years_of_service' => 8,
                'social_links' => json_encode([
                    'linkedin' => 'https://linkedin.com/in/blessing-emeka'
                ]),
                'email' => 'finance@fcsalumni.com',
                'phone' => '+234-803-456-7890',
                'sort_order' => 4,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Bro. James Okafor',
                'position' => 'Publicity Secretary',
                'bio' => 'Communications specialist dedicated to sharing the good news and fellowship activities.',
                'ministry_focus' => 'Media Ministry and Digital Evangelism',
                'years_of_service' => 6,
                'social_links' => json_encode([
                    'twitter' => 'https://twitter.com/james_okafor',
                    'instagram' => 'https://instagram.com/bro_james_okafor',
                    'linkedin' => 'https://linkedin.com/in/james-okafor'
                ]),
                'email' => 'publicity@fcsalumni.com',
                'phone' => '+234-803-567-8901',
                'sort_order' => 5,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Sis. Faith Akinwumi',
                'position' => 'Welfare Officer',
                'bio' => 'Social worker committed to member welfare and community development initiatives.',
                'ministry_focus' => 'Community Outreach and Social Services',
                'years_of_service' => 5,
                'social_links' => json_encode([
                    'facebook' => 'https://facebook.com/faith.akinwumi',
                    'instagram' => 'https://instagram.com/sis_faith_akinwumi'
                ]),
                'email' => 'welfare@fcsalumni.com',
                'phone' => '+234-803-678-9012',
                'sort_order' => 6,
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($executives as $executive) {
            Executive::firstOrCreate(
                ['email' => $executive['email']],
                $executive
            );
        }

        // Create National Board Members
        $boardMembers = [
            [
                'name' => 'Rev. Dr. Michael Adeyemi',
                'position' => 'National President',
                'bio' => 'Senior pastor and national coordinator of FCS activities across Nigeria.',
                'email' => 'national.president@fcs.ng',
                'region' => 'National',
                'sort_order' => 1,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Dr. Ruth Okechukwu',
                'position' => 'National Secretary',
                'bio' => 'Academic administrator and strategic planner for national fellowship coordination.',
                'email' => 'national.secretary@fcs.ng',
                'region' => 'National',
                'sort_order' => 2,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Pastor John Abubakar',
                'position' => 'Northern Region Coordinator',
                'bio' => 'Regional coordinator overseeing FCS activities in Northern Nigeria.',
                'email' => 'northern@fcs.ng',
                'region' => 'Northern Nigeria',
                'sort_order' => 3,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Mrs. Comfort Ogundimu',
                'position' => 'Western Region Coordinator',
                'bio' => 'Regional coordinator managing FCS chapters in Western Nigeria.',
                'email' => 'western@fcs.ng',
                'region' => 'Western Nigeria',
                'sort_order' => 4,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Dr. Emmanuel Onuoha',
                'position' => 'Eastern Region Coordinator',
                'bio' => 'Regional coordinator leading FCS expansion in Eastern Nigeria.',
                'email' => 'eastern@fcs.ng',
                'region' => 'Eastern Nigeria',
                'sort_order' => 5,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Pastor Sarah Babatunde',
                'position' => 'South-South Coordinator',
                'bio' => 'Regional coordinator developing FCS presence in South-South Nigeria.',
                'email' => 'southsouth@fcs.ng',
                'region' => 'South-South Nigeria',
                'sort_order' => 6,
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($boardMembers as $member) {
            BoardMember::firstOrCreate(
                ['email' => $member['email']],
                $member
            );
        }

        // Create Sample Activities
        $activities = [
            [
                'title' => 'Annual Alumni Reunion 2024',
                'description' => 'Join us for our biggest gathering of the year! Reconnect with old friends, meet new faces, and celebrate our shared faith journey. Features worship, testimonies, and fellowship meal.',
                'activity_date' => now()->addDays(30),
                'activity_time' => '10:00',
                'location' => 'University of Abuja Main Auditorium',
                'type' => 'general',
                'is_featured' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Prayer Chain Launch',
                'description' => 'Starting a 24/7 prayer chain across all our classes. Join us as we commit to covering each other and the nation in prayer.',
                'activity_date' => now()->addDays(7),
                'activity_time' => '18:00',
                'location' => 'FCS Prayer Center',
                'type' => 'announcement',
                'is_featured' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Class 2013 Trailblazers Meetup',
                'description' => 'Special gathering for the Trailblazers class. Come and fellowship with your classmates and plan upcoming class activities.',
                'activity_date' => now()->addDays(14),
                'activity_time' => '16:00',
                'location' => 'Transcorp Hilton Abuja',
                'type' => 'class_specific',
                'is_featured' => false,
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Scholarship Fund Drive',
                'description' => 'Help us raise funds to support incoming Christian students at the University of Abuja. Every contribution makes a difference in a young life.',
                'activity_date' => now()->subDays(5),
                'activity_time' => '14:00',
                'location' => 'Online Campaign',
                'type' => 'general',
                'is_featured' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Monthly Thanksgiving Service',
                'description' => 'Join us for our monthly thanksgiving service as we appreciate God for His faithfulness and celebrate testimonies from our members.',
                'activity_date' => now()->subDays(10),
                'activity_time' => '09:00',
                'location' => 'ECWA Church, Wuse 2',
                'type' => 'general',
                'is_featured' => false,
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Career Development Workshop',
                'description' => 'Professional development session featuring successful alumni sharing career insights and networking opportunities.',
                'activity_date' => now()->addDays(21),
                'activity_time' => '13:00',
                'location' => 'Sheraton Hotel Abuja',
                'type' => 'general',
                'is_featured' => true,
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::firstOrCreate(
                ['title' => $activity['title']],
                $activity
            );
        }

        $this->command->info('Sample data created successfully!');
        $this->command->info('- ' . count($executives) . ' Alumni Executives');
        $this->command->info('- ' . count($boardMembers) . ' National Board Members');
        $this->command->info('- ' . count($activities) . ' Sample Activities');
    }
}
