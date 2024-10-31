<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitModel extends Model
{
   use HasFactory;

    // Jika nama tabel berbeda dari nama model (misal: 'units')
    protected $table = 'units';

    // Jika tabel tidak memiliki kolom 'created_at' dan 'updated_at'
    public $timestamps = false;

    // Jika ada kolom lain yang tidak ingin dimasukkan secara mass assignment
    protected $guarded = []; // or you can list specific fields ['id', 'name']
}
