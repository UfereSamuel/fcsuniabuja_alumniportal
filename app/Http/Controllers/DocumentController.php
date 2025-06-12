<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Display a listing of public documents.
     */
    public function index(Request $request)
    {
        $query = Document::where('is_active', true);

        // If user is not authenticated, only show public documents
        if (!Auth::check()) {
            $query->where('is_public', true);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $query->where('category', $request->category);
        }

        // Get all categories for filter dropdown
        $categories = Document::where('is_active', true)
            ->when(!Auth::check(), function($q) {
                return $q->where('is_public', true);
            })
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort();

        // Order by created_at desc and paginate
        $documents = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('documents.index', compact('documents', 'categories'));
    }

    /**
     * Display the specified document.
     */
    public function show(Document $document)
    {
        // Check if document is accessible
        if (!$document->is_active) {
            abort(404);
        }

        if (!$document->is_public && !Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this document.');
        }

        return view('documents.show', compact('document'));
    }

    /**
     * Download the specified document.
     */
    public function download(Document $document)
    {
        // Check if document is accessible
        if (!$document->is_active) {
            abort(404);
        }

        if (!$document->is_public && !Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to download this document.');
        }

        if (!$document->file_path || !Storage::disk('public')->exists($document->file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Increment download count if user is authenticated
        if (Auth::check()) {
            $document->increment('download_count');
        }

        return Storage::disk('public')->download($document->file_path, $document->original_filename);
    }
}
