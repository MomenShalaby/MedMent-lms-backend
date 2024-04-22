<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $superAdminId = Admin::role('super_admin')->first(['id'])->id;
        $admins = Admin::all()->except($superAdminId);
        return $this->success(
            $admins,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'role' => ['sometimes', 'string'],
        ]);
        $admin = Admin::create($request->except('role'));
        $admin->assignRole($request->role);
        return $this->success([
            "createdAdmin" => $admin,
            "createdAdminRoles" => $admin->roles,   //TODO: duplicate data in the response
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return $this->success([
            "admin" => $admin,
            "roles" => $admin->roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => ['required_without_all:email,password,role', 'string'],
            'email' => ['required_without_all:name,password,role', 'string', 'email'],
            'password' => ['required_without_all:name,email,role', 'string'],
            'role' => ['required_without_all:name,email,password', 'string'],
        ]);
        if ($request->name || $request->email || $request->password) {
            $admin->update($request->except('role'));
        }
        if ($request->role) {
            $admin->syncRoles([$request->role]);
        }
        return $this->success([
            "admin" => $admin,
            "roles" => $admin->roles,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        $admin->syncRoles();
        return $this->success(
            '',
            'Admin deleted successfully',
        );
    }
}
