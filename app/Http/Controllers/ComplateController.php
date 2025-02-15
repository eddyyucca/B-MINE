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
use Illuminate\Support\Facades\Log;

class ComplateController extends Controller
{
    public function data_complate() 
    {
        $name_page = "B'Mine - Complate Submission";
        
        // Menggunakan nama model yang benar (Data_m_s_Model)
        $data_complate = Data_m_s_Model::with(['unitUsers.unitData'])
            ->where('status', 4)
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Menghapus baris yang tidak diperlukan karena $dataReqs tidak didefinisikan
        // $data_complate = $data_complate->paginate(10);
        // $this->processData($data_complate);

        return view('complate.data_complate', compact('data_complate', 'name_page'));
    }

     public function accept($kode)
    {
        try {
            // Mencari data berdasarkan kode
            $data = Data_m_s_Model::where('kode', $kode)->first();

            if (!$data) {
                return redirect()->back()->with('error', 'Data tidak ditemukan');
            }

            // Update status menjadi 1
            $data->status = '1';
            $data->save();

            // Logging untuk tracking
            Log::info('Status updated successfully for kode: ' . $kode);

            return redirect()->back()->with('success', 'Status berhasil diupdate');

        } catch (\Exception $e) {
            Log::error('Error updating status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengupdate status: ' . $e->getMessage());
        }
    }
}