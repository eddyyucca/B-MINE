<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\DashboardModel;
use App\Models\DataReqModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index() {
        $loggedInUser=session('logged_in_user')['level'];
        $name_page  = "B'Mine - Dashboard";
        $minepermit=DashboardModel::countAccess1();
        $simper=DashboardModel::countAccess2();
        $sheprosess=DataReqModel::where('validasi_in', 1)->count();
        $pjoprosess=DataReqModel::where('validasi_in', 2)->count();
        $becprosess=DataReqModel::where('validasi_in', 3)->count();
        $kttprosess=DataReqModel::where('validasi_in', 4)->count();
        $minepermit_data=DataReqModel::where('status', 1)->count();
        $simper_data=DataReqModel::where('status', 2)->count();
        $totaloutstanding=$sheprosess+$pjoprosess+$becprosess+$kttprosess;

        if ($loggedInUser==='admin'|| $loggedInUser==='section_admin'|| $loggedInUser==='she'|| $loggedInUser==='pjo') {
            // Jika pengguna adalah admin, section_admin, she, atau pjo
             return view('dashboard.dashboard', compact('name_page','minepermit', 'simper', 'sheprosess', 'pjoprosess', 'becprosess', 'kttprosess', 'totaloutstanding', 'simper_data', 'minepermit_data'));
        }

        elseif ($loggedInUser==='bec'|| $loggedInUser==='ktt') {
            // Jika pengguna adalah bec atau pjo
            return view('dashboard.dashboard_external', compact('name_page','minepermit', 'simper', 'sheprosess', 'pjoprosess', 'becprosess', 'kttprosess', 'totaloutstanding', 'simper_data', 'minepermit_data'));
        }

        else {
            // Jika tidak ada peran yang sesuai
            echo "Tidak ada peran yang dikenali";
        }
    }

    public function about() {
         $name_page  = "B'Mine - Dashboard";
        return view('dashboard.about', compact('name_page'));
    }
      public function reset_password(Request $request) {
        $name_page  = "B'Mine - Dashboard";
        return view('setting.reset_password', compact('name_page'));
    }
}
