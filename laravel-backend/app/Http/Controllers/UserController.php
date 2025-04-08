<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // return User::all();
        return User::with('role')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'full_name' => 'required|unique:users,full_name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required|exists:roles,id|unique:users,role_id'
            // 'role_id' => 'required|exists:roles,id'
            
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return [
            'message' => 'User created successfully',
            'user' => $user
        ];



    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $user = User::with('role')->findOrFail($id);
        //
        return [
            'user' => $user 
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $validated = $request->validate([
            'full_name' => 'required|unique:users,full_name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required'
            // 'role_id' => 'required|exists:roles,id'
            
        ]);

        $user->update($validated);

        return [
            'message' => 'User Updated successfully',
            'user' => $user
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
 
        return [
            'message' => 'User Deleted Successfully'
        ];
    }
}
