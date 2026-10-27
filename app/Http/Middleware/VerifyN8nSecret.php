<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyN8nSecret
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('X-N8N-SECRET') !== config('services.n8n.secret')) {
            return response()->json(['message' => 'Non autorisé'], 401);
        }

        return $next($request);
    }
}