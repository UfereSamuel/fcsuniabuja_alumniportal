<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Welcome to FCS Alumni',
                'description' => 'Connecting generations of believers, strengthening faith, and impacting lives for Christ across the globe',
                'image' => 'images/sliders/slider1.jpg',
                'button_text' => 'Join Our Community',
                'button_url' => '/register',
                'sort_order' => 1,
                'created_by' => 1
            ],
            [
                'title' => 'Fellowship in Action',
                'description' => 'Building lasting relationships and creating opportunities for ministry and spiritual growth worldwide',
                'image' => 'images/sliders/slider2.jpg',
                'button_text' => 'Explore Activities',
                'button_url' => '#activities',
                'sort_order' => 2,
                'created_by' => 1
            ],
            [
                'title' => 'United in Christ',
                'description' => 'From campus fellowship halls to a global network of professionals, ministers, and leaders advancing God\'s kingdom',
                'image' => 'images/sliders/slider3.jpg',
                'button_text' => 'Learn More',
                'button_url' => '#about',
                'sort_order' => 3,
                'created_by' => 1
            ]
        ];

        foreach ($sliders as $sliderData) {
            Slider::create($sliderData);
        }
    }
}
