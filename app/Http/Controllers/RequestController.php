<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\UnitModel;
use App\Models\DataReqModel;
use App\Models\UnitUser;
use Illuminate\Support\Str;

class RequestController extends Controller {
    public function index() {
        return view('request.request');
    }

    public function not_found() {
        return view('request.not_found');
    }

    public function get_data_nik(Request $request) {
        // Tangkap data yang dikirim dari form
        $nik=$request->input('nik');

        // Cek apakah NIK diisi
        if (empty($nik)) {
            return redirect()->back()->withErrors(['error'=> 'NIK is required.']);
        }

        // Ambil token API dari file .env
        $token=env('BMINE_API_TOKEN');

        try {
            // Request ke API dengan token
            $response=Http::withHeaders([ 'Authorization'=> 'Bearer '. $token,
                    ])->get('https://rest-api-peoplesync.bmine.id/karyawan/'. $nik);

            // Periksa apakah response berhasil (status code 200)
            if ($response->successful()) {
                $data=$response->json();

                // Cek apakah data kosong
                if (empty($data)) {
                    return redirect()->back()->withErrors(['error'=> 'No data found for the provided NIK.']);
                }

                // Ambil data units dari model Unit
                $licenses=UnitModel::all(); // Mengambil semua data dari tabel units
                // Kirimkan data ke view
                return view('request.get_data', [ 'data_karyawan'=> $data,
                    'licenses'=> $licenses]);
            }

            else {
                // Jika response gagal, tampilkan pesan error
                return redirect()->back()->withErrors(['error'=> 'Failed to fetch data from API.']);
            }
        }

        catch (\Exception $e) {
            // Jika terjadi error saat koneksi ke API
            return redirect()->back()->withErrors(['error'=> 'An error occurred while fetching data.']);
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
    // ]);

    // Generate kode unik
    $code = 'TRX-' . date('Ymd') . '-' . Str::random(6);

    // Menangkap semua input dari form
    $nik = $request->input('nik');
    $nama = $request->input('nama');
    $license_type = $request->input('license_type');
    
    // Mengatur jalur default jika file tidak ada
    $fotoPath = null;
    $medicalPath = null;
    $driversLicensePath = null;
    $attachmentPath = null;
    $validasi_in = "1";

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

    // Menyimpan data utama ke DataReqModel
    $dataReq = DataReqModel::create([
        'nik' => $nik,
        'kode' => $code,
        'nama' => $nama,
        'foto_path' => $fotoPath,
        'medical_path' => $medicalPath,
        'drivers_license_path' => $driversLicensePath,
        'attachment_path' => $attachmentPath,
        'validasi_in' => $validasi_in,
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
        return view('request.validasi', compact('employees'));
    }




}
