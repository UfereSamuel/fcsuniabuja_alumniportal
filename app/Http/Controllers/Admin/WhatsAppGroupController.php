<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WhatsAppGroup;
use App\Models\Zone;
use App\Models\ClassModel;

class WhatsAppGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of WhatsApp groups.
     */
    public function index(Request $request)
    {
        $query = WhatsAppGroup::with(['creator', 'zone', 'class']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->has('type') && $request->type !== '') {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // Order by created_at desc
        $groups = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.whatsapp-groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new WhatsApp group.
     */
    public function create()
    {
        $zones = Zone::active()->get();
        $classes = ClassModel::all();
        return view('admin.whatsapp-groups.create', compact('zones', 'classes'));
    }

    /**
     * Store a newly created WhatsApp group.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'invite_link' => 'required|string',
            'type' => 'required|in:general,zone,class,executive,special',
            'zone_id' => 'nullable|exists:zones,id',
            'class_id' => 'nullable|exists:classes,id',
            'member_count' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'rules' => 'nullable|string',
        ]);

        WhatsAppGroup::create([
            'name' => $request->name,
            'description' => $request->description,
            'invite_link' => $request->invite_link,
            'type' => $request->type,
            'zone_id' => $request->zone_id,
            'class_id' => $request->class_id,
            'member_count' => $request->member_count ?? 0,
            'is_active' => $request->boolean('is_active', true),
            'is_public' => $request->boolean('is_public', true),
            'rules' => $request->rules,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.whatsapp-groups.index')
                         ->with('success', 'WhatsApp group created successfully.');
    }

    /**
     * Display the specified WhatsApp group.
     */
    public function show(WhatsAppGroup $whatsappGroup)
    {
        $whatsappGroup->load(['creator', 'zone', 'class']);
        return view('admin.whatsapp-groups.show', compact('whatsappGroup'));
    }

    /**
     * Show the form for editing the specified WhatsApp group.
     */
    public function edit(WhatsAppGroup $whatsappGroup)
    {
        $zones = Zone::active()->get();
        $classes = ClassModel::all();
        return view('admin.whatsapp-groups.edit', compact('whatsappGroup', 'zones', 'classes'));
    }

    /**
     * Update the specified WhatsApp group.
     */
    public function update(Request $request, WhatsAppGroup $whatsappGroup)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'invite_link' => 'required|string',
            'type' => 'required|in:general,zone,class,executive,special',
            'zone_id' => 'nullable|exists:zones,id',
            'class_id' => 'nullable|exists:classes,id',
            'member_count' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'rules' => 'nullable|string',
        ]);

        $whatsappGroup->update([
            'name' => $request->name,
            'description' => $request->description,
            'invite_link' => $request->invite_link,
            'type' => $request->type,
            'zone_id' => $request->zone_id,
            'class_id' => $request->class_id,
            'member_count' => $request->member_count ?? $whatsappGroup->member_count,
            'is_active' => $request->boolean('is_active'),
            'is_public' => $request->boolean('is_public'),
            'rules' => $request->rules,
        ]);

        return redirect()->route('admin.whatsapp-groups.index')
                         ->with('success', 'WhatsApp group updated successfully.');
    }

    /**
     * Remove the specified WhatsApp group.
     */
    public function destroy(WhatsAppGroup $whatsappGroup)
    {
        $whatsappGroup->delete();

        return redirect()->route('admin.whatsapp-groups.index')
                         ->with('success', 'WhatsApp group deleted successfully.');
    }
}
