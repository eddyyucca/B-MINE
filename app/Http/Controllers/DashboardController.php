<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.dashboard');
    }
<<<<<<< HEAD
=======
    public function dashboard_external()
    {
        return view('dashboard.dashboard_external');
    }
>>>>>>> 1aaaf7a (update 03102024)
    public function about()
    {
        return view('dashboard.about');
    }
}
