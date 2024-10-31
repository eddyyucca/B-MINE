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

    // Jika tabel tidak memiliki timestamps (created_at, updated_at)
      public $timestamps = false;
}
