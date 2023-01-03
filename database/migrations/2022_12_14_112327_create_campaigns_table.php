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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('category_id')->nullable()->index('campaigns_category_id_foreign');
            $table->unsignedInteger('user_id')->index();
            $table->string('judul_campaign')->nullable();
            $table->string('judul_slug')->nullable();
            $table->mediumText('foto_campaign')->nullable();
            $table->text('foto_campaign_2')->nullable();
            $table->text('foto_campaign_3')->nullable();
            $table->text('foto_campaign_4')->nullable();
            $table->enum('campaign_type', ['event', 'compensation', 'operational', 'construction'])->nullable();
            $table->enum('kategori_penerima_manfaat', ['sendiri', 'keluarga', 'orang_lain'])->nullable();
            $table->text('ajakan')->nullable();
            $table->enum('status_publish', ['published', 'drafted'])->nullable();
            $table->string('nominal_campaign')->nullable();
            $table->string('tag_campaign')->nullable();
            $table->string('regencies')->nullable();
            $table->string('batas_waktu_campaign')->nullable();
            $table->text('cerita_tentang_pembuat_campaign')->nullable();
            $table->text('cerita_tentang_penerima_manfaat')->nullable();
            $table->text('foto_tentang_campaign')->nullable();
            $table->text('cerita_tentang_masalah_dan_usaha')->nullable();
            $table->text('foto_tentang_campaign_2')->nullable();
            $table->text('berapa_biaya_yang_dibutuhkan')->nullable();
            $table->text('kenapa_galangdana_dibutuhkan')->nullable();
            $table->text('foto_tentang_campaign_3')->nullable();
            $table->string('detail_campaign')->nullable();
            $table->longText('update_campaign')->nullable();
            $table->string('kategori_campaign')->nullable();
            $table->string('status')->nullable();
            $table->string('penerima')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('alamat_lengkap')->nullable();
            $table->string('rincian')->nullable();
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
};
