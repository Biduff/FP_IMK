<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipsntricks', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('gambar');
            $table->text('alat_dan_bahan');
            $table->text('langkah_langkah');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipsntricks');
    }
};
