<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Role::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
 
        $validated = $request->validate([
            'role_name' => 'required',
            'description' => 'required',
        ]);

        $role = Role::create($validated);

        return response()->json([
            'message' => 'Role Created Successfully',
            'role' => $role
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
        return [
            'role' => $role 
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //

        $validated = $request->validate([
            'role_name' => 'required',
            'description' => 'required',
        ]);

        $role->update($validated);

        return [
            'message' => 'Role Updated Successfully',
            'role' => $role
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
        $role->delete();

        return [
            'message' => 'Role Deleted Successfully'
        ];
    }
}
