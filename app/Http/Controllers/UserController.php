<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
 

    public function edit($id)
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
}
