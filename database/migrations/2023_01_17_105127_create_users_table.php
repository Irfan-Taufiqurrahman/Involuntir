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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('socialite_id')->nullable();
            $table->string('socialite_name')->nullable();
            $table->string('name')->nullable();
            $table->string('role')->default('User');
            $table->string('tipe')->default('Individu');
            $table->string('username')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('status_akun')->default('Not Verified');
            $table->string('no_telp')->nullable();
            $table->string('usia')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('alamat')->nullable();
            $table->smallInteger('provinsi')->nullable();
            $table->smallInteger('kabupaten')->nullable();
            $table->smallInteger('kecamatan')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('jenis_organisasi')->nullable();
            $table->date('tanggal_berdiri')->nullable();
            $table->string('photo')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('bank')->nullable();
            $table->string('no_rek')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->date('deleted_at')->nullable();

            $table->unique(['email'], 'email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
