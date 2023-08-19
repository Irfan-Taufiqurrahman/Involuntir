<?php

namespace Database\Seeders;

use App\Models\KabarTerbaru;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            // KabarTerbaruSeeder::class,
            CategorySeeder::class,
            ConnectCampaignToCategory::class,
        ]);
    }
}
