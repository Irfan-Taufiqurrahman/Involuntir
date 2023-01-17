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
        Schema::table('divisi_relawans', function (Blueprint $table) {
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
        Schema::table('divisi_relawans', function (Blueprint $table) {
            $table->dropForeign('divisi_relawans_info_id_foreign');
        });
    }
};
