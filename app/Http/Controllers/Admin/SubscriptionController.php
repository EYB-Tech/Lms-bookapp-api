<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Notifications\UserNotice;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Imports\SubscriptionStudentsImport;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:subscriptions_read'])->only(['index', 'show']);
        $this->middleware(['permission:subscriptions_create'])->only(['create', 'store', 'importStudents']);
        $this->middleware(['permission:subscriptions_update'])->only(['update']);
        $this->middleware(['permission:subscriptions_delete'])->only(['destroy']);
    }

    public function index(Request $request)
    {
        $now = Carbon::now();
        $subscriptionsQuery = Subscription::query()->with(['student', 'course']);

        $subscriptionCounts = [
            'yesterday' => Subscription::whereDate('created_at', Carbon::yesterday())->count(),
            'today' => Subscription::whereDate('created_at', Carbon::today())->count(),
            'thisMonth' => Subscription::whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->count(),
        ];

        $subscriptionsQuery->when($request->input('search'), function ($query, $search) {
            $query->whereHas('course', function ($subQuery) use ($search) {
                $subQuery->where('name', 'LIKE', "%$search%");
            })->orWhereHas('student', function ($subQuery) use ($search) {
                $subQuery->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")->orWhere('username', 'LIKE', "%$search%");
            });
        });

        $subscriptions = $subscriptionsQuery->latest()->paginate(20);

        return view('admin.pages.subscriptions.index', [
            'subscriptions' => $subscriptions,
            'yesterdaySubscriptionsCount' => $subscriptionCounts['yesterday'],
            'todaySubscriptionsCount' => $subscriptionCounts['today'],
            'thisMonthSubscriptionsCount' => $subscriptionCounts['thisMonth'],
        ]);
    }

    public function create()
    {
        $students = User::where('type', 'Student')->get();
        $courses = Course::all();
        // Get students imported from the Excel file
        $importedStudents = Session::get('imported_students', []);
        Session::forget('imported_students');
        return view('admin.pages.subscriptions.create', compact(
            'students',
            'courses',
            'importedStudents',
        ));
    }

    public function store(Request $request)
    {
        $request_data = $request->validate([
            'students' => 'required|array',
            'course_id' => 'nullable|exists:courses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $course = Course::find($request->input('course_id'));
        foreach ($request->input('students') as $studentId) {
            Subscription::create([
                'student_id' => $studentId,
                'course_id' => $request->input('course_id'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ]);
        }
        Session::forget('imported_students');
        session()->flash('success', __('Added successfully'));
        return redirect()->route('admin.subscriptions.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        $student = $subscription->student;
        $course = $subscription->course;
        return view('admin.pages.subscriptions.show', compact(
            'subscription',
            'student',
            'course',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        // Validate the request
        $request_data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        // Update the subscription
        $subscription->update($request_data);
        return redirect()->back()->with('success', __('Update successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        session()->flash('success', __('Deleted successfully'));
        return redirect()->back();
    }

    public function importStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xlsm,xlsb,xltx,xls',
        ]);

        $path = $request->file('file')->getRealPath();

        try {
            // Load data from the Excel file
            $data = Excel::toArray([], $path);

            if (empty($data[0]) || !isset($data[0][0])) {
                return redirect()->back()->with('error', 'The uploaded file is empty or invalid.');
            }

            // Extract the header row
            $headerRow = array_map('strtolower', $data[0][0]); // Convert headers to lowercase for consistency

            // Check if email or username exists in the header
            if (!in_array('email', $headerRow) && !in_array('username', $headerRow)) {
                return redirect()->back()->with('error', 'The file must contain either an email or username column.');
            }

            // Determine the column index for email or username
            $emailIndex = array_search('email', $headerRow);
            $usernameIndex = array_search('username', $headerRow);

            // Extract the respective column data (skip the header row)
            $columnData = array_column(array_slice($data[0], 1), $emailIndex !== false ? $emailIndex : $usernameIndex);

            // Retrieve students from the database
            $students = User::where('type', 'student')
                ->whereIn($emailIndex !== false ? 'email' : 'username', $columnData)
                ->get()
                ->pluck('id')
                ->toArray();

            // Store the retrieved students in the session
            Session::put('imported_students', $students);

            return redirect()->back()->with('success', 'Students imported successfully!');
        } catch (\Exception $e) {
            // Log the error message for debugging
            session()->flash('error', __('An error occurred during import: ') . $e->getMessage());
            return redirect()->back();
        }
    }
}
