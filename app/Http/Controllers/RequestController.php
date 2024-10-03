<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Tambahkan ini
class RequestController extends Controller
{
    public function index(){
          return view('request.request');
    }
    public function not_found(){
          return view('request.not_found');
    }

  public function get_data_nik(Request $request)
{
    // Tangkap data yang dikirim dari form
    $nik = $request->input('nik');

    // Cek apakah NIK diisi
    if (!$nik) {
        return redirect()->back()->withErrors(['NIK tidak ditemukan.']);
    }

    $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJkaSBiYWxpayBrb2RlIHlhbmcgdGVyc2VtYnVueWksIFRlcnNpbXBhbiBuYW1hIEVkZHkgQWRoYSBTYXB1dHJhIHBlbnVoaCBhcnRpLiBIb3J1Zi1odXJ1ZiB0ZXJhbmdrYWkgZGVuZ2FuIHJhcGksIFNlcGVydGkgcGVyamFsYW5hbiB5YW5nIHRhayBwZXJuYWggbWF0aS4gU2V0aWFwIGh1cnVmIHB1bnlhIG1ha25hIG1lbmRhbGFtLCBNZW5ndWtpciBqZWphayBkaWRhbGFtIGluZ2F0YW4uIFNlcGVydGkgdG9rZW4gdW5nIG1lbmthbmksIFVuZHVyIG5hbWFtdSwgRWRkeSwgdGFra2FuIHB1ZGFyIHNlbGFtY2FueWEuIiwibmFtZSI6IkVkZHkgQWRoYSBTYXB1dHJhIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c'; // Token API langsung di controller

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->get('https://rest-api-peoplesync.bmine.id/karyawan/' . $nik);

    $data = $response->json();
    
    // Cek apakah data null atau kosong
    if (is_null($data) || empty($data)) {
        return redirect()->back()->withErrors(['Data tidak ditemukan untuk NIK yang diberikan.']);
    }

    // Jika data ditemukan, kirimkan data ke view
    return redirect()->back()->with('data', $data);
}

}
