<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    protected $table = 'cabang';
    protected $fillable = [
        'kode_cabang',
        'nama_cabang',
        'id_kota',
        'nama_kota',
        'alamat_cabang'
    ];
}