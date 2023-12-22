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
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('category_id')->index('category_id');
            $table->unsignedInteger('user_id')->index('user_id');            
            $table->string('judul_activity');
            $table->string('judul_slug')->nullable();
            $table->text('foto_activity')->nullable();
            $table->text('detail_activity')->nullable();
            $table->string('batas_waktu')->nullable();
            $table->string('waktu_activity')->nullable();
            $table->string('lokasi')->nullable();
            $table->enum('tipe_activity', ['Virtual', 'In-Person', 'Hybrid', '']);
            $table->enum('status_publish', ['published', 'drafted', '', '']);
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
};
