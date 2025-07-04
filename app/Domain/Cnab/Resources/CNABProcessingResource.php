<?php

namespace App\Domain\Cnab\Resources;

use App\Domain\User\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CNABProcessingResource extends JsonResource
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
            'status' => $this->status,
            'original_filename' => $this->original_filename,
            'cnab_filepath' => $this->cnab_filepath,
            'original_filepath' => $this->original_filepath,
            'file_sequence' => $this->file_sequence,
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}