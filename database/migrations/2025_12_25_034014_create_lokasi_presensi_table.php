<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lokasi_presensis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat');
            $table->decimal('latitude', 10, 8); // -90.00000000 to 90.00000000
            $table->decimal('longitude', 11, 8); // -180.00000000 to 180.00000000
            $table->integer('radius_meter')->default(10); // Radius dalam meter
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lokasi_presensis');
    }
};