<?php

namespace Feature\Http\Controllers\Api\Users;

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
}
