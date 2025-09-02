<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UnitSekolahUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_sekolah_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_sekolah_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('unit_sekolah_id')->references('id')->on('unit_sekolah')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('unit_sekolah_user');
    }
}
