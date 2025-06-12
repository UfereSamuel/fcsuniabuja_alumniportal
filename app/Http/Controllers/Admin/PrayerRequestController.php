<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrayerRequest;

class PrayerRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of prayer requests.
     */
    public function index(Request $request)
    {
        $query = PrayerRequest::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('prayer_request', 'like', "%{$search}%")
                  ->orWhere('requester_name', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Order by created_at desc
        $prayerRequests = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.prayer-requests.index', compact('prayerRequests'));
    }

    /**
     * Show the form for creating a new prayer request.
     */
    public function create()
    {
        return view('admin.prayer-requests.create');
    }

    /**
     * Store a newly created prayer request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prayer_request' => 'required|string',
            'requester_name' => 'required|string|max:255',
            'requester_email' => 'nullable|email|max:255',
            'is_anonymous' => 'boolean',
            'is_urgent' => 'boolean',
        ]);

        PrayerRequest::create([
            'prayer_request' => $request->prayer_request,
            'requester_name' => $request->requester_name,
            'requester_email' => $request->requester_email,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'is_urgent' => $request->boolean('is_urgent'),
            'status' => 'pending',
        ]);

        return redirect()->route('admin.prayer-requests.index')
                         ->with('success', 'Prayer request created successfully.');
    }

    /**
     * Display the specified prayer request.
     */
    public function show(PrayerRequest $prayerRequest)
    {
        return view('admin.prayer-requests.show', compact('prayerRequest'));
    }

    /**
     * Update the specified prayer request status.
     */
    public function update(Request $request, PrayerRequest $prayerRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,denied',
        ]);

        $prayerRequest->update(['status' => $request->status]);

        return redirect()->route('admin.prayer-requests.index')
                         ->with('success', 'Prayer request status updated successfully.');
    }

    /**
     * Remove the specified prayer request.
     */
    public function destroy(PrayerRequest $prayerRequest)
    {
        $prayerRequest->delete();

        return redirect()->route('admin.prayer-requests.index')
                         ->with('success', 'Prayer request deleted successfully.');
    }
}
