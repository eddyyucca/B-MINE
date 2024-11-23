<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataReqModel extends Model
{
     use HasFactory;

    protected $table = 'data_req';  // Nama tabel di database

    protected $fillable = [
        'nik', 
        'kode', 
        'nama', 
        'jab', 
        'dept', 
        'foto_path', 
        'medical_path', 
        'drivers_license_path', 
        'attachment_path',
        'sio_path',
        'validasi_in',
        'sio_status',
        'status',
        'access'
    ];

    // Jika tabel tidak memiliki timestamps (created_at, updated_at)
      public $timestamps = false;
}
