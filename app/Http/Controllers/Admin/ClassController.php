<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClassController extends Controller
{
    /**
     * Display a listing of the classes.
     */
    public function index()
    {
        $classes = ClassModel::withCount(['members', 'activities'])
                    ->orderByDesc('graduation_year')
                    ->paginate(15);

        $stats = [
            'total_classes' => ClassModel::count(),
            'active_classes' => ClassModel::active()->count(),
            'total_members' => User::whereNotNull('class_id')->count(),
            'unassigned_members' => User::whereNull('class_id')->count(),
        ];

        return view('admin.classes.index', compact('classes', 'stats'));
    }

    /**
     * Show the form for creating a new class.
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:classes',
            'graduation_year' => 'required|integer|min:1950|max:' . (date('Y') + 10),
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        ClassModel::create($request->all());

        return redirect()->route('admin.classes.index')
                        ->with('success', 'Class created successfully.');
    }

    /**
     * Display the specified class.
     */
    public function show(ClassModel $class)
    {
        $class->load(['members', 'activities', 'whatsappGroups']);

        $statistics = [
            'members_count' => $class->members()->count(),
            'activities_count' => $class->activities()->count(),
            'whatsapp_groups_count' => $class->whatsappGroups()->count(),
            'total_payments' => $class->members()->whereHas('payments', function($q) {
                $q->where('status', 'successful');
            })->withSum('payments', 'amount')->get()->sum('payments_sum_amount'),
        ];

        return view('admin.classes.show', compact('class', 'statistics'));
    }

    /**
     * Show the form for editing the specified class.
     */
    public function edit(ClassModel $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    /**
     * Update the specified class in storage.
     */
    public function update(Request $request, ClassModel $class)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:classes,name,' . $class->id,
            'graduation_year' => 'required|integer|min:1950|max:' . (date('Y') + 10),
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $class->update($request->all());

        return redirect()->route('admin.classes.index')
                        ->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified class from storage.
     */
    public function destroy(ClassModel $class)
    {
        // Check if class has members
        if ($class->members()->count() > 0) {
            throw ValidationException::withMessages([
                'class' => 'Cannot delete class with active members. Please reassign members first.'
            ]);
        }

        $class->delete();

        return redirect()->route('admin.classes.index')
                        ->with('success', 'Class deleted successfully.');
    }

    /**
     * Get class members
     */
    public function members(ClassModel $class)
    {
        $members = $class->members()
                       ->with(['zone', 'zoneRole'])
                       ->orderBy('name')
                       ->paginate(20);

        return view('admin.classes.members', compact('class', 'members'));
    }

    /**
     * Toggle class status
     */
    public function toggleStatus(ClassModel $class)
    {
        $class->update(['is_active' => !$class->is_active]);

        return redirect()->back()
                        ->with('success', 'Class status updated successfully.');
    }
}
