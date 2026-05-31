<?php

namespace App\Http\Middleware;

use App\Models\System;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSystemApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey   = $request->header('X-Api-Key');
        $systemId = $request->header('X-System-Id');

        $system = System::where('api_key', $apiKey)
            ->where('system_id', $systemId)
            ->where('is_active', true)
            ->first();

        if (! $system) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->merge(['system' => $system]);

        return $next($request);
    }
}
