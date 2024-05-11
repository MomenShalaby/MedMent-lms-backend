<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\CanLoadRelationships;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use HttpResponses;
    use CanLoadRelationships;
    private $relations = ['subscription', 'country', 'state', 'experiences', 'education'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = $this->loadRelationships(User::query());
        $users = UserResource::collection($query->latest()->paginate());
        return $this->success([
            'users' => $users,
            // UserResource::collection($users)
        ]);
    }
}
