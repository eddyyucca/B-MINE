<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitModel extends Model
{
    use HasFactory;

    // Definisi nama tabel
    protected $table = 'units';

    // Tentukan primary key yang benar
    protected $primaryKey = 'id_units';

    // Nonaktifkan timestamps
    public $timestamps = false;

    // Izinkan mass assignment untuk semua kolom
    protected $guarded = [];

    // Relasi ke UserUnit - sesuaikan foreign key
    public function userUnits()
    {
        return $this->hasMany(UserUnit::class, 'unit', 'id_units');
    }

    // Definisikan kolom yang bisa diisi
    protected $fillable = [
        'id_units',
        'nama_unit',
        // tambahkan kolom lain yang ada di tabel units
    ];
}
