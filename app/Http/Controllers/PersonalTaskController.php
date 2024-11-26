<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataReqModel;
use Illuminate\Support\Facades\Session;

class PersonalTaskController extends Controller {
        protected $loggedInUser;

    public function __construct() {
        // Ambil data pengguna dari session
        $this->loggedInUser = Session::get('logged_in_user');
    }
    public function index() {
        if (!$this->loggedInUser) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    $loggedInUser = $this->loggedInUser;
        // Ambil data hanya yang memiliki validasi_in = 1
    $dataReqs = DataReqModel::where('status', 1)->get();
        return view('personal_task.data_req_view', compact('dataReqs','loggedInUser'));
    }

    public function personal_task_she() {
        if (!$this->loggedInUser) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    $loggedInUser = $this->loggedInUser;
        // Ambil data hanya yang memiliki status = 1
    $dataReqs = DataReqModel::where('validasi_in', 2)->get();
        return view('personal_task.data_req_view', compact('dataReqs','loggedInUser'));
    }
    public function personal_task_bec() {
        if (!$this->loggedInUser) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    $loggedInUser = $this->loggedInUser;
        // Ambil data hanya yang memiliki status = 1
    $dataReqs = DataReqModel::where('validasi_in', 3)->get();
        return view('personal_task.data_req_view', compact('dataReqs','loggedInUser'));
    }
    public function personal_task_ktt() {
        if (!$this->loggedInUser) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    $loggedInUser = $this->loggedInUser;
        // Ambil data hanya yang memiliki status = 1
    $dataReqs = DataReqModel::where('validasi_in', 5)->get();
        return view('personal_task.data_req_view', compact('dataReqs','loggedInUser'));
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
