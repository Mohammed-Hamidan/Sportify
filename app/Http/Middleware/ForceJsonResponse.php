<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForceJsonResponse
{
    public function handle(Request $request, Closure $next): Response|JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $response = $next($request);

        if ($response instanceof Response || $response instanceof JsonResponse) {
            $response->headers->set('Content-Type', 'application/json');
        }

        return $response;
    }
}

