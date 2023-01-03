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
        Schema::create('issues', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('user_id')->nullable();
            $table->string('judul', 191)->nullable();
            $table->string('judul_slug', 191)->nullable();
            $table->string('kategori', 191)->nullable();
            $table->mediumText('photo')->nullable();
            $table->longText('detail_issue')->nullable();
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
        Schema::dropIfExists('issues');
    }
};
