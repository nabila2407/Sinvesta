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
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();

            // kolom untuk menyimpan kode_kategori | maks 20 karakter | harus unik
            $table-> string('kode_kategori', 20)->unique();

            // kolom untuk penyimpan nama_kategori | maks 100 karakter
            $table->string('nama_kategori', 100);

            // kolom untuk menyimpan deskripsi kategori | type text agar muat banyak karakter || nullable = boleh dikosongkan
            $table->text('deskripsi')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
