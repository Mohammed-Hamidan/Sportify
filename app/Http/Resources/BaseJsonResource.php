<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    abstract public function toArray($request): array;

    public function with($request): array
    {
        return [
            'success' => true,
            'message' => '',
        ];
    }
}

