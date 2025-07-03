<?php

namespace App\Domain\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $token = $this->resource;
        
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
            'user'         =>[
                'id' => auth('api')->user()->id,
                'name' => auth('api')->user()->name,
                'email' => auth('api')->user()->email,
                'role' => auth('api')->user()->getRoleNames(),
            ]
        ];
    }
}
