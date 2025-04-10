<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\UserModel;
use App\Models\KaryawanModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller {

   /**
 * Display the login page
 * 
 * @return \Illuminate\View\View
 */
public function login()
{
    return view('auth.login');
}

public function auth(Request $request)
{
    // Validate input
    $request->validate([
        'identifier' => 'required', // Can be NIK or email
        'password' => 'required',
    ]);

    try {
        // Determine if identifier is email or NIK
        $isEmail = filter_var($request->identifier, FILTER_VALIDATE_EMAIL);
        
        // Find user based on identifier type
        $user = $isEmail 
            ? $this->findUserByEmail($request->identifier)
            : $this->findUserByNIK($request->identifier);
            
        if (!$user) {
            return redirect()->back()->with('error', 'Account Not Found.');
        }
        
        // Verify password
        if (!$this->verifyPassword($request->password, $user)) {
            return redirect()->back()->with('error', 'Incorrect password.');
        }
        
        // Extract user attributes
        $level = $user['level'] ?? null;
        $departement = $user['departement'] ?? null;
        $area = $user['area'] ?? null;
        
        if (!$level) {
            return redirect()->back()->with('error', 'No matching account level found.');
        }
        
        // Create session
        $this->createUserSession($request, [
            'identifier' => $request->identifier,
            'nama' => $user['nama'] ?? $user->name,
            'level' => $level,
            'departement' => $departement,
            'area' => $area,
        ]);
        
        // Check if password is still the default (12345678)
        $defaultPasswordMd5 = '25d55ad283aa400af464c76d713c07ad'; // MD5 of 12345678
        $userPassword = $user['password'] ?? $user->password;
        
        if ($userPassword === $defaultPasswordMd5) {
            // Set session flag for password change requirement
            Session::put('password_change_required', true);
            // Redirect to dashboard with warning about password change
            return redirect('/dashboard')->with('warning', 'Please change your default password.');
        }
        
        return redirect('/dashboard')->with('success', 'Login successful as Admin');
        
    } catch (Exception $e) {
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}

/**
 * Find user by email
 * 
 * @param string $email
 * @return mixed
 */
private function findUserByEmail($email)
{
    return UserModel::where('email', $email)->first();
}

/**
 * Find user by NIK
 * 
 * @param string $nik
 * @return mixed
 */
private function findUserByNIK($nik)
{
    return KaryawanModel::where('nik', $nik)->first();
}

/**
 * Verify user password
 * 
 * @param string $inputPassword
 * @param mixed $user
 * @return bool
 */
private function verifyPassword($inputPassword, $user)
{
    $storedPassword = $user['password'] ?? $user->password;
    return md5($inputPassword) === $storedPassword;
}

/**
 * Create user session
 * 
 * @param Request $request
 * @param array $userData
 * @return void
 */
private function createUserSession(Request $request, array $userData)
{
    Session::put('logged_in_user', $userData);
    $request->session()->regenerate();
}
/**
 * Handle user logout
 * 
 * @param Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function logout(Request $request)
{
    // Remove user session data
    Session::forget('logged_in_user');
    
    // Invalidate the session
    $request->session()->invalidate();
    
    // Regenerate CSRF token
    $request->session()->regenerateToken();
    
    return redirect('/login')->with('success', 'You have been logged out.');
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
