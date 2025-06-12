<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Executive;
use App\Models\BoardMember;

class AboutController extends Controller
{
    /**
     * Display the about/vision page with organizational statements
     */
    public function index()
    {
        $organizationData = [
            'vision_statement' => Setting::getValue('vision_statement', ''),
            'mission_statement' => Setting::getValue('mission_statement', ''),
            'identity_statement' => Setting::getValue('identity_statement', ''),
            'organization_history' => Setting::getValue('organization_history', ''),
            'core_values' => Setting::getValue('core_values', ''),
        ];

        // Get leadership data for about page
        $executives = Executive::active()->ordered()->take(6)->get();
        $boardMembers = BoardMember::active()->ordered()->take(6)->get();

        return view('about', compact('organizationData', 'executives', 'boardMembers'));
    }

    /**
     * Display vision statement only
     */
    public function vision()
    {
        $visionStatement = Setting::getValue('vision_statement', '');
        return view('about.vision', compact('visionStatement'));
    }

    /**
     * Display mission statement only
     */
    public function mission()
    {
        $missionStatement = Setting::getValue('mission_statement', '');
        return view('about.mission', compact('missionStatement'));
    }

    /**
     * Display organization identity
     */
    public function identity()
    {
        $identityStatement = Setting::getValue('identity_statement', '');
        return view('about.identity', compact('identityStatement'));
    }
}
