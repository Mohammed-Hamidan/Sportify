<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->as('api.v1.')
    ->group(function (): void {
        Route::get('/health', fn () => response()->json([
            'success' => true,
            'message' => 'Sportify API is healthy.',
            'data' => ['version' => 'v1'],
        ]));
    });

