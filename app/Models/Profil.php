<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;
 
    protected $table = 'profil';
    protected $fillable = [
        'nama_profil',
        'alias',
        'no_telp',
        'email',
        'alamat',
        'biaya_admin',
        'biaya_pembatalan',
        'no_rekening',
        'bank',
        'atas_nama',
        'gambar',
        'link'
    ];
}
