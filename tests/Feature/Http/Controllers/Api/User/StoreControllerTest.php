<?php

namespace Tests\Feature\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private array $updateParams;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public static function ユーザーの情報を更新することができるのデータプロバイダー()
    {
        return [
            '全てのパラメータが入力されている場合' => [
                'updateParams' => [
                        'user' => [
                        'email' => 'hoge@example.com',
                        'username' => 'hoge',
                        'password' => 'password',
                        'bio' => 'bio',
                        'image' => 'https://i.stack.imgur.com/xHWG8.jpg',
                    ]
                ],
                'expected' => [
                    'email' => 'hoge@example.com',
                    'username' => 'hoge',
                    'password' => 'password',
                    'bio' => 'bio',
                    'image_s3_path' => 'https://i.stack.imgur.com/xHWG8.jpg',
                ],
            ]
        ];
    }

    #[Test]
    #[DataProvider('ユーザーの情報を更新することができるのデータプロバイダー')]
    public function ユーザーの情報を更新することができる($updateParams, $expected)
    {
        $this->assertDatabaseMissing('users', $expected);
        $this->actingAs($this->user)
            ->put(route('api.user.store'), $updateParams)
            ->assertOk();
        $this->assertDatabaseHas('users', $expected);
    }
}
