<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function 任意のユーザーをフォローして、isFollowingがtrueになることを確認する()
    {
        $me = User::factory()->create();

        $followTarget = User::factory()->create();

        \DB::table('follows')->insert([
            'follow_user_id' => $followTarget->id,
            'follower_user_id' => $me->id,
        ]);

        $this->assertTrue($me->isFollowing($followTarget));
    }

    #[Test]
    public function 任意のユーザーをフォローすることができる()
    {
        $me = User::factory()->create();

        $followTarget = User::factory()->create();

        $me->followYou($followTarget);

        $this->assertDatabaseHas('follows', [
            'follow_user_id' => $followTarget->id,
            'follower_user_id' => $me->id,
        ]);
    }

    #[Test]
    public function 任意のユーザーのフォローを外すことができる()
    {
        $me = User::factory()->create();

        $followTarget = User::factory()->create();

        \DB::table('follows')->insert([
            'follow_user_id' => $followTarget->id,
            'follower_user_id' => $me->id,
        ]);

        $me->unfollowYou($followTarget);

        $this->assertDatabaseEmpty('follows');
    }
}
