<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardModel extends Model
{
       protected $table = 'data_m_s'; // Dideklarasikan di luar metode
     // Metode untuk menghitung user dengan akses 1
    public static function countAccess1()
    {
        return self::where('status_access', 1)->count();
    }

    // Metode untuk menghitung user dengan akses 2
    public static function countAccess2()
    {
        return self::where('status_access', 2)->count();
    }
}
