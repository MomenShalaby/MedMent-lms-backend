<?php

namespace App\Http\Controllers\Api\Profiles;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class AdminProfileController extends Controller
{
    use HttpResponses;
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);
        Auth::guard('admin')->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return $this->success('', 'Password updated successfully');
    }

    public function updateAvatar(Request $request)
    {
        //validation
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:3000'],
        ]);
        $user = Auth::guard('admin')->user();

        if ($request->hasFile('avatar')) {
            //save image in storage
            $imgExt = $request->avatar->extension();
            $imgName = "$user->id-" . uniqid() . ".$imgExt";
            // $imgName = $user->id . '-' . uniqid() . '.' . $imgExt;
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->avatar);
            $image = $image->resizeDown(400, 400)->encode();
            Storage::put("public/avatars/$imgName", $image);

            //save img name in db
            $oldAvatar = $user->avatar;
            $user->avatar = $imgName;
            $user->save();

            //delete the old avatar
            $oldAvatar = str_replace('/storage', 'public', $oldAvatar);
            Storage::delete($oldAvatar);

            return $this->success('', 'Profile Picture updated successfully');
        }
    }

    public function deleteAvatar(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $avatar = $user->avatar;
        if ($avatar === '/admin.png') {
            return $this->error("default avatar can't be deleted", 409);
        }
        $avatar = str_replace('/storage', 'public', $avatar);
        Storage::delete($avatar);

        $user->avatar = null;
        $user->save();

        return $this->success(
            '',
            'Avatar deleted successfully',
        );
    }
}
