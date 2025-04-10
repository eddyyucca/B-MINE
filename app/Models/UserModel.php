<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'login_external';  // Nama tabel di database
    protected $primaryKey = 'id_login_ext'; // Add this line to define primary key

    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
    ];
    // Jika tabel tidak memiliki timestamps (created_at, updated_at)
    public $timestamps = false;
}
