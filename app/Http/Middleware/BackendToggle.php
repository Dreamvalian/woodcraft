<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BackendToggle
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.backend_disabled')) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Backend services are temporarily disabled for maintenance.',
                ], 503);
            }

            abort(503);
        }

        return $next($request);
    }
}

