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
         // Filter berdasarkan area yang masih 'no'
	// ->whereRaw("JSON_EXTRACT(ktt, '$.\"" . $userArea . "\"') = '\"no\"'") 
->where("ktt->{$userArea}", 'no') 
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
                                'CP-TA' => 'no', // Tambahan CP-TA
                                'CP-TJ' => 'no', // Tambahan CP-TJ
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

    public function approveAllPjo() {
    try {
        // Ambil semua data yang perlu disetujui
        $pendingRequests = DataReqModel::where('status', 2)
            ->get();
            
        $count = 0;
        foreach ($pendingRequests as $request) {
            $request->status = 3; // Pindahkan ke tahap berikutnya
            $request->save();
            $count++;
        }
        
        if ($count > 0) {
            return redirect()->route('pjo.task')->with('success', "$count requests approved successfully");
        } else {
            return redirect()->route('pjo.task')->with('info', "No requests available for approval");
        }
    } catch (\Exception $e) {
        return redirect()->route('pjo.task')->with('error', 'Failed to approve requests: ' . $e->getMessage());
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

               // Cek apakah NIK sudah ada di tabel data_m_s
               $existingRecord = Data_m_s_Model::where('nik', $dataReq->nik)->first();
               
               if ($existingRecord) {
                   // Update record yang sudah ada
                   $existingRecord->kode = $dataReq->kode;
                   $existingRecord->nama = $dataReq->nama;
                   $existingRecord->jab = $dataReq->jab;
                   $existingRecord->dept = $dataReq->dept;
                   $existingRecord->date_req = $dataReq->date_req;
                   $existingRecord->expiry_date = $dataReq->expiry_date;
                   $existingRecord->foto_path = $dataReq->foto_path;
                   $existingRecord->medical_path = $dataReq->medical_path;
                   $existingRecord->drivers_license_path = $dataReq->drivers_license_path;
                   $existingRecord->attachment_path = $dataReq->attachment_path;
                   $existingRecord->sio_path = $dataReq->sio_path;
                   $existingRecord->validasi_in = $dataReq->validasi_in;
                   $existingRecord->status = $dataReq->status;
                   $existingRecord->dep_req = $dataReq->dep_req;
                   $existingRecord->sio_status = $dataReq->sio_status;
                   $existingRecord->access = $dataReq->access;
                   $existingRecord->ktt = $dataReq->ktt;
                   $existingRecord->status_access = $dataReq->status_access;
                   $existingRecord->no_simpol = $dataReq->no_simpol;
                   $existingRecord->sim = $dataReq->sim;
                   $existingRecord->save();
                   
                   $actionMessage = 'Request approved and existing record updated successfully';
               } else {
                   // Insert record baru
                   $data_ms = new Data_m_s_Model();
                   $data_ms->kode = $dataReq->kode;
                   $data_ms->nik = $dataReq->nik;
                   $data_ms->nama = $dataReq->nama;
                   $data_ms->jab = $dataReq->jab;
                   $data_ms->dept = $dataReq->dept;
                   $data_ms->date_req = $dataReq->date_req;
                   $data_ms->expiry_date = $dataReq->expiry_date;
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
                   $data_ms->status_access = $dataReq->status_access;
                   $data_ms->no_simpol = $dataReq->no_simpol;
                   $data_ms->sim = $dataReq->sim;
                   $data_ms->save();
                   
                   $actionMessage = 'Request approved and new record created successfully';
               }

               // Hapus data dari data_req
               $dataReq->delete();
                
               DB::commit();
               return redirect()->route('ktt.task')->with('success', $actionMessage);
           } catch (\Exception $e) {
               DB::rollBack();
               \Illuminate\Support\Facades\Log::error('Data Migration Error: ' . $e->getMessage());
               return redirect()->route('ktt.task')->with('error', 'Failed to move data: ' . $e->getMessage());
           }
       }

       // Jika belum semua yes, kembali ke halaman task
       return redirect()->route('ktt.task')->with('success', 'Request approved successfully');
   } catch (\Exception $e) {
       \Illuminate\Support\Facades\Log::error('KTT Approval Error: ' . $e->getMessage());
       return redirect()->route('ktt.task')->with('error', 'Failed to approve request: ' . $e->getMessage());
   }
}

public function approveAllKtt() {
    try {
        // Validasi session
        if (!session()->has('logged_in_user') || !isset(session('logged_in_user')['area'])) {
            throw new \Exception('User area not found in session');
        }
        
        $userArea = session('logged_in_user')['area'];
        
        // Ambil semua data yang perlu disetujui (tanpa filter reject_history)
        $pendingRequests = DataReqModel::whereNotNull('ktt')
            ->get();
            
        $count = 0;
        $migratedCount = 0;
        
        foreach ($pendingRequests as $dataReq) {
            try {
                // Validasi format access
                $access = json_decode($dataReq->ktt, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    continue;
                }
                
                // Validasi area exists
                if (!isset($access[$userArea])) {
                    continue;
                }
                
                // Jika sudah approve, skip
                if ($access[$userArea] === 'yes') {
                    continue;
                }
                
                // Update access
                $access[$userArea] = 'yes';
                
                // Update data
                $dataReq->ktt = json_encode($access);
                $dataReq->save();
                $count++;
                
                // Cek apakah semua approval sudah "yes"
                $expectedPermissions = [
                    'BT' => 'yes',
                    'FSP' => 'yes',
                    'TA' => 'yes',
                    'TJ' => 'yes'
                ];
                
                if ($access == $expectedPermissions) {
                    DB::beginTransaction();
                    
                    try {
                        // Cek apakah NIK sudah ada di tabel data_m_s
                        $existingRecord = Data_m_s_Model::where('nik', $dataReq->nik)->first();
                        
                        if ($existingRecord) {
                            // Update record yang sudah ada
                            $existingRecord->kode = $dataReq->kode;
                            $existingRecord->nama = $dataReq->nama;
                            $existingRecord->jab = $dataReq->jab;
                            $existingRecord->dept = $dataReq->dept;
                            $existingRecord->date_req = $dataReq->date_req;
                            $existingRecord->expiry_date = $dataReq->expiry_date;
                            $existingRecord->foto_path = $dataReq->foto_path;
                            $existingRecord->medical_path = $dataReq->medical_path;
                            $existingRecord->drivers_license_path = $dataReq->drivers_license_path;
                            $existingRecord->attachment_path = $dataReq->attachment_path;
                            $existingRecord->sio_path = $dataReq->sio_path;
                            $existingRecord->validasi_in = $dataReq->validasi_in;
                            $existingRecord->status = $dataReq->status;
                            $existingRecord->dep_req = $dataReq->dep_req;
                            $existingRecord->sio_status = $dataReq->sio_status;
                            $existingRecord->access = $dataReq->access;
                            $existingRecord->ktt = $dataReq->ktt;
                            $existingRecord->status_access = $dataReq->status_access;
                            $existingRecord->no_simpol = $dataReq->no_simpol;
                            $existingRecord->sim = $dataReq->sim;
                            $existingRecord->save();
                        } else {
                            // Insert record baru - PERBAIKAN: menggunakan $data_ms, bukan $existingRecord
                            $data_ms = new Data_m_s_Model();
                            $data_ms->kode = $dataReq->kode;
                            $data_ms->nik = $dataReq->nik;
                            $data_ms->nama = $dataReq->nama;
                            $data_ms->jab = $dataReq->jab;
                            $data_ms->dept = $dataReq->dept;
                            $data_ms->date_req = $dataReq->date_req;
                            $data_ms->expiry_date = $dataReq->expiry_date;  // PERBAIKAN: Menggunakan $data_ms bukan $existingRecord
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
                            $data_ms->status_access = $dataReq->status_access;
                            $data_ms->no_simpol = $dataReq->no_simpol;
                            $data_ms->sim = $dataReq->sim;
                            $data_ms->save();
                        }
                        
                        // Hapus data dari data_req setelah migrasi sukses
                        $dataReq->delete();
                        $migratedCount++;
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        throw $e; // Re-throw untuk ditangkap oleh catch berikutnya
                    }
                }
            } catch (\Exception $e) {
                // Error individual diproses di sini, tapi kita tetap melanjutkan ke record berikutnya
                continue;
            }
        }
        
        if ($count > 0) {
            $message = "$count requests approved for area $userArea";
            if ($migratedCount > 0) {
                $message .= " ($migratedCount records migrated to master data)";
            }
            return redirect()->route('ktt.task')->with('success', $message);
        } else {
            return redirect()->route('ktt.task')->with('info', "No pending requests found for area $userArea");
        }
    } catch (\Exception $e) {
        return redirect()->route('ktt.task')->with('error', 'Failed to process approval: ' . $e->getMessage());
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

  public function rejectRequest($stage = null, $kode = null)
{
    try {
        // Temukan data request
        $dataReq = DataReqModel::where('kode', $kode)->first();

        if (!$dataReq) {
            return redirect()->back()->withErrors(['error' => 'Data tidak ditemukan']);
        }
        

        // Hapus file-file terkait
        $fileFields = ['foto_path', 'medical_path', 'drivers_license_path', 'attachment_path'];
        
        foreach ($fileFields as $field) {
            if (!empty($dataReq->$field)) {
                $filePath = $dataReq->$field;
                
                // Cek apakah path sudah merupakan path lengkap (dimulai dengan /storage/)
                if (strpos($filePath, '/storage/') === 0) {
                    // Ubah /storage/ menjadi public/storage/ karena storage adalah symlink
                    $fullPath = public_path(str_replace('/storage/', 'storage/', $filePath));
                } else {
                    // Jika belum path lengkap, gunakan cara lama
                    $directory = '';
                    switch ($field) {
                        case 'foto_path':
                            $directory = 'fotos';
                            break;
                        case 'medical_path':
                            $directory = 'medical_certificates';
                            break;
                        case 'drivers_license_path':
                            $directory = 'drivers_licenses';
                            break;
                        case 'attachment_path':
                            $directory = 'attachments';
                            break;
                    }
                    $fullPath = public_path($directory . '/' . $filePath);
                }
                
                // Hapus file
                if (file_exists($fullPath)) {
                    try {
                        unlink($fullPath);
                        Log::info("File deleted: $fullPath");
                    } catch (\Exception $e) {
                        Log::error("Error deleting file $fullPath: " . $e->getMessage());
                    }
                } else {
                    Log::warning("File not found: $fullPath");
                }
            }
        }

        // Buat riwayat reject
        $rejectHistory = json_encode([
            'stage' => $stage,
            'rejected_at' => now(),
            'reason' => request()->input('reason', 'Tidak ada alasan spesifik')
        ]);

        // Simpan data ke tabel reject
        $dataReject = DataRejectModel::create([
            'kode' => $dataReq->kode,
            'nik' => $dataReq->nik,
            'nama' => $dataReq->nama,
            'jab' => $dataReq->jab,
            'dept' => $dataReq->dept,
            'reject_history' => $rejectHistory
        ]);

        // Hapus data dari tabel request
        $dataReq->delete();
        // Hapus data terkait di UnitModel
        UnitUser::where('id_uur', $kode)->delete();
        return redirect()->back()->with('success', 'Data berhasil ditolak');

    } catch (\Exception $e) {
        Log::error('Error in reject request: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Gagal menolak permintaan']);
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
    
    // Cek level pengguna yang login
    $loggedInUser = session('logged_in_user')['level'];
    
    // Query dasar
    $query = DataRejectModel::orderBy('id', 'desc');
    
    // Jika level pengguna adalah section_admin, tampilkan hanya data departemen yang sama
    if ($loggedInUser == 'section_admin') {
        // Menggunakan 'departement' sesuai dengan session
        $userDept = session('logged_in_user')['departement'];
        $query->where('dept', $userDept);
    }
    // Jika level pengguna lain, tampilkan semua data (tidak perlu filter tambahan)
    
    // Eksekusi query dengan pagination
    $dataReject = $query->paginate(10);
    
    return view('personal_task.data_req_rejected', compact('dataReject', 'name_page'));
}


    public function generateIdCardFront($nik)
    {
        //Bukan data req ya
        // Ambil data pegawai berdasarkan nik
        $dataReq = Data_m_s_Model::where('nik', $nik)->first();
        // Jika data tidak ditemukan
        if (!$dataReq) {
            abort(404, 'Data tidak ditemukan');
        }

         // Generate QR code
        $qrcode = QrCode::size(150)
        ->format('svg')
        ->style('round')
        ->backgroundColor(255,255,255)
        ->generate(url("/verifikasi/{$dataReq->nik}")); //ubah ke nik

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

    public function generateIdCardBack($nik)
    {
        $dataReq = Data_m_s_Model::where('nik', $nik)->first();

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
            ->generate(url("/verifikasi/{$dataReq->nik}"));

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

    public function scanQR($nik)
    {
        $dataReq = Data_m_s_Model::where('nik', $nik)->firstOrFail();

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
            ->generate(url("/verifikasi/{$dataReq->nik}"));

        // Proses foto
        if ($dataReq->foto_path) {
            $dataReq->foto_path = url("storage/app/public/fotos/" . basename($dataReq->foto_path));
        }

        // Proses access
        $access = is_string($dataReq->access) ? json_decode($dataReq->access, true) : $dataReq->access;

        return view('verifikasi.view_qr', [
            'dataReq' => $dataReq,
            'access' => $access,
            'units' => $units,
            'qrcode' => $qrcode
        ]);
    }


    public function index() {
        return $this->personalTask(request(), null);
    }
}
