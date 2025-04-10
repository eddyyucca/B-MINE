<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\UnitModel;
use App\Models\DataReqModel;
use App\Models\UnitUser;
use App\Models\KaryawanModel;
use App\Models\DataRejectModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class RequestController extends Controller {

    public function index() {
        $name_page  = "B'Mine - Request";
        return view('request.request' ,compact('name_page'));
    }

    public function not_found() {
        $name_page  = "B'Mine - Date Employee";
        return view('request.not_found',compact('name_page'));
    }

 public function get_data_nik(Request $request)
{
    try {
        $name_page = "B'Mine - Data Employee";
        
        // Validate NIK
        $validatedData = $request->validate([
            'nik' => 'required|numeric',
        ], [
            'nik.required' => 'NIK is required.',
            'nik.numeric' => 'NIK must be a number.',
        ]);
        
        // Check if NIK exists in DataReqModel
        $existing_request = DataReqModel::where('nik', $validatedData['nik'])->first();
        
        // Check if NIK exists in DataRejectModel
        $existing_rejected = DataRejectModel::where('nik', $validatedData['nik'])->first();
        
        // If NIK exists in either table, return message that application is still in process
        if ($existing_request || $existing_rejected) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Your application is still in process. Please wait for the completion of your current application.']);
        }

        // Get employee data
        $data_karyawan = KaryawanModel::where('nik', 'LIKE', $validatedData['nik'])
            ->first();

        // Check if employee exists
        if (!$data_karyawan) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'NIK not found in database.']);
        }

        // Get all licenses
        $licenses = UnitModel::all();

        // Return view with data
        return view('request.get_data', compact(
            'name_page',
            'data_karyawan',
            'licenses'
        ));

    } catch (ValidationException $e) {
        return redirect()
            ->back()
            ->withInput()
            ->withErrors($e->errors());
            
    } catch (\Exception $e) {
        // Use Facades\Log for logging
        Log::error('Error in get_data_nik: ' . $e->getMessage());
        
        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['error' => 'An error occurred while retrieving data. Please try again.']);
    }
}


public function insert_request(Request $request)
{
    // Generate kode unik
    $code = 'BUMA-' . date('Ymdhis') . '-' . Str::random(6);

    // Menangkap semua input dari form
    $nik = $request->input('nik');
    $nama = $request->input('nama');
    $license_type = $request->input('license_type');
    $jabatan = $request->input('jabatan');
    $date_req = date('Y-m-d');
    $departement = $request->input('departement');
    $sio = $request->input('sio') ? $request->input('sio') : "No";
    $permissions = $request->input('permissions', []);
    $dep_req = $request->input('dep_req');
    $expiry_date = $request->input('expiry_date');
    
    // Mengambil data tipe SIM dari form
    $simData = $request->input('sim', []);
    $no_sim = $request->input('no_sim');
    
    // Mengatur jalur default jika file tidak ada
    $fotoPath = null;
    $medicalPath = null;
    $driversLicensePath = null;
    $attachmentPath = null;
    $sio_filePath = null;
    
    // Inisialisasi array untuk menyimpan hasil dengan default 'no'
    $permissionsArray = [
                        'CHR-BT' => $permissions['CHR-BT'] ?? 'no',
                        'CHR-FSP' => $permissions['CHR-FSP'] ?? 'no',
                        'CP-FSP' => $permissions['CP-FSP'] ?? 'no',
                        'CP-BT' => $permissions['CP-BT'] ?? 'no',
                        'CP-TA' => $permissions['CP-TA'] ?? 'no', // Tambahan CP-TA
                        'CP-TJ' => $permissions['CP-TJ'] ?? 'no', // Tambahan CP-TJ
                        'PIT-BT' => $permissions['PIT-BT'] ?? 'no',
                        'PIT-TA' => $permissions['PIT-TA'] ?? 'no',
                        'PIT-TJ' => $permissions['PIT-TJ'] ?? 'no',
                        ];
    
    $permissionsKTT = array(
        'BT' => 'no',
        'FSP' => 'no',
        'TA' => 'no',
        'TJ' => 'no',
    );

    // Set nilai "yes" untuk permission yang ada di input
    foreach ($permissions as $permission) {
        if (array_key_exists($permission, $permissionsArray)) {
            $permissionsArray[$permission] = 'yes';
        }
    }
    
    // Menangkap file dan menyimpannya sebelum membuat data
    if ($request->hasFile('foto_view')) {
        $fotoPath = $request->file('foto_view')->store('public/fotos');
        $fotoPath = Storage::url($fotoPath); // Konversi ke URL yang bisa diakses
    }

    if ($request->hasFile('medical_certificate')) {
        $medicalPath = $request->file('medical_certificate')->store('public/medical_certificates');
        $medicalPath = Storage::url($medicalPath);
    }

    if ($request->hasFile('drivers_license')) {
        $driversLicensePath = $request->file('drivers_license')->store('public/drivers_licenses');
        $driversLicensePath = Storage::url($driversLicensePath);
    }

    if ($request->hasFile('attachment')) {
        $attachmentPath = $request->file('attachment')->store('public/attachments');
        $attachmentPath = Storage::url($attachmentPath);
    }

    if ($request->hasFile('sio_file')) {
        $sio_filePath = $request->file('sio_file')->store('public/sio_files');
        $sio_filePath = Storage::url($sio_filePath);
    }

    // Menyimpan data utama ke DataReqModel
    $dataReq = DataReqModel::create([
        'nik' => $nik,
        'kode' => $code,
        'nama' => $nama,
        'jab' => $jabatan,
        'dept' => $departement,
        'foto_path' => $fotoPath,
        'medical_path' => $medicalPath,
        'expiry_date' => $expiry_date,
        'drivers_license_path' => $driversLicensePath,
        'attachment_path' => $attachmentPath,
        'sio_path' => $sio_filePath,
        'validasi_in' => $license_type,
        'status' => "1",
        'sio_status' => $sio,
        'date_req' => date('Y-m-d'),
        'access' => json_encode($permissionsArray),
        'ktt' => json_encode($permissionsKTT),
        'dep_req' => session('logged_in_user')['departement'],
        'sim' => json_encode($simData), 
        'no_simpol' => $no_sim, 
    ]);

    // Jika license_type adalah 2, lakukan perulangan untuk menyimpan data units
    if ($license_type == "2") {
        $unitTypes = (array) $request->input('unit_type', []);
        $optionsList = (array) $request->input('options', []);
        
        foreach ($unitTypes as $index => $unitType) {
            $options = $optionsList[$index] ?? [];
            
            UnitUser::create([
                'unit' => $unitType,
                'type_unit' => json_encode($options), // Lebih baik gunakan json_encode
                'id_uur' => $code,
            ]);
        }
    }
    
    return redirect()->route('request.index')->with('success', 'Employee data inserted successfully');
}

    public function data() {
        // Mengambil semua data karyawan
        $employees=DataReqModel::all();

        // Mengirimkan data karyawan ke view
        return view('request.validasi', compact('employees', 'loggedInUser'));
    }




}
