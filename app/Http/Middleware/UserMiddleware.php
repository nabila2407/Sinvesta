<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// ? panggil class facades Auth agar dapat digunakan di function handle
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        /**
         * ? jika user belum login
         * ? atau role user tidak sama dengan role yang ditentukan di middleware group
         */
        if (! Auth::check() || Auth::user()->role !== $role) {

            // ? alihkan user ke halaman abort 403
            abort(403);
        }
        return $next($request);
    }
}
