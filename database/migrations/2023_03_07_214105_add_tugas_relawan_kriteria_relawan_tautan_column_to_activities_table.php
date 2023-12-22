<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTugasRelawanKriteriaRelawanTautanColumnToActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('tugas_relawan')->after('detail_activity');
            $table->string('kriteria_relawan')->after('tugas_relawan');
            $table->string('tautan')->after('tipe_activity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['activity_id']); // Replace 'activity_id' with the actual foreign key column name
    
            // Drop columns
            $table->dropColumn('tugas_relawan');
            $table->dropColumn('kriteria_relawan');
            $table->dropColumn('tautan');
        });
    }
    
}
