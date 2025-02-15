<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataReqModel;
use App\Models\DataRejectModel;
use App\Models\UnitModel;
use App\Models\UnitUser;
use App\Models\Data_m_s_Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PersonalTaskController extends Controller {

    public function personalTask(Request $request, $status = null) {
        $name_page = "B'Mine - Personal Task";
        $dataReqs = DataReqModel::with(['unitUsers.unitData']);

        if ($status !== null) {
            $dataReqs->where('validasi_in', $status);
        }

        $dataReqs = $dataReqs->paginate(10);
        $this->processData($dataReqs);

        return view('personal_task.data_req_view', compact('dataReqs', 'name_page'));
    }

    public function sheTask() {
           // Cek level user dari session
    $userLevel = session('logged_in_user')['level'] ?? null;
    
    // Validasi level user
    if (!in_array($userLevel, ['she', 'admin'])) {
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
        $name_page = "B'Mine - Personal Task SHE";
        $dataReqs = DataReqModel::with(['unitUsers.unitData'])
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Tambahkan pengecekan apakah data kosong
        if ($dataReqs->isEmpty()) {
            $dataReqs = collect(); // Kirim koleksi kosong
        }

        $this->processData($dataReqs);
        return view('personal_task.data_req_she', compact('dataReqs', 'name_page'));
    }

    public function pjoTask() {
           // Cek level user dari session
    $userLevel = session('logged_in_user')['level'] ?? null;
    
    // Validasi level user
    if (!in_array($userLevel, ['pjo', 'admin'])) {
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
        $name_page = "B'Mine - Personal Task PJO";
        $dataReqs = DataReqModel::with(['unitUsers.unitData'])
            ->where('status', 2)
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Tambahkan pengecekan apakah data kosong
        if ($dataReqs->isEmpty()) {
            $dataReqs = collect(); // Kirim koleksi kosong
        }

        $this->processData($dataReqs);
        return view('personal_task.data_req_pjo', compact('dataReqs', 'name_page'));
    }

    public function becTask() {
           // Cek level user dari session
    $userLevel = session('logged_in_user')['level'] ?? null;
    
    // Validasi level user
    if (!in_array($userLevel, ['bec', 'admin'])) {
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
        $name_page = "B'Mine - Personal Task BEC";
        $dataReqs = DataReqModel::with(['unitUsers.unitData'])
        ->where('status', 3)
        ->orderBy('id', 'desc')
        ->paginate(10);

        // Tambahkan pengecekan apakah data kosong
        if ($dataReqs->isEmpty()) {
            $dataReqs = collect(); // Kirim koleksi kosong
        }

        $this->processData($dataReqs);
        return view('personal_task.data_req_bec', compact('dataReqs', 'name_page'));
    }

public function kttTask() {
       // Cek level user dari session
    $userLevel = session('logged_in_user')['level'] ?? null;
    
    // Validasi level user
    if (!in_array($userLevel, ['ktt', 'admin'])) {
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
    $name_page = "B'Mine - Personal Task KTT";
    $userArea = session('logged_in_user')['area'];

    $dataReqs = DataReqModel::with(['unitUsers.unitData'])
        ->where('status', 4)
        ->whereRaw("JSON_EXTRACT(ktt, '$." . $userArea . "') = 'no'")  // Filter berdasarkan area yang masih 'no'
        ->orderBy('id', 'desc')
        ->paginate(10);

    // Tambahkan pengecekan apakah data kosong
    if ($dataReqs->isEmpty()) {
        $dataReqs = collect();
    }

    $this->processData($dataReqs);
    return view('personal_task.data_req_ktt', compact('dataReqs', 'name_page'));
}

    private function processData($dataReqs) {
        foreach ($dataReqs as $req) {
            if (is_string($req->access)) {
                $req->access = json_decode($req->access, true);
            }

            if (!$req->access) {
                $req->access = [
                    'CHR-BT' => 'no',
                    'CHR-FSP' => 'no',
                    'CP-FSP' => 'no',
                    'CP-BT' => 'no',
                    'PIT-BT' => 'no',
                    'PIT-TA' => 'no',
                    'PIT-TJ' => 'no'
                ];
            }
            

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
    }

    public function viewData($kode) {
        try {
            $unitUsers = UnitUser::with('unitData')
                ->where('id_uur', $kode)
                ->get();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'units' => $unitUsers
                ]);
            }

            $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();
            return view('data_req.view', compact('dataReq', 'unitUsers'));

        } catch (\Exception $e) {
            Log::error('Error in viewData:', ['error' => $e->getMessage()]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Data not found');
        }
    }

    public function approveDataShe($kode) {
        try {
            $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();
            $dataReq->status = 2; // Move to next stage
            $dataReq->save();

            return redirect()->route('she.task')->with('success', 'Request approved successfully');
        } catch (\Exception $e) {
            return redirect()->route('she.task')->with('error', 'Failed to approve request');
        }
    }
    public function approveDataPjo($kode) {
        try {
            $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();
            $dataReq->status = 3; // Move to next stage
            $dataReq->save();

            return redirect()->route('pjo.task')->with('success', 'Request approved successfully');
        } catch (\Exception $e) {
            return redirect()->route('pjo.task')->with('error', 'Failed to approve request');
        }
    }
    public function approveDataBec($kode) {
        try {
            $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();
            $dataReq->status = 4; // Move to next stage
            $dataReq->save();

            return redirect()->route('bec.task')->with('success', 'Request approved successfully');
        } catch (\Exception $e) {
            return redirect()->route('bec.task')->with('error', 'Failed to approve request');
        }
    }

  public function approveDataKtt($kode) {
   try {
       $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();
       
       // Validasi session
       if (!session()->has('logged_in_user') || !isset(session('logged_in_user')['area'])) {
           throw new \Exception('User area not found in session');
       }
       
       $userArea = session('logged_in_user')['area'];
       
       // Validasi format access
       $access = json_decode($dataReq->ktt, true);
       if (json_last_error() !== JSON_ERROR_NONE) {
           throw new \Exception('Invalid access data format');
       }
       
       // Validasi area exists
       if (!isset($access[$userArea])) {
           throw new \Exception('Invalid area key: ' . $userArea);
       }
       
       // Update access
       $access[$userArea] = 'yes';
       
       // Update data
       $dataReq->ktt = json_encode($access);
       $dataReq->save();

       // Cek apakah semua approval sudah "yes"
       $expectedPermissions = [
           'BT' => 'yes',
           'FSP' => 'yes',
           'TA' => 'yes',
           'TJ' => 'yes'
       ];

       if ($access == $expectedPermissions) {
           try {
               DB::beginTransaction();

               // Insert ke data_m_s menggunakan model
               $data_ms = new Data_m_s_Model();
               $data_ms->kode = $dataReq->kode;
               $data_ms->nik = $dataReq->nik;
               $data_ms->nama = $dataReq->nama;
               $data_ms->jab = $dataReq->jab;
               $data_ms->dept = $dataReq->dept;
               $data_ms->date_req = $dataReq->date_req;
               $data_ms->foto_path = $dataReq->foto_path;
               $data_ms->medical_path = $dataReq->medical_path;
               $data_ms->drivers_license_path = $dataReq->drivers_license_path;
               $data_ms->attachment_path = $dataReq->attachment_path;
               $data_ms->sio_path = $dataReq->sio_path;
               $data_ms->validasi_in = $dataReq->validasi_in;
               $data_ms->status = $dataReq->status;
               $data_ms->dep_req = $dataReq->dep_req;
               $data_ms->sio_status = $dataReq->sio_status;
               $data_ms->access = $dataReq->access;
               $data_ms->ktt = $dataReq->ktt;
               $data_ms->ktt = $dataReq->status_access; // Tambahkan kolom baru
               $data_ms->save();

               // Hapus data dari data_req
               $dataReq->delete();

               DB::commit();
               return redirect()->route('ktt.task')->with('success', 'Request approved and moved to data_m_s successfully');
           } catch (\Exception $e) {
               DB::rollBack();
               \Log::error('Data Migration Error: ' . $e->getMessage());
               return redirect()->route('ktt.task')->with('error', 'Failed to move data: ' . $e->getMessage());
           }
       }

       // Jika belum semua yes, kembali ke halaman task
       return redirect()->route('ktt.task')->with('success', 'Request approved successfully');
   } catch (\Exception $e) {
       \Log::error('KTT Approval Error: ' . $e->getMessage());
       return redirect()->route('ktt.task')->with('error', 'Failed to approve request: ' . $e->getMessage());
   }
}

    private function getPreviousStage($currentStage) {
        $stageMap = [
            2 => 1,  // SHE back to initial
            3 => 2,  // PJO back to SHE
            4 => 3,  // BEC back to PJO
            5 => 4   // KTT back to BEC
        ];

        return $stageMap[$currentStage] ?? 1;
    }

    public function rejectRequest(Request $request, $stage, $kode) {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            // 1. Get data from data_req
            $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();

            // 2. Log process untuk debugging
            Log::info('Rejecting request', [
                'kode' => $kode,
                'stage' => $stage,
                'current_data' => $dataReq->toArray()
            ]);

            // 3. Create reject history dengan format yang benar
            $rejectHistory = [
                (string)$stage => [
                    'reason' => $request->reason,
                    'timestamp' => now()->toDateTimeString()
                ]
            ];

            // 4. Insert ke data_reject dengan error checking
            $dataReject = DataRejectModel::create([
                'kode' => $dataReq->kode,
                'nik' => $dataReq->nik,
                'nama' => $dataReq->nama,
                'jab' => $dataReq->jab,
                'dept' => $dataReq->dept,
                'reject_history' => $rejectHistory
            ]);

            if (!$dataReject) {
                throw new \Exception('Failed to create reject record');
            }

            // 5. Delete dari data_req dengan konfirmasi
            $deleteResult = $dataReq->delete();

            if (!$deleteResult) {
                throw new \Exception('Failed to delete original request');
            }

            // 6. Log success
            Log::info('Request rejected successfully', [
                'kode' => $kode,
                'reject_id' => $dataReject->id_reject
            ]);

            DB::commit();
            return $this->redirectAfterReject($stage);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reject request failed', [
                'error' => $e->getMessage(),
                'kode' => $kode,
                'stage' => $stage
            ]);

            return redirect()->back()
                ->with('error', 'Failed to reject request: ' . $e->getMessage());
        }
    }

    private function redirectAfterReject($currentStage) {
        $routeMap = [
            2 => 'she.task',   // If rejected from SHE
            3 => 'pjo.task',   // If rejected from PJO
            4 => 'bec.task',   // If rejected from BEC
            5 => 'ktt.task'    // If rejected from KTT
        ];

        $route = $routeMap[$currentStage] ?? 'she.task';
        return redirect()->route($route)
            ->with('error', 'Request rejected and sent back to previous stage');
    }

    public function clearRejectHistory($kode) {
        try {
            $dataReject = DataRejectModel::where('kode', $kode)->firstOrFail();
            $dataReject->delete();

            return redirect()->back()->with('success', 'Rejection data deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete rejection data');
        }
    }

    public function rejectTask() {
        $name_page = "B'Mine - Rejected Tasks";

        $dataReqs = DataRejectModel::orderBy('id', 'desc')  // menggunakan id untuk pengurutan
            ->paginate(10);

        return view('personal_task.data_req_rejected', compact('dataReqs', 'name_page'));
    }



    // public function generateIdCard($nik) {
    //     try {
    //         $karyawan = DataReqModel::where('nik', $nik)->firstOrFail();

    //         $fotoBase64 = url('storage/app/public/fotos/' . basename($karyawan->foto_path));
    //         $bg = url('adminlte/idcard/depan.jpg');

    //         $pdf = PDF::loadView('layouts.idcard', [
    //             'karyawan' => $karyawan,
    //             'fotoBase64' => $fotoBase64,
    //             'bg' => $bg,
    //         ]);

    //         return $pdf->stream('id_card_' . $karyawan->nik . '.pdf');
    //     } catch (\Exception $e) {
    //         return redirect()->back()
    //             ->with('error', 'Failed to generate ID card: ' . $e->getMessage());
    //     }
    // }

    public function generateIdCardFront($kode)
    {
        // Ambil data pegawai berdasarkan kode
        $dataReq = DataReqModel::where('kode', $kode)->first();
        // Jika data tidak ditemukan
        if (!$dataReq) {
            abort(404, 'Data tidak ditemukan');
        }

         // Generate QR code
        $qrcode = QrCode::size(150)
        ->format('svg')
        ->style('round')
        ->backgroundColor(255,255,255)
        ->generate(url("/verifikasi/{$dataReq->kode}"));

        // Generate URL lengkap untuk foto menggunakan logika yang sama dengan processData
        $paths = ['foto_path'];
        $folders = [
            'foto_path' => 'fotos'
        ];

        foreach ($paths as $path) {
            if ($dataReq->$path) {
                $folder = $folders[$path];
                $dataReq->$path = url("storage/app/public/$folder/" . basename($dataReq->$path));
            }
        }

        // Mengambil akses sebagai array
        if (is_string($dataReq->access)) {
            $access = json_decode($dataReq->access, true);
        } else {
            $access = $dataReq->access;
        }

        // Mengambil data unit
        $units = $dataReq->unitUsers;


        return view('idcard.print_front', [
            'dataReq' => $dataReq,
            'access' => $access,
            'units' => $units,
            'qrcode' => $qrcode
        ]);
    }

    public function generateIdCardBack($kode)
    {
        $dataReq = DataReqModel::where('kode', $kode)->first();

        if (!$dataReq) {
            abort(404, 'Data tidak ditemukan');
        }

      // Mengambil data unit dengan relasi
        $units = $dataReq->unitUsers()->with('unitData')->get();

        // Jika units kosong, buat collection kosong agar bisa di-chunk
        if ($units->isEmpty()) {
            $units = collect([]);
        }

        // Generate QR code
        $qrcode = QrCode::size(150)
            ->format('svg')
            ->style('round')
            ->backgroundColor(255,255,255)
            ->generate(url("/verifikasi/{$dataReq->kode}"));

        // Proses foto
        if ($dataReq->foto_path) {
            $dataReq->foto_path = url("storage/app/public/fotos/" . basename($dataReq->foto_path));
        }

        // Proses access
        $access = is_string($dataReq->access) ? json_decode($dataReq->access, true) : $dataReq->access;

        return view('idcard.print_back', [
            'dataReq' => $dataReq,
            'access' => $access,
            'units' => $units,
            'qrcode' => $qrcode
        ]);
    }

    public function scanQR($kode)
    {
        $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();

        // Process foto path
        if ($dataReq->foto_path) {
            $folder = 'fotos';
            $dataReq->foto_path = url("storage/app/public/$folder/" . basename($dataReq->foto_path));
        }

        // Process access data
        if (is_string($dataReq->access)) {
            $access = json_decode($dataReq->access, true);
        } else {
            $access = $dataReq->access;
        }

        return view('verifikasi.view_qr', compact('dataReq', 'access'));
    }


    public function index() {
        return $this->personalTask(request(), null);
    }
}
