<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
 
    protected $table = 'pengeluaran';
    protected $fillable = [
        'tanggal_pengeluaran',
        'kode_pengeluaran',
        'nama_pengeluaran',
        'jumlah_pengeluaran',
        'keterangan',
        'pic',
        'bukti',
        'cabang_id'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
} 