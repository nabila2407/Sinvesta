<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lokasis', function (Blueprint $table) {
            $table->id();

            // untuk menyimapn data kode_lokasi | maks 20 karakter | harus unik
            $table->string('kode_lokasi', 20)->unique();

            // untuk menyimpanan data nama_lokasi | maks 100 karakter
            $table->string('nama_lokasi', 100);

            // untuk menyimpan deskripsi | text biar muat banyak karakter | nullable = boleh dikosongkan
            $table->text('deskripsi')->nulable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasis');
    }
};
