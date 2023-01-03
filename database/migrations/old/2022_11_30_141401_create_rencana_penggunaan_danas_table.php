<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRencanaPenggunaanDanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rencana_penggunaan_danas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('campaign_id');
            $table->unsignedBigInteger('icon_id')->nullable();
            $table->string('judul');
            $table->text('biaya');
            $table->boolean('is_percent')->default(false);
            $table->timestamps();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('icon_id')->references('id')->on('icon_rencana_penggunaan_danas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rencana_penggunaan_danas');
    }
}
