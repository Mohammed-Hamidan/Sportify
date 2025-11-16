<?php

use App\Exceptions\ApiException;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->use([
            \App\Http\Middleware\TrustHosts::class,
            \App\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \App\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        $middleware->group('web', [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            SubstituteBindings::class,
        ]);

        $middleware->group('api', [
            ForceJsonResponse::class,
            SubstituteBindings::class,
        ]);

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'signed' => \App\Http\Middleware\ValidateSignature::class,
        ]);

        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $exception, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $exception->errors(),
                ], 422);
            }
        });

        $exceptions->render(function (ApiException $exception, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage(),
                    'errors' => $exception->errors(),
                ], $exception->status());
            }
        });

        $exceptions->render(function (Throwable $exception, Request $request) {
            if (! $request->expectsJson()) {
                return null;
            }

            $status = $exception instanceof HttpExceptionInterface
                ? $exception->getStatusCode()
                : 500;

            $message = $status === 500
                ? 'Something went wrong. Please try again later.'
                : $exception->getMessage();

            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => null,
            ], $status);
        });
    })->create();
