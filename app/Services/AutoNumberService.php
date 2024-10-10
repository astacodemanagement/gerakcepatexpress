<?php

namespace App\Services;

use App\Models\Cabang;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class AutoNumberService
{
    public function invoice($cabangId)
    {
        $invoiceCodeLength = 6;
        $bulan = date('n'); // Mengambil bulan dalam format numerik tanpa leading zero
        $tahun = date('Y');
        
        // Daftar angka Romawi untuk bulan
        $bulanRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        $prefix = "INV/GCE/{$bulanRomawi[$bulan]}/{$tahun}/";

        // Ambil nomor terakhir berdasarkan prefix yang sama
        $lastInvoice = Invoice::select(DB::raw('RIGHT(no_invoice, 6) as no_invoice'))
            ->where(DB::raw('SUBSTRING(no_invoice, 1, LENGTH(no_invoice) - 6)'), $prefix)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastInvoice && $lastInvoice->no_invoice) {
            $lastNumber = (int)$lastInvoice->no_invoice + 1;
            $nextNumber = str_pad($lastNumber, $invoiceCodeLength, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = str_pad(1, $invoiceCodeLength, '0', STR_PAD_LEFT);
        }

        return $prefix . $nextNumber;
    }
}
