<?php

namespace App\Http\Controllers;
use App\Models\DataReqModel;
use App\Models\Data_m_s_Model;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
       public function index(){
         $name_page  = "B'Mine - Dashboard";
          $data_complate = Data_m_s_Model::with(['unitUsers.unitData'])
            ->where('status', 1)
            ->paginate(10);
        return view('history.history', compact('name_page', 'data_complate'));
       }
}
