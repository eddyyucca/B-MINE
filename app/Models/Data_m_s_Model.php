<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data_m_s_Model extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'data_m_s';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode',
        'nik',
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
        'status',
        'dep_req',
        'sio_status',
        'access',
      'ktt',
        'status_access' // Tambahkan kolom baru
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
  public function unitUsers()
    {
        return $this->hasMany(UnitUser::class, 'id_uur', 'kode'); // Relasi: kode -> id_uur
    }
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}