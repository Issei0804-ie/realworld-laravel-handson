<?php

namespace Tests\Feature\Http\Controllers\Api\Tags;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function タグ一覧を取得する()
    {
        $tag1 = Tag::factory()->create(['name' => 'tag1']);
        $tag2 = Tag::factory()->create(['name' => 'tag2']);
        $tag3 = Tag::factory()->create(['name' => 'tag3']);
        $this->get(route('api.tags.index'))
            ->assertOk()
            ->assertJson([
                'tags' => [
                    $tag1->name,
                    $tag2->name,
                    $tag3->name
                ]
            ]);
    }
}
