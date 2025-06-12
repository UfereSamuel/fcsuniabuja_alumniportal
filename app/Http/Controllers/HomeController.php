<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Executive;
use App\Models\BoardMember;
use App\Models\Activity;
use App\Models\Setting;
use App\Models\ClassModel;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $executives = Executive::active()->ordered()->get();
        $boardMembers = BoardMember::active()->ordered()->get();
        $recentActivities = Activity::where('is_active', true)
            ->where('activity_date', '>=', now()->subDays(30))
            ->orderBy('activity_date', 'desc')
            ->take(6)
            ->get();

        $settings = [
            'site_name' => Setting::getValue('site_name', 'FCS Alumni Portal'),
            'site_description' => Setting::getValue('site_description', 'Fellowship of Christian Students - University of Abuja Alumni Portal'),
            'welcome_message' => Setting::getValue('welcome_message', 'Welcome to the FCS University of Abuja Alumni Portal!'),
            'allow_registration' => Setting::getValue('allow_registration', true),
        ];

        $totalMembers = \App\Models\User::where('role', '!=', 'admin')->count();
        $totalClasses = ClassModel::where('is_active', true)->count();

        return view('fcs-welcome', compact('sliders', 'executives', 'boardMembers', 'recentActivities', 'settings', 'totalMembers', 'totalClasses'));
    }

    public function about()
    {
        return view('about');
    }

    public function executives()
    {
        $executives = Executive::active()->ordered()->get();
        return view('executives', compact('executives'));
    }

    public function boardMembers()
    {
        $boardMembers = BoardMember::active()->ordered()->get();
        return view('board-members', compact('boardMembers'));
    }
}
