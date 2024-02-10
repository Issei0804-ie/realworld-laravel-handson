<?php

namespace Tests\Feature\Http\Controllers\Api\Profiles;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    use RefreshDatabase;
    #[Test]
    public function ログインしていない状態でリクエストすると、プロフィールが返ってくる()
    {
        // このユーザーのプロフィール情報を取得したい
        $user = User::factory()->create();

        $this->get(route('api.profiles.show', ['user' => $user]))
            ->assertOk()
            ->assertJson([
                'profile' => [
                    'username' => $user->username,
                    'bio' => $user->bio,
                    'image' => $user->image_s3_path,
                    'following' => false,
                ]
            ]);
    }

    #[Test]
    #[DataProvider('ログインしている状態でリクエストすると、プロフィールが返ってくるのデータプロバイダー')]
    public function ログインしてい状態でリクエストすると、プロフィールが返ってくる($createTargetUserAndAccessedUser, $expected)
    {
        [$targetUser, $accessedUser] = $createTargetUserAndAccessedUser();

        $this->actingAs($accessedUser)
            ->get(route('api.profiles.show', ['user' => $targetUser]))
            ->assertOk()
            ->assertJson($expected($targetUser));
    }

    public static function ログインしている状態でリクエストすると、プロフィールが返ってくるのデータプロバイダー()
    {
        return [
            'フォローしている場合' => [
                'createTargetUserAndAccessedUser' => function (){
                    $targetUser = User::factory()->create();
                    $accessedUser = User::factory()->create();
                    $accessedUser->followYou($targetUser);
                    return [$targetUser, $accessedUser];
                },
                'expected' => fn($user) => [
                    'profile' => [
                        'username' => $user->username,
                        'bio' => $user->bio,
                        'image' => $user->image_s3_path,
                        'following' => true,
                    ]
                ],
            ],
            'フォローしていない場合' => [
                'createTargetUserAndAccessedUser' => function (){
                    $targetUser = User::factory()->create();
                    $accessedUser = User::factory()->create();
                    return [$targetUser, $accessedUser];
                },
                'expected' => fn($user) => [
                    'profile' => [
                        'username' => $user->username,
                        'bio' => $user->bio,
                        'image' => $user->image_s3_path,
                        'following' => false,
                    ]
                ],
            ],
        ];
    }
}
