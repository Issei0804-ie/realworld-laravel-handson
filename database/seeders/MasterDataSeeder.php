<?php

namespace Database\Seeders;

use Database\Seeders\MasterData\TagSeeder;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([TagSeeder::class]);
    }
}
