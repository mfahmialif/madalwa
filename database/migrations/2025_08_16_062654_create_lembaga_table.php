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
            $table->string('nsm');
            $table->string('npsn');
            $table->string('nama_sekolah');
            $table->string('jenjang_sekolah');
            $table->string('status_sekolah');
            $table->string('alamat_lengkap');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('no_telp');
            $table->string('email');
            $table->string('website');
            $table->string('kepala_madrasah');
            $table->string('nip');
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
