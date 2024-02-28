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
        });

        // Update 'status' field based on 'user_id' presence in 'donations' table
        DB::table('users')->update(['status' => 'not yet donated']);
        DB::table('users')
            ->whereIn('id', function ($query) {
                $query->select('user_id')->from('donations');
            })
            ->update(['status' => 'donated']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop 'status' field
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
        });

    }
}
