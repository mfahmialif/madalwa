<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLembagaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lembaga', function (Blueprint $table) {
            $table->id();
            $table->string('nsm')->nullable();
            $table->string('npsn')->nullable();
            $table->string('nama_sekolah')->nullable();
            $table->string('jenjang_sekolah')->nullable();
            $table->string('status_sekolah')->nullable();
            $table->string('alamat_lengkap')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('kepala_madrasah')->nullable();
            $table->string('nip')->nullable();
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
        Schema::dropIfExists('lembaga');
    }
}
