<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:staffs_read'])->only(['index','show']);
        $this->middleware(['permission:staffs_create'])->only(['create', 'store']);
        $this->middleware(['permission:staffs_update'])->only(['edit', 'update']);
        $this->middleware(['permission:staffs_delete'])->only(['destroy']);
    }

    public function index(Request $request)
    {
        // Get the status and search query from the request
        $search = $request->input('search', '');   // Default is empty string
        $staffs = User::query();
        // Apply filter based on status
        $staffs->where('type', 'Admin')->whereHasRole('staff');
        // Apply search filter if a search term is provided
        if (!empty($search)) {
            $staffs->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }
        // Get the filtered staffs with pagination
        $staffs = $staffs->latest()->paginate(12);
        return view('admin.pages.staffs.index', compact('staffs'));
    }

    public function store(Request $request)
    {
        $request_data = $request->validate([
            // 'phone' => 'required|numeric|digits:11|unique:admins,phone',
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'image' => 'nullable|image|mimetypes:image/*|max:100240',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($request->hasFile('image')) {
            $request_data['image'] = mediaUploadImage('admins', $request->file('image'));
        }
        $request_data['type'] = 'Admin';
        $request_data['password'] = Hash::make($request->password);
        $user = User::create($request_data);
        $user->addRole('staff');
        session()->flash('success', __('Added successfully'));
        return redirect()->route('admin.staffs.index');
    }

    public function create()
    {
        return view('admin.pages.staffs.create');
    }

    public function edit(User $user)
    {
        if ($user->type != "Admin" || $user->roles[0]->name != 'staff') {
            abort(403);
        }
        $permissions = Permission::all();
        return view('admin.pages.staffs.edit', compact('user', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->type != "Admin") {
            abort(403);
        }
        $request_data = $request->validate([
            // 'phone' => 'nullable|numeric|digits:11|unique:admins,phone,' . $user->id,
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimetypes:image/*|max:100240',
        ]);
        if ($request->hasFile('image')) {
            $request_data['image'] = mediaUploadImage('admins', $request->file('image'));
        }
        $user->update($request_data);
        session()->flash('success', __('Updated successfully'));
        return redirect()->back();
    }
}
