<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            \App\Models\Company::create([
                'user_id' => 1,
                'name' => 'Company ' . $i,
                'location' => 'Bandung',
                'address' => 'Jl. Cihampelas No. 1',
                'latitude' => -8.056345,
                'longitude' => 111.869357,
                'product_type' => 'Fashion',
                'photo' => 'https://picsum.photos/200/300',
                'coin_discount' => 100,
                'discount_percentage' => 10,
            ]);
        }
    }
}
