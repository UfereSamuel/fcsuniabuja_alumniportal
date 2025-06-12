<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Executive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ExecutiveController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isAdmin()) {
                abort(403, 'Access denied. Admin privileges required.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the executives.
     */
    public function index(Request $request)
    {
        $query = Executive::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // Filter by position
        if ($request->has('position') && $request->position) {
            $query->where('position', $request->position);
        }

        $executives = $query->ordered()->paginate(15);

        return view('admin.executives.index', compact('executives'));
    }

    /**
     * Show the form for creating a new executive.
     */
    public function create()
    {
        return view('admin.executives.create');
    }

    /**
     * Store a newly created executive in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:100'],
            'bio' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        $executiveData = $request->all();
        $executiveData['created_by'] = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('executives', 'public');
            $executiveData['image'] = $path;
        }

        Executive::create($executiveData);

        return redirect()->route('admin.executives.index')
                        ->with('success', 'Executive added successfully.');
    }

    /**
     * Display the specified executive.
     */
    public function show(Executive $executive)
    {
        // Get other executives (excluding the current one)
        $otherExecutives = Executive::where('id', '!=', $executive->id)
                                  ->active()
                                  ->ordered()
                                  ->take(5)
                                  ->get();

        return view('admin.executives.show', compact('executive', 'otherExecutives'));
    }

    /**
     * Show the form for editing the specified executive.
     */
    public function edit(Executive $executive)
    {
        return view('admin.executives.edit', compact('executive'));
    }

    /**
     * Update the specified executive in storage.
     */
    public function update(Request $request, Executive $executive)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:100'],
            'bio' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        $executiveData = $request->except(['image']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($executive->image) {
                Storage::disk('public')->delete($executive->image);
            }
            $path = $request->file('image')->store('executives', 'public');
            $executiveData['image'] = $path;
        }

        $executive->update($executiveData);

        return redirect()->route('admin.executives.index')
                        ->with('success', 'Executive updated successfully.');
    }

    /**
     * Remove the specified executive from storage.
     */
    public function destroy(Executive $executive)
    {
        // Delete image if exists
        if ($executive->image) {
            Storage::disk('public')->delete($executive->image);
        }

        $executive->delete();

        return redirect()->route('admin.executives.index')
                        ->with('success', 'Executive removed successfully.');
    }

    /**
     * Toggle executive status (active/inactive).
     */
    public function toggleStatus(Executive $executive)
    {
        $executive->update(['is_active' => !$executive->is_active]);

        $status = $executive->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.executives.index')
                        ->with('success', "Executive {$status} successfully.");
    }
}
