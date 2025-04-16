<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:courses_read'])->only(['index', 'show']);
        $this->middleware(['permission:courses_create'])->only(['create', 'store']);
        $this->middleware(['permission:courses_update'])->only(['edit', 'update']);
        $this->middleware(['permission:courses_delete'])->only(['destroy']);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        // Get the status and search query from the request
        $search = $request->input('search', '');   // Default is empty string
        $courses = Course::query();
        // Apply search filter if a search term is provided
        if (!empty($search)) {
            $courses->where(function ($query) use ($search) {
                $query->whereLike('name', '%' . $search . '%');
            });
        }
 
        // Get the filtered courses with pagination
        $courses = $courses->latest()->paginate(12);
        // Return the view with the courses and filters
        return view('admin.pages.courses.index', compact(
            'courses'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request_data = $request->validate([
            'name' => 'required|string|max:255|unique:courses,name',
        ]);

        // Create the course
        $course = Course::create([
            'name' => $request->input('name'),
        ]);
        return redirect()->route('admin.courses.index')->with('success', __('created successfully'));
    }

    public function show(Course $course)
    {
        return view('admin.pages.courses.show', compact('course'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('admin.pages.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        // Validate the request
        $request_data = $request->validate([
            'name' => 'required|string|max:255|unique:courses,name,' . $course->id,
        ]);
        // Update the course
        $course->update([
            'name' => $request->input('name'),
        ]);
        return back()->with('success', __('Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        session()->flash('success', __('Deleted successfully'));
        return redirect()->back();
    }
}
