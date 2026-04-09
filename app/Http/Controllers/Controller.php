<?php

namespace App\Http\Controllers;
// ! diipanggil agar semua controller bisa memanggil method authorize Policy
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    // ? ini digunakan agar semua Controller terhubung dengan policy
    use AuthorizesRequests;
}
