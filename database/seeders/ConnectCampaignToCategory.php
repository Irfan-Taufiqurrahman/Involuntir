<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Category;
use Exception;
use Illuminate\Database\Seeder;

class ConnectCampaignToCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $change_to = [
        "Kemanusiaan" => "Kemanusiaan",
        "Medis & Kesehatan" => "Kesehatan & Medis",
        "Kegiatan Sosial" => "Kegiatan Sosial",
        "Panti Asuhan" => "Panti Asuhan",
        "Beasiswa" => "Beasiswa & Pendidikan",
        "Rumah Ibadah" => "Rumah Ibadah",
        "Bencana Alam" => "Bencana Alam",
        "kesehatan" => "Kesehatan & Medis",
        "Difabel" => "Kemanusiaan",
        "Sarana & Insfrastruktur" => "Kemanusiaan",
        "Kesehatan" => "Kesehatan & Medis",
        "Zakat" => "Kemanusiaan",
        "Menolong Hewan" => "Kemanusiaan",
        "Kesehatan, Kemanusiaan" => "Kemanusiaan",
        "beasiswa pendidikan" => "Beasiswa & Pendidikan",
        "Kesehatan & Medis" => "Kesehatan & Medis",
        "Beasiswa & Pendidikan" => "Beasiswa & Pendidikan",
        "" => "Kemanusiaan",
        "Sarana & Infrastruktur" => "Kemanusiaan",
    ];

    private function changeCategory()
    {
        $catNames = Category::get('name');
        $names = [];

        foreach ($catNames as $name) {
            array_push($names, $name->name);
        }

        $campaigns = Campaign::withTrashed()->get();

        foreach ($campaigns as $campaign) {
            if(array_key_exists($campaign->kategori_campaign, $this->change_to)) {
                Campaign::withTrashed()->where('id', $campaign->id)->update(['kategori_campaign' => $this->change_to[$campaign->kategori_campaign]]);
            }else {
                Campaign::withTrashed()->where('id', $campaign->id)->update(['kategori_campaign' => "Kemanusiaan"]);
            }
        }
    }

    private function connectCampaignToCategory()
    {
        $campaigns = Campaign::withTrashed()->get();

        foreach($campaigns as $campaign) {
            $category_id = Category::where('name', $campaign->kategori_campaign)->first()->id;
            Campaign::withTrashed()->where('id', $campaign->id)->update(['category_id' => $category_id]);
        }
    }

    public function run()
    {
        // rubah category yang random ke dalam category yang sudah ditentukan *masih beruba string yang belum direlasikan
        $this->changeCategory();

        // menyambungkan data category pada campaign dengan tabel categories
        $this->connectCampaignToCategory();
    }
}
