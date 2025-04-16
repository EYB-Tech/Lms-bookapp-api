<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAuthApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the AUTH_API key from .env
        $authApiKey = env('AUTH_API_KEY',"e5458cdcf99e3395bf37cef35afd536ed8c60751ea3dedeb947bdcf548f1652c");

        // Get the API key from the request headers
        $requestApiKey = $request->header('AUTH_API');

        if (!$requestApiKey || $requestApiKey !== $authApiKey) {
            return response()->json(['error' => 'Unauthorized API access'], 403);
        }

        return $next($request);
    }
}
