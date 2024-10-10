<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    protected $fillable = [
        'cabang_id',
        'no_invoice',
        'tanggal_invoice',
        'status_invoice',
        'bill_to_id',
        'bill_to',
    ];

    public function cabangTujuan()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id_tujuan');
    }

    public function cabangAsal()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id_asal');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

}