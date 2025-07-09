<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    // return profile page
    public function profile()
    {

        $authenticatedUser = Auth::user();

        return view('settings.user-profile', compact('authenticatedUser'));
    }

    // return change password page
    public function changePassword()
    {

        $authenticatedUser = Auth::user();

        return view('settings.change-password', compact('authenticatedUser'));
    }

    // method to change password
    public function updatePassword(Request $request)
    {
        $request->validate([
            "current_password" => "required|max:255",
            "new_password" => 'required|min:8|confirmed|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_])\S{8,}$/',
        ]);

        // get the current authenticated user
        $authenticatedUser = Auth::user();

        if (Hash::check($request->current_password, $authenticatedUser->password)) {
            // update the password
            $authenticatedUser->password = Hash::make($request->new_password);
            $authenticatedUser->save();

            return redirect()->back()->with('success_change', 'Password successfully changed.');
        } else {
            return redirect()->back()->with('error_change', 'The current password you entered does not match your existing password.');
        }
    }


    // method to update user profile or details
    public function updateProfile(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'firstname' => 'string|max:255',
            'lastname' => 'string|max:255',
            'email' => 'email|max:255'
        ]);

        // get the authenticated user
        $user = User::find($request->user_id);

        if ($user == null) {
            return redirect()->back()->with('error_edit', 'User does not exist');
        }

        $isUpdated = $user->update([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'email' => $request->email
        ]);

        if ($isUpdated) {
            return redirect()->back()->with('success_edit', 'You have successfully updated your details.');
        } else {
            return redirect()->back()->with('error_edit', 'Failed to update your details');
        }
    }
}