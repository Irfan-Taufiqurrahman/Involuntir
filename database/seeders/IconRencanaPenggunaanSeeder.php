<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IconRencanaPenggunaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'icon' => '/icon/icon/rencana_penggunaan/program.svg',
            ],
            [
                'icon' => '/icon/icon/rencana_penggunaan/instagram.svg',
            ],
        ];

        \App\Models\IconRencanaPenggunaanDana::insert($data);
    }
}
