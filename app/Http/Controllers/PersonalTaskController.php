<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataReqModel;

class PersonalTaskController extends Controller {
    public function index() {
        // Ambil data hanya yang memiliki validasi_in = 1
    $dataReqs = DataReqModel::where('validasi_in', 1)->get();
        return view('personal_task.data_req', compact('dataReqs'));
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

}
