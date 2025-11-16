<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        Schema::defaultStringLength(191);

        Response::macro('api', function (
            bool $success = true,
            string $message = '',
            mixed $data = null,
            int $status = 200
        ) {
            return response()->json([
                'success' => $success,
                'message' => $message,
                'data' => $data,
            ], $status);
        });

        RateLimiter::for('api', function (Request $request) {
            $maxAttempts = (int) config('api.rate_limit.max_attempts', 60);
            $decayMinutes = (int) config('api.rate_limit.decay_minutes', 1);

            return Limit::perMinutes($decayMinutes, $maxAttempts)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many requests. Please try again later.',
                        'errors' => null,
                    ], 429);
                });
        });
    }
}
