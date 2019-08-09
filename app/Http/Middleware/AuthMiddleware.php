<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {

            return response()->json([
               'message' => 'You are not authorised'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $request->user = $user;
        return $next($request);
    }
}
