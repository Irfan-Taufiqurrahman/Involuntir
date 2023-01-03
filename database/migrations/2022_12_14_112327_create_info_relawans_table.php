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
        Schema::create('info_relawans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('info_relawans_user_id_foreign');
            $table->string('judul_info_relawan');
            $table->string('judul_slug')->nullable();
            $table->string('jumlah_info_relawan');
            $table->string('jam_kerja_info_relawan')->nullable();
            $table->string('nomor_telp_info_relawan')->nullable();
            $table->longText('syarat_info_relawan')->nullable();
            $table->longText('tugas_info_relawan')->nullable();
            $table->longText('perlengkapan_info_relawan')->nullable();
            $table->mediumText('foto_info_relawan')->nullable();
            $table->string('kategori_info_relawan')->nullable();
            $table->date('batas_waktu_info_relawan');
            $table->date('waktu_mulai_info_relawan')->nullable();
            $table->date('waktu_selesai_info_relawan')->nullable();
            $table->longText('detail_info_relawan');
            $table->longText('update_info_relawan')->nullable();
            $table->string('status')->nullable();
            $table->string('regencies')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_relawans');
    }
};
