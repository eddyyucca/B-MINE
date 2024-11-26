<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EnsureUserIsLoggedIn
{
    /**
     * Menangani permintaan masuk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Memeriksa apakah pengguna terautentikasi
        if (!Session::has('logged_in_user')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data pengguna dari session
        $loggedInUser = Session::get('logged_in_user');

        // Memeriksa apakah level pengguna ada
        if (!isset($loggedInUser['level']) || empty($loggedInUser['level'])) {
            return redirect('/login')->with('error', 'Akses ditolak: Level akun tidak valid.');
        }

        return $next($request);
    }
}