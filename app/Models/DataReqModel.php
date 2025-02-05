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
        'date_req',
        'foto_path',
        'medical_path',
        'drivers_license_path',
        'attachment_path',
        'sio_path',
        'validasi_in',
        'sio_status',
        'status',
        'access',
        'reject_history',
        'locked_by',
        'locked_by_name',
        'locked_at'
    ];

    protected $casts = [
        'access' => 'array',
        'reject_history' => 'array'
    ];

    public $timestamps = false;

    public function unitUsers()
    {
        return $this->hasMany(UnitUser::class, 'id_uur', 'kode'); // Relasi: kode -> id_uur
    }
}
