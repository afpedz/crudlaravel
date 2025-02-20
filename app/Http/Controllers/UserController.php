<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
    
        // Return the deleted user ID as JSON
        return response()->json(['id' => $id]);
    }
}
