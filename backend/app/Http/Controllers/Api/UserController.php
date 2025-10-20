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
            $user = new \App\Models\User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

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
        $user = $request->user();              // same as auth('sanctum')->user()

        if (!$user) {
            // If the route wasn't protected or token missing
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Revoke just the current token (personal access token flow)
        $user->currentAccessToken()?->delete();

        // Or, to revoke all tokens:  $user->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }


    /***
     * Update user infos
     */
    public function UpdateUserProfile(Request $request)
    {
        $request->validate([
            'profile_image' => 'image|mimes:png,jpg,jpeg,webp|max:2048'
        ]);

        if($request->has('profile_image')) {
            //check if the old image exists and remove it
            if(File::exists(public_path($request->user()->profile_image))) {
                File::delete(public_path($request->user()->profile_image));
            }
            //store the user profile image 
            $file = $request->file('profile_image');
            $profile_image_name = time().'_'.$file->getClientOriginalName();
            $file->storeAs('images/users',$profile_image_name,'public');
            //update the user profile image
            $request->user()->update([
                'profile_image' => 'storage/images/users/'.$profile_image_name
            ]);
            //return the response
            return response()->json([
                'user' => UserResource::make($request->user()),
                'message' => 'Profile image has been updated successfully'
            ]);
        }else {
            $request->user()->update([
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'phone_number' => $request->phone_number,
                'profile_completed' => 1
            ]);
            //return the response
            return response()->json([
                'user' => UserResource::make($request->user()),
                'message' => 'Profile updated successfully'
            ]);
        }
    }
}
