<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard', ['user' => $user]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id, 
        ]);
    
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
    
        // Return the updated user data as JSON
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        // Check if the authenticated user is trying to delete their own account
        if (Auth::id() === $user->id) {
            // Log out the user
            Auth::logout();
            
            // Return the deleted user ID and logged out status as JSON
            return response()->json(['id' => $id, 'loggedOut' => true]);
        }
    
        // Return the deleted user ID as JSON
        return response()->json(['id' => $id, 'loggedOut' => false]);
    }

    public function store(Request $request){
        // Validate
        $this->validate($request, [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        // Store
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Sign in user
        Auth::attempt($request->only('email', 'password'));

        // Return a JSON response
        return response()->json(['redirect' => route('dashboard')]);
    }
}
