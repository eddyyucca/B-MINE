<?php

namespace App\Http\Controllers;
use App\Models\DataReqModel;
use Illuminate\Http\Request;

class OutstandingController extends Controller
{
       public function index(){
         $name_page  = "B'Mine - Dashboard";
          $dataReqs = DataReqModel::with(['unitUsers.unitData'])
            ->where('status', 1)
            ->paginate(10);
        return view('outstanding.outstanding', compact('name_page', 'dataReqs'));
       }
}
