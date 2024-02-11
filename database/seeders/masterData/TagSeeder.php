<?php

namespace Database\Seeders\MasterData;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Laravel'],
            ['name' => 'Vue.js'],
            ['name' => 'React.js'],
            ['name' => 'Angular'],
            ['name' => 'Node.js'],
            ['name' => 'Docker'],
            ['name' => 'AWS'],
            ['name' => 'GCP'],
            ['name' => 'Azure'],
            ['name' => 'Firebase'],
            ['name' => 'MySQL'],
            ['name' => 'PostgreSQL'],
            ['name' => 'MongoDB'],
            ['name' => 'Redis'],
            ['name' => 'Elasticsearch'],
            ['name' => 'Kubernetes'],
            ['name' => 'Deno'],
            ['name' => 'TypeScript'],
            ['name' => 'JavaScript'],
            ['name' => 'PHP'],
            ['name' => 'Python'],
            ['name' => 'Ruby'],
            ['name' => 'Go'],
            ['name' => 'Rust'],
            ['name' => 'Swift']
        ];
        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
