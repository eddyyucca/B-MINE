<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\UnitModel;
use App\Models\DataReqModel;
use App\Models\UnitUser;
use App\Models\KaryawanModel;
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

        // Get employee data
        $data_karyawan = KaryawanModel::where('nik', 'LIKE', $validatedData['nik'])
            ->first();

        // Check if employee exists
        if (!$data_karyawan) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'NIK tidak ditemukan dalam database.']);
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
        // Gunakan Facades\Log untuk logging
        Log::error('Error in get_data_nik: ' . $e->getMessage());
        
        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['error' => 'Terjadi kesalahan saat mengambil data. Silakan coba lagi.']);
    }
}


public function insert_request(Request $request)
{
    // Validasi input
    // $request->validate([
    //     'nik' => 'required|string|max:255',
    //     'nama' => 'required|string|max:255',
    //     'license_type' => 'required|integer',
    //     'units' => 'array',
    //     'units.*.unit_type' => 'required|integer',
    //     'units.*.options' => 'array',
    //     'foto_view' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:15360',
    //     'medical_certificate' => 'nullable|mimes:pdf,jpg,png|max:15360',
    //     'drivers_license' => 'nullable|mimes:pdf,jpg,png|max:15360',
    //     'attachment' => 'nullable|mimes:pdf,jpg,png|max:15360',
    // ]); $loggedInUser = $this->loggedInUser;

    // Generate kode unik
    $code = 'BUMA-' . date('Ymdhis') . '-' . Str::random(6);

    // Menangkap semua input dari form
    $nik = $request->input('nik');
    $nama = $request->input('nama');
    $license_type = $request->input('license_type');
    $jabatan = $request->input('jabatan');
    $date_req = date('Y-m-d');
    $departement = $request->input('departement');
    $sio = $request->input('sio');
    $permissions = $request->input('permissions', []);
    $dep_req = $request->input('dep_req');
    // Mengatur jalur default jika file tidak ada
    $fotoPath = null;
    $medicalPath = null;
    $driversLicensePath = null;
    $attachmentPath = null;
    $validasi_in = "1";
    $permissions = $request->input('permissions', []); // Ambil data permissions

    // Inisialisasi array untuk menyimpan hasil dengan default 'no'
    $permissionsArray = [
        'CHR-BT' => $permissions['CHR-BT'] ?? 'no',
        'CHR-FSP' => $permissions['CHR-FSP'] ?? 'no',
        'CP-FSP' => $permissions['CP-FSP'] ?? 'no',
        'CP-BT' => $permissions['CP-BT'] ?? 'no',
        'PIT-BT' => $permissions['PIT-BT'] ?? 'no',
        'PIT-TA' => $permissions['PIT-TA'] ?? 'no',
        'PIT-TJ' => $permissions['PIT-TJ'] ?? 'no',
    ];
    $permissionsKTT = [
        'CHR-BT' => $permissions['CHR-BT'] ?? 'no',
        'CHR-FSP' => $permissions['CHR-FSP'] ?? 'no',
        'CP-FSP' => $permissions['CP-FSP'] ?? 'no',
        'CP-BT' => $permissions['CP-BT'] ?? 'no',
        'PIT-BT' => $permissions['PIT-BT'] ?? 'no',
        'PIT-TA' => $permissions['PIT-TA'] ?? 'no',
        'PIT-TJ' => $permissions['PIT-TJ'] ?? 'no',
    ];

    // Set nilai "yes" untuk permission yang ada di input
    foreach ($permissions as $permission) {
        if (array_key_exists($permission, $permissionsArray)) {
            $permissionsArray[$permission] = 'yes';
        }
    }
    // Menangkap file foto dan sertifikat kesehatan jika ada
    if ($request->hasFile('foto_view')) {
        $fotoPath = $request->file('foto_view')->store('public/fotos');
    }

    if ($request->hasFile('medical_certificate')) {
        $medicalPath = $request->file('medical_certificate')->store('public/medical_certificates');
    }

    if ($request->hasFile('drivers_license')) {
        $driversLicensePath = $request->file('drivers_license')->store('public/drivers_licenses');
    }

    if ($request->hasFile('attachment')) {
        $attachmentPath = $request->file('attachment')->store('public/attachments');
    }
    if ($request->hasFile('sio_file')) {
        $sio_filePath = $request->file('sio_file')->store('public/sio_files');
    }

    // Menyimpan data utama ke DataReqModel
    $dataReq = DataReqModel::create([
        'nik' => $nik,
        'kode' => $code,
        'nama' => $nama,
        'jab' => $jabatan,
        'dept' => $departement,
        'status' => $license_type,
        'foto_path' => $fotoPath,
        'medical_path' => $medicalPath,
        'drivers_license_path' => $driversLicensePath,
        'attachment_path' => $attachmentPath,
        'sio_path' => $sio_filePath,
        'validasi_in' => $validasi_in,
        'status' => "1",
        'sio_status' => $sio,
        'date_req' => date('Y-m-d'),
        'access' => json_encode($permissionsArray),
        'ktt' => json_encode($permissionsKTT),
        'dep_req' => session('logged_in_user')['departement'],
    ]);

// Jika license_type adalah 2, lakukan perulangan untuk menyimpan data units
if ($license_type == "2") {
    // Pastikan unit_type dan options selalu dalam bentuk array
    $unitTypes = (array) $request->input('unit_type', []);  // Array dari unit_type
    $optionsList = (array) $request->input('options', []);  // Array dari options

    foreach ($unitTypes as $index => $unitType) {
        $options = $optionsList[$index] ?? []; // Ambil opsi berdasarkan indeks jika ada

        // Simpan data ke tabel UserUnit
        UnitUser::create([
            'unit' => $unitType,
            'type_unit' => json_encode($options), // Simpan opsi dalam bentuk JSON
            'id_uur' => $code, // Simpan referensi ID dari DataReqModel (contohnya $dataReq->id)
        ]);
    }
}



    return redirect()->back()->with('success', 'Employee data inserted successfully');
}




    public function karyawanfolder() {
        // Ambil token API dari file .env
        $token=env('BMINE_API_TOKEN');

        // Ambil data dari REST API
        $response=Http::withHeaders([ 'Authorization'=> 'Bearer '. $token,
                ])->get('https://rest-api-peoplesync.bmine.id/karyawan/');

        // Periksa jika request berhasil
        if ($response->successful()) {
            // Ambil data JSON dari response
            $karyawans=$response->json();

            // Perulangan setiap karyawan
            foreach ($karyawans as $karyawan) {
                // Ambil NIK dari setiap karyawan
                $nik=$karyawan['nik'];

                // Tentukan path folder yang ingin dibuat berdasarkan NIK
                $folderPath="data/data_karyawan/{$nik}";

                // Buat folder jika belum ada
                if (!Storage::exists($folderPath)) {
                    Storage::makeDirectory($folderPath);
                }
            }

            return 'Folders created successfully!';
        }

        else {
            return 'Failed to fetch data from the API.';
        }
    }

    public function data() {
        // Mengambil semua data karyawan
        $employees=DataReqModel::all();

        // Mengirimkan data karyawan ke view
        return view('request.validasi', compact('employees', 'loggedInUser'));
    }




}
