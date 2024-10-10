<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = [
        'tanggal_booking',
        'tanggal_kirim',
        'tanggal_terima_otomatis',
        'tanggal_terima',
        'tanggal_bawa',
        'kode_resi',
        'nama_barang',
        'koli',
        'berat',
        'konsumen_id',
        'nama_konsumen',
        'branch_id_asal',
        'branch_id_tujuan',
        'keterangan',
        'harga',
        'harga_kirim',
        'sub_charge',
        'biaya_admin',
        'total',
        'total_bayar',
        'jenis_pembayaran',
        'metode_pembayaran',
        'jumlah_bayar',
        'bukti_bayar',
        'status_bayar',
        'status_bawa',
        'gambar_pengambil',
        'nama_konsumen_penerima',
        'konsumen_penerima_id'
    ];

    public function cabangTujuan()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id_tujuan');
    }

    public function cabangAsal()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id_asal');
    }





    // Method untuk mendapatkan kode resi baru
    public static function generateKodeResi($cabangId, $userId)
    {
        $lastTransaksi = self::latest('kode_resi')->first();

        if ($lastTransaksi) {
            $lastCode = $lastTransaksi->kode_resi;
            $lastNumber = (int)substr($lastCode, -4) + 1;
            $nextCode = str_pad($lastNumber, 4, '0', STR_PAD_LEFT);
            return $nextCode;
        }

        return '0001';
    }

    // Relasi dengan User melalui Cabang
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi dengan Cabang
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    // Method untuk membuat kode resi baru dengan format yang diinginkan
    public static function createKodeResi($cabangId, $userId)
    {
        $cabang = Cabang::find($cabangId);

        if ($cabang) {
            $kota = Kota::find($cabang->id_kota);

            if ($kota) {
                $kodeKota = $kota->kode_kota;
                $kodeCabang = $cabang->kode_cabang;

                $latestCode = self::generateKodeResi($cabangId, $userId);
                $nextCode = 'GCE' . $kodeKota . $kodeCabang . $latestCode;

                return $nextCode;
            }
        }

        return null;
    }

    // Relasi dengan konsumen
    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'konsumen_id');
    }

    // Relasi dengan konsumen
    public function penerima()
    {
        return $this->belongsTo(Konsumen::class, 'konsumen_penerima_id');
    }

    public static function detailTransaksi()
    {
        return self::selectRaw('cabang_id, cabang_id_tujuan, tanggal_kirim, MONTH(tanggal_kirim) bulan, YEAR(tanggal_kirim) tahun,
                                (COALESCE(CASE WHEN jenis_pembayaran = "CASH" AND metode_pembayaran = "Transfer" AND (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(total_bayar, 0) ELSE 0 END, 0)) as cash_transfer,
                                (COALESCE(CASE WHEN jenis_pembayaran = "CASH" AND metode_pembayaran = "Tunai" AND (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(total_bayar, 0) ELSE 0 END, 0)) as cash_tunai,
                                (COALESCE(CASE WHEN jenis_pembayaran = "COD" AND (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(total_bayar, 0) ELSE 0 END, 0)) as cod,
                                (COALESCE(CASE WHEN jenis_pembayaran = "CAD" AND (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(total_bayar, 0) ELSE 0 END, 0)) as cad,
                                (COALESCE(CASE WHEN status_batal = "Verifikasi Disetujui" THEN COALESCE(biaya_pembatalan, 0) ELSE 0 END, 0)) as pembatalan,
                                (COALESCE(CASE WHEN (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(berat, 0) ELSE 0 END, 0)) as berat,
                                (COALESCE(CASE WHEN (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(koli, 0) ELSE 0 END, 0)) as koli,
                                (COALESCE(CASE WHEN (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(id, 0) ELSE 0 END, 0)) as resi');
    }

    public static function summaryTransaksi()
    {
        return self::selectRaw('cabang_id, cabang_id_tujuan, tanggal_kirim, MONTH(tanggal_kirim) bulan, DATE_FORMAT(tanggal_kirim, "%M") format_bulan, YEAR(tanggal_kirim) tahun,
                                SUM(COALESCE(CASE WHEN jenis_pembayaran = "CASH" AND metode_pembayaran = "Transfer" AND (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(total_bayar, 0) ELSE 0 END, 0)) as cash_transfer,
                                SUM(COALESCE(CASE WHEN jenis_pembayaran = "CASH" AND metode_pembayaran = "Tunai" AND (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(total_bayar, 0) ELSE 0 END, 0)) as cash_tunai,
                                SUM(COALESCE(CASE WHEN jenis_pembayaran = "COD" AND (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(total_bayar, 0) ELSE 0 END, 0)) as cod,
                                SUM(COALESCE(CASE WHEN jenis_pembayaran = "CAD" AND (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(total_bayar, 0) ELSE 0 END, 0)) as cad,
                                SUM(COALESCE(CASE WHEN status_batal = "Verifikasi Disetujui" THEN COALESCE(biaya_pembatalan, 0) ELSE 0 END, 0)) as pembatalan,
                                SUM(COALESCE(CASE WHEN (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(berat, 0) ELSE 0 END, 0)) as berat,
                                SUM(COALESCE(CASE WHEN (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(koli, 0) ELSE 0 END, 0)) as koli,
                                COUNT(COALESCE(CASE WHEN (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(id, 0) ELSE 0 END, 0)) as resi');
    }

}
