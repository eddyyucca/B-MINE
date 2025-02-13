<?php

namespace App\Http\Controllers;
// Model
use App\Models\DataReqModel;
use App\Models\DataRejectModel;
use App\Models\UnitModel;
use App\Models\UnitUser;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class AkunController extends Controller
{
    public function akun_external()
    {
        $name_page  = "B'Mine - External Akun";
        $dataReqs = DataReqModel::all();
        $unit = UnitModel::all();
        $unit_user = UnitUser::all();
        $reject = DataRejectModel::all();
        return view('akun.external', compact('dataReqs', 'unit', 'unit_user', 'name_page'));
    }
}
