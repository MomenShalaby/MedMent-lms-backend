<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\CanLoadRelationships;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use HttpResponses;
    use CanLoadRelationships;
    private $relations = ['permissions'];

    public function index()
    {
        $query = $this->loadRelationships(Role::query());
        $roles = $query->whereNotIn('name', ['super_admin'])->latest()->get();
        return $this->success([
            'roles' => $roles,
        ]);
    }

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
                "role" => $role->load('permissions'),
            ],
            'Role created successfully',
            201
        );
    }

    public function show(Role $role)
    {
        return $this->success([
            "role" => $this->loadRelationships($role),
        ]);
    }

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
            [
                "role" => $role->load('permissions'),
            ],
            'Role updated successfully',
        );
    }

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
