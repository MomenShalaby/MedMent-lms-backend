<?php

namespace App\Http\Controllers\Api\Profiles;

use App\Enums\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    use HttpResponses;
    private $relations = ['subscription', 'country', 'state', 'experiences', 'experiences.hospital', 'experiences.country', 'experiences.state', 'education', 'education.degree', 'education.university', 'tags'];

    public function index()
    {
        $user = Auth::user()->load($this->relations);
        return $this->success([
            'user' => new UserResource($user),
            // 'token' => $token,
        ]);
    }
    public function updateInformation(Request $request)
    {
        $validated = $request->validate([
            'fname' => ['required_without_all:lname,email,gender,country_id,state_id', 'string', 'max:30'],
            'lname' => ['required_without_all:fname,email,gender,country_id,state_id', 'string', 'max:30'],
            'email' => ['required_without_all:fname,lname,gender,country_id,state_id', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($request->user()->id)],
            'gender' => ['required_without_all:fname,lname,email,country_id,state_id', Rule::enum(Gender::class)],
            'country_id' => ['required_without_all:fname,lname,email,gender,state_id', 'exists:countries,id'],
            'state_id' => ['required_without_all:fname,lname,email,gender,country_id', 'exists:states,id'],
        ]);
        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return $this->success('', 'Profile updated successfully');

    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
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

            return $this->success('', 'Profile Picture updated successfully');
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        return $this->success('', 'Account deleted successfully');
    }

    public function deleteAvatar(Request $request)
    {
        $user = Auth::user();
        $avatar = $user->avatar;
        if ($avatar === '/fdoctor.png' || $avatar === '/doctor.png') {
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
