<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Pengeluaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $today = Carbon::now()->toDateString(); // Ambil tanggal hari ini

        if ($this->isSuperadmin()) {
            $summaryCash = Transaksi::selectRaw('SUM(COALESCE(CASE WHEN status_batal IN ("Verifikasi Disetujui", "Telah Diambil Pembatalan") THEN 0 ELSE COALESCE(CASE WHEN jenis_pembayaran = "CASH" AND metode_pembayaran = "Tunai" THEN COALESCE(total_bayar, 0) ELSE 0 END, 0) END, 0)) as total')
                ->whereDate('tanggal_kirim', $today)
                ->get();
        } else {
            $summaryCash = Transaksi::selectRaw('SUM(COALESCE(CASE WHEN status_batal IN ("Verifikasi Disetujui", "Telah Diambil Pembatalan") THEN 0 ELSE COALESCE(CASE WHEN jenis_pembayaran = "CASH" AND metode_pembayaran = "Tunai" THEN COALESCE(total_bayar, 0) ELSE 0 END, 0) END, 0)) as total')
                ->where('cabang_id', Auth::user()->cabang_id)
                ->whereDate('tanggal_kirim', $today)
                ->get();
        }

        if ($this->isSuperadmin()) {
            $summaryCashTransfer = Transaksi::selectRaw('SUM(COALESCE(CASE WHEN status_batal IN ("Verifikasi Disetujui", "Telah Diambil Pembatalan") THEN 0 ELSE COALESCE(CASE WHEN jenis_pembayaran = "CASH" AND metode_pembayaran = "Transfer" THEN COALESCE(total_bayar, 0) ELSE 0 END, 0) END, 0)) as total')
                ->whereDate('tanggal_kirim', $today)
                ->get();
        } else {
            $summaryCashTransfer = Transaksi::selectRaw('SUM(COALESCE(CASE WHEN status_batal IN ("Verifikasi Disetujui", "Telah Diambil Pembatalan") THEN 0 ELSE COALESCE(CASE WHEN jenis_pembayaran = "CASH" AND metode_pembayaran = "Transfer" THEN COALESCE(total_bayar, 0) ELSE 0 END, 0) END, 0)) as total')
                ->where('cabang_id', Auth::user()->cabang_id)
                ->whereDate('tanggal_kirim', $today)
                ->get();
        }


        if ($this->isSuperadmin()) {
            $summaryCod = Transaksi::selectRaw('SUM(total_bayar) as total')
                ->whereNull('status_batal')
                ->where('jenis_pembayaran', 'COD')
                ->whereDate('tanggal_kirim', $today)
                ->get();
        } else {
            $summaryCod = Transaksi::selectRaw('SUM(total_bayar) as total')
                ->whereNull('status_batal')
                ->where('jenis_pembayaran', 'COD')
                ->where('cabang_id', Auth::user()->cabang_id)
                ->whereDate('tanggal_kirim', $today)
                ->get();
        }

        if ($this->isSuperadmin()) {
            $summaryCad = Transaksi::selectRaw('SUM(total_bayar) as total')
                ->whereNull('status_batal')
                ->where('jenis_pembayaran', 'CAD')
                ->whereDate('tanggal_kirim', $today)
                ->get();
        } else {
            $summaryCad = Transaksi::selectRaw('SUM(total_bayar) as total')
                ->whereNull('status_batal')
                ->where('jenis_pembayaran', 'CAD')
                ->where('cabang_id', Auth::user()->cabang_id)
                ->whereDate('tanggal_kirim', $today)
                ->get();
        }

        $summaryPembatalan = Transaksi::selectRaw('SUM(biaya_pembatalan) as total')
            ->where(function ($query) {
                $query->where('status_batal', 'Verifikasi Disetujui')
                      ->orWhere('status_batal', 'Telah Diambil Pembatalan');
            })
            ->when(!$this->isSuperadmin(), function($q) {
                return $q->where('cabang_id', Auth::user()->cabang_id);
            })
            ->whereDate('tanggal_kirim', $today)
            // ->whereIn('metode_pembayaran', ['Tunai', 'Transfer'])
            ->first();

            // $transaksiCod = Transaksi::where('jenis_pembayaran', 'COD')
            // ->where('metode_pembayaran', 'Tunai') // Filter untuk metode pembayaran Tunai
            // ->whereNull('status_batal')
            // ->when(!$isSuperadmin, function ($q) use ($cabangId) {
            //     $q->where('cabang_id_tujuan', $cabangId);
            // })
            // // ->whereNotNull('tanggal_terima') // Filter untuk tanggal_terima tidak null
            // ->whereBetween('tanggal_terima', [$filterStartDate, $filterEndDate])
            // ->groupBy('cabang_id_asal') // Mengelompokkan berdasarkan cabang_id
            // ->selectRaw('cabang_id_asal, SUM(total_bayar) as total_bayar')
            // ->get();

        $summaryCODBarangTurunTunai = Transaksi::selectRaw('SUM(total_bayar) as total')
            // ->where('status_bawa', 'Sudah Dibawa')
            ->where('jenis_pembayaran', 'COD')
            ->where('metode_pembayaran', 'Tunai')
            ->whereNull('status_batal')
            ->whereBetween('tanggal_terima', [$today, $today])
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
            })
            // ->groupBy('cabang_id_asal')
            // ->orderBy('id', 'desc')
            ->first();

        $summaryCODBarangTurunTransfer = Transaksi::selectRaw('SUM(total_bayar) as total')
            // ->where('status_bawa', 'Sudah Dibawa')
            ->where('jenis_pembayaran', 'COD')
            ->where('metode_pembayaran', 'Transfer')
            ->whereNull('status_batal')
            ->whereBetween('tanggal_terima', [$today, $today])
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
            })
            // ->orderBy('id', 'desc')
            ->first();


        // Ambil data transaksi
        $userCabangId = Auth::user()->cabang_id;

        $today = now()->format('Y-m-d');



        $summary = Transaksi::select(
            'transaksi.cabang_id',
            'transaksi.cabang_id_tujuan',
            DB::raw('SUM(CASE WHEN transaksi.jenis_pembayaran = "CASH" THEN transaksi.total_bayar ELSE 0 END) as total_cash'),
            DB::raw('SUM(CASE WHEN transaksi.jenis_pembayaran = "COD" THEN transaksi.total_bayar ELSE 0 END) as total_cod'),
            DB::raw('SUM(CASE WHEN transaksi.jenis_pembayaran = "CAD" THEN transaksi.total_bayar ELSE 0 END) as total_cad'),
            DB::raw('SUM(transaksi.total_bayar) as total_bayar'),
            DB::raw('SUM(transaksi.koli) as total_koli'),
            DB::raw('SUM(transaksi.berat) as total_berat'),

            DB::raw('COUNT(transaksi.kode_resi) as total_resi')
        )
            ->leftJoin('cabang as cabang_tujuan', 'transaksi.cabang_id_tujuan', '=', 'cabang_tujuan.id')
            // ->where('transaksi.status_bawa', '=', 'Sudah Dibawa')
            // ->where('transaksi.status_bayar', '=', 'Sudah Lunas')
            ->whereNull('transaksi.status_batal') // Tambahkan ini untuk filter status_batal yang Null
            ->groupBy('transaksi.cabang_id')
            ->get();



        $userCabangId = Auth::user()->cabang_id;

        $daftar_muat = Transaksi::select(
            'transaksi.cabang_id_tujuan',
            DB::raw('SUM(transaksi.koli) as total_koli'),
            DB::raw('SUM(transaksi.berat) as total_berat')
        )
            ->leftJoin('cabang as cabang_tujuan', 'transaksi.cabang_id_tujuan', '=', 'cabang_tujuan.id')
            ->where('transaksi.cabang_id', '=', $userCabangId)
            ->whereNotNull('transaksi.tanggal_kirim') // Hanya ambil data dengan tanggal_kirim tidak null
            ->where(function ($query) {
                $query->whereNull('transaksi.status_batal');
            })
            ->whereDate('transaksi.tanggal_booking', now()->toDateString()) // Filter berdasarkan today tanggal_booking
            ->groupBy('transaksi.cabang_id_tujuan')
            ->get();





        $filterStartDate = today();
        $filterEndDate = today();


        // Cek apakah user adalah superadmin
        $isSuperadmin = $this->isSuperadmin();

        // Ambil cabang_id dari user yang sedang login
        $cabangId = $isSuperadmin ? null : auth()->user()->cabang_id;
        $transaksi = Transaksi::whereIn('jenis_pembayaran', ['CASH', 'COD'])
            ->when(!$isSuperadmin, function ($q) use ($cabangId) {
                $q->where('cabang_id', $cabangId);
            })
            ->selectRaw('cabang_id, 
        SUM(COALESCE(
            CASE 
                WHEN status_batal = "Verifikasi Disetujui" OR status_batal = "Telah Diambil Pembatalan" THEN 0 
                WHEN jenis_pembayaran = "CASH" AND metode_pembayaran = "Tunai" THEN COALESCE(total_bayar, 0) 
                ELSE 0 
            END, 
            0
        )) as total_bayar,
        SUM(COALESCE(
            CASE 
                WHEN status_batal = "Verifikasi Disetujui" OR status_batal = "Telah Diambil Pembatalan" THEN COALESCE(biaya_pembatalan, 0) 
                ELSE 0 
            END, 
            0
        )) as biaya_pembatalan')

            ->whereBetween('tanggal_kirim', [$filterStartDate, $filterEndDate])
            ->groupBy('cabang_id')
            ->get();

        $totalBayar = $transaksi->sum('total_bayar');







        // Query untuk mengambil data transaksi COD sesuai filter
        $transaksiCod = Transaksi::where('jenis_pembayaran', 'COD')
            ->whereIn('metode_pembayaran', ['Tunai']) // Filter untuk metode pembayaran Tunai
            // ->whereIn('metode_pembayaran', ['Tunai', 'Transfer']) // Filter untuk metode pembayaran Tunai
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













        $cabangId = auth()->user()->cabang_id;

        // Penggunaan $cabangId dalam query penghitungan biaya pembatalan
        $total_pembatalan = Transaksi::where(function ($query) use ($cabangId) {
            $query->where('cabang_id', $cabangId)
                ->orWhere('cabang_id_tujuan', $cabangId);
        })
            ->where('status_batal', 'Telah Diambil Pembatalan')
            ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                return $q->whereDate('tanggal_kirim', '>=', $filterStartDate)
                    ->whereDate('tanggal_kirim', '<=', $filterEndDate);
            })
            ->sum('biaya_pembatalan');








        // Query untuk menghitung total pengeluaran per cabang
        $total_pengeluaran = Pengeluaran::where('cabang_id', $cabangId)
            ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                return $q->whereDate('tanggal_pengeluaran', '>=', $filterStartDate)
                    ->whereDate('tanggal_pengeluaran', '<=', $filterEndDate);
            })
            ->sum('jumlah_pengeluaran'); // Sesuaikan dengan nama kolom jumlah_pengeluaran pada tabel pengeluaran


        $total_pengeluaran_per_cabang = [];

        foreach ($summary as $p) {
            $total_pengeluaran_per_cabang[$p->cabang_id] = Pengeluaran::where('cabang_id', $p->cabang_id)
                ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                    return $q->whereDate('tanggal_pengeluaran', '>=', $filterStartDate)
                        ->whereDate('tanggal_pengeluaran', '<=', $filterEndDate);
                })
                ->sum('jumlah_pengeluaran');
        }


        $cabang = [];

        if ($this->isSuperadmin()) {
            $cabang = Cabang::all();
        }

        //  return view('dashboard', compact('summaryCash','summaryCad','summaryCod','summaryPembatalan', 'summary', 'total_pengeluaran',  'kasir_detail'));
        return view('dashboard', compact('summaryCash', 'daftar_muat', 'summaryCad', 'summaryCod', 'summaryPembatalan', 'summaryCashTransfer', 'summary', 'total_pengeluaran', 'transaksi', 'transaksiCod', 'totalBayarCod', 'totalBayar', 'total_pengeluaran_per_cabang', 'total_pembatalan', 'summaryCODBarangTurunTunai', 'summaryCODBarangTurunTransfer', 'cabang'));
    }

    public function grafikTransaksi(Request $request)
    {
        // $totalDay = today()->daysInMonth;
        $arrData = [];
        $arrCollectData = [];

        /** RINGKASAN BULANAN */
        if ($request->ringkasan == 'bulanan' && ($request->tanggal_awal == null && $request->tanggal_akhir == null)) {
            $totalDay = today()->daysInMonth;

            $arrDate = [];

            for ($i = 1; $i <= $totalDay; $i++) {
                $arrDate[] = date('Y-m-') . sprintf('%02d', $i);
                $arrCollectData[date('Y-m-') . sprintf('%02d', $i)] = [
                    'pendapatan' => 0,
                    'pengeluaran' => 0,
                    'profit' => 0,
                    'berat' => 0,
                    'koli' => 0,
                    'resi' => 0,
                    'label' => $i
                ];
            }

            $transaksi = Transaksi::detailTransaksi()
                                    ->whereIn('tanggal_kirim', $arrDate)
                                    ->when($request->cabang != 'all', function ($q) use ($request) {
                                        return $q->where('cabang_id', $request->cabang);
                                    })
                                    ->get();
                                    
            $pengeluaran = Pengeluaran::select('tanggal_pengeluaran', 'jumlah_pengeluaran')
                                        ->whereIn('tanggal_pengeluaran', $arrDate)
                                        ->when($request->cabang != 'all', function ($q) use ($request) {
                                            return $q->where('cabang_id', $request->cabang);
                                        })
                                        ->get();

            foreach ($transaksi as $tr) {
                $pendapatan = $tr->cash_tunai + $tr->cash_transfer + $tr->cad + $tr->cod + $tr->pembatalan;
                $arrCollectData[$tr->tanggal_kirim]['pendapatan'] += $pendapatan;
                $arrCollectData[$tr->tanggal_kirim]['berat'] += $tr->berat;
                $arrCollectData[$tr->tanggal_kirim]['koli'] += $tr->koli;
                $arrCollectData[$tr->tanggal_kirim]['resi']++;
            }

            foreach ($pengeluaran as $pr) {
                $arrCollectData[$pr->tanggal_pengeluaran]['pengeluaran'] += $pr->jumlah_pengeluaran;
            }
        } else if ($request->ringkasan == 'bulanan' && ($request->tanggal_awal != null && $request->tanggal_akhir != null)) {
            $totalDay = today()->daysInMonth;

            $start_date = date_create($request->tanggal_awal);
            $end_date = date_create(Carbon::parse($request->tanggal_akhir)->addDays(1)->format('Y-m-d'));

            // Step 2: Defining the Date Interval
            $interval = new DateInterval('P1D');

            // Step 3: Creating the Date Range
            $dateRange = new DatePeriod($start_date, $interval, $end_date);

            // Step 4: Looping Through the Date Range
            $arrDate = [];

            foreach ($dateRange as $date) {
                // echo $date->format('Y-m-d') . "\n";
                $arrDate[] = $date->format('Y-m-d');
                $arrCollectData[$date->format('Y-m-d')] = [
                    'pendapatan' => 0,
                    'pengeluaran' => 0,
                    'profit' => 0,
                    'berat' => 0,
                    'koli' => 0,
                    'resi' => 0,
                    'label' => (int)$date->format('d')
                ];
            }

            $transaksi = Transaksi::detailTransaksi()
                                    ->whereIn('tanggal_kirim', $arrDate)
                                    ->when($request->cabang != 'all', function ($q) use ($request) {
                                        return $q->where('cabang_id', $request->cabang);
                                    })
                                    ->get();

            $pengeluaran = Pengeluaran::select('tanggal_pengeluaran', 'jumlah_pengeluaran')
                                        ->whereIn('tanggal_pengeluaran', $arrDate)
                                        ->when($request->cabang != 'all', function ($q) use ($request) {
                                            return $q->where('cabang_id', $request->cabang);
                                        })
                                        ->get();

            foreach ($transaksi as $tr) {
                $pendapatan = $tr->cash_tunai + $tr->cash_transfer + $tr->cad + $tr->cod + $tr->pembatalan;
                $arrCollectData[$tr->tanggal_kirim]['pendapatan'] += $pendapatan;
                $arrCollectData[$tr->tanggal_kirim]['berat'] += $tr->berat;
                $arrCollectData[$tr->tanggal_kirim]['koli'] += $tr->koli;
                $arrCollectData[$tr->tanggal_kirim]['resi']++;
            }

            foreach ($pengeluaran as $pr) {
                $arrCollectData[$pr->tanggal_pengeluaran]['pengeluaran'] += $pr->jumlah_pengeluaran;
            }
        }

        /** RINGKASAN TAHUNAN */
        else if ($request->ringkasan == 'tahunan' && ($request->tanggal_awal == null && $request->tanggal_akhir == null)) {
            $arrMonth = [];

            for ($i = 1; $i <= 12; $i++) {
                $arrMonth[] = sprintf('%02d', $i);
                $arrCollectData[$i] = [
                    'pendapatan' => 0,
                    'pengeluaran' => 0,
                    'profit' => 0,
                    'berat' => 0,
                    'koli' => 0,
                    'resi' => 0,
                    'label' => Carbon::parse(date('Y-' . $i . '-d'))->format('M')
                ];
            }

            $transaksi = Transaksi::detailTransaksi()
                                    ->whereRaw('MONTH(tanggal_kirim) IN (' . implode(', ', $arrMonth) . ')')
                                    ->whereYear('tanggal_kirim', today()->format('Y'))
                                    ->when($request->cabang != 'all', function ($q) use ($request) {
                                        return $q->where('cabang_id', $request->cabang);
                                    })
                                    ->get();

            $pengeluaran = Pengeluaran::select('tanggal_pengeluaran', 'jumlah_pengeluaran', DB::raw("MONTH(tanggal_pengeluaran) as bulan"))
                                        ->whereRaw('MONTH(tanggal_pengeluaran) IN (' . implode(', ', $arrMonth) . ')')
                                        ->whereYear('tanggal_pengeluaran', today()->format('Y'))
                                        ->when($request->cabang != 'all', function ($q) use ($request) {
                                            return $q->where('cabang_id', $request->cabang);
                                        })
                                        ->get();

            foreach ($transaksi as $tr) {
                $pendapatan = $tr->cash_tunai + $tr->cash_transfer + $tr->cad + $tr->cod + $tr->pembatalan;
                $arrCollectData[$tr->bulan]['pendapatan'] += $pendapatan;
                $arrCollectData[$tr->bulan]['berat'] += $tr->berat;
                $arrCollectData[$tr->bulan]['koli'] += $tr->koli;
                $arrCollectData[$tr->bulan]['resi']++;
            }

            foreach ($pengeluaran as $pr) {
                $arrCollectData[$pr->bulan]['pengeluaran'] += $pr->jumlah_pengeluaran;
            }
        }

        /** FILTER TANGGAL DIISI */
        else {
            $arrMonth = [];

            for ($i = 1; $i <= 12; $i++) {
                $arrMonth[] = sprintf('%02d', $i);
                $arrCollectData[$i] = [
                    'pendapatan' => 0,
                    'pengeluaran' => 0,
                    'profit' => 0,
                    'berat' => 0,
                    'koli' => 0,
                    'resi' => 0,
                    'label' => Carbon::parse(date('Y-' . $i . '-d'))->format('M')
                ];
            }

            $transaksi = Transaksi::detailTransaksi()
                                    ->whereBetween('tanggal_kirim', [$request->tanggal_awal, $request->tanggal_akhir])
                                    ->when($request->cabang != 'all', function ($q) use ($request) {
                                        return $q->where('cabang_id', $request->cabang);
                                    })
                                    ->get();

            $pengeluaran = Pengeluaran::select('tanggal_pengeluaran', 'jumlah_pengeluaran', DB::raw("MONTH(tanggal_pengeluaran) as bulan"))
                                        ->whereBetween('tanggal_pengeluaran', [$request->tanggal_awal, $request->tanggal_akhir])
                                        ->when($request->cabang != 'all', function ($q) use ($request) {
                                            return $q->where('cabang_id', $request->cabang);
                                        })
                                        ->get();

            foreach ($transaksi as $tr) {
                $pendapatan = $tr->cash_tunai + $tr->cash_transfer + $tr->cad + $tr->cod + $tr->pembatalan;
                $arrCollectData[$tr->bulan]['pendapatan'] += $pendapatan;
                $arrCollectData[$tr->bulan]['berat'] += $tr->berat;
                $arrCollectData[$tr->bulan]['koli'] += $tr->koli;
                $arrCollectData[$tr->bulan]['resi']++;
            }

            foreach ($pengeluaran as $pr) {
                $arrCollectData[$pr->bulan]['pengeluaran'] += $pr->jumlah_pengeluaran;
            }
        }

        foreach ($arrCollectData as $k => $v) {
            $pendapatan = $v['pendapatan'];
            $pengeluaran = $v['pengeluaran'];
            $profit = $pendapatan - $pengeluaran;
            $v['profit'] = $profit;
            $arrData[] = $v;
        }

        return response()->json($arrData);
    }

    public function tableTransaksi(Request $request)
    {
        $cabang = $request->cabang;
        $ringkasan = $request->ringkasan;
        $tglAwal = $request->tanggal_awal;
        $tglAkhir = $request->tanggal_akhir;

        $transaksi = Transaksi::summaryTransaksi()
                                ->with('cabang:id,nama_cabang', 'cabangTujuan:id,nama_cabang')
                                // ->when($cabang != 'all', function ($q) use ($cabang) {
                                //     return $q->where('cabang_id', $cabang);
                                // })
                                // ->when($cabang != 'all' && $ringkasan == 'bulanan' && ($tglAwal == null && $tglAkhir == null), function ($q) {
                                //     return $q->whereMonth('tanggal_kirim', today()->format('m'))
                                //              ->whereYear('tanggal_kirim', today()->format('Y'))
                                //              ->groupBy('tanggal_kirim');
                                // })
                                // ->when($cabang != 'all' && $ringkasan == 'tahunan' && ($tglAwal == null && $tglAkhir == null), function ($q) {
                                //     return $q->whereYear('tanggal_kirim', today()->format('Y'))
                                //              ->groupBy('bulan', 'tahun', 'cabang_id', 'cabang_id_tujuan');
                                // })
                                // ->when($cabang == 'all' && $ringkasan != 'tahunan', function ($q) {
                                //     return $q->groupBy('cabang_id');
                                // })
                                // ->when($cabang == 'all' && $ringkasan == 'bulanan' && ($tglAwal == null && $tglAkhir == null), function ($q) {
                                //     return $q->whereMonth('tanggal_kirim', today()->format('m'))
                                //              ->whereYear('tanggal_kirim', today()->format('Y'))
                                //              ->groupBy('tanggal_kirim');
                                // })
                                // ->when($cabang == 'all' && $ringkasan == 'tahunan' && ($tglAwal == null && $tglAkhir == null), function ($q) {
                                //     return $q->whereYear('tanggal_kirim', today()->format('Y'))
                                //              ->groupBy('bulan', 'tahun');
                                // })
                                // ->when($tglAwal != null && $tglAkhir != null, function ($q) use ($tglAwal, $tglAkhir) {
                                //     return $q->whereBetween('tanggal_kirim', [$tglAwal, $tglAkhir])
                                //              ->groupBy('tanggal_kirim');
                                // })
                                // ->when($cabang != 'all', function ($q) use ($cabang) {
                                //     return $q->where('cabang_id', $cabang)
                                //              ->groupBy('cabang_id');
                                // })
                                // ->when($ringkasan == 'bulanan' && ($tglAwal == null && $tglAkhir == null), function ($q) {
                                //     return $q->whereYear('tanggal_kirim', today()->format('Y'))
                                //              ->whereMonth('tanggal_kirim', today()->format('m'));
                                // })
                                // ->when($ringkasan == 'bulanan', function ($q) {
                                //     return $q->groupBy('cabang_id', 'cabang_id_tujuan');
                                // })
                                // ->when($ringkasan == 'tahunan' && ($tglAwal == null && $tglAkhir == null), function ($q) {
                                //     return $q->whereYear('tanggal_kirim', today()->format('Y'));
                                // })
                                // ->when($ringkasan == 'tahunan', function ($q) {
                                //     return $q->groupBy('bulan', 'tahun', 'cabang_id', 'cabang_id_tujuan');
                                // })
                                // ->when($tglAwal != null && $tglAkhir != null, function ($q) use ($tglAwal, $tglAkhir) {
                                //     return $q->whereBetween('tanggal_kirim', [$tglAwal, $tglAkhir]);
                                // })
                                ->when($cabang == 'all', function ($q) use ($ringkasan, $tglAwal, $tglAkhir) {
                                    return $q->when($tglAkhir == null && $tglAwal == null, function ($qr) use ($ringkasan) {
                                                return $qr->when($ringkasan == 'tahunan', function ($r) {
                                                                return $r->whereYear('tanggal_kirim', today()->format('Y'))
                                                                         ->groupBy('bulan', 'tahun');
                                                            })
                                                            ->when($ringkasan == 'bulanan', function ($r) {
                                                                return $r->whereYear('tanggal_kirim', today()->format('Y'))
                                                                         ->whereMonth('tanggal_kirim', today()->format('m'))
                                                                         ->groupBy('bulan', 'tahun', 'cabang_id');
                                                            });
                                            })
                                            ->when($tglAkhir != null && $tglAwal != null, function ($qr) use ($tglAwal, $tglAkhir) {
                                                return $qr->whereBetween('tanggal_kirim', [$tglAwal, $tglAkhir])
                                                          ->groupBy('cabang_id_tujuan');
                                            });
                                })
                                ->when($cabang != 'all', function ($q) use ($cabang, $ringkasan, $tglAwal, $tglAkhir) {
                                    return $q->when($tglAkhir == null && $tglAwal == null, function ($qr) use ($ringkasan) {
                                                return $qr->when($ringkasan == 'tahunan', function ($r) {
                                                                return $r->whereYear('tanggal_kirim', today()->format('Y'))
                                                                         ->groupBy('bulan', 'tahun');
                                                            })
                                                            ->when($ringkasan == 'bulanan', function ($r) {
                                                                return $r->whereYear('tanggal_kirim', today()->format('Y'))
                                                                         ->whereMonth('tanggal_kirim', today()->format('m'))
                                                                         ->groupBy('bulan', 'tahun', 'cabang_id_tujuan');
                                                            });
                                            })
                                            ->when($tglAkhir != null && $tglAwal != null, function ($qr) use ($tglAwal, $tglAkhir) {
                                                return $qr->whereBetween('tanggal_kirim', [$tglAwal, $tglAkhir])
                                                          ->groupBy('cabang_id_tujuan');
                                            })
                                            ->where('cabang_id', $cabang);
                                })
                                ->get();

        return response()->json($transaksi);
    }

    public function tableProfit(Request $request)
    {
        return response()->json($this->profitQuery($request));
    }

    public function tableProfitAll(Request $request)
    {
        return response()->json($this->profitQuery($request, true));
    }

    private function profitQuery($request, $profitAll = false)
    {
        $cabang = $request->cabang;
        $ringkasan = $request->ringkasan;
        $tglAwal = $request->tanggal_awal;
        $tglAkhir = $request->tanggal_akhir;

        $transaksi = Transaksi::selectRaw('cabang_id, tanggal_kirim, MONTH(tanggal_kirim) bulan, YEAR(tanggal_kirim) tahun, DATE_FORMAT(tanggal_kirim, "%M") format_bulan,
                                            SUM(COALESCE(CASE WHEN (status_batal IS NULL OR status_batal = "Pengajuan Batal") THEN COALESCE(total_bayar, 0) ELSE 0 END, 0)) as pendapatan,
                                            SUM(COALESCE(CASE WHEN status_batal = "Verifikasi Disetujui" THEN COALESCE(biaya_pembatalan, 0) ELSE 0 END, 0)) as pembatalan')
                                ->with('cabang:id,nama_cabang')
                                // ->when($cabang != 'all', function ($q) use ($cabang) {
                                //     return $q->where('cabang_id', $cabang);
                                // })
                                // ->when($ringkasan == 'bulanan' && ($tglAwal == null && $tglAkhir == null), function ($q) {
                                //     return $q->whereMonth('tanggal_kirim', today()->format('m'))
                                //              ->whereYear('tanggal_kirim', today()->format('Y'))
                                //              ->groupBy('bulan', 'tahun', 'cabang_id');
                                // })
                                // ->when($cabang == 'all' && $ringkasan == 'tahunan' && ($tglAwal == null && $tglAkhir == null), function ($q) {
                                //     return $q->whereYear('tanggal_kirim', today()->format('Y'))
                                //              ->groupBy('bulan', 'tahun');
                                // })
                                // ->when($cabang != 'all' && $ringkasan == 'tahunan' && ($tglAwal == null && $tglAkhir == null), function ($q) {
                                //     return $q->whereYear('tanggal_kirim', today()->format('Y'))
                                //              ->groupBy('bulan', 'tahun', 'cabang_id');
                                // })
                                // ->when($tglAwal != null && $tglAkhir != null, function ($q) use ($tglAwal, $tglAkhir) {
                                //     return $q->whereBetween('tanggal_kirim', [$tglAwal, $tglAkhir]);
                                // })
                                // ->when(!$profitAll, function ($q) {
                                //     return $q->groupBy('cabang_id');
                                // })
                                ->when(!$profitAll, function ($q) use ($cabang, $ringkasan, $tglAwal, $tglAkhir) {
                                    return $q->when($cabang == 'all', function ($qr) use ($ringkasan, $tglAwal, $tglAkhir) {
                                                return $qr->when($tglAkhir == null && $tglAwal == null, function ($qry) use ($ringkasan) {
                                                                return $qry->when($ringkasan == 'tahunan', function ($r) {
                                                                                return $r->whereYear('tanggal_kirim', today()->format('Y'))
                                                                                        ->groupBy('bulan', 'tahun');
                                                                            })
                                                                            ->when($ringkasan == 'bulanan', function ($r) {
                                                                                return $r->whereYear('tanggal_kirim', today()->format('Y'))
                                                                                        ->whereMonth('tanggal_kirim', today()->format('m'))
                                                                                        ->groupBy('bulan', 'tahun', 'cabang_id');
                                                                            });
                                                            })
                                                            ->when($tglAkhir != null && $tglAwal != null, function ($qr) use ($tglAwal, $tglAkhir) {
                                                                return $qr->whereBetween('tanggal_kirim', [$tglAwal, $tglAkhir])
                                                                        ->groupBy('cabang_id');
                                                            });
                                            })
                                            ->when($cabang != 'all', function ($q) use ($cabang, $ringkasan, $tglAwal, $tglAkhir) {
                                                return $q->when($tglAkhir == null && $tglAwal == null, function ($qry) use ($ringkasan) {
                                                            return $qry->when($ringkasan == 'tahunan', function ($r) {
                                                                            return $r->whereYear('tanggal_kirim', today()->format('Y'))
                                                                                    ->groupBy('bulan', 'tahun');
                                                                        })
                                                                        ->when($ringkasan == 'bulanan', function ($r) {
                                                                            return $r->whereYear('tanggal_kirim', today()->format('Y'))
                                                                                    ->whereMonth('tanggal_kirim', today()->format('m'))
                                                                                    ->groupBy('bulan', 'tahun', 'cabang_id');
                                                                        });
                                                        })
                                                        ->when($tglAkhir != null && $tglAwal != null, function ($qr) use ($tglAwal, $tglAkhir) {
                                                            return $qr->whereBetween('tanggal_kirim', [$tglAwal, $tglAkhir])
                                                                    ->groupBy('cabang_id');
                                                        })
                                                        ->where('cabang_id', $cabang);
                                            });
                                })
                                ->when($profitAll, function ($q) use ($cabang, $ringkasan, $tglAwal, $tglAkhir) {
                                    return $q->when($cabang == 'all', function ($qr) use ($ringkasan, $tglAwal, $tglAkhir) {
                                                return $qr->when($tglAkhir == null && $tglAwal == null, function ($qry) use ($ringkasan) {
                                                                return $qry->when($ringkasan == 'tahunan', function ($r) {
                                                                                return $r->whereYear('tanggal_kirim', today()->format('Y'))
                                                                                        ->groupBy('bulan', 'tahun');
                                                                            })
                                                                            ->when($ringkasan == 'bulanan', function ($r) {
                                                                                return $r->whereYear('tanggal_kirim', today()->format('Y'))
                                                                                        ->whereMonth('tanggal_kirim', today()->format('m'))
                                                                                        ->groupBy('bulan', 'tahun');
                                                                            });
                                                            })
                                                            ->when($tglAkhir != null && $tglAwal != null, function ($qr) use ($tglAwal, $tglAkhir) {
                                                                return $qr->whereBetween('tanggal_kirim', [$tglAwal, $tglAkhir]);
                                                            });
                                            })
                                            ->when($cabang != 'all', function ($q) use ($cabang, $ringkasan, $tglAwal, $tglAkhir) {
                                                return $q->when($tglAkhir == null && $tglAwal == null, function ($qry) use ($ringkasan) {
                                                            return $qry->when($ringkasan == 'tahunan', function ($r) {
                                                                            return $r->whereYear('tanggal_kirim', today()->format('Y'))
                                                                                    ->groupBy('bulan', 'tahun');
                                                                        })
                                                                        ->when($ringkasan == 'bulanan', function ($r) {
                                                                            return $r->whereYear('tanggal_kirim', today()->format('Y'))
                                                                                    ->whereMonth('tanggal_kirim', today()->format('m'))
                                                                                    ->groupBy('bulan', 'tahun', 'cabang_id');
                                                                        });
                                                        })
                                                        ->when($tglAkhir != null && $tglAwal != null, function ($qr) use ($tglAwal, $tglAkhir) {
                                                            return $qr->whereBetween('tanggal_kirim', [$tglAwal, $tglAkhir])
                                                                    ->groupBy('cabang_id');
                                                        })
                                                        ->where('cabang_id', $cabang);
                                            });
                                })
                                ->get();

        $i = 0;
        foreach ($transaksi as $tr) {
            $pengeluaran = Pengeluaran::selectRaw('cabang_id, SUM(jumlah_pengeluaran) as jumlah_pengeluaran, MONTH(tanggal_pengeluaran) bulan, YEAR(tanggal_pengeluaran) tahun')
                                        // ->when($cabang != 'all', function ($q) use ($tr) {
                                        //     return $q->where('cabang_id', $tr->cabang_id);
                                        // })
                                        // ->when($cabang == 'all' && $ringkasan == 'tahunan' && ($tglAwal == null && $tglAkhir == null), function ($q) use ($tr, $profitAll) {
                                        //     return $q->whereYear('tanggal_pengeluaran', $tr->tahun)
                                        //              ->whereMonth('tanggal_pengeluaran', $tr->bulan)
                                        //              ->groupBy('bulan', 'tahun');
                                        // })
                                        // ->when($cabang != 'all' && $ringkasan == 'tahunan' && ($tglAwal == null && $tglAkhir == null), function ($q) use ($tr, $profitAll) {
                                        //     return $q->whereYear('tanggal_pengeluaran', $tr->tahun)
                                        //              ->whereMonth('tanggal_pengeluaran', $tr->bulan)
                                        //              ->when(!$profitAll, function($qr){
                                        //                 return $qr->groupBy('bulan', 'tahun', 'cabang_id');
                                        //              })
                                        //              ->when($profitAll, function($qr){
                                        //                 return $qr->groupBy('bulan', 'tahun');
                                        //              });
                                        // })
                                        // ->when($ringkasan == 'bulanan' && ($tglAwal == null && $tglAkhir == null), function ($q) use ($tr) {
                                        //     return $q->whereMonth('tanggal_pengeluaran', $tr->bulan)
                                        //              ->whereYear('tanggal_pengeluaran', $tr->tahun)
                                        //              ->groupBy('bulan', 'tahun', 'cabang_id');
                                        // })
                                        // // ->when($ringkasan == 'tahunan' && ($tglAwal == null && $tglAkhir == null), function ($q) {
                                        // //     return $q->whereYear('tanggal_pengeluaran', today()->format('Y'));
                                        // // })
                                        // ->when($tglAwal != null && $tglAkhir != null, function ($q) use ($tglAwal, $tglAkhir) {
                                        //     return $q->whereBetween('tanggal_pengeluaran', [$tglAwal, $tglAkhir]);
                                        // })
                                        // ->when(!$profitAll, function($q){
                                        //    return $q->where('cabang_id', '!=', 0);
                                        // })
                                        ->when(!$profitAll, function ($q) use ($cabang, $ringkasan, $tglAwal, $tglAkhir, $tr) {
                                            return $q->when($cabang == 'all', function ($qr) use ($ringkasan, $tglAwal, $tglAkhir, $tr) {
                                                        return $qr->when($tglAkhir == null && $tglAwal == null, function ($qry) use ($ringkasan, $tr) {
                                                                        return $qry->when($ringkasan == 'tahunan', function ($r) use ($tr) {
                                                                                        return $r->whereYear('tanggal_pengeluaran', $tr->tahun)
                                                                                                 ->whereMonth('tanggal_pengeluaran', $tr->bulan)
                                                                                                 ->where('cabang_id', '!=', 0)
                                                                                                 ->groupBy('bulan', 'tahun');
                                                                                    })
                                                                                    ->when($ringkasan == 'bulanan', function ($r) use ($tr) {
                                                                                        return $r->whereYear('tanggal_pengeluaran', $tr->tahun)
                                                                                                ->whereMonth('tanggal_pengeluaran', $tr->bulan)
                                                                                                ->where('cabang_id', $tr->cabang_id)
                                                                                                ->groupBy('bulan', 'tahun', 'cabang_id');
                                                                                    });
                                                                    })
                                                                    ->when($tglAkhir != null && $tglAwal != null, function ($qr) use ($tglAwal, $tglAkhir, $tr) {
                                                                        return $qr->whereBetween('tanggal_pengeluaran', [$tglAwal, $tglAkhir])
                                                                                  ->where('cabang_id', $tr->cabang_id)
                                                                                  ->groupBy('cabang_id');
                                                                    });
                                                    })
                                                    ->when($cabang != 'all', function ($q) use ($cabang, $ringkasan, $tglAwal, $tglAkhir, $tr) {
                                                        return $q->when($tglAkhir == null && $tglAwal == null, function ($qry) use ($ringkasan, $tr) {
                                                                    return $qry->when($ringkasan == 'tahunan', function ($r) use ($tr) {
                                                                                    return $r->whereYear('tanggal_pengeluaran', $tr->tahun)
                                                                                             ->whereMonth('tanggal_pengeluaran', $tr->bulan)
                                                                                             ->groupBy('bulan', 'tahun');
                                                                                })
                                                                                ->when($ringkasan == 'bulanan', function ($r) use ($tr) {
                                                                                    return $r->whereYear('tanggal_pengeluaran', $tr->tahun)
                                                                                            ->whereMonth('tanggal_pengeluaran', $tr->bulan)
                                                                                            ->groupBy('bulan', 'tahun', 'cabang_id');
                                                                                });
                                                                })
                                                                ->when($tglAkhir != null && $tglAwal != null, function ($qr) use ($tglAwal, $tglAkhir) {
                                                                    return $qr->whereBetween('tanggal_pengeluaran', [$tglAwal, $tglAkhir])
                                                                              ->groupBy('cabang_id');
                                                                })
                                                                ->where('cabang_id', $cabang);
                                                    });
                                        })
                                        ->when($profitAll, function ($q) use ($cabang, $ringkasan, $tglAwal, $tglAkhir, $tr) {
                                            return $q->when($cabang == 'all', function ($qr) use ($ringkasan, $tglAwal, $tglAkhir, $tr) {
                                                        return $qr->when($tglAkhir == null && $tglAwal == null, function ($qry) use ($ringkasan, $tr) {
                                                                        return $qry->when($ringkasan == 'tahunan', function ($r) use ($tr) {
                                                                                        return $r->whereYear('tanggal_pengeluaran', $tr->tahun)
                                                                                                 ->whereMonth('tanggal_pengeluaran', $tr->bulan)
                                                                                                 ->groupBy('bulan', 'tahun');
                                                                                    })
                                                                                    ->when($ringkasan == 'bulanan', function ($r) use ($tr) {
                                                                                        return $r->whereYear('tanggal_pengeluaran', $tr->tahun)
                                                                                                 ->whereMonth('tanggal_pengeluaran', $tr->bulan)
                                                                                                 ->groupBy('bulan', 'tahun');
                                                                                    });
                                                                    })
                                                                    ->when($tglAkhir != null && $tglAwal != null, function ($qr) use ($tglAwal, $tglAkhir) {
                                                                        return $qr->whereBetween('tanggal_pengeluaran', [$tglAwal, $tglAkhir]);
                                                                    });
                                                    })
                                                    ->when($cabang != 'all', function ($q) use ($cabang, $ringkasan, $tglAwal, $tglAkhir, $tr) {
                                                        return $q->when($tglAkhir == null && $tglAwal == null, function ($qry) use ($ringkasan, $tr) {
                                                                    return $qry->when($ringkasan == 'tahunan', function ($r) use ($tr) {
                                                                                    return $r->whereYear('tanggal_pengeluaran', $tr->tahun)
                                                                                             ->whereMonth('tanggal_pengeluaran', $tr->bulan)
                                                                                             ->groupBy('bulan', 'tahun');
                                                                                })
                                                                                ->when($ringkasan == 'bulanan', function ($r) use ($tr) {
                                                                                    return $r->whereYear('tanggal_pengeluaran', today()->format('Y'))
                                                                                            ->whereMonth('tanggal_pengeluaran', today()->format('m'))
                                                                                            ->groupBy('bulan', 'tahun');
                                                                                });
                                                                })
                                                                ->when($tglAkhir != null && $tglAwal != null, function ($qr) use ($tglAwal, $tglAkhir) {
                                                                    return $qr->whereBetween('tanggal_pengeluaran', [$tglAwal, $tglAkhir]);
                                                                });
                                                    });
                                        })
                                        ->first();

            $jmlPendapatan = $tr->pendapatan ? $tr->pendapatan : 0;
            $jmlPembatalan = $tr->pembatalan ? $tr->pembatalan : 0;
            $jmlPengeluaran = $pengeluaran ? $pengeluaran->jumlah_pengeluaran : 0;
            $transaksi[$i]->pendapatan = $jmlPendapatan + $jmlPembatalan;
            $transaksi[$i]->pengeluaran = $jmlPengeluaran;
            $transaksi[$i]->profit = $jmlPendapatan + $jmlPembatalan - $jmlPengeluaran;
            $i++;
        }

        return $transaksi;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
