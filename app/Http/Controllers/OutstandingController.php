<?php

namespace App\Http\Controllers;
use App\Models\DataReqModel;
use Illuminate\Http\Request;

class OutstandingController extends Controller
{
       public function index(){
         $name_page  = "B'Mine - Outstanding Request";
         $dep_req = session('logged_in_user')['departement'];
          $dataReqs = DataReqModel::with(['unitUsers.unitData'])
            ->where('dep_req', $dep_req)
            ->paginate(10);
        return view('outstanding.outstanding', compact('name_page', 'dataReqs'));
       }
}
