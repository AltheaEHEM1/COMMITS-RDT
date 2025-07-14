<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Activitylog\Facades\Activity;

class UserController extends Controller
{
    /**
     *  Display login form
     */
    public function showLogin()
    {
        return view('authentication.login');
    }


    /**
     *  Handle user login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user(); // Get authenticated user

            if (strtolower($user->status) == 'deactivated') {
                // User account is deactivated and cannot log in
                Auth::logout(); // Log out the user
                return back()->with('error', 'Your account has been deactivated. Please contact support.');
            }

            // Check if the user is suspended
            if (strtolower($user->status) == 'suspended') {
                Auth::logout(); // Log out the user
                return back()->with('error', 'Your account is suspended. Please contact support.');
            }

            // check if first time login and update certain details
            if (!$user->is_activated && $user->status == "inactive") {
                $user->is_activated = true;
                $user->status = "active";
                $user->save();
            }

            // Log successful login activity
            Activity::causedBy($user)
                ->log('logged in successfully');

            // Check user role and redirect accordingly
            if ($user->role === 'superadmin') {
                return redirect()->route('Superadmin_dashboard');
            } else {
                // For standard users, redirect to the dashboard
                return redirect()->route('dashboard');
            }
        }

        // Authentication failed - log failed login attempt
        $failedUser = User::where('email', $request->email)->first();
        if ($failedUser) {
            Activity::causedBy($failedUser)
                ->log('failed login attempt');
        }

        // Authentication failed
        return back()->with('error', 'Invalid credentials');
    }

    /**
     *  Handle user logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Log logout activity before logging out
        if ($user) {
            Activity::causedBy($user)
                ->log('logged out');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // redirect to login page
        return redirect()->route('login');
    }

    /**
     *  Return User management page
     */
    public function getUsers()
    {
        $users = User::paginate(10);

        return view('SuperAdmin.users.index', compact('users'));
    }

    /**
     *  Store new user
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role' => 'required|string|in:standard,superadmin',
        ]);

        try {
            $email = $validatedData['email'];

            // first check if there is an active user with this email
            $activeUser = User::where('email', $email)->whereNull('deleted_at')->first();

            if ($activeUser) {
                // Email is in use by active user
                return response()->json([
                    'success' => false,
                    'message' => 'Email already exists!',
                    'user' => $activeUser
                ]);
            }

            // next check if there is a soft-deleted user with this email
            $trashedUser = User::onlyTrashed()->where('email', $email)->first();

            $password = Str::random(10);

            if ($trashedUser) {
                // restore + update the trashed user
                $trashedUser->restore();
                $trashedUser->update([
                    'first_name' => $validatedData['first_name'],
                    'last_name' => $validatedData['last_name'],
                    'role' => $validatedData['role'],
                    'email' => $validatedData['email'],
                    'status' => 'inactive',
                    'is_activated' => false,
                    'password' => Hash::make($password),
                ]);
                $user = $trashedUser;
            } else {
                // create new user
                $user = User::create([
                    'first_name' => $validatedData['first_name'],
                    'last_name' => $validatedData['last_name'],
                    'email' => $validatedData['email'],
                    'role' => $validatedData['role'],
                    'status' => 'inactive',
                    'is_activated' => false,
                    'password' => Hash::make($password),
                ]);
            }

            // send the welcome email
            Mail::to($user->email)->send(new WelcomeMail($user->first_name, $user->email, $password));

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User created successfully!',
                    'user' => $user
                ]);
            }

            return redirect()->route('users.get')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating user: ' . $e->getMessage()
                ]);
            }

            return redirect()->back()->with('error', 'Error creating user: ' . $e->getMessage())->withInput();
        }
    }


    /**
     *  Update user info
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:users,id',
            'status' => 'required|string|in:active,inactive,suspended,deactivated',
        ]);

        try {
            $user = User::findOrFail($validatedData['id']);
            $user->status = $validatedData['status'];
            $user->save();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User updated successfully!',
                    'user' => $user
                ]);
            }

            return redirect()->route('users.get')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating user: ' . $e->getMessage()
                ]);
            }

            return redirect()->back()->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }

    /**
     *  Delete an account
     */
    public function delete(Request $request)
    {
        $request->validate([
            'delete_user_id' => 'required|exists:users,id',
        ]);

        $userToDelete = User::find($request->delete_user_id);

        if ($userToDelete) {

            $userToDelete->update([
                'status' => 'deactivated',
            ]);

            $userToDelete->delete();

            return redirect()->back()->with('success', 'User deleted successfully');
        }
        return redirect()->back()->with('error', 'Failed to delete user');
    }
}
