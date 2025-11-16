<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    protected function successResponse(
        mixed $data = null,
        string $message = '',
        int $status = Response::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    protected function createdResponse(
        mixed $data = null,
        string $message = 'Resource created successfully.'
    ): JsonResponse {
        return $this->successResponse($data, $message, Response::HTTP_CREATED);
    }

    protected function noContentResponse(string $message = 'Resource deleted successfully.'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => null,
        ], Response::HTTP_OK);
    }

    protected function paginatedResponse(
        LengthAwarePaginator $paginator,
        string $message = ''
    ): JsonResponse {
        return $this->successResponse([
            'items' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
        ], $message);
    }

    protected function errorResponse(
        string $message,
        int $status = Response::HTTP_BAD_REQUEST,
        mixed $errors = null
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}

