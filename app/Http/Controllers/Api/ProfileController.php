<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    public function updateInformation()
    {
    }

    public function updateAvatar(Request $request)
    {
        //validation
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:3000'],
        ]);
        $user = Auth::user();

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

            return response()->json([
                $image
            ]);
        }


        //image name
        // $imgext = $request->avatar->extension();
        // $img = Image::make($request->avatar)->fit(160)->encode($imgext);
        // return $img;
        // $imgName = time() . '.' . $imgext;
        // Storage::put("public/uploadedAvatars/$imgName", $img);
        // //store img name in db
        // $user = Auth::user();
        // $oldAvatar = $user->avatar;
        // $user->avatar = $imgName;
        // $user->save();
        // //delete the old avatar
        // $oldAvatar = str_replace('/storage', 'public', $oldAvatar);
        // Storage::delete($oldAvatar);
        // //store img in public folder
        // return Redirect::route('profile.edit')->with('status', 'avatar updated');
    }
}
