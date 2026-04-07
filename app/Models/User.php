<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name_lengkap', //ubah 'name' jadi 'nama_lengkap'
        'username', //tambahkan kolom 'username'
        'email', 
        'password',
        'role', //tambahkan kolom role
        'lembaga', //tambahkan kolom lembaga
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // function untuk merubah route key dari {id} menjadi {username}
    // agar data yang muncul di url = username 
    // contoh          : http://127.0.0.1:8000/user/1/edit
    // diubah menjadi  : http://127.0.0.1:8000/user/nabilaptr/edit
    public function getRouteKeyName() : string 
    {
        return 'username';
    }
}
