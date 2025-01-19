<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataReqModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PDF;

class PersonalTaskController extends Controller {

    // Mengelola data dengan parameter untuk validasi_in
    // Edit controller
    public function personalTask(Request $request, $status = null) {
        $name_page = "B'Mine - Personal Task";
        $query = DataReqModel::query();

        if ($status !== null) {
            $query->where('validasi_in', $status);
        }

        $dataReqs = $query->paginate(10);

        foreach ($dataReqs as $req) {
            // Decode access data
            if (is_string($req->access)) {
                $req->access = json_decode($req->access, true);
            }

            if (!$req->access) {
                $req->access = [
                    'CHR BT' => 'no',
                    'CHR FSB' => 'no',
                    'PIT BT' => 'no',
                    'PIT TA' => 'no'
                ];
            }

            // Set path file dengan format yang benar
            if ($req->foto_path) {
                $req->foto_path = url('storage/app/public/fotos/' . basename($req->foto_path));
            }

            if ($req->medical_path) {
                $req->medical_path = url('storage/app/public/medical_certificates/' . basename($req->medical_path));
            }

            if ($req->drivers_license_path) {
                $req->drivers_license_path = url('storage/app/public/drivers_licenses/' . basename($req->drivers_license_path));
            }

            if ($req->attachment_path) {
                $req->attachment_path = url('storage/app/public/attachments/' . basename($req->attachment_path));
            }
        }

        return view('personal_task.data_req_view', compact('dataReqs', 'name_page'));
    }
    // Persetujuan data dengan parameter tipe validasi
    public function approveData($kode, $type) {
        $validasiInMap = [
            'she' => 2,
            'pjo' => 3,
            'bec' => 4,
            'ktt' => 5,
        ];

        // Validasi tipe approval
        if (!isset($validasiInMap[$type])) {
            return redirect()->back()->with('error', 'Invalid approval type.');
        }

        try {
            $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();
            $dataReq->validasi_in = $validasiInMap[$type];
            $dataReq->save();

            return redirect()->route('personal_task', ['status' => $validasiInMap[$type]])->with('success', 'Data has been approved successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to approve data: ' . $e->getMessage());
        }
    }

    // Melihat detail data berdasarkan kode unik
    public function viewData($kode) {
        try {
            $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();
            return view('dataReq.view', compact('dataReq'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data not found: ' . $e->getMessage());
        }
    }

    // Generate ID Card dalam format PDF
    public function generateIdCard($nik) {
        try {
            // Mengambil data karyawan berdasarkan NIK
            $karyawan = DataReqModel::where('nik', $nik)->firstOrFail();

            // Persiapan data untuk PDF
            $fotoBase64 = url('storage/app/public/fotos/' . basename($karyawan->foto_path));
            $bg = url('adminlte/idcard/depan.jpg');

            // Generate PDF dengan Blade view
            $pdf = PDF::loadView('layouts.idcard', [
                'karyawan' => $karyawan,
                'fotoBase64' => $fotoBase64,
                'bg' => $bg,
            ]);

            return $pdf->stream('id_card_' . $karyawan->nik . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate ID card: ' . $e->getMessage());
        }
    }

    // Fungsi default untuk dashboard utama
    public function index() {
        return $this->personalTask(request(), null); // Menampilkan semua data tanpa filter
    }
}
