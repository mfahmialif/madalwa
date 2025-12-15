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
        Schema::create('kamar', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kamar');
            $table->unsignedBigInteger('unit_sekolah_id');
            $table->unsignedBigInteger('tahun_pelajaran_id');
            $table->text('keterangan')->nullable();
            $table->integer('kapasitas')->nullable();
            $table->timestamps();

            $table->foreign('unit_sekolah_id')->references('id')->on('unit_sekolah');
            $table->foreign('tahun_pelajaran_id')->references('id')->on('tahun_pelajaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kamar');
    }
};
