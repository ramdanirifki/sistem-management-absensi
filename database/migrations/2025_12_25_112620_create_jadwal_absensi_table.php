<?php
// database/migrations/xxxx_create_jadwal_absensi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_absensi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jadwal');
            $table->string('kode_jadwal')->unique();
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->integer('toleransi_keterlambatan')->default(15); 
            $table->boolean('is_default')->default(false);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_absensi');
    }
};
