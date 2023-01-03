<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnOfCampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function(Blueprint $table) {
            $table->text('foto_campaign_2')->nullable()->after('foto_campaign');
            $table->text('foto_campaign_3')->nullable()->after('foto_campaign_2');
            $table->text('foto_campaign_4')->nullable()->after('foto_campaign_3');
            $table->enum('campaign_type', ['event', 'compensation', 'operational', 'construction'])->nullable()->after('foto_campaign_4');
            $table->enum('kategori_penerima_manfaat', ['sendiri', 'keluarga', 'orang_lain'])->nullable()->after('campaign_type');
            $table->text('ajakan')->nullable()->after('kategori_penerima_manfaat');
            $table->enum('status_publish', ['published', 'drafted'])->nullable()->after('ajakan');

            // change column to nullabel
            $table->string('penerima')->nullable()->change();
            $table->string('judul_campaign')->nullable()->change();
            $table->string('nominal_campaign')->nullable()->change();
            $table->string('regencies')->nullable()->change();
            $table->string('batas_waktu_campaign')->nullable()->change();
            $table->string('detail_campaign')->nullable()->change();
            $table->string('tujuan')->nullable()->change();
            $table->string('alamat_lengkap')->nullable()->change();
            $table->string('rincian')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function(Blueprint $table) {
            $table->dropColumn('foto_campaign_2');
            $table->dropColumn('foto_campaign_3');
            $table->dropColumn('foto_campaign_4');
            $table->dropColumn('campaign_type');
            $table->dropColumn('kategori_penerima_manfaat');
            $table->dropColumn('ajakan');
            $table->dropColumn('status_publish');

            // change column to nullabel
            $table->string('judul_campaign')->change();
            $table->string('penerima')->change();
            $table->string('nominal_campaign')->change();
            $table->string('regencies')->change();
            $table->string('batas_waktu_campaign')->change();
            $table->string('detail_campaign')->change();
            $table->string('tujuan')->change();
            $table->string('alamat_lengkap')->change();
            $table->string('rincian')->change();
        });
    }
}
