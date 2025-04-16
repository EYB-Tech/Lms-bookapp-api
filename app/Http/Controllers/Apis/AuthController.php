<?php

namespace App\Http\Controllers\Apis;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Classes\ApiResponseClass as ResponseClass;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login",
     *     description="Login user and return an access token",
     *     tags={"Dashboard Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"email", "password"},
     *                 @OA\Property(property="email", type="string", format="email", example="admin@app.com"),
     *                 @OA\Property(property="password", type="string", format="password", example="12345678")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="string", example="user_data"),
     *             @OA\Property(property="access_token", type="string", example="your_token_here"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'email' => 'required|string|max:255',
                'password' => 'required'
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        // Determine if login is by email or username
        $fieldType = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $loginCredentials = [
            $fieldType => $credentials['email'],
            'password' => $credentials['password'],
        ];

        if (!$token = auth('api')->attempt($loginCredentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth('api')->user();

        // Allow only students to log in
        if ($user->type !== 'Student') {
            auth('api')->logout();
            return response()->json(['error' => 'Only students are allowed'], 403);
        }

        // Get the Device-ID from the request header
        $deviceId = $request->header('Device-ID');

        if (!$deviceId) {
            return response()->json(['error' => 'Device-ID is required'], 400);
        }

        // 🔥 Prevent multiple users from sharing the same Device-ID
        $deviceUsedByAnotherUser = Device::where('device_token', $deviceId)
            ->where('user_id', '!=', $user->id)
            ->exists();

        if ($deviceUsedByAnotherUser) {
            return response()->json(['error' => 'This Device-ID is already registered under another account.'], 403);
        }

        // Check if the device is already registered for the current user
        $existingDevice = $user->devices()->where('device_token', $deviceId)->exists();

        if (!$existingDevice) {
            // Limit the number of allowed devices
            $deviceCount = $user->devices()->count();
            $maxDevicesAllowed = 1; // Modify as needed

            if ($deviceCount >= $maxDevicesAllowed) {
                return response()->json(['error' => 'Device limit exceeded. Please log out from another device to continue.'], 403);
            }

            // Register the new device
            $user->devices()->create([
                'device_name' => $request->header('User-Agent'),
                'device_token' => $deviceId,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $this->respondWithToken($token);
    }




    /**
     * @OA\Get(
     *     path="/api/me",
     *     summary="Get authenticated user",
     *     description="Fetch the authenticated user's details",
     *     tags={"Dashboard Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated user",
     *         @OA\JsonContent(
     *             ref="#"
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     * security={{ "bearerAuth": {} }}
     * )
     */
    public function me()
    {
        return ResponseClass::sendResponse(auth('api')->user(), '', 200);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout",
     *     description="Logout the authenticated user",
     *     tags={"Dashboard Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function logout(Request $request)
    {
        // $user = auth('api')->user();
        // $deviceToken = $request->header('Device-Token');

        // // Remove the device from the user's device list
        // DB::table('user_devices')
        //     ->where('user_id', $user->id)
        //     ->where('device_token', $deviceToken)
        //     ->delete();

        // Log the user out
        auth('api')->logout();
        return ResponseClass::sendResponse([], 'Successfully logged out', 200);
    }

    // Refresh token
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    // Helper method to format token response
    protected function respondWithToken($token)
    {
        return response()->json([
            'user' => auth('api')->user(),
            'access_token' => $token,
            'device_id' => auth('api')->user()->devices()->first()->device_token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
