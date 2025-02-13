<?php

namespace App\Http\Controllers;
// Model
use App\Models\DataReqModel;
use App\Models\DataRejectModel;
use App\Models\UnitModel;
use App\Models\UnitUser;
use App\Models\karyawanModel;
use App\Models\UserModel;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class AkunController extends Controller
{
    public function akun_external()
    {
        $name_page  = "B'Mine - External Akun";
        $dataKar = UserModel::all();
        return view('akun.external', compact('dataKar','name_page'));
    }

    public function akun_internal()
    {
        $name_page  = "B'Mine - Internal Akun";
        $dataKar = karyawanModel::all();
        return view('akun.internal', compact('dataKar','name_page'));
    }
}
