<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\DashboardModel;

class DashboardController extends Controller
{
    public function index()
    {
         $minepermit = DashboardModel::countAccess1();
        $simper = DashboardModel::countAccess2();
        return view('dashboard.dashboard', compact('minepermit', 'simper'));
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
