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
        Schema::table('penarikan_donations', function (Blueprint $table) {
            $table->foreign(['user_id'])->references(['id'])->on('users')->onDelete('CASCADE');
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
        Schema::table('penarikan_donations', function (Blueprint $table) {
            $table->dropForeign('penarikan_donations_user_id_foreign');
            $table->dropForeign('penarikan_donations_campaign_id_foreign');
        });
    }
};
