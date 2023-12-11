<?php

namespace Tests\Feature\Http\Controllers\Api\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function DBに登録されていないメールアドレスを使用してリクエストすると、登録できること()
    {
        $username = 'username';
        $email = 'sample@example.com';
        $password = 'password';

        $this->assertGuest();
        $this->post(route('api.users.store'), [
            'user' => [
                'username' => $username,
                'email' => $email,
                'password' => $password,
            ],
        ])->assertStatus(200)
            ->assertJson([
                'user' => [
                    'email' => $email,
                    'username' => $username,
                    'bio' => null,
                    'image' => null,
                ]])
            ->assertJsonStructure([
                'user' => [
                    'email',
                    'token',
                    'username',
                    'bio',
                    'image',
                ],
            ]
            );
    }

    #[Test]
    public function DBに登録されているメールアドレスを使用してリクエストすると、登録できない()
    {
        $username = 'username';
        $email = 'sample@example.com';
        $password = 'password';
        // ユーザーを登録する
        User::factory()->create([
            'email' => $email,
        ]);

        $this->assertGuest();

        // 既に登録されているメールアドレスでリクエストするので、エラーが返ってくる
        $this->post(route('api.users.store'), [
            'user' => [
                'username' => $username,
                'email' => $email,
                'password' => $password,
            ],
        ])->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'user.email' => ['The user.email has already been taken.'],
                ],
            ]);
    }
}
