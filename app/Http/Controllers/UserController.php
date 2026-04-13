<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * ? menampilkan semua data user
     */
    public function index()
    {
        // ? panggil function viewAny UserPolic untuk menentukan siapa yang bisa akses view index
        $this->authorize('viewAny', User::class);

        // ? jalankan view index.blade.php di folder users, sambil kirimkan data :
        return view('dashboard.users.index', [
            'title' => 'Daftar Pengguna Sinvesta', // judul halaman
            'users' => User::latest()->get(), // semua data user diurutkan berdasarkan yang terbaru
        ]);

    }

    /**
     * ? menampilkan halaman formulir tambah user baru
     */
    public function create()
    {
        // ? panggil function create UserPolicy untuk menentukan siapa yang bisa akses view create
        $this->authorize('create', User::class);

        // ? jalankan view create.blade.php di folder dashboard/users
        return view('dashboard.users.create', [
            'title' => 'Tambahkan Pengguna Baru',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ? 1. Buat aturan validasi, agar user tidak memasukkan data sembarangan
        $aturan = [
            // nama_lengkap wajib diisi, harus berupa text, maks 100 karakter
            'nama_lengkap' => 'required|string|max:100',
            // usernmae wajib diisi, harus berupa text, maks 50 karakter, harus unik
            'username' => 'required|string|max:50|unique:users,username',
            // email wajib diisi, harus berupa email yg valid, maks 100 karakter, harus unik
            'email' => 'required|email|max:100|unique:users,email',
            // password wajib diisi, harus berupa text, min 8 karakter, maks 32 karakter, harus sama dengan konfirmasi password
            'password' => 'required|string|min:8|max:32|confirmed',
            // role wajib diisi, pilihan hanya 2 'admin' atau 'user'
            'role' => 'required|in:admin,user',
            // lembaga wajib diisi, harus berupa text, maks 100 karakter
            'lembaga' => 'required|string|max:100',
        ];

        // ? 2. Tentukan pesan error saat data yang dikirim tidak valid (tidak sesuai aturan diatas)
        $pesan = [
            'required' => 'Kolom :attribute nggak boleh kosong!!.',
            'unique' => 'Kolom :attribute sudah ada yang pakai!.',
            'email' => 'Kolom :attribute pakai email yang valid dong!.',
            'min' => 'Kolom :attribute minimal :min karakter ya!.',
            'confirmed' => 'Konfirmasi :attribute nggak sama.',
            'in' => 'Kolom :attribute tidak valid.',
            'max' => 'Kolom :attribute maksimal :max karakter ya!.',
        ];

        // ? 3. Lakukan validasi data
        $validatedData = $request->validate($aturan, $pesan);

        // ? 4. Simpan data yang sudah divalidasi ke databse melalui Model User
        User::create($validatedData);

        // ? 5. Alihkan ke halaman login dengan pesan sukses
        return redirect()->route('users.index')->with('berhasil', 'Yes! Data User Berhasil Disimpan!.');
    }

    /**
     * ? menampilkan detail 1 data
     */
    public function show(User $user)
    {
        /**
         * ? menampilkan detail 1 data user
         */
        // * pada tabel user, kita tidak akan menampilkan halaman detail
        // * kita akan langsung mengalihkan ke form edit data user
        return redirect()->route('users.edit', $user);

    }

    /**
     * ? menampilkan form edit user
     */
    public function edit(User $user)
    {
        // ? panggil function update UserPolicy untuk menentukan siapa yang bisa mengubah data user
        $this->authorize('update', $user);

        // ? jalankan view edit.blade.php di folder dashboard/users, sambil kirim data:
        return view('dashboard.users.edit', [
            'title' => 'Edit Pengguna', // judul halaman
            'user' => $user, // data user yang mau di ubah
        ]);
    }

    /**
     * ? Perbarui 1 data user ke database
     */
    public function update(Request $request, User $user)
    {
        // ? 1. membuat aturan validasi untuk nama dan lembaga
        $aturan = [
            'nama_lengkap' => 'required|string|max:100',
            'lembaga' => 'required|string|max:100',
        ];

        // ? 2. jika username diubah, tambahkan aturan untuk username yang baru
        if ($request->username !== $user->username) {
            // username wajib diisi, harus berupa text, maks 50 karakter, harus unik
            $aturan['username'] = 'required|string|max:50|unique:users,username';
        }

        // ? 3. jika email diubah, tambahkan aturan untuk email yang baru
        if ($request->email !== $user->email) {
            // email wajib diisi, harus berupa email yg valid, maks 100 karakter, harus unik
            $aturan['email'] = 'required|email|max:100|unique:users,email';
        }

        // ? 4. jika kolom password diisi, tambahkan aturan untuk password yang baru
        if ($request->password) {
            // password wajib diisi, harus berupa text, min 8 karakter, maks 32 karakter, harus sama dengan konfirmasi password
            $aturan['password'] = 'string|min:8|confirmed';
        }

        // ? 5. KEAMANAN TAMBAHAN, hanya admin yang bisa memperbarui role
        if (Auth::user()->role === 'admin') {
            // role wajib diisi, pilihan antara 'admin' dan 'user'
            $aturan['role'] = 'required|in:admin,user';
        }

        // ? 6. Pesan validasi
        $pesan = [
            'required' => 'Kolom :attribute nggak boleh kosong!!.',
            'unique' => 'Kolom :attribute sudah ada yang pakai!.',
            'email' => 'Kolom :attribute pakai email yang valid dong!.',
            'min' => 'Kolom :attribute minimal :min karakter ya!.',
            'confirmed' => 'Konfirmasi :attribute nggak sama.',
            'in' => 'Kolom :attribute tidak valid.',
            'max' => 'Kolom :attribute maksimal :max karakter ya!.',
        ];

        // ? 7. validasi data dari request
        $validatedData = $request->validate($aturan, $pesan);

        // ? 8. jika password diganti, password yang baru diubah kedalam bentuk enkripsi
        if ($request->password) {
            $validatedData['password'] = bcrypt($request->password);
        }

        // ? 9. update data user dengan data yang sudah divalidasi
        $user->update($validatedData);

        // ? 10. kembali ke halaman edit user sambil kirim pesan konfirmasi berhasil
        return redirect()->route('users.edit', $user)->with('berhasil', 'Yeaay! Data Pengguna berhasil diperbarui.');
    }

    /**
     * ? hapus 1 data user yang dipilih
     */
    public function destroy(User $user)
    {
        // ? panggil function delete UserPolicy untuk menentukan siapa yang bisa menghapus data user
        $this->authorize('delete', $user);

        // ? hapus user dari database
        $user->delete();

        // ? alihkan ke halaman list data pengguna
        return redirect()->route('users.index')->with('berhasil', 'User berhasil dihapus!');
    }
}
