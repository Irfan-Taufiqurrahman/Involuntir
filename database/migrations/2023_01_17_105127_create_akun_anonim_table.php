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
        Schema::create('akun_anonim', function (Blueprint $table) {
            $table->integer('id_donasi');
            $table->string('nama', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('no_hp', 50)->nullable();
            $table->string('kode_referal', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akun_anonim');
    }
};
