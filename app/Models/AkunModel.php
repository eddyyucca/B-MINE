<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunModel extends Model
{
   protected $table = 'id_login_ext';
    
    protected $fillable = [
        'nama',
        'email',
        'password',
        'level',
        'area'
    ];

    protected $hidden = [
        'password'
    ];

    // If you don't want to use Laravel's default timestamp columns
    public $timestamps = false;
}
"{
\"CHR-BT\":\"yes\",
\"CHR-FSP\":\"yes\",
\"CP-FSP\":\"yes\",
\"CP-BT\":\"yes\",
\"PIT-BT\":\"yes\",
\"PIT-TA\":\"yes\",
\"PIT-TJ\":\"yes\"
}"