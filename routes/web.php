<?php

// ! Panggil class AuthController agar bisa digunakan oleh route
use App\Http\Controllers\AuthController;

// ! Panggil class DaftarController agar bisa digunakan oleh route
use App\Http\Controllers\DaftarController;

// ! Panggil class DashboardController agar bisa digunakan oleh route
use App\Http\Controllers\DashboardController;

// ! Panggil class UserController agar bisa digunakan oleh route
use App\Http\Controllers\UserController;

// ! Panggil class KategoriController agar bisa digunakan oleh route
use App\Http\Controllers\KategoriController;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//    return view('welcome');
// });

/**
 * ? Fungsi Group Middleware "Guest"
 * Digunakan khusus untuk menangani permintaan dari user yang belum melakukan autentikasi (login)
 * ! "Guest" = "Tamu" artinya orang yang belum masuk / belum melakukan login ke sistem
 */
Route::middleware('guest')->group(function () {

    /**
     * ? Route untuk menampilkan halaman form login
     * * Panggil AuthController lalu menjalankan function 'index'
     */
    Route::get('/', [AuthController::class, 'index'])->name('login');

    /**
     * ? Route untuk menampilkan halaman form pendaftaran user
     * * Panggil DaftarController lalu menjalankan function 'index'
     */
    Route::get('/daftar', [DaftarController::class, 'index'])->name('daftar.index');

    // TAMBAHKAN INI: Route untuk menerima data pendaftaran
    Route::post('/daftar', [DaftarController::class, 'store'])->name('daftar.store');

    /**
     * ? Route untuk proses login (autentikasi)
     * * Panggil AuthController lalu jalankan function 'login'
     * ! Karena ada data yang dikirim dari form login.bldae.php ke AuthController,
     * ! maka method yang digunakan adalah 'POST'
     */
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

});

/**
 * ? Fungsi Group Middleware "Auth"
 * * Digunakan khusus untuk menangani permintaan dari user yang sudah melakukan autentikasi (login)
 * ! "Auth" = "Autentikasi" artinya orang yang sudah masuk / sudah berhasil login ke sistem
 */
Route::middleware('auth')->group(function () {

    /**
     * ? Route untuk menampilkan halaman dashboard
     * * Panggil DashboardController lalu jalankan function 'index'
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * ? Route untuk menangani permintaan logout
     * karena fitur logout menggunakan form dengan method POST, maka method route juga menggunakan POST
     */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /**
     * ? Route untuk mengelola data user
     * * karena controller yang digunakan adalah controller resource, maka method route juga pake resource
     * * 1 route ini bisa menangani permintaan: index, create, store, show, edit, update dan destory, gokiiiil
     */
    Route::resource('/dashboard/users', UserController::class);
});



/**
 * ? Fungsi Group Middleware Auth dengan role = admin
 * * Digunakan khusus untuk fitur-fitur yang tersedia hanya untuk user yang sudah login dan role = admin
 * ! User yang belum login dan user dengan role = 'user' tidak akan bisa akses fitur didalam group ini
 */
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Gunakan KategoriController agar datanya sesuai
    Route::resource('/dashboard/kategori', KategoriController::class);

    // ? Route untuk fitur ekspor data kategori ke file PDF
    Route::get('/dashboard/export-kategori-to/pdf', [KategoriController::class, 'exportToPdf'])->name('kategori.exportToPdf');
});