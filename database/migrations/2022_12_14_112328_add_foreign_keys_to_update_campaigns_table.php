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
        Schema::table('update_campaigns', function (Blueprint $table) {
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
        Schema::table('update_campaigns', function (Blueprint $table) {
            $table->dropForeign('update_campaigns_campaign_id_foreign');
        });
    }
};
