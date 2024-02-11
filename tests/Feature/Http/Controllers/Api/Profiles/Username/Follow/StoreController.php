<?php

namespace Tests\Feature\Http\Controllers\Api\Profiles\Username\Follow;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreController extends TestCase
{
    use RefreshDatabase;
    private User $source;
    private User $target;
    protected function setUp(): void
    {
        parent::setUp();
        $this->source = User::factory()->create();
        $this->target = User::factory()->create();
    }


    #[Test]
    public function 既にフォローしている状態でAPIを叩くとフォローが解除されない()
    {
        $this->source->followYou($this->target);
        $this->assertDatabaseCount('follows', 1);
        $this->assertDatabaseHas('follows', [
            'follow_user_id' => $this->target->id,
            'follower_user_id' => $this->source->id,
        ]);

        $this->actingAs($this->source)
            ->post(route('api.profiles.username.follow.store', ['user' => $this->target]))
            ->assertOk()
            ->assertJson([
                'profile' => [
                    'username' => $this->target->username,
                    'bio' => $this->target->bio,
                    'image' => $this->target->image_s3_path,
                    'following' => true,
                ]
            ]);

        $this->assertDatabaseCount('follows', 1);
        $this->assertDatabaseHas('follows', [
            'follow_user_id' => $this->target->id,
            'follower_user_id' => $this->source->id,
        ]);
    }

    #[Test]
    public function フォローしていない状態でAPIを叩くとフォローすることができる()
    {
        $this->assertDatabaseEmpty('follows');

        $this->actingAs($this->source)
            ->post(route('api.profiles.username.follow.store', ['user' => $this->target]))
            ->assertOk()
            ->assertJson([
                'profile' => [
                    'username' => $this->target->username,
                    'bio' => $this->target->bio,
                    'image' => $this->target->image_s3_path,
                    'following' => true,
                ]
            ]);

        $this->assertDatabaseCount('follows', 1);
        $this->assertDatabaseHas('follows', [
            'follow_user_id' => $this->target->id,
            'follower_user_id' => $this->source->id,
        ]);
    }
}
