<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'model' => $this->model,
            'year' => $this->year,
            'createdAt' => $this->created_at,
        ];
    }
}
