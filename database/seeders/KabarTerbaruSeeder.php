<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KabarTerbaruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;
        while ($i < 5) {
            DB::table('kabar_terbarus')->insert([
                'body' => Str::random('200'),
                'user_id' => rand(1, 2233),
                'campaign_id' => 1055,
            ]);
            $i++;
        }
    }
}
