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
    public function dashboard_external()
    {
        return view('dashboard.dashboard_external');
    }
    public function about()
    {
        return view('dashboard.about');
    }
}
