<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
    * @return void
     */

    private $data = [
        [
            "id" => 1,
            "name" => "Panti Asuhan",
            "main-icon" => "/icon/icon/landing-page/panti.svg",
            "secondary-icon" => "/icon/icon/landing-page/panti-secondary.svg",
        ],
        [
            "id" => 2,
            "name" => "Beasiswa & Pendidikan",
            "main-icon" => "/icon/icon/landing-page/beasiswa.svg",
            "secondary-icon" => "/icon/icon/landing-page/beasiswa-secondary.svg",
        ],
        [
            "id" => 3,
            "name" => "Kemanusiaan",
            "main-icon" => "/icon/icon/landing-page/kemanusiaan.svg",
            "secondary-icon" => "/icon/icon/landing-page/kemanusiaan-secondary.svg",
        ],
        [
            "id" => 4,
            "name" => "Kegiatan Sosial",
            "main-icon" => "/icon/icon/landing-page/gift.svg",
            "secondary-icon" => "/icon/icon/landing-page/gift-secondary.svg",
        ],
        [
            "id" => 5,
            "name" => "Rumah Ibadah",
            "main-icon" => "/icon/icon/landing-page/building.svg",
            "secondary-icon" => "/icon/icon/landing-page/building-secondary.svg",
        ],
        [
            "id" => 6,
            "name" => "Bencana Alam",
            "main-icon" => "/icon/icon/landing-page/bencana-alam.svg",
            "secondary-icon" => "/icon/icon/landing-page/bencana-alam-secondary.svg",
        ],
        [
            "id" => 7,
            "name" => "Kesehatan & Medis",
            "main-icon" => "/icon/icon/landing-page/hospital.svg",
            "secondary-icon" => "/icon/icon/landing-page/hospital-secondary.svg",
        ]
    ];
    public function run()
    {
        foreach($this->data as $data) {
            Category::insert([
                'id' => $data['id'],
                'name' => $data['name'],
                'main_icon' => $data['main-icon'],
                'secondary_icon' => $data['secondary-icon'],
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.',
            ]);
        }
    }
}
