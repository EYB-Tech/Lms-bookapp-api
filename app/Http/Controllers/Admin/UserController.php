<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as RulesPassword;

class UserController extends Controller
{
    public function startImpersonation(User $user)
    {
        $user = User::findOrFail($user->id);
        // Store the original admin ID in the session
        // session(['impersonated_by' => Auth::id()]);

        // Log in as the user
        Auth::guard('web')->login($user);
        session()->flash('success', __('You are now impersonating ') . $user->name);
        return redirect()->route('home');
    }

    public function changePassword(Request $request, User $user)
    {
        if ($user->type != "Admin") {
            abort(403);
        }
        $request->validate([
            'new_password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        #Update the new Password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        session()->flash('success', __('Password changed successfully!'));
        return redirect()->back();
    }

    public function updatePermissions(Request $request, User $user)
    {
        if ($user->type != "Admin") {
            abort(403);
        }
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name',
        ]);
        // $user->permissions()->sync($request->permissions);
        $user->syncPermissions($request->permissions);

        session()->flash('success', __('Updated successfully'));
        return redirect()->back();
    }

    public function destroy(User $user)
    {
        if ($user->type != "Admin") {
            abort(403);
        }
        mediaDeleteImage($user->image);
        $user->delete();
        session()->flash('success', __('Deleted successfully'));
        return redirect()->back();
    }
}
