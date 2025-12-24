<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/users/me",
     *   tags={"Users"},
     *   summary="Get authenticated user profile",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="User profile data"
     *   )
     * )
     */

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * @OA\Post(
     *   path="/api/users/me",
     *   tags={"Users"},
     *   summary="Update user profile and avatar",
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(property="user_name", type="string", example="Jane Doe"),
     *         @OA\Property(property="email", type="string", example="jane@mail.com"),
     *         @OA\Property(property="phone_number", type="string", example="098765432"),
     *         @OA\Property(
     *           property="avatar",
     *           type="string",
     *           format="binary",
     *           description="Avatar image file"
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Profile updated successfully"
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Validation error"
     *   )
     * )
     */

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

    /**
     * @OA\Put(
     *   path="/api/users/me/password",
     *   tags={"Users"},
     *   summary="Change user password",
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"old_password","new_password"},
     *       @OA\Property(property="old_password", type="string", example="old123456"),
     *       @OA\Property(property="new_password", type="string", example="new123456")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Password updated"
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Old password incorrect"
     *   )
     * )
     */

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
