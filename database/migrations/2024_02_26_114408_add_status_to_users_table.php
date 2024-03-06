<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddStatusToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['donated', 'not yet donated'])->default('not yet donated');
            $table->integer('total_donated')->default(0);
        });

        // Update 'status' field based on 'user_id' presence in 'donations' table
        DB::table('users')->update(['status' => 'not yet donated']);
        DB::table('users')
        ->whereIn('id', function ($query) {
            $query->select('user_id')
                  ->distinct()
                  ->from('donations')
                  ->where('status_donasi', 'Approved');
        })
        ->update(['status' => 'donated']);
    
        // Update total_donated for existing users using DB facade, berdasarkan table donations yang memiliki user_id dan status_donasi bernilai Approved
        // Set value for total_donated based on conditions
        DB::table('users')
        ->whereNotIn('id', function ($query) {
            $query->select('user_id')
                    ->from('donations')
                    ->where('status_donasi', 'Approved');
        })
        ->update(['total_donated' => 0]);

        DB::table('users')
            ->whereIn('id', function ($query) {
                $query->select('user_id')
                        ->from('donations')
                        ->where('status_donasi', 'Approved');
            })
            ->update(['total_donated' => DB::raw('(
                SELECT COUNT(*) FROM donations
                WHERE users.id = donations.user_id
                AND donations.status_donasi = "Approved"
            )')]);    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('total_donated');
        });

    }
}
