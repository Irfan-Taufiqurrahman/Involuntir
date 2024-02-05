<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            // Remove columns
            $table->dropColumn('status_pemberian_pertama');
            $table->dropColumn('foto_pertama');
            $table->dropColumn('status_pemberian_kedua');
            $table->dropColumn('foto_kedua');
            $table->dropColumn('status_pemberian_ketiga');
            $table->dropColumn('foto_ketiga');
            $table->dropColumn('komentar');
            $table->dropColumn('snap_token');
            $table->dropColumn('status_terbaru');
            $table->dropColumn('payment_url');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // If needed, you can add code to recreate the columns in the down method.
        // However, dropping columns is usually a one-way operation.
    }
}
