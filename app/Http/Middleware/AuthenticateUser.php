<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Cek apakah pengguna sudah login berdasarkan session
        if (!Session::has('logged_in_user')) {
            // Jika belum login, redirect ke halaman login
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Jika sudah login, izinkan akses ke halaman yang diinginkan
        return $next($request);
    }
}
