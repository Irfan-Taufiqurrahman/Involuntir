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
        Schema::create('penarikan_donations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('campaign_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->string('judul_slug')->nullable();
            $table->string('no_rek')->nullable();
            $table->string('atas_nama')->nullable();
            $table->string('bank')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('alasan')->nullable();
            $table->string('status')->nullable();
            $table->string('approved')->nullable();
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
        Schema::dropIfExists('penarikan_donations');
    }
};
