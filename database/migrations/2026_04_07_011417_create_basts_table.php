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
        Schema::create('basts', function (Blueprint $table) {
            $table->id();

            // untuk menyimpan id barang 
            // jika barang dihapus, maka data bast yang ada barang tersebut akan ikut terhapus
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');

            // untuk menyimpan id user penyerah 
            // jika user dihapus dari sistem, maka data bast yang ada user tersebut akan ikut terhapus
            $table->foreignId('user_serah_id')->constrained('users')->onDelete('cascade');

            // untuk menyimpan id user penerima
            // jika user dihapus dari sistem, maka data bast yang ada user tersebut akan ikut terhapus
            $table->foreignId('user_terima_id')->constrained('users')->onDelete('cascade');

            // untuk menyimpan status penyerah | pilihannya hanya 2, 'Menunggu' 'atau 'Disetujui', selain itu error
            $table->enum('status_serah', ['Menunggu', 'Disetujui'])->default('Menunggu');

            // untuk menyimpan status penerima | pilihannya hanya 2, 'Menunggu' 'atau 'Disetujui', selain itu error
            $table->enum('status_terima', ['Menunggu', 'Disetujui'])->default('Menunggu');

            // untuk menyimpan path file pdf hasil export
            $table->text('file_export')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basts');
    }
};
