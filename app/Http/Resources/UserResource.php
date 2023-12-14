<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'email' => $this->email,
                'token' => $this->currentAccessToken(),
                'username' => $this->username,
                'bio' => $this->bio,
                'image' => $this->image_s3_path,
            ],
        ];
    }
}
