<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('activity_id')->index('participations_activity_id_foreign');
            $table->string('judul_slug_activity');
            $table->string('name_voucher');
            $table->integer('minimum_donated')->default(1);
            $table->unsignedBigInteger('kuota_voucher')->default(0);
            $table->decimal('presentase_diskon', 10, 2);
            $table->string('deadline')->nullable();
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
        Schema::dropIfExists('vouchers');
    }
}
