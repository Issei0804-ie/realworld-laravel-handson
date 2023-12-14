<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function __construct(private User|null $user, $resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        $tagList = $this->tags->map(fn ($tag) => $tag->name)->toArray();
        return [
            'article' => [
                'slug' => $this->slug,
                'title' => $this->title,
                'description' => $this->description,
                'body' => $this->body,
                'tagList' => $tagList,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
                'favorited' => $this->user ? $this->favoritedByUser($this->user) : false,
                'favoritesCount' => $this->favoritesCount(),
                'author' => [
                    'username' => $this->author->username,
                    'bio' => $this->author->bio,
                    'image' => $this->author->image_s3_path,
                    'following' => $this->author->following,
                ]
            ]
        ];
    }
}
