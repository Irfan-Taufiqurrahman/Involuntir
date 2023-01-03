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
        Schema::create('rencana_penggunaan_danas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('campaign_id')->index('rencana_penggunaan_danas_campaign_id_foreign');
            $table->unsignedBigInteger('icon_id')->nullable()->index('rencana_penggunaan_danas_icon_id_foreign');
            $table->string('judul');
            $table->text('biaya');
            $table->boolean('is_percent')->default(false);
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
        Schema::dropIfExists('rencana_penggunaan_danas');
    }
};
