<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

            // check if first time login and update certain details
            if (!$user->is_activated && $user->status == "inactive") {
                $user->is_activated = true;
                $user->status = "active";
                $user->save();
            }

            // Check user role and redirect accordingly
            if ($user->role === 'superadmin') {
                return redirect()->route('Superadmin_dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }

        // Authentication failed
        return redirect()->back()->withErrors(['password' => 'Invalid credentials']);
    }

    /**
     *  Handle user logout
     */
    public function logout(Request $request)
    {
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
        $users = User::paginate(20);

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
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:standard,superadmin',
        ]);
        
        try {
            // Generate a random password
            $password = Str::random(10);
            
            // Create the user
            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'role' => $validatedData['role'],
                'password' => Hash::make($password),
                'status' => 'inactive',
                'is_activated' => false,
            ]);
            
            // Send welcome email with password
            // Mail::to($user->email)->send(new WelcomeMail($user->first_name, $user->email, $password));
            
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