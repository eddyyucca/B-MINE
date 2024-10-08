<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
class QrcodeController extends Controller
{
      public function index() {
        return view('qrcode'); // Nama file Blade view
    }

    public function generatePDF()
    {
        $data = [
            'name' => 'Eddy Adha Saputra',
            'nik' => '10034026',
            'company' => 'BUMA',
            'department' => 'IT',
            'position' => 'Foreman',
            'expiry_date' => '15-Jun-25',
        ];

        $pdf = PDF::loadView('qrcode', $data);
        return $pdf->stream('id_card.pdf');
    }
}
