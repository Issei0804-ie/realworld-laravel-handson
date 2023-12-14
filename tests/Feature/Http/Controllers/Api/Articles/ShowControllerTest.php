<?php

namespace Tests\Feature\Http\Controllers\Api\Articles;

use App\Models\Article;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    #[Test]
    public function 記事を取得できること()
    {
        $article = Article::factory()->create();
        $this->get(route('api.articles.show', ['slug' => $article->slug]))
            ->assertOk();
    }

    #[Test]
    public function 存在しない記事を閲覧しようとすると、404がかえってくること()
    {
        $this->get(route('api.articles.show', ['slug' => 'not_found']))
            ->assertNotFound();
    }
}
