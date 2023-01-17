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
        Schema::create('donations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->string('nama')->nullable();
            $table->unsignedInteger('campaign_id')->index();
            $table->string('judul_slug')->nullable();
            $table->integer('biaya_persen')->nullable()->default(15);
            $table->decimal('donasi', 65, 0)->nullable();
            $table->string('kode_donasi')->nullable();
            $table->string('prantara_donasi')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->string('nomor_va')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('emoney_name')->nullable();
            $table->text('qr_code')->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_telp', 14)->nullable();
            $table->string('status_donasi')->nullable();
            $table->string('status_pembayaran')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('payment_url')->nullable();
            $table->string('status_pemberian_pertama')->nullable();
            $table->mediumText('foto_pertama')->nullable();
            $table->string('status_pemberian_kedua')->nullable();
            $table->mediumText('foto_kedua')->nullable();
            $table->string('status_pemberian_ketiga')->nullable();
            $table->mediumText('foto_ketiga')->nullable();
            $table->longText('status_terbaru')->nullable();
            $table->string('komentar')->nullable();
            $table->timestamp('deadline')->nullable();
            $table->date('tanggal_donasi')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
};
