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
        Schema::create('campaign_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('user_id')->index('campaign_reports_user_id_foreign');
            $table->timestamps();

            $table->unique(['campaign_id', 'user_id'], 'campaign_reports_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_reports');
    }
};
