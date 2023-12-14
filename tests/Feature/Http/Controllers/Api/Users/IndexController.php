<?php

namespace Tests\Feature\Http\Controllers\Api\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IndexController extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function ログインしている状態でリクエストすると、自分のユーザー情報が返ってくる()
    {
        $user = User::factory()->create();
        $this->assertGuest();
        $this->actingAs($user)
            ->get(route('api.users.index'))
            ->assertOk()
            ->assertJsonStructure([
                'user' => [
                    'email',
                    'token',
                    'username',
                    'bio',
                    'image',
                ],
            ]);
    }

    #[Test]
    public function ログインしていない状態でリクエストすると、401エラーが返ってくること()
    {
        $this->assertGuest();
        $this->get(route('api.users.index'))->assertUnauthorized();
    }
}
