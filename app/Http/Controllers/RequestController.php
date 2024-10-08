<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Tambahkan ini

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
        if ( !$nik) {
            return redirect()->back()->withErrors(['No data found for the provided NIK.']);
        }

        // Ambil token API dari file .env
        $token=env('BMINE_API_TOKEN');

        $response=Http::withHeaders([ 'Authorization'=> 'Bearer '. $token,
            ])->get('https://rest-api-peoplesync.bmine.id/karyawan/'. $nik);

        $data=$response->json();

        // Cek apakah data null atau kosong
        if (is_null($data) || empty($data)) {
            return redirect()->back()->withErrors(['No data found for the provided NIK.']);
        }

        // Jika data ditemukan, kirimkan data ke view
        return redirect()->back()->with('data', $data);
    }

    public function post_data() {
        // Validasi NIK dan file upload
        $request->validate([ 'nik'=> 'required|string|max:16',
            'foto_view'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'medical_certificate'=> 'nullable|mimes:pdf,doc,docx|max:2048',
            'drivers_license'=> 'nullable|mimes:pdf,doc,docx|max:2048',
            'attachment'=> 'nullable|mimes:pdf,doc,docx|max:2048',
            ]);

        // Simpan file jika diupload
        if ($request->hasFile('foto_view')) {
            $fotoPath=$request->file('foto_view')->store('photos', 'public');
        }

        if ($request->hasFile('medical_certificate')) {
            $medicalCertificatePath=$request->file('medical_certificate')->store('medical_certificates', 'public');
        }

        if ($request->hasFile('drivers_license')) {
            $driversLicensePath=$request->file('drivers_license')->store('licenses', 'public');
        }

        if ($request->hasFile('attachment')) {
            $attachmentPath=$request->file('attachment')->store('attachments', 'public');
        }

        // Simulasi data karyawan yang ditemukan
      $data = [
            'nik' => '123456789',
            'name' => $request->input('name'),
            'jabatan' => 'Manager',
            'departement' => 'HR',
            'unit' => 'Unit 1'
        ];

        // Simpan data ke session atau tampilkan
        return back()->with('data', $data);
    }
}
