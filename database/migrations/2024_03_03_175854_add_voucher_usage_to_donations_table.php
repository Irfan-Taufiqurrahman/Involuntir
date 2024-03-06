<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVoucherUsageToDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->unsignedBigInteger('voucher_id')->nullable()->index('participations_voucher_id_foreign');
            $table->boolean('used_voucher')->default(false);
        });
    

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('voucher_id');
            $table->dropColumn('used_voucher');
        });
    }
}
