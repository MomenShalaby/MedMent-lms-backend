<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::whereNotIn('name', ['super_admin'])->latest()->get();
        return $this->success(
            $roles,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:3'],
            'permissions' => ['required', 'array']
        ]);
        $validated['guard_name'] = 'admin';
        $role = Role::create($validated);
        $role->givePermissionTo($validated['permissions']);
        return $this->success(
            [
                "role" => $role,
                "permissions" => $role->permissions,
            ],
            'Role created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return $this->success(
            [
                "role" => $role,
                "permissions" => $role->permissions, //TODO: need to edit the form of data returned
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'min:3'],
            'permissions' => ['required', 'array']
        ]);
        if ($request->permissions) {
            $role->syncPermissions($validated["permissions"]);
        }
        if ($request->name) {
            $role->update($validated);
        }
        return $this->success(
            $role,
            'Role updated successfully',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        $role->syncPermissions();
        return $this->success(
            '',
            'Role deleted successfully',
        );

    }
}
