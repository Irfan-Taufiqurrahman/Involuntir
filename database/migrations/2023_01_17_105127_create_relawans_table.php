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
        Schema::create('relawans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('relawans_user_id_foreign');
            $table->unsignedInteger('info_id')->index('relawans_info_id_foreign');
            $table->longText('user_comment')->nullable();
            $table->string('nomor_relawan')->nullable();
            $table->string('verify')->nullable();
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
        Schema::dropIfExists('relawans');
    }
};
