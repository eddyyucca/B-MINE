<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Tambahkan ini

class AuthController extends Controller {

    public function login() {
        return view('auth.login');
    }

    public function auth(Request $request) {
        // Validasi input NIK dan password
        $request->validate([ 'nik'=> 'required',
            'password'=> 'required',
            ]);

        // Ambil token API dari file .env (untuk keamanan, token tidak dimasukkan di hardcode)
        $token=env('BMINE_API_TOKEN');

        // Kirim request ke REST API eksternal untuk verifikasi login
        $response=Http::withHeaders([ 'Authorization'=> 'Bearer '. $token,
                ])->get('https://rest-api-peoplesync.bmine.id/karyawan/'. $request->nik);

        // Cek apakah request API berhasil dan data ditemukan
        if ($response->successful()) {
            $userData=$response->json(); // Ambil data dari respons API

            // Verifikasi password MD5 (karena password disimpan dalam format MD5)
            if (md5($request->password)===$userData['password']) {
                // Cek level akun pengguna
                $level=$userData['level'];

                // Arahkan pengguna sesuai dengan level akun
                if ($level==='admin') {
                    // Redirect ke halaman dashboard admin
                    return redirect('/dashboard')->with('success', 'Login berhasil sebagai Admin');
                }

                elseif ($level==='user') {
                    // Redirect ke halaman dashboard user biasa
                    return redirect('/dashboard')->with('success', 'Login berhasil sebagai User');
                }

                else {
                    return view('auth.login')->with('error', 'Tidak ada level akun yang cocok.');
                }
            }

            else {
                return view('auth.login')->with('error', 'Password salah.');
            }


            // Jika API gagal atau data tidak ditemukan
            return response()->json([ 'success'=> false,
                'message'=> 'NIK tidak ditemukan atau API error.',
                ], 404);
        }
    }

    public function logout(Request $request) {
        // Hapus semua token pengguna yang aktif
        $request->user()->tokens()->delete();

        return response()->json(['message'=> 'Logged out successfully'], 200);
    }

}
