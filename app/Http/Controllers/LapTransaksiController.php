<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Pengeluaran;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LapTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_pendapatan(Request $request)
    {
        $filterStartDate = $request->start_date ?? today()->format('Y-m-d');
        $filterEndDate = $request->end_date ?? today()->format('Y-m-d');

        $pendapatan = Transaksi::when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
            return $q->whereDate('tanggal_kirim', '>=', $filterStartDate) // Menambahkan kondisi untuk filter tanggal mulai
                ->whereDate('tanggal_kirim', '<=', $filterEndDate); // Menambahkan kondisi untuk filter tanggal akhir
        })->get();

        return view('laporan.pendapatan.index', compact('pendapatan', 'filterStartDate', 'filterEndDate'));
    }

    public function index_pengiriman(Request $request)
    {
        $filterStartDate = $request->start_date ?? null;
        $filterEndDate = $request->end_date ?? null;

        $pengiriman = Transaksi::when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
            return $q->whereDate('tanggal_kirim', '>=', $filterStartDate) // Menambahkan kondisi untuk filter tanggal mulai
                ->whereDate('tanggal_kirim', '<=', $filterEndDate); // Menambahkan kondisi untuk filter tanggal akhir
        })->get();

        return view('laporan.pengiriman.index', compact('pengiriman', 'filterStartDate', 'filterEndDate'));
    }

    public function index_pengiriman_belum_kirim(Request $request)
    {
        $filterStartDate = $request->start_date ?? null;
        $filterEndDate = $request->end_date ?? null;

        $pengiriman = Transaksi::when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
            return $q->whereDate('tanggal_kirim', '>=', $filterStartDate) // Menambahkan kondisi untuk filter tanggal mulai
                ->whereDate('tanggal_kirim', '<=', $filterEndDate); // Menambahkan kondisi untuk filter tanggal akhir
        })->get();

        return view('laporan.pengiriman_belum_kirim.index', compact('pengiriman', 'filterStartDate', 'filterEndDate'));
    }

    public function index_kasir_detail(Request $request)
    {
        $filterStartDate = $request->input('start_date', Carbon::now()->format('Y-m-d'));
        $filterEndDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $kasir_detail = Transaksi::query();

        // Jika pengguna bukan superAdmin dan memiliki cabang_id, maka filter berdasarkan cabang_id
        if (!$this->isSuperadmin() && Auth::user()->cabang_id) {
            $kasir_detail->where('cabang_id', Auth::user()->cabang_id);
        }

        $kasir_detail = $kasir_detail
            ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                return $q->whereDate('tanggal_kirim', '>=', $filterStartDate)
                    ->whereDate('tanggal_kirim', '<=', $filterEndDate);
            })
            ->where(function ($q) {
                // Tambahkan ini agar kondisi whereNotNull('status_batal') dan whereNull('status_batal') menjadi satu kelompok
                $q->whereNull('status_batal')
                    ->orWhereNotNull('status_batal');
            })
            ->get();

        return view('laporan.kasir_detail.index', compact('kasir_detail', 'filterStartDate', 'filterEndDate'));
    }




    public function index_kasir_summary(Request $request)
    {
        // Ambil data filter tanggal dari request
        $filterStartDate = $request->input('start_date', Carbon::now()->format('Y-m-d'));
        $filterEndDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Cek apakah user adalah superadmin
        $isSuperadmin = $this->isSuperadmin();

        // Ambil cabang_id dari user yang sedang login
        $cabangId = $isSuperadmin ? null : auth()->user()->cabang_id;
        // $transaksi = Transaksi::whereIn('jenis_pembayaran', ['CASH','COD'])
        $transaksi = Transaksi::whereIn('jenis_pembayaran', ['CASH', 'COD'])
            ->when(!$isSuperadmin, function ($q) use ($cabangId) {
                $q->where('cabang_id', $cabangId);
            })
            ->selectRaw('cabang_id,
                     SUM(COALESCE(CASE WHEN jenis_pembayaran = "CASH" AND metode_pembayaran = "Tunai" AND (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(total_bayar, 0) ELSE 0 END, 0)) as total_bayar,
                     SUM(COALESCE(CASE WHEN status_batal = "Verifikasi Disetujui" THEN COALESCE(biaya_pembatalan, 0) ELSE 0 END, 0)) as biaya_pembatalan')
            ->whereBetween('tanggal_kirim', [$filterStartDate, $filterEndDate])
            ->groupBy('cabang_id')
            ->get();






        // Query untuk mengambil data transaksi COD sesuai filter
        $transaksiCod = Transaksi::where('jenis_pembayaran', 'COD')
            ->where('metode_pembayaran', 'Tunai') // Filter untuk metode pembayaran Tunai
            ->whereNull('status_batal')
            ->when(!$isSuperadmin, function ($q) use ($cabangId) {
                $q->where('cabang_id_tujuan', $cabangId);
            })
            // ->whereNotNull('tanggal_terima') // Filter untuk tanggal_terima tidak null
            ->whereBetween('tanggal_terima', [$filterStartDate, $filterEndDate])
            ->groupBy('cabang_id_asal') // Mengelompokkan berdasarkan cabang_id
            ->selectRaw('cabang_id_asal, SUM(total_bayar) as total_bayar')
            ->get();

        // Hitung summary total_bayar COD
        $totalBayarCod = $transaksiCod->sum('total_bayar');








        $total_pengeluaran = Pengeluaran::where('cabang_id', $cabangId)
            ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                return $q->whereDate('tanggal_pengeluaran', '>=', $filterStartDate)
                    ->whereDate('tanggal_pengeluaran', '<=', $filterEndDate);
            })
            ->sum('jumlah_pengeluaran');






        // Pass data ke view
        return view('laporan.kasir_summary.index', [
            'transaksi' => $transaksi,
            'transaksiCod' => $transaksiCod,
            'totalBayar' => $transaksi->sum('total_bayar'),
            'totalBayarCod' => $totalBayarCod,
            'filterStartDate' => $filterStartDate,
            'filterEndDate' => $filterEndDate,
            'total_pengeluaran' => $total_pengeluaran,
        ]);
    }











    public function index_all_summary(Request $request)
    {
        $filterStartDate = $request->start_date ?? today()->format('Y-m-d');
        $filterEndDate = $request->end_date ?? today()->format('Y-m-d');

        // Query untuk mengambil summary seperti sebelumnya
        $summary = Transaksi::select(
            'transaksi.cabang_id',
            'transaksi.cabang_id_tujuan',
            DB::raw('SUM(CASE WHEN transaksi.jenis_pembayaran = "CASH" THEN transaksi.total_bayar ELSE 0 END) as total_cash'),
            DB::raw('SUM(CASE WHEN transaksi.jenis_pembayaran = "COD" THEN transaksi.total_bayar ELSE 0 END) as total_cod'),
            DB::raw('SUM(CASE WHEN transaksi.jenis_pembayaran = "CAD" THEN transaksi.total_bayar ELSE 0 END) as total_cad')
        )
            ->leftJoin('cabang as cabang_tujuan', 'transaksi.cabang_id_tujuan', '=', 'cabang_tujuan.id')
            ->where('transaksi.status_bawa', '=', 'Sudah Dibawa')
            ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                return $q->whereDate('tanggal_kirim', '>=', $filterStartDate) // Menambahkan kondisi untuk filter tanggal mulai
                    ->whereDate('tanggal_kirim', '<=', $filterEndDate); // Menambahkan kondisi untuk filter tanggal akhir
            })
            ->groupBy('transaksi.cabang_id_tujuan', 'cabang_tujuan.nama_cabang')
            ->get();

        // Hitung total pendapatan per cabang_id_tujuan
        $total_pendapatan_per_cabang = Transaksi::select(
            'transaksi.cabang_id_tujuan',
            DB::raw('SUM(total_bayar) as total_pendapatan')
        )
            ->whereIn('jenis_pembayaran', ['COD', 'CASH', 'CAD'])
            ->where('status_bawa', 'Sudah Dibawa')
            ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                return $q->whereDate('tanggal_kirim', '>=', $filterStartDate) // Menambahkan kondisi untuk filter tanggal mulai
                    ->whereDate('tanggal_kirim', '<=', $filterEndDate); // Menambahkan kondisi untuk filter tanggal akhir
            })
            ->groupBy('cabang_id_tujuan')
            ->get();

        // Menghitung total pendapatan dari total_pendapatan_per_cabang
        $total_pendapatan = $total_pendapatan_per_cabang->sum('total_pendapatan');

        // Hitung total pengeluaran per cabang_id
        $total_pengeluaran_per_cabang = Pengeluaran::select(
            'cabang_id',
            DB::raw('SUM(jumlah_pengeluaran) as total_pengeluaran')
        )
            ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                return $q->whereDate('tanggal_pengeluaran', '>=', $filterStartDate) // Menambahkan kondisi untuk filter tanggal mulai
                    ->whereDate('tanggal_pengeluaran', '<=', $filterEndDate); // Menambahkan kondisi untuk filter tanggal akhir
            })
            ->groupBy('cabang_id')
            ->get();

        // Menghitung total pengeluaran dari total_pengeluaran_per_cabang
        $total_pengeluaran = $total_pengeluaran_per_cabang->sum('total_pengeluaran');

        // Menghitung total harus disetor
        $total_harus_disetor = $total_pendapatan - $total_pengeluaran;

        return view('laporan.all_summary.index', compact('summary', 'total_pendapatan_per_cabang', 'total_pengeluaran_per_cabang', 'total_pendapatan', 'total_pengeluaran', 'total_harus_disetor', 'filterStartDate', 'filterEndDate'));
    }

    public function index_pembayaran()
    {
        $pembayaran = Transaksi::all();
        return view('laporan.pembayaran.index', compact('pembayaran'));
    }

    public function index_daftar_muat_detail(Request $request)
    {
        $filterStartDate = $request->start_date ?? Carbon::now()->format('Y-m-d');
        $filterEndDate = $request->end_date ?? Carbon::now()->format('Y-m-d');

        $daftar_muat = Transaksi::select(
            'transaksi.*',
            'cabang_asal.nama_cabang as nama_cabang_asal',
            'cabang_tujuan.nama_cabang as nama_cabang_tujuan',
            'konsumen.no_telp'
        )
            ->leftJoin('cabang as cabang_asal', 'transaksi.cabang_id_asal', '=', 'cabang_asal.id')
            ->leftJoin('cabang as cabang_tujuan', 'transaksi.cabang_id_tujuan', '=', 'cabang_tujuan.id')
            ->leftJoin('konsumen', 'transaksi.nama_konsumen_penerima', '=', 'konsumen.nama_konsumen')
            // ->where('transaksi.status_bawa', '=', 'Sudah Dibawa')
            ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                return $q->whereDate('tanggal_kirim', '>=', $filterStartDate) // Menambahkan kondisi untuk filter tanggal mulai
                    ->whereDate('tanggal_kirim', '<=', $filterEndDate); // Menambahkan kondisi untuk filter tanggal akhir
            })
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('transaksi.cabang_id', Auth::user()->cabang_id);
            })

            ->get();

        return view('laporan.daftar_muat_detail.index', compact('daftar_muat', 'filterStartDate', 'filterEndDate'));
    }

    public function index_daftar_muat_summary(Request $request)
    {
        $filterStartDate = $request->start_date ?? Carbon::now()->format('Y-m-d');
        $filterEndDate = $request->end_date ?? Carbon::now()->format('Y-m-d');

        $summary = Transaksi::select(
            'transaksi.cabang_id',
            'transaksi.cabang_id_tujuan',
            DB::raw('SUM(transaksi.koli) as total_koli'),
            DB::raw('SUM(transaksi.berat) as total_berat')
        )
            ->leftJoin('cabang as cabang_tujuan', 'transaksi.cabang_id_tujuan', '=', 'cabang_tujuan.id')
            ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                return $q->whereDate('tanggal_kirim', '>=', $filterStartDate)
                    ->whereDate('tanggal_kirim', '<=', $filterEndDate);
            })
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('transaksi.cabang_id', Auth::user()->cabang_id);
            })
            ->where(function ($q) {
                $q->where('transaksi.status_batal', '!=', 'Verifikasi Disetujui')
                    ->where('transaksi.status_batal', '!=', 'Telah Diambil Pembatalan')
                    ->orWhereNull('transaksi.status_batal');
            })
            ->groupBy('transaksi.cabang_id_tujuan', 'cabang_tujuan.nama_cabang')
            ->get();

        return view('laporan.daftar_muat_summary.index', compact('summary', 'filterStartDate', 'filterEndDate'));
    }




    public function index_bongkar_detail(Request $request)
    {
        // Menggunakan waktu server yang nyata
        $currentServerDate = Carbon::now()->format('Y-m-d');

        // Mengambil tanggal filter dari request atau menggunakan waktu server jika tidak ada
        $filterStartDate = $request->start_date ?? $currentServerDate;
        $filterEndDate = $request->end_date ?? $currentServerDate;

        // Ambil tanggal terima otomatis terkecil dari database
        $tanggalTerimaOtomatis = Transaksi::min('tanggal_terima_otomatis');

        // Jika waktu server sekarang kurang dari tanggal_terima_otomatis, jangan tampilkan data
        $bongkar = [];
        if ($currentServerDate >= $tanggalTerimaOtomatis) {
            // Jika sudah sesuai, baru jalankan query untuk mengambil data
            $bongkar = Transaksi::select(
                'transaksi.*',
                'cabang_asal.nama_cabang as nama_cabang_asal',
                'cabang_tujuan.nama_cabang as nama_cabang_tujuan',
                'konsumen.no_telp'
            )
                ->leftJoin('cabang as cabang_asal', 'transaksi.cabang_id_asal', '=', 'cabang_asal.id')
                ->leftJoin('cabang as cabang_tujuan', 'transaksi.cabang_id_tujuan', '=', 'cabang_tujuan.id')
                ->leftJoin('konsumen', 'transaksi.nama_konsumen_penerima', '=', 'konsumen.nama_konsumen')
                ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate, $currentServerDate) {
                    return $q->whereDate('tanggal_terima_otomatis', '>=', $filterStartDate)
                             ->whereDate('tanggal_terima_otomatis', '<=', $filterEndDate)
                             // Tambahkan validasi bahwa data tidak boleh muncul sebelum tanggal sekarang
                             ->whereDate('tanggal_terima_otomatis', '<=', $currentServerDate);
                })
                ->when(!$this->isSuperadmin(), function ($q) {
                    return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
                })
                // Tambahkan validasi status_batal tidak terisi
                ->whereNull('status_batal')
                ->get();
        }

        // Kirimkan variabel bongkar, filter date ke view tanpa pesan error
        return view('laporan.bongkar_detail.index', compact('bongkar', 'filterStartDate', 'filterEndDate'));
    }



    public function index_bongkar_summary(Request $request)
    {
        // Menggunakan waktu server yang nyata
        $currentServerDate = Carbon::now()->format('Y-m-d');

        // Mengambil tanggal filter dari request atau menggunakan waktu server jika tidak ada
        $filterStartDate = $request->start_date ?? $currentServerDate;
        $filterEndDate = $request->end_date ?? $currentServerDate;

        // Ambil tanggal terima otomatis terkecil dari database
        $tanggalTerimaOtomatis = Transaksi::min('tanggal_terima_otomatis');

        // Jika waktu server sekarang kurang dari tanggal_terima_otomatis, jangan tampilkan data
        $summary = [];
        if ($currentServerDate >= $tanggalTerimaOtomatis) {
            // Jika sudah sesuai, baru jalankan query untuk mengambil data
            $summary = Transaksi::select(
                'transaksi.cabang_id',
                'transaksi.cabang_id_tujuan',
                DB::raw('SUM(transaksi.koli) as total_koli'),
                DB::raw('SUM(transaksi.berat) as total_berat')
            )
                ->leftJoin('cabang as cabang_tujuan', 'transaksi.cabang_id_tujuan', '=', 'cabang_tujuan.id')
                ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate, $currentServerDate) {
                    return $q->whereDate('tanggal_terima_otomatis', '>=', $filterStartDate)
                             ->whereDate('tanggal_terima_otomatis', '<=', $filterEndDate)
                             // Tambahkan validasi bahwa data tidak boleh muncul sebelum tanggal sekarang
                             ->whereDate('tanggal_terima_otomatis', '<=', $currentServerDate);
                })
                ->when(!$this->isSuperadmin(), function ($q) {
                    return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
                })
                // Tambahkan validasi status_batal tidak terisi
                ->whereNull('status_batal')
                ->groupBy('transaksi.cabang_id_tujuan', 'cabang_tujuan.nama_cabang')
                ->get();
        }

        // Kirimkan variabel summary, filter date ke view tanpa pesan error
        return view('laporan.bongkar_summary.index', compact('summary', 'filterStartDate', 'filterEndDate'));
    }






    public function index_transferan(Request $request)
    {
        $filterStartDate = $request->start_date ?? today()->format('Y-m-d');
        $filterEndDate = $request->end_date ?? today()->format('Y-m-d');

        $transferan = Transaksi::where('jenis_pembayaran', '!=', 'CAD')
                                ->where('metode_pembayaran', 'Transfer')
                                ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                                    return $q->whereDate('tanggal_kirim', '>=', $filterStartDate) // Menambahkan kondisi untuk filter tanggal mulai
                                        ->whereDate('tanggal_kirim', '<=', $filterEndDate); // Menambahkan kondisi untuk filter tanggal akhir
                                })
                                ->get();

        return view('laporan.transferan.index', compact('transferan', 'filterStartDate', 'filterEndDate'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pendapatan.create');
    }

    public function show($id)
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Metode untuk menyimpan data pendapatan
    public function store(Request $request)
    {
    }



    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
    }


    public function destroy($id)
    {
    }

    public function getLatestCodeTransaksi()
    {
    }
}
