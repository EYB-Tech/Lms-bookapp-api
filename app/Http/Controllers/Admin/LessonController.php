<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:lessons_read'])->only(['show']);
        $this->middleware(['permission:lessons_create'])->only(['create', 'store']);
        $this->middleware(['permission:lessons_update'])->only(['edit', 'update']);
        $this->middleware(['permission:lessons_delete'])->only(['destroy']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        $tags = Tag::all();
        return view('admin.pages.lessons.create', compact('course','tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        // Validate the request
        $request_data = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'type' => 'required|in:file',
            'tags' => 'required|array',
            'tags.*' => 'required|exists:tags,id',
            'attached_id' => 'nullable|exists:uploads,id',
        ]);

        // Create the lesson
        $lesson = Lesson::create([
            'course_id' => $course->id,
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'order' => $request->input('order', 1),
            'attached_id' => $request->input('attached_id'),
            'active' => $request->has('active'),
        ]);
        $lesson->tags()->attach($request->input('tags'));
        return redirect()->route('admin.courses.show', $course->id)->with('success', __('created successfully'));
    }

    public function show(Lesson $lesson)
    {
        return view('admin.pages.lessons.show', compact('lesson'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        $tags = Tag::all();
        return view('admin.pages.lessons.edit', compact('lesson','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        // Validate the request
        $request_data = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'type' => 'required|in:file',
            'tags' => 'required|array',
            'tags.*' => 'required|exists:tags,id',
            'attached_id' => 'nullable|exists:uploads,id',
        ]);

        // Update the lesson
        $lesson->update([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'order' => $request->input('order', 1),
            'attached_id' => $request->input('attached_id'),
            'active' => $request->has('active'),
        ]);
        $lesson->tags()->sync($request->input('tags'));
        return back()->with('success', __('Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        session()->flash('success', __('Deleted successfully'));
        return redirect()->back();
    }

    public function content(Request $request)
    {
        $lesson = Lesson::find($request->query('lesson'));
        return response()->json([
            'content_view' => view('admin.pages.lessons.partials.form.' . $request->type, compact('lesson'))->render(),
            "message" => __('Viewed content successfully'),
        ]);
    }
}
