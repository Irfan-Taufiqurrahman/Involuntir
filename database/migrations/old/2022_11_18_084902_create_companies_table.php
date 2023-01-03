<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('product_type')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedInteger('coin_discount');
            $table->unsignedInteger('discount_percentage');
            $table->string('location');
            $table->text('address');
            // latitude
            $table->decimal('latitude', 10, 8)->nullable();
            // longitude
            $table->decimal('longitude', 11, 8)->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('companies');
    }
}
