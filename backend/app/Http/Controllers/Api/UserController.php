<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     *  Store the new User.
     */
    public function store(StoreUserRequest $request)
    {

        if ($request->validated()) {
            // $user = new \App\Models\User();
            // $user->name = $request->name;
            // $user->email = $request->email;
            // $user->password = bcrypt($request->password);
            // $user->save();

            return response()->json([
                'message' => 'Acount created successfully',
                // 'user' => $user
            ], 201);
        }
    }

    /**
     * Login User
     */
    public function auth(AuthUserRequest $request)
    {

        if ($request->validated()) {
            $user = User::whereEmail($request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'error' => 'These credentials do not match any of our records.'
                ]);
            } else {
                return response()->json([
                    'user' => UserResource::make($user),
                    'access_token' => $user->createToken('new_user')->plainTextToken,
                    'message' => 'Logged in successfully'
                ]);
            }
        }
    }

    /**
     *  Logout User
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Update User Profile
     */
    public function updateUserProfile(Request $request)
    {

        if ($request->validate([
            'image_profile' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ])) {
        }
        if ($request->hasFile('image_profile')) {
            // check old image exestes and delete
            if (File::exists(asset($request->user()->image_profile))) {
                File::delete(asset($request->user()->image_profile));
            }
            // store new image
            $profile_image_name = time() . '.' . $file->getClientOriginalName();
            $file->storeAs('images/users', $profile_image_name, 'public');
            $request->user()->update([
                'profile_image' => 'storage/images/users/' . $profile_image_name,
            ]);
            // return the response
            return response()->json([
                'message' => 'Profile image updated successfully',
                'user' => UserResource::make($request->user())
            ]);
            // $profile_image_name = time().'.'.$request->image_profile->extension();
            // $request->image_profile->move(public_path('images'), $image_name);
            // $request->user()->image_profile = 'images/'.$image_name;
            // $request->user()->save();

        } else {
            $request->user()->update([
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'phone_number' => $request->phone_number,
                'profile_completed' => 1,
            ]);
            //return the response
            return response()->json([
                'user' => UserResource::make($request->user()),
                'message' => 'Profile updated successfully'
            ]);
        }
    }
}
