<?php

namespace App\Http\Controllers;
// Model
use App\Models\DataReqModel;
use App\Models\DataRejectModel;
use App\Models\UnitModel;
use App\Models\UnitUser;
use App\Models\KaryawanModel;
use App\Models\UserModel;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class AkunController extends Controller
{
    public function akun_external()
    {
        $name_page  = "B'Mine - External Akun";
        $dataKar = UserModel::all();
        return view('akun.external', compact('dataKar','name_page'));
    }

    public function akun_internal()
    {
         $name_page  = "B'Mine - Add Account";
        $dataKar = karyawanModel::all();
        return view('akun.internal', compact('dataKar','name_page'));
    }
    public function tambah_internal()
    {
       $name_page  = "B'Mine - Add Account";
        $dataKar = karyawanModel::all();
        return view('akun.add_internal', compact('dataKar','name_page'));
    }
    public function tambah_external()
    {
        $name_page  = "B'Mine - Add Account";
        $dataKar = karyawanModel::all();
        return view('akun.add_external', compact('dataKar','name_page'));
    }

     public function store_external(Request $request)
    {
        // Validate request data
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:login_external,email',
            'password' => 'required|min:6|confirmed',
            'level' => ['required', Rule::in(['bec', 'ktt'])],
        ];

        // Add area validation only if level is ktt
        if ($request->level == 'ktt') {
            $rules['area'] = 'required|string|max:255';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create new external account
        $account = new UserModel();
        $account->nama = $request->nama;
        $account->email = $request->email;
        $account->password = md5($request->password);
        $account->level = $request->level;
        
        // Set area only if level is ktt
        if ($request->level == 'ktt') {
            $account->area = $request->area;
        } else {
            $account->area = null;
        }
        
        $account->save();

        return redirect()->route('dataaccounts_ext.view')
            ->with('success', 'External account has been created successfully');
    }


public function update_level(Request $request)
{
    try {
        $request->validate([
            'nik' => 'required',
            'level' => 'required|in:admin,section_admin,she,pjo,user',
        ]);
        
        // Mencari akun berdasarkan NIK menggunakan KaryawanModel
        $karyawan = KaryawanModel::where('nik', $request->nik)->first();
        
        if (!$karyawan) {
            return redirect()->route('dataaccounts_int.view')->with('error', 'Account not found');
        }
        
        // Menyimpan level lama untuk log
        $oldLevel = $karyawan->level;
        
        // Update level - karena timestamps dinonaktifkan, ini seharusnya bekerja dengan baik
        $karyawan->level = $request->level;
        $karyawan->save();
        
        // Log perubahan level (dengan namespace yang benar)
        Log::info("Account level changed: NIK {$request->nik} from {$oldLevel} to {$request->level}");
        
        return redirect()->route('dataaccounts_int.view')->with('success', 'Account level has been updated successfully');
    } catch (\Exception $e) {
        return redirect()->route('dataaccounts_int.view')->with('error', 'Failed to update account level: ' . $e->getMessage());
    }
}

/**
 * Delete an internal account
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function delete_internal(Request $request)
{
    try {
        $nik = $request->input('nik');
        
        // Find and delete the account using your KaryawanModel
        $karyawan = KaryawanModel::where('nik', $nik)->first();
        
        if (!$karyawan) {
            return redirect()->route('dataaccounts_int.view')
                ->with('error', 'Account not found');
        }
        
        $accountName = $karyawan->nama;
        $karyawan->delete();
        
        return redirect()->route('dataaccounts_int.view')
            ->with('success', "Account for $accountName has been deleted successfully");
            
    } catch (\Exception $e) {
        return redirect()->route('dataaccounts_int.view')
            ->with('error', 'Failed to delete account: ' . $e->getMessage());
    }
}

public function delete_external(Request $request)
{
    try {
        $id = $request->input('id');
        
        // Find the account using id_login_ext column
        $user = UserModel::where('id_login_ext', $id)->first();
        
        if (!$user) {
            return redirect()->route('dataaccounts_ext.view')
                ->with('error', 'Account not found');
        }
        
        $accountName = $user->nama;
        
        // Delete using the correct primary key column
        UserModel::where('id_login_ext', $id)->delete();
        
        return redirect()->route('dataaccounts_ext.view')
            ->with('success', "Account for $accountName has been deleted successfully");
            
    } catch (\Exception $e) {
        return redirect()->route('dataaccounts_ext.view')
            ->with('error', 'Failed to delete account: ' . $e->getMessage());
    }
}

public function changePassword()
{
    $name_page = "B'Mine - Change Password";
    return view('setting.update_password', compact('name_page'));
}

/**
 * Update the user's password.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\RedirectResponse
 */
/**
 * Update the user's password.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function updatePassword(Request $request)
{
    // Validate the form data
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|confirmed|min:8',
        'new_password_confirmation' => 'required',
    ]);

    // Get user identifier and level from session
    $userIdentifier = session('logged_in_user')['identifier'];
    $userLevel = session('logged_in_user')['level'];

    // Determine if user is internal or external based on level
    $isInternal = in_array($userLevel, ['admin', 'she', 'pjo']);
    $isExternal = in_array($userLevel, ['bec', 'ktt']);

    try {
        // Determine the model to use based on user level
        if ($isExternal) {
            // For external users (bec & ktt)
            $user = UserModel::where('email', $userIdentifier)->first();
            
            if (!$user) {
                return back()->with('error', 'User not found');
            }
            
            // Check if current password matches
            if (md5($request->current_password) !== $user->password) {
                return back()->with('error', 'Current password is incorrect');
            }
            
            // Update the password
            UserModel::where('email', $userIdentifier)
                ->update(['password' => md5($request->new_password)]);
        } elseif ($isInternal) {
            // For internal users (admin, she, pjo)
            $user = KaryawanModel::where('nik', $userIdentifier)->first();
            
            if (!$user) {
                return back()->with('error', 'User not found');
            }
            
            // Check if current password matches
            if (md5($request->current_password) !== $user->password) {
                return back()->with('error', 'Current password is incorrect');
            }
            
            // Update the password
            KaryawanModel::where('nik', $userIdentifier)
                ->update(['password' => md5($request->new_password)]);
        } else {
            // Handle any other level not defined
            return back()->with('error', 'Unknown user level');
        }

        return back()->with('success', 'Your password has been updated successfully');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to update password: ' . $e->getMessage());
    }
}

 public function store_internal(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nik' => [
                'required',
                Rule::unique('karyawan', 'nik'),
            ],
            'nama' => 'required|string|max:100',
            'departement' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('karyawan', 'email'),
            ],
            'level' => 'required|string|in:admin,user,she,pjo,section_admin',
        ], [
            'nik.required' => 'NIK is required',
            'nik.unique' => 'NIK has already been taken',
            'nama.required' => 'Name is required',
            'departement.required' => 'Department is required',
            'jabatan.required' => 'Position is required',
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email format',
            'email.unique' => 'Email has already been taken',
            'level.required' => 'Level is required',
            'level.in' => 'Invalid level',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dataaccounts_int.tambah')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Buat akun baru - gunakan password langsung karena model sudah menghandle bcrypt
            KaryawanModel::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'departement' => $request->departement,
                'jabatan' => $request->jabatan,
                'email' => $request->email,
                'level' => $request->level,
                'status_mp' => 'Active',
                'password' => md5('12345678'), // Model akan mengenkripsi
            ]);

            return redirect()
                ->route('dataaccounts_int.view')
                ->with('success', 'Akun internal berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->route('dataaccounts_int.view')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}
