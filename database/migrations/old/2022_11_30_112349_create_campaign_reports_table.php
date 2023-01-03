<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

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
}
