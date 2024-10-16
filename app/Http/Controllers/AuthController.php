<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller {

    public function login() {
        return view('auth.login');
    }

    public function auth(Request $request) {
        // Validasi input NIK dan password
        $request->validate([
            'nik' => 'required',
            'password' => 'required',
        ]);

        // Ambil token API dari file .env
        $token = env('BMINE_API_TOKEN');

        // Kirim request ke REST API eksternal untuk verifikasi login
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://rest-api-peoplesync.bmine.id/karyawan/' . $request->nik);

        if ($response->successful()) {
            $userData = $response->json();

            // Verifikasi password MD5
            if (md5($request->password) === $userData['password']) {
                // Cek level akun pengguna
                $level = $userData['level'];

                // Simpan data pengguna ke dalam sesi
                Session::put('logged_in_user', [
                    'nik' => $userData['nik'],
                    'nama' => $userData['nama'],
                    'level' => $level,
                ]);

                // Regenerasi sesi
                $request->session()->regenerate();

                // Arahkan pengguna sesuai dengan level akun
                if ($level === 'admin') {
                    return redirect('/dashboard')->with('success', 'Login berhasil sebagai Admin');
                } elseif ($level === 'user') {
                    return redirect('/dashboard')->with('success', 'Login berhasil sebagai User');
                } else {
                    return redirect()->back()->with('error', 'Tidak ada level akun yang cocok.');
                }
            } else {
                return redirect()->back()->with('error', 'Password salah.');
            }
        } else {
            return redirect()->back()->with('error', 'NIK tidak ditemukan atau API error.');
        }
    }

    public function logout(Request $request) {
        // Hapus semua data pengguna dari sesi
        Session::forget('logged_in_user');

        // Hapus sesi
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }

}
