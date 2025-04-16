<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Device;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user();

        if ($user) {
            $deviceId = $request->header('Device-ID');

            if (!$deviceId) {
                return response()->json(['error' => 'Device-ID is required'], 400);
            }

            // Check if the device is associated with another user
            $deviceUsedByAnotherUser = Device::where('device_token', $deviceId)
                ->where('user_id', '!=', $user->id)
                ->exists();

            if ($deviceUsedByAnotherUser) {
                return response()->json(['error' => 'This Device-ID is already registered under another account.'], 403);
            }

            // Check if the current device exists for the authenticated user
            $existingDevice = $user->devices()->where('device_token', $deviceId)->exists();

            if (!$existingDevice) {
                return response()->json(['error' => 'This device is not registered for your account.'], 403);
            }
        }

        return $next($request);
    }
}
