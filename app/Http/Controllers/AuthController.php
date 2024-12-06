<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\UserModel;

use Illuminate\Support\Facades\Auth;
class AuthController extends Controller {

    public function login() {
        return view('auth.login');
    }

   public function auth(Request $request) {
    // Validasi input NIK/email dan password
    $request->validate([
        'identifier' => 'required', // Bisa NIK atau email
        'password' => 'required',
    ]);
    // Ambil token API dari file .env
    $token = env('BMINE_API_TOKEN');

    // Cek apakah identifier adalah email atau NIK
    if (filter_var($request->identifier, FILTER_VALIDATE_EMAIL)) {
        // Jika identifier adalah email, gunakan database user_external
        $user = UserModel::where('email', $request->identifier)->first();
    } else {
        // Jika identifier adalah NIK, gunakan API eksternal
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://restapi.bmineapp.com/public/karyawan/' . $request->identifier);

        if ($response->successful()) {
            $user = $response->json();
        } else {
            return redirect()->back()->with('error', 'NIK tidak ditemukan atau API error.');
        }
    }

    if ($user) {
        // Verifikasi password MD5
        if (md5($request->password) === $user['password']) {
            // Cek level akun pengguna
            $level = $user['level'];

            // Simpan data pengguna ke dalam sesi
            Session::put('logged_in_user', [
                'identifier' => $request->identifier,
                'nama' => $user['nama'],
                'level' => $level,
            ]);

            // Regenerasi sesi
            $request->session()->regenerate();

            // Arahkan pengguna sesuai dengan level akun
            if ($level == true) {
                return redirect('/dashboard')->with('success', 'Login berhasil sebagai Admin');
            } else {
                return redirect()->back()->with('error', 'Tidak ada level akun yang cocok.');
            }
        } else {
            return redirect()->back()->with('error', 'Password salah.');
        }
    } else {
        return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
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
