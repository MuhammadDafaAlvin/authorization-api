<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('D4MI-API-KEY');

        if ($apiKey !== env('API_KEY')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized: Invalid API Key',
            ], 401);
        }
        return $next($request);
    }
}
