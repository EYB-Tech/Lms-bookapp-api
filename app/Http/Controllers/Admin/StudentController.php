<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:students_read'])->only(['index', 'show']);
        $this->middleware(['permission:students_create'])->only(['create', 'store', 'import']);
        $this->middleware(['permission:students_update'])->only(['edit', 'update']);
        $this->middleware(['permission:students_delete'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        // Get the status and search query from the request
        $search = $request->input('search', '');   // Default is empty string
        $students = User::query();
        // Apply filter based on status
        $students->where('type', 'Student');
        // Apply search filter if a search term is provided
        if (!empty($search)) {
            $students->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        $total_available_students = (clone $students)->whereNotNull('email_verified_at')->count();
        $total_not_available_students = (clone $students)->whereNull('email_verified_at')->count();
        // Get the filtered students with pagination
        $students = $students->latest()->paginate(20);
        return view('admin.pages.students.index', compact('students', 'total_available_students', 'total_not_available_students'));
    }

    public function store(Request $request)
    {
        $request_data = $request->validate([
            'phone' => 'nullable|numeric|digits:11|unique:users,phone',
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'image' => 'nullable|image|mimetypes:image/*|max:100240',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($request->hasFile('image')) {
            $request_data['image'] = mediaUploadImage('users', $request->file('image'));
        }
        $request_data['type'] = 'Student';
        $request_data['email_verified_at'] = now();
        $request_data['password'] = Hash::make($request->password);
        $student = User::create($request_data);
        session()->flash('success', __('Added successfully'));
        return redirect()->route('admin.students.index');
    }

    public function create()
    {
        return view('admin.pages.students.create');
    }

    public function show(User $student)
    {
        $subscriptions = $student->subscriptions()
            ->with(['course'])->latest('created_at')->paginate(30, ['*'], 'subscriptions_page');

        $courses = Course::whereHas('subscriptions', function ($query) use ($student) {
            $query->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>', now())->where('student_id', $student->id);
        })->latest('created_at')->get();
        $devices = $student->devices()->get();
        return view('admin.pages.students.show', compact('student', 'courses', 'subscriptions', 'devices'));
    }

    public function edit(User $student)
    {
        if ($student->type != "Student") {
            abort(403);
        }
        return view('admin.pages.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        if ($student->type != "Student") {
            abort(403);
        }
        $request_data = $request->validate([
            'phone' => 'nullable|numeric|digits:11|unique:users,phone,' . $student->id,
            'username' => 'required|unique:users,username,' . $student->id,
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users,email,' . $student->id,
            'image' => 'nullable|image|mimetypes:image/*|max:100240',
        ]);
        if ($request->hasFile('image')) {
            $request_data['image'] = mediaUploadImage('users', $request->file('image'));
        }
        $student->update($request_data);
        session()->flash('success', __('Updated successfully'));
        return redirect()->back();
    }

    public function destroy(User $user)
    {
        if ($user->type != "Student") {
            abort(403);
        }
        mediaDeleteImage($user->image);
        $user->delete();
        session()->flash('success', __('Deleted successfully'));
        return redirect()->back();
    }

    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx,xlsx,xlsm,xlsb,xltx',
        ]);

        // Store the uploaded file temporarily
        $filePath = $request->file('file')->store('temp');

        try {
            // Import the file using the StudentsImport class
            Excel::import(new StudentsImport, storage_path('app/' . $filePath));

            // Delete the temporary file after successful import
            Storage::delete($filePath);

            session()->flash('success', __('Students imported successfully'));
            return redirect()->back();
        } catch (Exception $e) {
            // Handle any exceptions that occur during import
            Storage::delete($filePath); // Ensure file cleanup on error

            // Log the error message for debugging
            session()->flash('error', __('An error occurred during import: ') . $e->getMessage());
            return redirect()->back();
        }
    }
    public function exportExample()
    {
        return Excel::download(new StudentsExport(), 'students.xlsx');
    }
}
