<?php

namespace App\Http\Controllers;
use App\Models\DataReqModel;
use Illuminate\Http\Request;

class OutstandingController extends Controller
{
   public function index()
    {
        $name_page = "B'Mine - Outstanding Request";
        $level = session('logged_in_user')['level'];
        $dep_req = session('logged_in_user')['departement'];
        
        // Jika level user adalah she atau admin, tampilkan semua data
        if($level == 'she' || $level == 'admin'){
            $dataReqs = DataReqModel::with(['unitUsers.unitData'])
                ->paginate(10);
        } 
        // Jika level user selain she dan admin, tampilkan data sesuai dep_req
        else {
            $dataReqs = DataReqModel::with(['unitUsers.unitData'])
                ->where('dep_req', $dep_req)
                ->paginate(10);
        }
        
        return view('outstanding.outstanding', compact('name_page', 'dataReqs'));
    }
}
