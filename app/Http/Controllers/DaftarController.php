<?php

namespace App\Http\Controllers;

use App\Models\User;
// ? Panggil Model User agar dapat digunakan oleh function store
use Illuminate\Http\Request;

class DaftarController extends Controller
{
    public function index()
    {
        /**
         * ? function index akan menjalankan view 'daftar.blade.php' di dalam folder 'auth'
         * ? lalu mengirimkan data 'title'
         */
        return view('auth.daftar', [
            'title' => 'Daftar Sinvesta',
        ]);
    }

    /**
     * ? function store digunakan untuk menyimpan data user ke database
     * * gunakan class Request agar dapat menerima data dari view form daftar.blade.php
     */
    public function store(Request $request)
    {
        $aturan = [
            'nama_lengkap' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|string|email|max:100|unique:users,email', // Tambahkan 'email' agar format terjaga
            'password' => 'required|string|min:8|max:32|confirmed',
            'role' => 'required|in:admin,user',
            'lembaga' => 'required|string|max:100',
        ];

        $pesan = [
            'required' => 'Kolom :attribute nggak boleh kosong!!.',
            'unique' => 'Kolom :attribute sudah ada yang pakai!.',
            'email' => 'Kolom :attribute pakai email yang valid dong!.',
            'min' => 'Kolom :attribute minimal :min karakter ya!.',
            'confirmed' => 'Konfirmasi :attribute nggak sama.',
            'in' => 'Kolom :attribute tidak valid.',
            'max' => 'kolom :attribute maksimal :max karakter ya!.',
        ];

        $validatedData = $request->validate($aturan, $pesan);

        // HASHING PASSWORD SEBELUM DISIMPAN
        $validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);

        return redirect()->route('login')->with('berhasil', 'Pendaftaran berhasil! silahkan login.');
    }
}
