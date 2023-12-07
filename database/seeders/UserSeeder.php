<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::factory(10)->create();
        // 3つだけ取り出す
        $tags1 = $tags->take(3);

        $user1 = User::factory(10)
            ->create()
            ->first();
        $me = User::factory()
            ->create([
                'username' => 'cani',
                'email' => 'cani@example.com'
            ]);
        $me->following()->attach($user1);
        $user1->following()->attach($me);

        $articles = Article::factory(2)
            ->create([
                'author' => $me->id
            ])
            ->each(function (Article $article) use ($tags1) {
                $article->tags()->attach($tags1);
            });

        Comment::factory(10)->create([
            'commented_article_id' =>$articles->first()->id,
            'commented_user_id' => $user1->id
        ]);
    }
}
