<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
       public function index(){
         $name_page  = "B'Mine - Dashboard";
        return view('history.history', compact('name_page'));
       }
}
