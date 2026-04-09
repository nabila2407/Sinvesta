<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * ? menentukan siapa yang bisa melihat semua data user (index)
     */
    public function viewAny(User $user): bool
    {
        // ? yang bisa melihat semua data user (index) hanya role 'admin'
        return $user->role === 'admin';
    }

    /**
     * ? menentukan siapa yang bisa melihat detail user (show)
     */
    public function view(User $user, User $model): bool
    {
        // ? role 'admin' bisa melihat detail semua data user
        if ($user->role === 'admin') {
            return true;
        }

        // ? role 'user' hanya  bisa melihat detail data miliknya sendiri
        return $user->id === $model->id;
    }

    /**
     * ? menentukan siapa yang  bisa menambahkan data user (create) ke database
     */
    public function create(User $user): bool
    {
        // ? hanya role 'admin' yang bisa menambah (create) data user ke database
        return $user->role === 'admin';
    }

    /**
     * ? menentukan siapa yang  bisa mengubah data user (edit)
     */
    public function update(User $user, User $model): bool
    {

        // ? role 'admin' bisa mengubah semua data user
        if ($user->role === 'admin') {
            return true;
        }

        // ? role 'user' hanya bisa menguah data miliknya sendiri
        return $user->id === $model->id;
    }

    /**
     * ? menentukan siapa yang  bisa menghapus (destory) data user
     */
    public function delete(User $user, User $model): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->id === $model-id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
