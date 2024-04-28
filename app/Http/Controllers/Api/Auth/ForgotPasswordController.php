<?php

namespace App\Http\Controllers\Api\auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use HttpResponses;
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $input = $request->only('email');
        $user = User::where('email', $input)->first();
        $user->notify(new ResetPasswordNotification());
        $success['succees'] = true;
        return $this->success([], 'an otp is sent to your email address');
    }
}
