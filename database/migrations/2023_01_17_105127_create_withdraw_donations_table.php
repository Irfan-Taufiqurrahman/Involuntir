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
        Schema::create('withdraw_donations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('campaign_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->string('judul_slug')->nullable();
            $table->string('no_rek')->nullable();
            $table->string('atas_nama')->nullable();
            $table->string('jumlah_uang_pertama')->nullable();
            $table->string('alasan_pertama')->nullable();
            $table->string('status_pertama')->nullable();
            $table->string('approved_pertama')->nullable();
            $table->string('jumlah_uang_kedua')->nullable();
            $table->string('alasan_kedua')->nullable();
            $table->string('status_kedua')->nullable();
            $table->string('approved_kedua')->nullable();
            $table->string('jumlah_uang_ketiga')->nullable();
            $table->string('alasan_ketiga')->nullable();
            $table->string('status_ketiga')->nullable();
            $table->string('approved_ketiga')->nullable();
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
        Schema::dropIfExists('withdraw_donations');
    }
};
