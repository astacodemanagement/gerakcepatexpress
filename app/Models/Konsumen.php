<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    use HasFactory;

    protected $table = 'konsumen';
    protected $fillable = [
        'nama_konsumen',
        'nama_perusahaan',
        'no_telp',
        'email',
        'alamat',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}