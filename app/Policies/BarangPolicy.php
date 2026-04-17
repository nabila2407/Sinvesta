<?php

namespace App\Policies;

use App\Models\Bast;
use App\Models\User;

class BastPolicy
{
    /**
     * ? menentukan siapa saja yang bisa melihat halaman list Bast
     */
    public function viewAny(User $user): bool
    {
        // ? hanya admin yang bisa melihat halaman list Bast
        return $user->role === 'admin';
    }

    /**
     * ? menentukan siapan saja yang bisa melihat detail Bast
     */
    public function view(User $user, Bast $bast): bool
    {
        // ? yang bisa lihat detail Bast adalah admin
        return $user->role === 'admin'
            || $user->id === $bast->user_serah_id // ? atau user yang jadi user penyerah
            || $user->id === $bast->user_terima_id; // ? atau user yang jadi user penerima

        // ? selain yang diatas ga bisa lihat detail bast
    }

    /**
     * ? menentukan siapa saja yang bisa membuka halaman buat Bast baru
     */
    public function create(User $user): bool
    {
        // ? hanya admin yang bisa membuka halaman buat bast baru
        return $user->role === 'admin';
    }

    /**
     * ? menentukan siapa saja yang bisa membuka halaman edit Bast
     */
    public function update(User $user, Bast $bast): bool
    {
        // ? hanya admin yang bisa membuka halaman edit bast
        return $user->role === 'admin';
    }

    /**
     * ? menentukan siapa saja yang bisa menghapus bast
     */
    public function delete(User $user, Bast $bast): bool
    {
        // ? hanya admin yang bisa menghapus bast
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Bast $bast): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Bast $bast): bool
    {
        return false;
    }

    /**
     * ? menentukan siapa saja yang bisa menyetujui Bast sebagai user penyerah
     */
    public function approveSerah(User $user, Bast $bast)
    {
        // ? hanya user penyerah dibast tersebut dan status bast = menunggu
        // ? yang bisa melakukan approval (menyetujui) sebagai user penyerah
        return $user->id === $bast->user_serah_id
            && $bast->status_serah === 'Menunggu';
    }

    /**
     * ? menentukan siapa saja yang bisa menyetujui Bast sebagai user penerima
     */
    public function approveTerima(User $user, Bast $bast)
    {
        // ? hanya user penerima dibast tersebut dan status bast = menunggu
        // ? yang bisa melakukan approval (menyetujui) sebagai user penerima
        return $user->id === $bast->user_terima_id
            && $bast->status_terima === 'Menunggu';
    }
}
