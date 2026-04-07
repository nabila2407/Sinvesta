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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();

            // untuk menyimpan kode barang | maks 20 karakter | harus unik
            $table->string('kode_barang', 20)->unique();

            // untuk menyimpan nama barang | maks 100 karakter
            $table->string('nama_barang', 100);

            // untuk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
