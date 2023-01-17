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
        Schema::create('divisi_relawans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('info_id')->index('divisi_relawans_info_id_foreign');
            $table->string('nama_divisi');
            $table->string('jumlah_relawan_divisi')->nullable();
            $table->string('jam_kerja_divisi')->nullable();
            $table->longText('syarat_divisi_relawan')->nullable();
            $table->longText('tugas_divisi_relawan')->nullable();
            $table->longText('perlengkapan_divisi_relawan')->nullable();
            $table->timestamps();
            $table->longText('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisi_relawans');
    }
};
