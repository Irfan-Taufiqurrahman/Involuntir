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
        Schema::table('relawans', function (Blueprint $table) {
            $table->foreign(['user_id'])->references(['id'])->on('users')->onDelete('CASCADE');
            $table->foreign(['info_id'])->references(['id'])->on('info_relawans')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relawans', function (Blueprint $table) {
            $table->dropForeign('relawans_user_id_foreign');
            $table->dropForeign('relawans_info_id_foreign');
        });
    }
};
