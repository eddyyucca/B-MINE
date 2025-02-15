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
        // $dataReqs = $dataReqs->paginate(10);
        // $this->processData($dataReqs);

        return view('complate.data_complate', compact('data_complate', 'name_page'));
    }
}