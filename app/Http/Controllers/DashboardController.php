<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\DashboardModel;
use App\Models\DataReqModel;

class DashboardController extends Controller
{
    public function index()
    {
        $minepermit = DashboardModel::countAccess1();
        $simper = DashboardModel::countAccess2();
        $sheprosess = DataReqModel::where('validasi_in', 1)->count();
        $pjoprosess = DataReqModel::where('validasi_in', 2)->count();
        $becprosess = DataReqModel::where('validasi_in', 3)->count();
        $kttprosess = DataReqModel::where('validasi_in', 4)->count();
        $minepermit_data = DataReqModel::where('status', 1)->count();
        $simper_data = DataReqModel::where('status', 2)->count();
        $totaloutstanding = $sheprosess + $pjoprosess + $becprosess + $kttprosess;
        // $userData = Session::get('logged_in_user');
        return view('dashboard.dashboard', compact('minepermit', 'simper', 'sheprosess', 'pjoprosess', 'becprosess', 'kttprosess', 'totaloutstanding', 'simper_data', 'minepermit_data'));

    }
    public function dashboard_external()
    {
        $minepermit = DashboardModel::countAccess1();
        $simper = DashboardModel::countAccess2();
        return view('dashboard.dashboard', compact('minepermit', 'simper'));
    }
    public function about()
    {
        return view('dashboard.about');
    }
}
