<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:tags_read'])->only(['index']);
        $this->middleware(['permission:tags_create'])->only(['create', 'store']);
        $this->middleware(['permission:tags_update'])->only(['edit', 'update']);
        $this->middleware(['permission:tags_delete'])->only(['destroy']);
    }

    public function index(Request $request)
    {
        // Get the status and search query from the request
        $search = $request->input('search', '');   // Default is empty string
        $tags = Tag::query();
        // Apply search filter if a search term is provided
        if (!empty($search)) {
            $tags->where(function ($query) use ($search) {
                $query->whereLike('name', '%' . $search . '%');
            });
        }
        // Get the filtered tags with pagination
        $tags = $tags->latest()->paginate(12);
        // Return the view with the tags and filters
        return view('admin.pages.tags.index', compact(
            'tags'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request_data = $request->validate([
            'name' => 'required|string|max:200|unique:tags,name',
        ]);

        // Create the tag
        $tag = Tag::create([
            'name' => $request->input('name')
        ]);
        return redirect()->route('admin.tags.index')->with('success', __('created successfully'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.pages.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        // Validate the request
        $request_data = $request->validate([
            'name' => 'required|string|max:200|unique:tags,name,' . $tag->id,
        ]);

        // Update the tag
        $tag->update([
            'name' => $request->input('name')
        ]);
        return back()->with('success', __('Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        session()->flash('success', __('Deleted successfully'));
        return redirect()->back();
    }
}
