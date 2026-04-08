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

            // untuk menyimpan id kategori
            // jika kategori di hapus, semua dta barang yang memiliki id kategori tersebut juga akan ikut terhapus
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');

            // untuk menyimpan id lokasi
            // jika kategori di hapus, semua dta barang yang memiliki id kategori tersebut juga akan ikut terhapus
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('cascade');

            // untuk menyimpan status barang | pilihannya hanya Baik, Rusak Ringan, Rusak Berat, dan Hilang, selain itu akan error
            $table->enum('status_barang', ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang'])->default('Baik');

            // untuk menyimpan deskripsi barang
            $table->text('deskripsi')->nullable();
            
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
