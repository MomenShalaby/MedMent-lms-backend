<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\ContactUsNotification;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    use HttpResponses;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $admin = Admin::role('super_admin')->first();
        // return $admin;
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:20'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'min:3'],
            'message' => ['required', 'string', 'min:10'],
        ]);

        $admin->notify(new ContactUsNotification($data));
        return $this->success('', 'Email sent successfully');
    }
}
