<?php

namespace Tests\Feature\Models;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;
    #[Test]
    public function 任意の記事のお気に入りを行ったUserを取得できる()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();

        DB::table('article_favorites')->insert([
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);
        $favoritedUser = $article->favoritedUsers()->first();
        $this->assertEquals($user->id, $favoritedUser->id);
    }

    #[Test]
    public function 任意のユーザーが記事のお気に入りをしたか確認できる()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $article = Article::factory()->create();

        $this->assertFalse($article->favoritedByUser($user1));
        DB::table('article_favorites')->insert([
            'user_id' => $user1->id,
            'article_id' => $article->id,
        ]);

        $this->assertTrue($article->favoritedByUser($user1));
        $this->assertFalse($article->favoritedByUser($user2));
    }

    #[Test]
    public function 何人のユーザーが記事のお気に入りをしたか確認できる()
    {
        $favoritedUserCount = 10;
        $users = User::factory($favoritedUserCount)->create();

        $article = Article::factory()->create();

        foreach ($users as $user) {
            DB::table('article_favorites')->insert([
                'user_id' => $user->id,
                'article_id' => $article->id,
            ]);
        }

        $this->assertEquals($article->favoritesCount(), $favoritedUserCount);
    }

    #[Test]
    public function 任意の記事をお気に入りすることができる()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();

        $this->assertDatabaseEmpty('article_favorites');
        $article->favorite($user);
        $this->assertDatabaseHas('article_favorites', [
           'user_id' => $user->id,
           'article_id' => $article->id,
        ]);
    }

}
