<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use HttpResponses;

    private $otp;
    public function __construct()
    {
        $this->otp = new Otp();
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        $otp2 = $this->otp->validate($request->email, $request->otp);
        if (!$otp2->status) {
            return response()->json(['error' => $otp2], 401);

        }
        $user = User::where('email', $request->email)->first();
        // return $user;
        $user->update(
            [
                'password' => Hash::make($request->password)
            ]
        );
        // Auth::invalidate();  
        // $user->tokens()->delete();
        $success['succees'] = true;
        return $this->success([], 'Passwords updated successfully');
    }
}
