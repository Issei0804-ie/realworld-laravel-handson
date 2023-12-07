<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::factory(10)
            ->has(Article::factory()->count(2))
            ->create()
            ->first();
        $me = User::factory()
            ->create([
                'username' => 'cani',
                'email' => 'cani@example.com'
            ]);
        $me->following()->attach($user1);
        $user1->following()->attach($me);
    }
}
