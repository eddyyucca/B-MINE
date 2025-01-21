<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataReqModel;
use App\Models\UnitModel;
use App\Models\UnitUser;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Support\Facades\Log;

class PersonalTaskController extends Controller {

    public function personalTask(Request $request, $status = null) {
        $name_page = "B'Mine - Personal Task";
        $query = DataReqModel::query();

        if ($status !== null) {
            $query->where('validasi_in', $status);
        }

        // Load all relationships
        $dataReqs = DataReqModel::with(['unitUsers.unitData'])->paginate(10);

        foreach ($dataReqs as $req) {
            // Decode access data
            if (is_string($req->access)) {
                $req->access = json_decode($req->access, true);
            }

            // Set default access jika kosong
            if (!$req->access) {
                $req->access = [
                    'CHR BT' => 'no',
                    'CHR FSB' => 'no',
                    'PIT BT' => 'no',
                    'PIT TA' => 'no'
                ];
            }

            // Set path file
            $paths = ['foto_path', 'medical_path', 'drivers_license_path', 'attachment_path'];
            $folders = [
                'foto_path' => 'fotos',
                'medical_path' => 'medical_certificates',
                'drivers_license_path' => 'drivers_licenses',
                'attachment_path' => 'attachments'
            ];

            foreach ($paths as $path) {
                if ($req->$path) {
                    $folder = $folders[$path];
                    $req->$path = url("storage/app/public/$folder/" . basename($req->$path));
                }
            }
        }

        return view('personal_task.data_req_view', compact('dataReqs', 'name_page'));
    }
     // Melihat detail data berdasarkan kode unik
     public function viewData($kode) {
        \Log::info('Kode yang diterima:', ['kode' => $kode]);

        try {
            $unitUsers = UnitUser::with('unitData')->where('id_uur', $kode)->get();

            \Log::info('Data unit:', $unitUsers->toArray());

            return response()->json([
                'success' => true,
                'units' => $unitUsers
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in viewData:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }



    // Persetujuan data dengan parameter tipe validasi
    public function approveData($kode, $type) {
        $validasiInMap = [
            'she' => 2,
            'pjo' => 3,
            'bec' => 4,
            'ktt' => 5,
        ];

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




    // Generate ID Card dalam format PDF
    public function generateIdCard($nik) {
        try {
            $karyawan = DataReqModel::where('nik', $nik)->firstOrFail();

            $fotoBase64 = url('storage/app/public/fotos/' . basename($karyawan->foto_path));
            $bg = url('adminlte/idcard/depan.jpg');

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
        return $this->personalTask(request(), null);
    }
}
