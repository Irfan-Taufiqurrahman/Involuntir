<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
             $table->text('cerita_tentang_pembuat_campaign')->nullable()->after('batas_waktu_campaign');
             $table->text('cerita_tentang_penerima_manfaat')->nullable()->after('cerita_tentang_pembuat_campaign');
             $table->text('foto_tentang_campaign')->nullable()->after('cerita_tentang_penerima_manfaat');
             $table->text('cerita_tentang_masalah_dan_usaha')->nullable()->after('foto_tentang_campaign');
             $table->text('foto_tentang_campaign_2')->nullable()->after('cerita_tentang_masalah_dan_usaha');
             $table->text('berapa_biaya_yang_dibutuhkan')->nullable()->after('foto_tentang_campaign_2');
             $table->text('kenapa_galangdana_dibutuhkan')->nullable()->after('berapa_biaya_yang_dibutuhkan');
             $table->text('foto_tentang_campaign_3')->nullable()->after('kenapa_galangdana_dibutuhkan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('cerita_tentang_pembuat_campaign');
            $table->dropColumn('cerita_tentang_penerima_manfaat');
            $table->dropColumn('foto_tentang_campaign');
            $table->dropColumn('cerita_tentang_masalah_dan_usaha');
            $table->dropColumn('foto_tentang_campaign_2');
            $table->dropColumn('berapa_biaya_yang_dibutuhkan');
            $table->dropColumn('kenapa_galangdana_dibutuhkan');
            $table->dropColumn('foto_tentang_campaign_3');
        });
    }
}
