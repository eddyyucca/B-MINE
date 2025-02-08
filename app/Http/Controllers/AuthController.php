<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller {

    public function login() {
        return view('auth.login');
    }

  public function auth(Request $request)
{
    // Validasi input NIK/email dan password
    $request->validate([
        'identifier' => 'required', // Bisa NIK atau email
        'password' => 'required',
    ]);

    // Ambil token API dari file .env
    $token = env('BMINE_API_TOKEN');

    $user = null; // Default user

    try {
        // Cek apakah identifier adalah email atau NIK
        if (filter_var($request->identifier, FILTER_VALIDATE_EMAIL)) {
            // Jika identifier adalah email, gunakan database user_external
            $user = UserModel::where('email', $request->identifier)->first();
        } else {
            // Jika identifier adalah NIK, gunakan API eksternal
            $identifier = $request->identifier;
            $response = Http::withToken($token)
                ->timeout(10) // Timeout untuk mencegah permintaan lama
                ->get('http://localhost:8088/rest_api/karyawan/' . $identifier);
  
            if ($response->successful()) {
                $user = $response->json();
            } else {
                return redirect()->back()->with('error', 'NIK tidak ditemukan atau API error: ' . $response->status());
            }

        }
        // Verifikasi user dan password
        if ($user && md5($request->password) === ($user['password'] ?? $user->password)) {
            // Cek level akun pengguna
            $level = $user['level'] ?? null;
            $departement = $user['departement'] ?? null;
            // Simpan data pengguna ke dalam sesi
            Session::put('logged_in_user', [
                'identifier' => $request->identifier,
                'nama' => $user['nama'] ?? $user->name,
                'level' => $level,
                'departement' => $departement,
            ]);

            // Regenerasi sesi
            $request->session()->regenerate();

            // Arahkan pengguna sesuai dengan level akun
            if ($level) {
                return redirect('/dashboard')->with('success', 'Login berhasil sebagai Admin');
            } else {
                return redirect()->back()->with('error', 'Tidak ada level akun yang cocok.');
            }
        } else {
            return redirect()->back()->with('error', 'Password salah.');
        }
    } catch (Exception $e) {
        // Tangani exception
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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

     public function resetPassword(Request $request)
    {
        // Validasi input NIK
        $request->validate([
            'nik' => 'required|string', // Pastikan NIK wajib diisi dan berupa string
        ]);
        // Ambil NIK dari request
        $nik = $request->input('nik');

        try {
            // Ambil token API dari .env
            $token = env('BMINE_API_TOKEN');

            // Kirim permintaan ke REST API
            $response = Http::withToken($token)
                ->timeout(10)
                ->put("http://localhost:8088/rest_api/karyawan/{$nik}/reset-password");
            // Periksa apakah permintaan berhasil
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Password berhasil direset.');
                // echo "Password berhasil direset.";
            } else {
                return redirect()->back()->with('error', 'Gagal mereset password: ' . $response->status());
            // echo "Gagal mereset password: " . $response->status();
            }
        } catch (\Exception $e) {
            // Tangani error lainnya
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
