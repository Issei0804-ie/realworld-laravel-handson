<?php

namespace App\Http\Controllers\Api\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ShowController extends Controller
{
    public function __invoke(string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return response()->json(new ArticleResource(null, $article));
    }
}
