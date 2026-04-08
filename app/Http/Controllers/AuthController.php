<?php

namespace App\Http\Controllers;

// ? panggil model User agar bisa digunakan olen function login
use App\Models\User;
// ? panggil class facades Auth agar bisa digunakan olen function login
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
         
{
    public function index ()
    {
        /**
         * ? function index akan menjalankan view 'login.blade.php' di dalam folder 'auth'
         * ? lalu mengirimkan data 'title'
         */
        return view('auth.login', [
            'title' => 'Login Sinvesta',
        ]);
    }

    /**
     * ? function login digunakan untuk proses autentikasi
     * * gunakan class Request agar dapat menerima data dari view form 'login.blade.php'
     */
    public function login(Request $request)
    {
        //? 1. membuat aturan validasi
        $aturan = [
            // username wajib diisi dan harus berupa text
            'username' => 'required|string',
            // password wajib diisi dan harus berupa text
            'password' => 'required|string',
        ];

        //? 2. pesan jika data yang dikirim tidak valid (tidak sesuai aturan diatas)
        $pesan = [
            'required' => ':attribute nggak boleh kosong ya!.',
            'string' => ':attribute harus berupa teks.',
        ];

        //? 3. lakukan validasi data
        $request->validate($aturan, $pesan);

        //? 4. cek apakah username sudah terdaftar
        $user = User::where('username', $request->username)->first();

        // jika user tidak ditemukan
        if (!$user) {
            // kirim pesan error di kolom username
            return back()->withErrors([
                'username' => 'Username tidak terdaftar.',
            ])->withInput();
        }
        // jika username sudah terdaftar, lanjut ke proses 5

        //? 5. Coba login menggunakan Class Auth
        // atur data yang digunkan untuk autentikasi = username dan password (defaultnya email)
        $credentials = $request->only('username', 'password');
        // jika proses login gagal
        if (!Auth::attempt($credentials)) {
            // kirim pesan error di kolom password
            return back()->withError([
                'password' => 'Ups! sepertinya password yang kamu masukan salah!.',
            ])->withInput();
        }
        // jika proses login berhasil, lanjut ke proses ke 6

        //? 6. regenerasi session (keamanan) dan simpan data user yang sedang login di browser
        $request->session()->regenerate();

        //? 7. alihkan ke halaman dashboard
        //! karena kita belum punya route dashboard, kita cukup tampilkan teks
        // return "Gokiiil!, proses login berhasil, welcome ". Auth::user()->nama_lengkap;
        return redirect()->route('dashboard');
    }

    /**
     * ? function logout untuk menangani permintaan logout user
     * * gunakan class Request agar dapat menerima data dari tombol form logout
     */
    public function logout(Request $request)
    {
        // ? keluar dari sistem
        Auth::logout();

        // ? hapus session dari browser
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // ? alihkan ke halaman login
        return redirect(route('login'));
    }
}
