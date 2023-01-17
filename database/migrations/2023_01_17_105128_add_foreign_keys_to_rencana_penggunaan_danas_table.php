<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rencana_penggunaan_danas', function (Blueprint $table) {
            $table->foreign(['icon_id'])->references(['id'])->on('icon_rencana_penggunaan_danas')->onDelete('SET NULL');
            $table->foreign(['campaign_id'])->references(['id'])->on('campaigns')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rencana_penggunaan_danas', function (Blueprint $table) {
            $table->dropForeign('rencana_penggunaan_danas_icon_id_foreign');
            $table->dropForeign('rencana_penggunaan_danas_campaign_id_foreign');
        });
    }
};
