<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataReqModel;
use Illuminate\Support\Facades\Session;

class PersonalTaskController extends Controller {
        protected $name_page;

    public function __construct() {
        // Ambil data pengguna dari session
        $this->name_page = Session::get('logged_in_user');
    }
    public function index() {
    $name_page = "B'Mine - Personal Task";
        // Ambil data hanya yang memiliki validasi_in = 1
    $dataReqs = DataReqModel::where('status', 1)->get();
        return view('personal_task.data_req_view', compact('dataReqs','name_page'));
    }

    public function personal_task_she() {
        $name_page  = "B'Mine - Dashboard";
          // Ambil data hanya yang memiliki status = 1
    $dataReqs = DataReqModel::where('validasi_in', 2)->get();
        return view('personal_task.data_req_view', compact('dataReqs','name_page'));
    }
    public function personal_task_bec() {
        $name_page  = "B'Mine - Dashboard";
          // Ambil data hanya yang memiliki status = 1
    $dataReqs = DataReqModel::where('validasi_in', 3)->get();
        return view('personal_task.data_req_view', compact('dataReqs','name_page'));
    }
    public function personal_task_ktt() {
        $name_page  = "B'Mine - Dashboard";
          // Ambil data hanya yang memiliki status = 1
    $dataReqs = DataReqModel::where('validasi_in', 5)->get();
        return view('personal_task.data_req_view', compact('dataReqs','name_page'));
    }

    public function viewData($kode) {
        // Ambil data berdasarkan kode unik
        $dataReq=DataReqModel::where('kode', $kode)->firstOrFail();

        // Kirim data ke view
        return view('dataReq.view', compact('dataReq'));
    }

    public function approveData($kode) {
    // Ambil data berdasarkan kode unik
    $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();

    // Update status validasi menjadi 2 untuk status "Approved"
    $dataReq->validasi_in = 2; 
    $dataReq->save();

    // Redirect ke halaman view_data dengan pesan sukses
    return redirect()->route('personal_tak')->with('success', 'Data has been approved successfully.');
}
    public function approveDataSHE($kode) {
    // Ambil data berdasarkan kode unik
    $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();

    // Update status validasi menjadi 2 untuk status "Approved"
    $dataReq->validasi_in = 2; 
    $dataReq->save();

    // Redirect ke halaman view_data dengan pesan sukses
    return redirect()->route('personal_task_she')->with('success', 'Data has been approved successfully.');
}
    public function approveDataPJO($kode) {
    // Ambil data berdasarkan kode unik
    $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();

    // Update status validasi menjadi 2 untuk status "Approved"
    $dataReq->validasi_in = 3; 
    $dataReq->save();

    // Redirect ke halaman view_data dengan pesan sukses
    return redirect()->route('personal_task_pjo')->with('success', 'Data has been approved successfully.');
}
    public function approveDataBEC($kode) {
    // Ambil data berdasarkan kode unik
    $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();

    // Update status validasi menjadi 2 untuk status "Approved"
    $dataReq->validasi_in = 4; 
    $dataReq->save();

    // Redirect ke halaman view_data dengan pesan sukses
    return redirect()->route('personal_task_bec')->with('success', 'Data has been approved successfully.');
}
    public function approveDataKTT($kode) {
    // Ambil data berdasarkan kode unik
    $dataReq = DataReqModel::where('kode', $kode)->firstOrFail();

    // Update status validasi menjadi 2 untuk status "Approved"
    $dataReq->validasi_in = 5; 
    $dataReq->save();

    // Redirect ke halaman view_data dengan pesan sukses
    return redirect()->route('personal_task_bec')->with('success', 'Data has been approved successfully.');
}

}
