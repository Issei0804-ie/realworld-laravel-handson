<?php

namespace Tests\Feature\Http\Controllers\Api\Profiles\Username\Follow;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteControllerTest extends TestCase
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
    public function 既にフォローしている状態でフォロー解除すると、フォローが外れていることを確認する(): void
    {
        $this->source->followYou($this->target);
        $this->assertDatabaseCount('follows', 1);
        $this->assertDatabaseHas('follows', [
            'follow_user_id' => $this->target->id,
            'follower_user_id' => $this->source->id,
        ]);

        $this->actingAs($this->source)
            ->delete(route('api.profiles.username.follow.delete', ['user' => $this->target]))
            ->assertOk()
            ->assertJson([
                'profile' => [
                    'username' => $this->target->username,
                    'bio' => $this->target->bio,
                    'image' => $this->target->image_s3_path,
                    'following' => false,
                ]
            ]);

        $this->assertDatabaseCount('follows', 0);
    }

    #[Test]
    public function フォローしていない状態でフォロー解除すると、フォローが外れていることを確認する()
    {
        $this->assertDatabaseCount('follows', 0);

        $this->actingAs($this->source)
            ->delete(route('api.profiles.username.follow.delete', ['user' => $this->target]))
            ->assertOk()
            ->assertJson([
                'profile' => [
                    'username' => $this->target->username,
                    'bio' => $this->target->bio,
                    'image' => $this->target->image_s3_path,
                    'following' => false,
                ]
            ]);

        $this->assertDatabaseCount('follows', 0);
    }
}
