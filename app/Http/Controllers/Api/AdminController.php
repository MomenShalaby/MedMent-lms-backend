<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\CanLoadRelationships;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use HttpResponses;
    use CanLoadRelationships;
    private $relations = ['roles'];

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
            'role' => ['sometimes', 'string', 'exists:roles,name'],
        ]);
        $admin = Admin::create($request->except('role'));
        $admin->assignRole($request->role);

        return $this->success([
            "admin" => $admin->load('roles'),
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
            'fname' => ['required_without_all:lname,email,password,role', 'string'],
            'lname' => ['required_without_all:fname,email,password,role', 'string'],
            'email' => ['required_without_all:fname,lname,password,role', 'string', 'email'],
            'password' => ['required_without_all:fname,lname,email,role', 'string'],
            'role' => ['required_without_all:fname,lname,email,password', 'string', 'exists:roles,name'],
        ]);
        if ($request->fname || $request->lname || $request->email || $request->password) {
            $admin->update($request->except('role'));
        }
        if ($request->role) {
            $admin->syncRoles([$request->role]);
        }
        return $this->success([
            "admin" => $admin->load('roles'),
        ]);

    }

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
