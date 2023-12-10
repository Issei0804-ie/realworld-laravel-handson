<?php

namespace Tests\Feature\Http\Controllers\Api\Users\Login;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function 既に登録されているメールアドレスと、メールアドレスに紐づく正しいパスワードを使用するとログインできること()
    {
        $user = \App\Models\User::factory()->create();

        $this->assertGuest();
        $this->post(route('api.users.login.store'), [
            'user' => [
                'email' => $user->email,
                'password' => 'password',
            ],
        ])->assertStatus(200)
            ->assertJson([
                'user' => [
                    'email' => $user->email,
                    'username' => $user->username,
                    'bio' => $user->bio,
                    'image' => $user->image_s3_path,
                ],
            ])
            ->assertJsonStructure([
                'user' => [
                    'email',
                    'token',
                    'username',
                    'bio',
                    'image',
                ],
            ]);

        $this->assertAuthenticated();
    }

    #[Test]
    public function 登録されていないメールアドレスでログインできないことを確認する()
    {
        $this->assertGuest();
        $this->post(route('api.users.login.store'), [
            'user' => [
                'email' => 'example@example.com',
                'password' => 'password',
            ],
        ])->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'message',
                ],
            ]);
        $this->assertGuest();
    }

    #[Test]
    public function 既に登録されているメールアドレスで、間違ったパスワードを使用するとログインに失敗する()
    {
        $user = \App\Models\User::factory()->create();

        $this->assertGuest();
        $this->post(route('api.users.login.store'), [
            'user' => [
                'email' => $user->email,
                'password' => 'wrong_password',
            ],
        ])->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'message',
                ],
            ]);
        $this->assertGuest();
    }

    #[Test]
    public function passwordを送信しないでリクエストを送ると、バリデーションエラーを返す()
    {
        $this->assertGuest();
        $this->post(route('api.users.login.store'), [
            'user' => [
                'email' => 'hoge@example.com',
            ],
        ])->assertStatus(422);

        $this->assertGuest();
    }
}
