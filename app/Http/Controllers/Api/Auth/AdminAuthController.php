<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    use HttpResponses;

    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated($request->all());
        $credentials = $request->only('email', 'password');

        $token = Auth::guard('admin')->attempt($credentials);
        if (!$token) {
            return $this->error('Credentials do not match', 401);
        }
        $user = Auth::guard('admin')->user()->load('roles')->load('permissions');
        return $this->success([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::guard('admin')->logout();
        return $this->success('', 'logged out successfully');
    }

    public function me(): JsonResponse
    {
        return $this->success([
            'user' => Auth::guard('admin')->user(),
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

