<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitUser extends Model
{
    use HasFactory;

    protected $table = 'user_unit';

    protected $fillable = [
        'unit',
        'type_unit',
        'id_uur',
    ];

    public $timestamps = false;

    protected $primaryKey = 'id_user_unit';

    // Hapus atau modifikasi casting untuk type_unit
    protected $casts = [];
    
    // Atau jika ingin tetap menggunakan casting, tambahkan mutator
    public function setTypeUnitAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['type_unit'] = '["' . implode('","', $value) . '"]';
        } else {
            $this->attributes['type_unit'] = $value;
        }
    }

    public function unitData() {
        return $this->belongsTo(UnitModel::class, 'unit', 'id_units');
    }

    public function dataReq()
    {
        return $this->belongsTo(DataReqModel::class, 'id_uur', 'kode');
    }
}