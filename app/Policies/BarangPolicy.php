<?php

namespace App\Policies;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BarangPolicy
{
    /**
     * ? menentukan siapa saja yang bisa melihat list data barang (index)
     */
    public function viewAny(User $user): bool
    {
        // ? hanya user dengan role = admin yang bisa melihat lihat data barang
        return $user->role === 'admin';
    }

    /**
     * ? menentukan siapa saja yang bisa melihat detail barang (show)
     */
    public function view(User $user, Barang $barang): bool
    {
        // ? semua role baik admin maupun user bisa melihat detail barang
        return true;
    }

    /**
     * ? menentukan siapa saja yang bisa menambahkan data barang baru (create)
     */
    public function create(User $user): bool
    {
        // ? hanya user dengan role = admin yang bisa menambah data baru ke database
        return $user->role === 'admin';
    }

    /**
     * ? menentukan siapa saja yang bisa memperbarui data barang (update/edit)
     */
    public function update(User $user, Barang $barang): bool
    {
        // ? hanya user dengan role = admin yang bisa memperbarui data barang
        return $user->role === 'admin';
    }

    /**
     * ? menentukan siapa saja yang bisa menghapus data barang (destroy)
     */
    public function delete(User $user, Barang $barang): bool
    {
        // ? hanya user dengan role = admin yang bisa menghapus data barang
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}