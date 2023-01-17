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
        Schema::create('participations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('activity_id')->index('participations_activity_id_foreign');
            $table->unsignedInteger('user_id')->index('participations_user_id_foreign');
            $table->string('nomor_hp');
            $table->string('akun_linkedin')->nullable();
            $table->text('pesan')->nullable();
            $table->timestamps();

            $table->unique(['activity_id', 'user_id'], 'participations_unique_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participations');
    }
};
