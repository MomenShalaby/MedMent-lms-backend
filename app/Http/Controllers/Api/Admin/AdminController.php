<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\CanLoadRelationships;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use HttpResponses;
    use CanLoadRelationships;
    private $relations = ['permissions'];

    public function index()
    {
        $superAdminId = Admin::role('super_admin')->first(['id'])->id;
        $query = $this->loadRelationships(Admin::query());
        $admins = $query->get()->except($superAdminId);
        return $this->success(
            $admins,
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'fname' => ['required', 'string'],
            'lname' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            // 'role' => ['sometimes', 'string', 'exists:roles,name'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name']
            // 'string|in:code,netflix,games,sports,reading'
        ]);
        $admin = Admin::create($request->except('role'));
        // $admin->assignRole($request->role);
        $admin->syncPermissions($request->permissions);

        return $this->success([
            "admin" => $admin->load('permissions'),
        ], 'Admin created successfully', 201);
    }

    public function show(Admin $admin)
    {
        return $this->success([
            "admin" => $this->loadRelationships($admin),
        ]);
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'fname' => ['required_without_all:lname,email,password,permissions', 'string'],
            'lname' => ['required_without_all:fname,email,password,permissions', 'string'],
            'email' => ['required_without_all:fname,lname,password,permissions', 'string', 'email'],
            'password' => ['required_without_all:fname,lname,email,permissions', 'string'],
            // 'role' => ['required_without_all:fname,lname,email,password', 'string', 'exists:roles,name'],
            'permissions' => ['required_without_all:fname,lname,email,password', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name']
        ]);
        if ($request->fname || $request->lname || $request->email || $request->password) {
            $admin->update($request->except('role'));
        }

        if ($request->permissions) {
            // $admin->syncRoles([$request->role]);
            $admin->syncPermissions($request->permissions);
        }
        return $this->success([
            "admin" => $admin->load('permissions'),
        ]);

    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        $admin->syncPermissions();
        return $this->success(
            '',
            'Admin deleted successfully',
        );
    }
}
