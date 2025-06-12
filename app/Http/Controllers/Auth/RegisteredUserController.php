<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Zone;
use App\Models\ZoneRole;
use App\Models\Setting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Check if registration is allowed
        $allowRegistration = Setting::getValue('allow_registration', true);

        if (!$allowRegistration) {
            abort(403, 'Registration is currently disabled. Please contact the administrator.');
        }

        $classes = ClassModel::where('is_active', true)
            ->orderBy('graduation_year', 'desc')
            ->get();

        $zones = Zone::active()
            ->orderBy('name')
            ->get();

        return view('auth.register', compact('classes', 'zones'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if registration is allowed
        $allowRegistration = Setting::getValue('allow_registration', true);

        if (!$allowRegistration) {
            abort(403, 'Registration is currently disabled. Please contact the administrator.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female'],
            'class_id' => ['required', 'exists:classes,id'],
            'zone_id' => ['required', 'exists:zones,id'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'terms' => ['required', 'accepted'],
        ]);

        // Get the default member role
        $memberRole = ZoneRole::where('name', 'Member')->where('is_active', true)->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'class_id' => $request->class_id,
            'zone_id' => $request->zone_id,
            'zone_role_id' => $memberRole ? $memberRole->id : null,
            'zone_joined_at' => now(),
            'occupation' => $request->occupation,
            'location' => $request->location,
            'bio' => $request->bio,
            'role' => 'member',
            'is_active' => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
