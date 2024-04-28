<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    use HttpResponses;

    public function register(StoreUserRequest $request): JsonResponse
    {
        $request->validated($request->all());
        // return $request;
        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'subscription_id' => $request->subscription_id,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
        ]);
        // $user->assignRole('user');

        $token = Auth::login($user);
        return $this->success([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated($request->all());
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return $this->error('', 'Credentials do not match', 401);
        }
        $user = Auth::user();
        return $this->success([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
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

    public function refresh()
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
