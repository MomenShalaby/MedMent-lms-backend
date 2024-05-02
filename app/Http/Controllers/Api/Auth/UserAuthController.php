<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\State;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    use HttpResponses;

    private $relations = ['subscription', 'country', 'state', 'experiences', 'experiences.hospital', 'experiences.country', 'experiences.state', 'education', 'education.degree', 'education.university', 'tags'];

    private function doesStateBelongToCountry($stateId, $countryId): bool
    {
        $state = State::findOrFail($stateId);
        if ($state->country_id !== (int) $countryId) {
            return false;
        }

        return true;

    }

    public function register(StoreUserRequest $request): JsonResponse
    {
        $request->validated($request->all());

        if (!$this->doesStateBelongToCountry($request->state_id, $request->country_id)) {
            return $this->error("state doesn't belong to the country entered");
        }

        $user = User::create([
            'fname' => ucfirst($request->fname),
            'lname' => ucfirst($request->lname),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
        ]);
        $token = Auth::login($user);
        $user->load(['country', 'state']);
        return $this->success([
            'user' => new UserResource($user),
            'token' => $token,
        ], 'Registered successfully', 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated($request->all());
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return $this->error('Email or password is wrong', 401);
        }
        $user = Auth::user()->load($this->relations);
        return $this->success([
            'user' => new UserResource($user),
            'token' => $token,
        ], 'Logged in Successfully');
    }

    public function logout(): JsonResponse
    {
        Auth::logout();
        return $this->success('', 'logged out successfully');
    }

    public function me(): JsonResponse
    {
        return $this->success([
            'user' => new UserResource(Auth::user()),
        ]);
    }

    public function refresh(): JsonResponse
    {
        $user = Auth::user();
        $token = Auth::refresh();
        return $this->success([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60
    //     ]);
    // }
}
