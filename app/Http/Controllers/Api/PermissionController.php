<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $permissions = Permission::all();
        return $this->success(
            $permissions,
        );

    }
}
