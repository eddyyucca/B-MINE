<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    use HasFactory;
     protected $table = 'user_access';  // Nama tabel di database

    protected $fillable = [
        'access', 
        'code_user', 
    ];

    // Jika tabel tidak memiliki timestamps (created_at, updated_at)
      public $timestamps = false;
}
