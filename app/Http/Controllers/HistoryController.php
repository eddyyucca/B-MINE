<?php

namespace App\Http\Controllers;
use App\Models\DataReqModel;
use App\Models\Data_m_s_Model;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(){
        $name_page = "B'Mine - History Complate";
        
        // Cek level pengguna yang login
        $loggedInUser = session('logged_in_user')['level'];
        
        // Query dasar
        $query = Data_m_s_Model::with(['unitUsers.unitData'])->where('status', 1);
        
        // Jika level pengguna adalah section_admin, tampilkan hanya data departemen yang sama
        if ($loggedInUser == 'section_admin') {
            // Perbaikan: Menggunakan 'dept' bukan 'level'
            $userDept = session('logged_in_user')['departement'];
            $query->where('dept', $userDept);
        }
        // Jika level pengguna lain, tampilkan semua data (tidak perlu filter tambahan)
        
        // Eksekusi query dengan pagination
        $data_complate = $query->paginate(10);
        
        return view('history.history', compact('name_page', 'data_complate'));
    }
}
