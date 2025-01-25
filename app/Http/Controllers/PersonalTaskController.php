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
       $dataReqs = DataReqModel::with(['unitUsers.unitData']);

       if ($status !== null) {
           $dataReqs->where('validasi_in', $status);
       }

       $dataReqs = $dataReqs->paginate(10);
       $this->processData($dataReqs);

       return view('personal_task.data_req_view', compact('dataReqs', 'name_page'));
   }

    public function sheTask() {
        $name_page = "B'Mine - Personal Task SHE";
        $dataReqs = DataReqModel::with(['unitUsers.unitData'])
            ->where('status', 1)
            ->paginate(10);

        // Tambahkan pengecekan apakah data kosong
        if ($dataReqs->isEmpty()) {
            $dataReqs = collect(); // Kirim koleksi kosong
        }

        $this->processData($dataReqs);
        return view('personal_task.data_req_she', compact('dataReqs', 'name_page'));
    }

    public function pjoTask() {
        $name_page = "B'Mine - Personal Task PJO";
        $dataReqs = DataReqModel::with(['unitUsers.unitData'])
            ->where('status', 2)
            ->paginate(10);

        // Tambahkan pengecekan apakah data kosong
        if ($dataReqs->isEmpty()) {
            $dataReqs = collect(); // Kirim koleksi kosong
        }

        $this->processData($dataReqs);
        return view('personal_task.data_req_pjo', compact('dataReqs', 'name_page'));
    }

    public function becTask() {
        $name_page = "B'Mine - Personal Task BEC";
        $dataReqs = DataReqModel::with(['unitUsers.unitData'])
            ->where('status', 3)
            ->paginate(10);

        // Tambahkan pengecekan apakah data kosong
        if ($dataReqs->isEmpty()) {
            $dataReqs = collect(); // Kirim koleksi kosong
        }

        $this->processData($dataReqs);
        return view('personal_task.data_req_bec', compact('dataReqs', 'name_page'));
    }

    public function kttTask() {
        $name_page = "B'Mine - Personal Task KTT";
        $dataReqs = DataReqModel::with(['unitUsers.unitData'])
            ->where('status', 4)
            ->paginate(10);

        // Tambahkan pengecekan apakah data kosong
        if ($dataReqs->isEmpty()) {
            $dataReqs = collect(); // Kirim koleksi kosong
        }

        $this->processData($dataReqs);
        return view('personal_task.data_req_ktt', compact('dataReqs', 'name_page'));
    }

    public function rejectTask() {
        $name_page = "B'Mine - Rejected Tasks";

        $dataReqs = DataReqModel::with(['unitUsers.unitData'])
            ->paginate(10);

        $this->processData($dataReqs);

        return view('personal_task.data_req_rejected', compact('dataReqs', 'name_page'));
     }

   private function processData($dataReqs) {
       foreach ($dataReqs as $req) {
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

            return redirect()->route('pjo.task')->with('success', 'Request approved successfully');
        } catch (\Exception $e) {
            return redirect()->route('pjo.task')->with('error', 'Failed to approve request');
        }
    }
    public function approveDataPjo($kode) {
        try {
            $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();
            $dataReq->status = 3; // Move to next stage
            $dataReq->save();

            return redirect()->route('bec.task')->with('success', 'Request approved successfully');
        } catch (\Exception $e) {
            return redirect()->route('bec.task')->with('error', 'Failed to approve request');
        }
    }
    public function approveDataBec($kode) {
        try {
            $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();
            $dataReq->status = 4; // Move to next stage
            $dataReq->save();

            return redirect()->route('ktt.task')->with('success', 'Request approved successfully');
        } catch (\Exception $e) {
            return redirect()->route('ktt.task')->with('error', 'Failed to approve request');
        }
    }
    public function approveDataKtt($kode) {
        try {
            $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();
            $dataReq->status = 5; // Move to next stage
            $dataReq->save();

            return redirect()->route('ktt.task')->with('success', 'Request approved successfully');
        } catch (\Exception $e) {
            return redirect()->route('ktt.task')->with('error', 'Failed to approve request');
        }
    }


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
           return redirect()->back()
               ->with('error', 'Failed to generate ID card: ' . $e->getMessage());
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

        $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();
        $rejectHistory = json_decode($dataReq->reject_history, true) ?? [];

        $rejectHistory[$stage] = [
            'reason' => $request->reason,
            'timestamp' => now()->toDateTimeString()
        ];

        $dataReq->reject_history = json_encode($rejectHistory);
        $dataReq->status = $this->getPreviousStage($stage);
        $dataReq->save();

        return $this->redirectAfterReject($stage);
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
            $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();
            $dataReq->reject_history = null;
            $dataReq->save();

            return redirect()->back()->with('success', 'Rejection history cleared successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clear rejection history');
        }
    }

   public function index() {
       return $this->personalTask(request(), null);
   }
}
