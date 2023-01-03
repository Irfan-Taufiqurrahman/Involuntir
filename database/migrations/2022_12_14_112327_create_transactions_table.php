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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->index('transactions_user_id_foreign');
            $table->unsignedBigInteger('balance_id')->index('transactions_balance_id_foreign');
            $table->string('invoice_id')->unique();
            $table->bigInteger('amount');
            $table->enum('payment_method', ['emoney', 'bank_payment'])->default('bank_payment');
            $table->string('payment_name')->nullable();
            $table->text('qr_code')->nullable();
            $table->string('va_number')->nullable();
            $table->timestamp('deadline')->useCurrentOnUpdate()->useCurrent();
            $table->enum('status', ['pending', 'rejected', 'approved'])->default('pending');
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
        Schema::dropIfExists('transactions');
    }
};
