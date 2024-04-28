<?php

namespace App\Http\Controllers\Api;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
