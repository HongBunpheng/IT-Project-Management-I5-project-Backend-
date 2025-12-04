<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET FULL PROFILE
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    // UPDATE PROFILE + AVATAR COMBINED
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'user_name'     => 'nullable|string|max:50',
            'email'         => 'nullable|email|unique:users,email,' . $user->id,
            'phone_number'  => 'nullable|string|max:15',
            'avatar'        => 'nullable|image|max:2048'
        ]);

        // Update basic fields
        if (isset($validated['user_name'])) {
            $user->user_name = $validated['user_name'];
        }
        if (isset($validated['email'])) {
            $user->email = $validated['email'];
        }
        if (isset($validated['phone_number'])) {
            $user->phone_number = $validated['phone_number'];
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('avatars', $filename, 'public');

            $user->profile_picture = 'avatars/' . $filename;
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user,
            'avatar_url' => $user->profile_picture ? asset('storage/' . $user->profile_picture) : null
        ]);
    }

    // CHANGE PASSWORD
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6'
        ]);

        $user = $request->user();

        if (!Hash::check($validated['old_password'], $user->password)) {
            return response()->json([
                'message' => 'Old password incorrect'
            ], 400);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return response()->json([
            'message' => 'Password updated'
        ]);
    }

}
