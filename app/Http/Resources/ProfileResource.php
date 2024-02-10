<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public $collects = User::class;
    public function __construct($resource, private ?User $userAccessedProfile = null)
    {
        parent::__construct($resource);
    }
    public function toArray(Request $request): array
    {
        return [
            'profile' => [
                'username' => $this->username,
                'bio' => $this->bio,
                'image' => $this->image_s3_path,
                'following' => $this->userAccessedProfile ? $this->userAccessedProfile->isFollowing($this->resource) : false,
            ],
        ];
    }
}
