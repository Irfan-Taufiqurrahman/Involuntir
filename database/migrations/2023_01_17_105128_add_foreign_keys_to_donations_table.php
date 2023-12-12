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
        Schema::table('donations', function (Blueprint $table) {
            $table->foreign(['user_id'], 'donations_user_id_index')->references(['id'])->on('users')->onDelete('CASCADE');
            $table->foreign(['activity_id'], 'donations_activity_id_index')->references(['id'])->on('activities')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign('donations_user_id_index');
            $table->dropForeign('donations_activity_id_index');
        });
    }
};