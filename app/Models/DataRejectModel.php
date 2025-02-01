<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRejectModel extends Model
{
    use HasFactory;

    public $timestamps = false; // Tambahkan ini

    protected $table = 'data_reject';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode',
        'nik',
        'nama',
        'jab',
        'dept',
        'reject_history'
    ];

    protected $casts = [
        'reject_history' => 'array'
    ];
}
