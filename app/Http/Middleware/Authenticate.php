<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate extends Middleware
{
    use ApiResponse;

    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        return route('login');
    }

    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {
            throw new HttpResponseException(
                $this->errorResponse('Unauthenticated.', Response::HTTP_UNAUTHORIZED)
            );
        }

        throw new AuthenticationException(
            'Unauthenticated.',
            $guards,
            $this->redirectTo($request)
        );
    }
}

