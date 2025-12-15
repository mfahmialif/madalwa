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
        Schema::create('kamar_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kamar_id');
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('kelas_id'); // To track which class the student was in when assigned to this room
            $table->unsignedBigInteger('tahun_pelajaran_id');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('kamar_id')->references('id')->on('kamar');
            $table->foreign('siswa_id')->references('id')->on('siswa');
            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->foreign('tahun_pelajaran_id')->references('id')->on('tahun_pelajaran');

            // Unique constraint: one student can only have one room per class
            $table->unique(['siswa_id', 'kelas_id'], 'unique_siswa_kelas_kamar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kamar_siswa');
    }
};
