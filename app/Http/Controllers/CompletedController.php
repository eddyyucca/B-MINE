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

class CompletedController extends Controller
{
    public function data_completed() 
    {
        $name_page = "B'Mine - Completed Submission";
        
        // Menggunakan nama model yang benar (Data_m_s_Model)
        $data_completed = Data_m_s_Model::with(['unitUsers.unitData'])
            ->where('status', 4)
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Menghapus baris yang tidak diperlukan karena $dataReqs tidak didefinisikan
        // $data_completed = $data_completed->paginate(10);
        // $this->processData($data_completed);

        return view('completed.data_completed', compact('data_completed', 'name_page'));
    }

     public function accept($kode)
{
    try {
        // Debug untuk melihat kode yang diterima
        Log::info('Accepting kode: ' . $kode);
        
        // Mencari data berdasarkan kode
        $data = Data_m_s_Model::where('kode', $kode)->first();

        if (!$data) {
            Log::warning('Data tidak ditemukan untuk kode: ' . $kode);
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Log status sebelum diubah
        Log::info('Status sebelum: ' . $data->status);

        // Update status menjadi 1
        $data->status = '1';
        $data->save();

        // Log status setelah diubah
        Log::info('Status setelah: ' . $data->status);

        return redirect()->back()->with('success', 'Status berhasil diupdate');

    } catch (\Exception $e) {
        Log::error('Error updating status: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Gagal mengupdate status: ' . $e->getMessage());
    }
}
}