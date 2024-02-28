<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->foreign(['activity_id'])->references(['id'])->on('activities')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
        // Add trigger to update deadline field in vouchers table
        DB::unprepared('
        CREATE TRIGGER fill_deadline_on_voucher_insert
        BEFORE INSERT ON vouchers
        FOR EACH ROW
        BEGIN
            SET NEW.deadline = (SELECT batas_waktu FROM activities WHERE id = NEW.activity_id);
        END
        ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropForeign('vouchers_activity_id_foreign');
        });
        // Drop trigger if exists
        DB::unprepared('DROP TRIGGER IF EXISTS fill_deadline_on_voucher_insert');
    }
}
