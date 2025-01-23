<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitUser extends Model
{
    use HasFactory;

    protected $table = 'user_unit';  // Nama tabel di database

    protected $fillable = [
        'unit',
        'type_unit',
        'id_uur',
    ];

    // Nonaktifkan timestamps
    public $timestamps = false;

    // Relasi ke model UnitModel (bukan Unit)
    public function unitData() {
        // Gunakan UnitModel::class
        return $this->belongsTo(UnitModel::class, 'unit', 'id_units');
    }

    // Relasi ke DataReq
    public function dataReq()
    {
        return $this->belongsTo(DataReqModel::class, 'id_uur', 'kode');
    }

    // Cast type_unit sebagai array
    protected $casts = [
        'type_unit' => 'array'
    ];

    // Primary Key jika berbeda dari 'id'
    protected $primaryKey = 'id_user_unit';
}
