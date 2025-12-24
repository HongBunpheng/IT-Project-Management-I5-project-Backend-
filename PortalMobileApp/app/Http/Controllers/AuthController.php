<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/auth/register",
     *   tags={"Auth"},
     *   summary="Register a new user",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"user_name","email","password","role"},
     *       @OA\Property(property="user_name", type="string", example="John Doe"),
     *       @OA\Property(property="email", type="string", example="john@mail.com"),
     *       @OA\Property(property="password", type="string", example="123456"),
     *       @OA\Property(property="gender", type="string", example="male"),
     *       @OA\Property(property="phone_number", type="string", example="012345678"),
     *       @OA\Property(property="role", type="string", example="student")
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="User registered successfully"
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Validation error"
     *   )
     * )
     */

    public function register(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'gender' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'role' => 'required|string'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    /**
     * @OA\Post(
     *   path="/api/auth/login",
     *   tags={"Auth"},
     *   summary="User login",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"email","phone_number","password"},
     *       @OA\Property(property="email", type="string", example="john@mail.com"),
     *       @OA\Property(property="phone_number", type="string", example="012345678"),
     *       @OA\Property(property="password", type="string", example="123456")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Login success"
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Invalid credentials"
     *   )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'phone_number' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials']
            ]);
        }

        $token = $user->createToken('mobile_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'token' => $token,
            'user' => $user
        ]);
    }

    /**
     * @OA\Post(
     *   path="/api/auth/logout",
     *   tags={"Auth"},
     *   summary="Logout current user",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="Logged out successfully"
     *   )
     * )
     */

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * @OA\Get(
     *   path="/api/auth/me",
     *   tags={"Auth"},
     *   summary="Get authenticated user",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="Authenticated user data"
     *   )
     * )
     */

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
